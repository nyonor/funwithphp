<?php
/**
 * Модуль создает роут, контроллер и экшен на основе
 * реквеста, обрабатывет результаты отработки экшена и контроллера.
 * Возвращает результаты в виде респонса.
 *
 * Created by PhpStorm.
 * User: NyoNor
 * Date: 3/15/2018
 * Time: 1:50 PM
 */

namespace App\Modules\Mvc;


use App\Ioc\Ioc;
use App\Modules\ModuleArgumentInterface;
use App\Modules\ModuleResult;
use App\Modules\ModuleResultInterface;
use App\Modules\Mvc\Controller\ActionResultFactoryInterface;
use App\Modules\Mvc\Controller\ActionResultInterface;
use App\Modules\Mvc\Controller\MvcControllerFactoryInterface;
use App\Modules\Mvc\Routing\RequestInterface;
use App\Modules\Mvc\Routing\ResponseInterface;
use App\Modules\Mvc\Routing\RoutingInterface;

class MvcModule implements MvcModuleInterface
{
    protected $routing;
    protected $controllerFactory;
    protected $actionResultFactory;
    protected $request;
    protected $response;


    public function __construct(RoutingInterface $routing,
                                MvcControllerFactoryInterface $controller_factory,
                                ActionResultFactoryInterface $action_result_factory)
    {
        $this->routing = $routing;
        $this->controllerFactory = $controller_factory;
        $this->actionResultFactory = $action_result_factory;
    }

    /**
     * Запуск модуля, начало работы и инциализация
     * @param ModuleArgumentInterface $argument
     * @return ModuleArgumentInterface ;
     */
    public function process(ModuleArgumentInterface $argument): ModuleResultInterface
    {
        $this->request = $argument->getRequest();
        $this->response = $argument->getResponse();

        /**
         * @var $routing RoutingInterface
         */
        //создаем роут на основе входящих аргументов
        $routing = $this->routing; //todo
        $route = $routing->getRoute($argument->getRequest());

        //получаем контоллер
        $controller_class_name = $route->getControllerClassName();

        //экшн
        $action_method_name = $route->getActionMethodName();

        //параметры
        $route_and_url_args = $route->getParameters();

        //создаем контроллер
        $controller_instance = $this->controllerFactory->createController(
            $controller_class_name,
            $this->actionResultFactory,
            $route,
            $this->getRequest(),
            $this->getResponse()
        );

        //вызываем метод контроллера (экшен)
        /**
         * @var $action_result ActionResultInterface
         */
        $action_result = call_user_func_array([$controller_instance, $action_method_name], $route_and_url_args);

        //если пусто
        if (empty($action_result)) {
            Ioc::factory(ModuleArgumentInterface::class);
        }

        echo $action_result->getRenderedContent(); //todo

        //todo реализовать
    }

    /**
     * Возвращает ассоциированый с запросом реквест
     * @return RequestInterface
     */
    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    /**
     * Возвращает ассоциированый с запросом реквест
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }

    /**
     * Возвращает полное имя модуля
     * @return string
     */
    public function getNameOfModule(): string
    {
        return self::class;
    }
}