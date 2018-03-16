<?php
/**
 * Результат обработки шаблонов роутинга
 *
 * Created by PhpStorm.
 * User: NyoNor
 * Date: 3/16/2018
 * Time: 11:10 AM
 */

namespace App\Modules\Mvc\Routing;


interface RouteInterface
{

    /**
     * Возвращает функцию по выполнению которой будут вызваны соответствующие классы и переданы
     * необходимые аргументы для выполнения маршрута
     * @return callable
     */
    public function GetCallChain() : callable;

    /**
     * Возвращает темплейт связанный с данным роутом
     * @return string
     */
    public function GetTemplate() : string;
}