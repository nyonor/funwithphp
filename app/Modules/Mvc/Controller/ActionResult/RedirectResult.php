<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/21/18
 * Time: 4:12 PM
 */

namespace App\Modules\Mvc\Controller\ActionResult;


class RedirectResult extends AbstractActionResult implements RedirectResultInterface
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

    public function getRenderedContent()
    {
        // TODO: Implement getRenderedContent() method.
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