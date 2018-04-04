<?php
/**
 * todo
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 4/4/18
 * Time: 3:51 PM
 */

namespace App\Modules\Mvc\Controller;


interface  ActionResultFactoryInterface
{
    public function getViewResult($view_name, $view_model) : ActionResultInterface;
    public function getJsonResult($to_json_content) : ActionResultInterface;
}