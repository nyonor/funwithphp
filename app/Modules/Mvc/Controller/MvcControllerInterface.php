<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 4/4/18
 * Time: 3:50 PM
 */

namespace App\Modules\Mvc\Controller;


interface MvcControllerInterface
{
    public function getActionResultFactory() : ActionResultFactoryInterface;
}