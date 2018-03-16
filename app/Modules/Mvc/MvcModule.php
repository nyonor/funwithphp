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
    public function Process(ModuleArgumentInterface $argument = null): ModuleArgumentInterface
    {
        /**
         * @var $routing RoutingInterface
         */
        //создаем роут на основе входящих аргументов
        $routing = Ioc::FactoryWithArgs(RoutingInterface::class, $argument);
        $route = $routing->GetRoute($argument->GetRequest());

        //получаем контоллер
        $controller = $route->GetController();

        //экшн
        $action = $route->GetAction();

        //параметры
        $parameters = $route->GetParameters();

        //выполняем
        $result = $controller->$action($parameters);

        //todo реализовать
    }
}