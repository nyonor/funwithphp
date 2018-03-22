<?php
/**
 * Интерфейс для реализации в классах, которые позвляют получать объекты реализующие RouteInterface
 * Created by PhpStorm.
 * User: NyoNor
 * Date: 3/15/2018
 * Time: 2:09 PM
 */

namespace App\Modules\Mvc\Routing;


interface RoutingInterface
{
    /**
     * Фабрика создания роутов
     * @param $request RequestInterface
     * @return RouteInterface
     */
    public function getRoute($request) : RouteInterface;
}