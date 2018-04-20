<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 4/4/18
 * Time: 10:43 PM
 */

namespace App\Modules\Mvc\Controller;


use App\Modules\Mvc\Routing\RequestInterface;
use App\Modules\Mvc\Routing\ResponseInterface;
use App\Modules\Mvc\Routing\RouteInterface;
use App\Modules\Mvc\View\Render\RenderInterface;

class MvcControllerFactory implements MvcControllerFactoryInterface
{
    public function createController(string $controller_class_name,
                                     ActionResultFactoryInterface $action_result_factory,
                                     RouteInterface $route,
                                     RequestInterface $request,
                                     ResponseInterface $response): MvcControllerInterface
    {
        return new $controller_class_name($action_result_factory, $route, $request, $response);
    }

    public function createAndCall(ActionResultFactoryInterface $action_result_factory,
                                  RouteInterface $route,
                                  RequestInterface $request,
                                  ResponseInterface $response): ActionResultInterface
    {
        //получаем контоллер
        $controller_class_name = $route->getControllerClassName();

        //экшн
        $action_method_name = $route->getActionMethodName();

        //параметры
        $route_and_url_args = $route->getParameters();;

        //создаем контроллер
        $controller_instance = $this->createController(
            $controller_class_name,
            $action_result_factory,
            $route,
            $request,
            $response
        );

        //вызываем метод контроллера (экшен)
        /**
         * @var $action_result ActionResultInterface
         */
        $action_result = call_user_func_array([$controller_instance, $action_method_name], $route_and_url_args);

        return $action_result;
    }
}