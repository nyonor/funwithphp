<?php
/**
 * Created by PhpStorm.
 * User: NyoNor
 * Date: 3/22/2018
 * Time: 7:50 AM
 */

namespace App\Modules\Mvc\Routing;


interface RouteArgumentInterface
{
    /**
     * RouteArgumentInterface constructor.
     * @param array $init_vals
     * $init_vals = [
     *  'template' => (string)
     *  'controller' => (string)
     *  'action' => (string)
     *  'route_parameters' => (array)
     *  'uri_parameters' => (array)
     *  'form_parameters' => (array)
     * ]
     */
    public function __construct(array $init_vals);

    /**
     * Шаблон по которому был сопоставлен маршрут
     * @return string
     */
    public function getTemplate();

    /**
     * Название контроллера (НЕ НАЗВАНИЕ КЛАССА)
     * @return string
     */
    public function getControllerName();

    /**
     * Название экшена
     * @return string
     */
    public function getActionName();

    /**
     * Массив параметров в URI (параметры ДО запятой) в виде:
     * название_параметра => значение
     * @return array //todo нифига не так пока
     */
    public function getRouteParameters();

    /**
     * Массив параметров ПОСЛЕ запятой
     * @return array //todo нихрена тут пока не массив
     */
    public function getUriParameters();

    /**
     * Параметры переданные через form
     * @return mixed //todo зедсь вообще пока пусто
     */
    public function getFormParameters();

    /**
     * Возвращает домен текущего запроса
     * @return string
     */
    public function getCurrentDomainName();

}