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


use App\Config\Config;
use App\Http\Response;
use App\Http\StringStream;
use App\Modules\ModuleArgumentInterface;
use App\Modules\ModuleResult;
use App\Modules\ModuleResultInterface;
use App\Modules\Mvc\Controller\ActionResult\ActionResultFactoryInterface;
use App\Modules\Mvc\Controller\ActionResult\ActionResultInterface;
use App\Modules\Mvc\Controller\ActionResult\RedirectToRouteResultInterface;
use App\Modules\Mvc\Controller\ActionResult\RedirectToUrlResultInterface;
use App\Modules\Mvc\Controller\MvcControllerFactoryInterface;
use App\Http\RequestInterface;
use App\Http\ResponseInterface;
use App\Modules\Mvc\Routing\RoutingInterface;
use Closure;

class MvcModule implements MvcModuleInterface
{
    /**
     * @var RoutingInterface
     */
    protected $routing;

    /**
     * @var MvcControllerFactoryInterface
     */
    protected $controllerFactory;

    /**
     * @var ActionResultFactoryInterface
     */
    protected $actionResultFactory;

    /**
     * @var ModuleArgumentInterface
     */
    protected $moduleArgument;

    /**
     * Результат отработки ->process
     * @var ModuleResultInterface
     */
    protected $processResult;

    /**
     * Результат выполнения контроллер->экшн
     * @var ActionResultInterface
     */
    protected $actionResult;

    /**
     * MvcModule constructor.
     * @param RoutingInterface $routing
     * @param MvcControllerFactoryInterface $controller_factory
     * @param ActionResultFactoryInterface $action_result_factory
     */
    public function __construct(RoutingInterface $routing,
                                MvcControllerFactoryInterface $controller_factory,
                                ActionResultFactoryInterface $action_result_factory)
    {
        $this->routing = $routing;
        $this->controllerFactory = $controller_factory;
        $this->actionResultFactory = $action_result_factory;
    }

    /**
     * @return Closure
     */
    protected function resultClosure()
    {
        return function() {
            return $this->actionResult->getResult();
        };
    }

    /**
     * На основе action_result устанавливает респонс
     *
     * todo Реализовать в отдельном классе! - ActionResultHandler
     * @return void
     */
    protected function setResponse()
    {
        $set_response_function = function () {

            $empty_response = new Response();

            if (Config::getCurrentEnv() == Config::ENV_DEBUG) {
                if (empty($this->actionResult->getException()) == false) {
                    $empty_response = $empty_response->withBody(new StringStream((string)$this->actionResult->getException()));
                }
            }

            $rendered_content = $this->actionResult->getResult();

            if ($this->actionResult->isSuccessful() == false) {
                $response_with_500 = $empty_response->withStatus(500, 'Internal Server Error!');
                $this->moduleArgument->setResponse($response_with_500);
                return;
            }

            $is_redirect = is_subclass_of($this->actionResult, RedirectToUrlResultInterface::class);
            if ($is_redirect) {
                /**
                 * @var $redirect_result RedirectToUrlResultInterface
                 */
                $redirect_result = $this->actionResult;
                $response_with_307 = $empty_response->withStatus(307);
                $response_with_307 = $response_with_307->withHeader('Location', $redirect_result->getResult());
                $this->moduleArgument->setResponse($response_with_307);
                return;
            }

            $response_with_200 = $empty_response->withStatus(200, 'OK')
                                                ->withBody(new StringStream($rendered_content));
            $this->moduleArgument->setResponse($response_with_200);
        };

        $this->processResult->setModifiedResponseClosure(Closure::fromCallable($set_response_function));
    }

    /**
     * Запуск модуля, начало работы и инциализация
     * @param ModuleArgumentInterface $argument
     * @return ModuleResultInterface ;
     */
    public function process(ModuleArgumentInterface $argument): ModuleResultInterface
    {
        if (isset($this->processResult)) {
            return $this->processResult;
        }

        $this->moduleArgument = $argument;

        /**
         * @var $routing RoutingInterface
         */
        //создаем роут на основе входящих аргументов
        $routing = $this->routing; //todo
        $route = $routing->getRoute($argument->getRequest());

        //создается контроллер и вызывается экшен с соответствующими параметрами
        $this->actionResult = $this->controllerFactory->createAndCall(
            $this->actionResultFactory,
            $route,
            $this->getRequest(),
            $this->getResponse()
        );

        //todo deprecated?
        $result_closure = Closure::fromCallable($this->resultClosure());

        $module_result = new ModuleResult($this, $this->actionResult); //todo refactor to factory instance
        $module_result->setResultClosure($result_closure);
        $this->processResult = $module_result;

        $this->setResponse();

        return $this->processResult;
    }

    /**
     * Возвращает ассоциированый с запросом реквест
     * @return RequestInterface
     */
    public function getRequest(): RequestInterface
    {
        return $this->getArgument()->getRequest();
    }

    /**
     * Возвращает ассоциированый с запросом реквест
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface
    {
        return $this->getArgument()->getResponse();
    }

    /**
     * Возвращает полное имя модуля
     * @return string
     */
    public function getNameOfModule(): string
    {
        return self::class;
    }

    /**
     * Возвращает аргумент переданный в модуль
     * @return ModuleArgumentInterface
     */
    public function getArgument(): ModuleArgumentInterface
    {
        return $this->moduleArgument;
    }

    /**
     * Возвращает последний ActionResultInterface
     * полученный при выполнении контроллер->экшн
     * @return ActionResultInterface
     */
    public function getActionResult(): ActionResultInterface
    {
        return $this->actionResult;
    }
}