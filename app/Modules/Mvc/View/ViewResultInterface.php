<?php
/**
 * todo
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 4/4/18
 * Time: 1:12 PM
 */

namespace App\Modules\Mvc\View;


use App\Modules\Mvc\Controller\ActionResultInterface;
use App\Modules\Mvc\View\Render\ViewRenderInterface;

interface ViewResultInterface extends ActionResultInterface
{
    public function __construct(array $options, ViewRenderInterface $render);
    public function getViewName();
    public function getViewModel();
}