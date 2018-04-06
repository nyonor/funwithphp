<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 4/5/18
 * Time: 3:00 PM
 */

namespace App\Modules\Mvc\View\Render;


use App\Modules\Mvc\View\ViewResultInterface;
use stdClass;

interface ViewRenderInterface extends RenderInterface
{
    public function setViewName($view_name);
    public function setTemplatesPath($templates_path);
    public function setViewModel($view_model);
}