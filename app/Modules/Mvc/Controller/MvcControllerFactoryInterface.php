<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 4/4/18
 * Time: 10:32 PM
 */

namespace App\Modules\Mvc\Controller;


use App\Modules\Mvc\View\Render\RenderInterface;

interface MvcControllerFactoryInterface
{
    public function createController(string $controller_class_name,
                                     ActionResultFactoryInterface $action_result_factory,
                                     RenderInterface ...$renders) : MvcControllerInterface;
}