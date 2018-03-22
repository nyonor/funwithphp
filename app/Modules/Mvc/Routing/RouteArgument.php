<?php
/**
 * Класс для хранения аргументов для создания Route
 * Created by PhpStorm.
 * User: NyoNor
 * Date: 3/22/2018
 * Time: 7:47 AM
 */

namespace App\Modules\Mvc\Routing;


class RouteArgument implements RouteArgumentInterface
{
    protected $template;
    protected $controllerName;
    protected $actionName;
    protected $routeParameters;
    protected $uriParameters;
    protected $formParameters;
    protected $domainName;

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
    public function __construct(array $init_vals)
    {
        var_dump($init_vals);
        $this->template = $init_vals['template'];
        $this->controllerName = $init_vals['controller'];
        $this->actionName = $init_vals['action'];
        $this->routeParameters = $init_vals['route_parameters'];
        $this->uriParameters = $init_vals['uri_parameters'];
        $this->formParameters = $init_vals['form_parameters'];
        $this->domainName = $init_vals['domain_name'];
    }

    /**
     * Шаблон по которому был сопоставлен маршрут
     * @return string
     */
    public function getTemplate() : string
    {
        return $this->template;
    }

    /**
     * Название контроллера (НЕ НАЗВАНИЕ КЛАССА)
     * @return string
     */
    public function getControllerName() : string
    {
        return $this->controllerName;
    }

    /**
     * Название экшена
     * @return string
     */
    public function getActionName() : string
    {
        return $this->actionName;
    }

    /**
     * Массив параметров в URI (параметры ДО запятой) в виде:
     * название_параметра => значение
     * @return array //todo нифига не так пока
     */
    public function getRouteParameters() : array
    {
        return $this->routeParameters;
    }

    /**
     * Массив параметров ПОСЛЕ запятой
     * @return array //todo нихрена тут пока не массив
     */
    public function getUriParameters() : array
    {
        return $this->uriParameters;
    }

    /**
     * Параметры переданные через form
     * @return mixed //todo зедсь вообще пока пусто
     */
    public function getFormParameters() : array
    {
        return $this->formParameters;
    }

    /**
     * Возвращает домен текущего запроса
     * @return string
     */
    public function getCurrentDomainName()
    {
        return $this->domainName;
    }
}