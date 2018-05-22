<?php
/**
 * todo
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 4/4/18
 * Time: 3:51 PM
 */

namespace App\Modules\Mvc\Controller\ActionResult;


use App\Modules\Mvc\View\Render\RenderInterface;

interface  ActionResultFactoryInterface
{
    public function __construct(RenderInterface... $renders);
    public function getViewResult(array $options) : ActionResultInterface;
    public function getJsonResult($to_json_content) : ActionResultInterface;
    public function getRedirectResult(string $controller_name, string $action_name, array $parameters_array = null);
    public function getRedirectResultToUrl($url);
}