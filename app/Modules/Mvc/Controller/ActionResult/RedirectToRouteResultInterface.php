<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/21/18
 * Time: 6:23 PM
 */

namespace App\Modules\Mvc\Controller\ActionResult;


interface RedirectToRouteResultInterface extends RedirectToUrlResultInterface
{
    public function getControllerName() : string;
    public function getActionName() : string;
    public function getParametersArray() : array;
}