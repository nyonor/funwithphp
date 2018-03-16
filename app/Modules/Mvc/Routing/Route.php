<?php
/**
 * Created by PhpStorm.
 * User: NyoNor
 * Date: 3/16/2018
 * Time: 2:09 PM
 */

namespace App\Modules\Mvc\Routing;


class Route implements RouteInterface
{

    /**
     * Возвращает функцию по выполнению которой будут вызваны соответствующие классы и переданы
     * необходимые аргументы для выполнения маршрута
     * @return callable
     */
    public function GetCallChain(): callable
    {
        // TODO: Implement GetCallChain() method.
    }

    /**
     * Возвращает темплейт связанный с данным роутом
     * @return string
     */
    public function GetTemplate(): string
    {
        // TODO: Implement GetTemplate() method.
    }
}