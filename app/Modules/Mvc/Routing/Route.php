<?php
/**
 * Created by PhpStorm.
 * User: NyoNor
 * Date: 3/16/2018
 * Time: 2:09 PM
 */

namespace App\Modules\Mvc\Routing;


use App\Config\Config;
use App\Pipeline\PipelineException;

class Route implements RouteInterface
{
    /**
     * Исходные аргументы
     * @var RouteArgumentInterface
     */
    protected $routeArgument;

    /**
     * Имя класса-контроллера
     * @var $controllerClassName string
     */
    protected $controllerClassName;

    /**
     * Текущий сегмент
     * @var $segment array
     */
    protected $segment;

    /**
     * RouteInterface constructor.
     * @param RouteArgumentInterface $argument
     */
    public function __construct(RouteArgumentInterface $argument)
    {
        $this->routeArgument = $argument;
    }

    /**
     * Возвращает функцию по выполнению которой будут вызваны соответствующие классы и переданы
     * необходимые аргументы для выполнения маршрута
     * @return callable
     */
    public function getCallChain(): callable
    {
        // TODO: Implement GetCallChain() method.
    }

    /**
     * Возвращает темплейт связанный с данным роутом
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->getTemplate();
    }

    /**
     * Возвращает ИМЯ КЛАССА, который является соответсвтующим контроллером
     * @return string
     * @throws PipelineException
     */
    public function getController(): string
    {
        if (empty($this->controllerClassName)){
            $this->controllerClassName = $this->findControllerClassName($this->routeArgument->getControllerName());
        }

        return $this->controllerClassName;
    }

    /**
     * Возвращает ИМЯ МЕТОДА, который является соответствующим экшеном
     * @return string
     */
    public function getAction(): string
    {
        // TODO: Implement GetAction() method.
    }

    /**
     * Возвращает соответствущие список параметров типа
     * имя_параметра => значение_параметра
     * @return array
     */
    public function getParameters(): array
    {
        // TODO: Implement GetParameters() method.
    }

    /**
     * Поиск сегмента в конфиге
     * @return array
     */
    public function getSegment(): array
    {
        if (empty($this->segment)) {
            foreach (Config::$projectSegments as $key => $val) {
                $segment_options = $val;
                if ($segment_options['domain_name'] != $this->routeArgument->getCurrentDomainName()){
                    continue;
                }

                $this->segment = Config::$projectSegments[$key];
                break;
            }
        }

        return $this->segment;
    }

    protected function findControllerClassName($controller_name)
    {
        $controller_class_name = null;
        $segment = $this->getSegment();
        if (empty($segment)) {
            throw new PipelineException("Сегмент не найден!");
        }
        $supposed_class_name = null;

        foreach ($segment['autoload_data'] as $namespace => $path) {

        }

        $res = class_exists($supposed_class_name, true);
        var_dump($res);

        return $controller_class_name;
    }
}