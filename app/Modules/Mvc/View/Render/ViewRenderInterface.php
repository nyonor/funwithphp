<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 4/5/18
 * Time: 3:00 PM
 */

namespace App\Modules\Mvc\View\Render;


use App\Modules\Mvc\View\ViewResultInterface;

interface ViewRenderInterface extends RenderInterface
{
    public function getViewResultInterface() : ViewResultInterface;
    public function set($view_path, $view_model);
}