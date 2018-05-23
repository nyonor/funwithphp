<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/21/18
 * Time: 4:12 PM
 */

namespace App\Modules\Mvc\Controller\ActionResult;


class RedirectToRouteResult extends AbstractActionResult implements RedirectToRouteResultInterface
{
    protected $controllerName;
    protected $actionName;
    protected $parametersArray;

    public function __construct($controller_name, $action_name, array $parameters = null)
    {
        $this->controllerName = $controller_name;
        $this->actionName = $action_name;
        $this->parametersArray = $parameters;
    }

    public function getResult()
    {
        $result = '/';

        if (empty($this->controllerName) == false) {
            $result .= $this->controllerName;
        }

        if (empty($this->actionName) == false) {
            $result .= $this->actionName;
        }

        if (empty($this->parametersArray) == false && count($this->parametersArray) > 0) {
            $result .= http_build_query($this->parametersArray);
        }

        return $result;
    }

    public function getControllerName(): string
    {
        return $this->controllerName;
    }

    public function getActionName(): string
    {
        return $this->actionName;
    }

    public function getParametersArray(): array
    {
        return $this->parametersArray;
    }
}