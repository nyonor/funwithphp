<?php
/**
 * Точка входа в приложение через веб-сервер
 *
 * Created by PhpStorm.
 * User: NyoNor
 * Date: 2/9/2018
 * Time: 12:16 PM
 */

//Инклудим конфиг
require_once("../app/Config/Config.php");

// Инклудим автозагрузчик
require_once ("../vendor/autoload.php");

//здесь можно зарегистрировать еще автозагрузчики!

//наполняем IoC-контейнер
$container = \App\Helpers\Globals\container();
$container
    ->bind(\App\Pipeline\PipelineInterface::class, \App\Pipeline\Pipeline::class)
    ->bind(\App\Modules\ModuleArgumentInterface::class, \App\Modules\ModuleArgument::class)
    ->bind(\App\Modules\Mvc\Controller\ActionResult\ActionResultFactoryInterface::class, \App\Modules\Mvc\Controller\ActionResult\ActionResultFactory::class)
    ->bind(\App\Pipeline\ModuleArgumentHandlerInterface::class, \App\Pipeline\ModuleArgumentHandler::class)
    ->bind(\App\Modules\Mvc\Controller\MvcControllerFactoryInterface::class, \App\Modules\Mvc\Controller\MvcControllerFactory::class)
    ->bind(\App\Helpers\PathInterface::class, \App\Helpers\Path::class)
    ->bind(\App\Pipeline\PipelineInterface::class, \App\Pipeline\Pipeline::class)
    ->bind(\App\Modules\Mvc\Routing\RoutingInterface::class, \App\Modules\Mvc\Routing\Routing::class)
    ->bind(\App\Modules\Mvc\Routing\RouteInterface::class, \App\Modules\Mvc\Routing\Route::class)
    ->bind(\App\Modules\Mvc\Routing\RouteArgumentInterface::class, \App\Modules\Mvc\Routing\RouteArgument::class)
    ->bind(\App\Http\RequestInterface::class, \App\Http\Request::class)
    ->bind(\App\Http\ResponseInterface::class, \App\Http\Response::class)
    ->bind(\App\Pipeline\ResponseHandlerInterface::class, \App\Pipeline\ResponseHandler::class)
    ->bind(\App\Modules\Mvc\View\Render\ViewRenderInterface::class, function () use ($container){
        $parameters = [
            'globals' => [
                'path' => $container->create(\App\Helpers\PathInterface::class),
                'storage' => $container->create(\App\Http\SessionInterface::class)
            ]
        ];

        $container->bind(\App\Modules\Mvc\View\Render\TwigRender::class, \App\Modules\Mvc\View\Render\TwigRender::class);
        return $container->create(\App\Modules\Mvc\View\Render\TwigRender::class, $parameters);
    })
    ->bind(\App\Modules\Mvc\Controller\ActionResult\ViewResultInterface::class, \App\Modules\Mvc\Controller\ActionResult\ViewResult::class)
    ->bind(\App\DAL\Mysql\MysqlPdoDbConnectionInterface::class, \App\DAL\Mysql\MysqlPdoDbConnection::class)
    ->bind(\App\Modules\Mvc\MvcModuleInterface::class, \App\Modules\Mvc\MvcModule::class)
    ->bind(\App\DAL\DbConnectorInterface::class, \App\DAL\DbConnector::class)
    ->bind(\App\Http\SessionInterface::class, function () {
        return \App\Http\Session::getInstance();
    })

    //todo не системные бинды, перенести в сегменты
    ->bind('registration_service', \Segments\Nyo\Services\Registration\UserRegistrationService::class)
    ->bind('authorization_service', function () use ($container) {

        $container->bind('user_repository', \Segments\Nyo\DAL\Repository\User\UserRepository::class);
        $container->bind(\Segments\Nyo\Services\Authorization\AuthorizationServiceInterface::class,
            \Segments\Nyo\Services\Authorization\AuthorizationService::class);

        return $container->create(\Segments\Nyo\Services\Authorization\AuthorizationServiceInterface::class,
            $container->create(\App\Http\SessionInterface::class),
            $container->create('user_repository')
        );
    })
    ->bind('vk_service', function () use ($container) {
        $container
            ->bind(\VK\OAuth\VKOAuth::class, \VK\OAuth\VKOAuth::class)
            ->bind(\VK\Client\VKApiClient::class, \VK\Client\VKApiClient::class)
            ->bind(\Segments\Nyo\Services\Authorization\Vk\VkAuthorizationServiceInterface::class,
                \Segments\Nyo\Services\Authorization\Vk\VkService::class);

        return $container->create(\Segments\Nyo\Services\Authorization\Vk\VkAuthorizationServiceInterface::class,
            $container->create(\VK\Client\VKApiClient::class),
            $container->create(\VK\OAuth\VKOAuth::class)
        );
    })
	->bind('user_model', \Segments\Nyo\Model\User\UserModel::class);

//создание пайплайна, модулей, регистрация модулей в пайплайне
/**
 * @var $pipe_line \App\Pipeline\PipelineInterface
 */
$pipeline_handler = $container->create(\App\Pipeline\ModuleArgumentHandlerInterface::class);
$response_handler = $container->create(\App\Pipeline\ResponseHandlerInterface::class);
$pipe_line = $container->create(\App\Pipeline\PipelineInterface::class, $pipeline_handler, $response_handler);
$view_renderer = $container->create(\App\Modules\Mvc\View\Render\ViewRenderInterface::class);
$action_result_factory = $container->create(\App\Modules\Mvc\Controller\ActionResult\ActionResultFactoryInterface::class, $view_renderer);
$routing = $container->create(\App\Modules\Mvc\Routing\RoutingInterface::class);
$controller_factory = $container->create(\App\Modules\Mvc\Controller\MvcControllerFactoryInterface::class);
$mvc_module = $container->create(\App\Modules\Mvc\MvcModuleInterface::class, $routing, $controller_factory, $action_result_factory);

//регистрация модулей
$pipe_line->registerModule($mvc_module);

//создание объектов реквест и респонс
$request = $container->create(\App\Http\RequestInterface::class);
$response = $container->create(\App\Http\ResponseInterface::class);

//запуск обработки
$pipe_line->go($container->create(\App\Modules\ModuleArgumentInterface::class, [
    'request'   => $request,
    'response'  => $response
]));
