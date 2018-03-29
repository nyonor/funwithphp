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
     * RouteInterface constructor.
     * @param RouteArgumentInterface $argument
     */
    public function __construct(RouteArgumentInterface $argument);

    /**
     * Возвращает функцию по выполнению которой будут вызваны соответствующие классы и переданы
     * необходимые аргументы для выполнения маршрута
     * @return callable
     */
    public function getCallChain() : callable;

    /**
     * Возвращает темплейт связанный с данным роутом
     * @return string
     */
    public function getTemplate() : string;

    /**
     * Возвращает ИМЯ КЛАССА, который является соответсвтующим контроллером
     * @return string
     */
    public function getControllerClassName() : string;

    /**
     * Возвращает ИМЯ МЕТОДА, который является соответствующим экшеном
     * @return string
     */
    public function getActionMethodName() : string;

    /**
     * Возвращает соответствущие список параметров типа
     * имя_параметра => значение_параметра
     * @return array
     */
    public function getParameters() : array;

    /**
     * На основании
     * @return array
     */
    public function getSegment() : array;
}