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
use App\Modules\Mvc\Controller\ActionResultFactoryInterface;
use App\Modules\Mvc\Controller\ActionResultInterface;
use App\Modules\Mvc\Controller\MvcControllerFactoryInterface;
use App\Modules\Mvc\Routing\RoutingInterface;
use App\Modules\View\RendererInterface;

class MvcModule implements MvcModuleInterface
{
    protected $routing;
    protected $controllerFactory;
    protected $actionResultFactory;
    protected $renders;


    public function __construct(RoutingInterface $routing,
                                MvcControllerFactoryInterface $controller_factory,
                                ActionResultFactoryInterface $action_result_factory,
                                RendererInterface ...$renders)
    {
        $this->routing = $routing;
        $this->controllerFactory = $controller_factory;
        $this->actionResultFactory = $action_result_factory;
        $this->renders = $renders;
    }

    /**
     * Запуск модуля, начало работы и инциализация
     * @param ModuleArgumentInterface $argument
     * @return ModuleArgumentInterface ;
     */
    public function process(ModuleArgumentInterface $argument): ModuleArgumentInterface
    {
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

        //выполняем
        $controller_instance = $this->controllerFactory->createController(
            $controller_class_name,
            $this->actionResultFactory,
            $this->renders);
        /**
         * @var $action_result ActionResultInterface
         */
        $action_result = call_user_func_array([$controller_instance, $action_method_name], $route_and_url_args);

        //если пусто
        if (empty($action_result)) {
            Ioc::factory(ModuleArgumentInterface::class);
        }

        //todo реализовать
    }
}