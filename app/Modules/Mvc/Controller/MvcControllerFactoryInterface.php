<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 4/4/18
 * Time: 10:32 PM
 */

namespace App\Modules\Mvc\Controller;


use App\Modules\View\RendererInterface;

interface MvcControllerFactoryInterface
{
    public function createController(string $controller_class_name,
                                     ActionResultFactoryInterface $action_result_factory,
                                     RendererInterface ...$renders) : MvcControllerInterface;
}