<?php
/**
 * Создает Route на основе переданных данных
 *
 * Created by PhpStorm.
 * User: NyoNor
 * Date: 3/15/2018
 * Time: 2:09 PM
 */

namespace App\Modules\Mvc\Routing;


class Routing implements RoutingInterface
{
    protected $argument;

    /**
     * Фабрика создания роутов
     * @param $request RequestInterface
     * @return RouteInterface
     */
    public function GetRoute($request): RouteInterface
    {
        //todo реализация
    }
}