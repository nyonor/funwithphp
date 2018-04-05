<?php
/**
 * todo
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 4/4/18
 * Time: 3:51 PM
 */

namespace App\Modules\Mvc\Controller;


use App\Modules\Mvc\View\Render\RenderInterface;

interface  ActionResultFactoryInterface
{
    public function __construct(RenderInterface... $renders);
    public function getViewResult($view_path, $view_model) : ActionResultInterface;
    public function getJsonResult($to_json_content) : ActionResultInterface;
}