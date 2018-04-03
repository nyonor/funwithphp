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
use App\Modules\Mvc\Routing\RoutingInterface;

class MvcModule implements MvcModuleInterface
{
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
        $routing = Ioc::factoryWithArgs(RoutingInterface::class, $argument);
        $route = $routing->getRoute($argument->getRequest());

        //получаем контоллер
        $controller_class_name = $route->getControllerClassName();

        //экшн
        $action_method_name = $route->getActionMethodName();

        //параметры
        $route_and_url_args = $route->getParameters();

        //выполняем
        $controller_instance = new $controller_class_name;
        /**
         * @var $action_result ActionResultInterface
         */
        $action_result = call_user_func_array([$controller_instance, $action_method_name], $route_and_url_args);

        //если
        if (empty($action_result)) {
            return null;
        }

        //todo реализовать
    }
}