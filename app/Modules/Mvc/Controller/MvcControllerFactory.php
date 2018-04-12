<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 4/4/18
 * Time: 10:43 PM
 */

namespace App\Modules\Mvc\Controller;


use App\Modules\Mvc\Routing\RequestInterface;
use App\Modules\Mvc\Routing\RouteInterface;
use App\Modules\Mvc\View\Render\RenderInterface;

class MvcControllerFactory implements MvcControllerFactoryInterface
{
    public function createController(string $controller_class_name,
                                     ActionResultFactoryInterface $action_result_factory,
                                     RouteInterface $route, RequestInterface $request): MvcControllerInterface
    {
        return new $controller_class_name($action_result_factory, $route);
    }
}