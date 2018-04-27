<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 4/4/18
 * Time: 10:32 PM
 */

namespace App\Modules\Mvc\Controller;


use App\Http\RequestInterface;
use App\Http\ResponseInterface;
use App\Modules\Mvc\Routing\RouteInterface;

interface MvcControllerFactoryInterface
{
    public function createController(string $controller_class_name,
                                     ActionResultFactoryInterface $action_result_factory,
                                     RouteInterface $route,
                                     RequestInterface $request,
                                     ResponseInterface $response) : MvcControllerInterface;

    public function createAndCall(ActionResultFactoryInterface $action_result_factory,
                                  RouteInterface $route,
                                  RequestInterface $request,
                                  ResponseInterface $response) : ActionResultInterface;
}