<?php
/**
 * Created by PhpStorm.
 * User: NyoNor
 * Date: 3/15/2018
 * Time: 1:50 PM
 */

namespace App\Modules\Mvc;


use App\Ioc\Ioc;
use App\Modules\ModuleArgumentInterface;
use App\Modules\Mvc\Routing\RoutingInterface;

class MvcModule implements MvcModuleInterface
{
    /**
     * Запуск модуля, начало работы и инциализация
     * @param ModuleArgumentInterface $argument
     * @return ModuleArgumentInterface ;
     */
    public function process(ModuleArgumentInterface $argument = null): ModuleArgumentInterface
    {
        /**
         * @var $routing RoutingInterface
         */
        //создаем роут на основе входящих аргументов
        $routing = Ioc::factoryWithArgs(RoutingInterface::class, $argument);
        $route = $routing->getRoute($argument->getRequest());

        //получаем контоллер
        $controller_class_name = $route->getControllerClassName();

        //экшн
        $action_method_name = $route->getActionMethodName();

        //параметры
        //$parameters_ = $route->getParameters();

        //выполняем
        //$result = $controller->$action($parameters);

        //todo реализовать
    }
}