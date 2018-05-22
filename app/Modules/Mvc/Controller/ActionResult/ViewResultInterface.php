<?php
/**
 * todo
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 4/4/18
 * Time: 1:12 PM
 */

namespace App\Modules\Mvc\Controller\ActionResult;


use App\Modules\Mvc\View\Render\ViewRenderInterface;

interface ViewResultInterface extends ActionResultInterface
{
    public function __construct(array $options, ViewRenderInterface $render);
    public function getViewName();
    public function getViewModel();
}