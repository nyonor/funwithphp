<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 4/5/18
 * Time: 12:18 PM
 */

namespace App\Modules\Mvc\View\Render;


use App\Modules\Mvc\View\ViewResultInterface;

final class TwigRender implements TwigRenderInterface
{
    protected $viewName;
    protected $viewModel;

    public function render()
    {
        echo 'Doing TWIGRENDER';
    }

    public function getViewResultInterface(): ViewResultInterface
    {
        // TODO: Implement getViewResultInterface() method.
    }

    public function set($view_name, $view_model)
    {
        $this->viewName = $view_name;
        $this->viewModel = $view_model;
    }
}