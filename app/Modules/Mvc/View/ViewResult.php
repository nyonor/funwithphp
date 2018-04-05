<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 4/4/18
 * Time: 7:26 PM
 */

namespace App\Modules\Mvc\View;


use App\Modules\Mvc\Controller\AbstractActionResult;
use App\Modules\Mvc\View\Render\ViewRenderInterface;
use stdClass;

final class ViewResult extends AbstractActionResult implements ViewResultInterface
{
    private $viewName;
    private $viewModel;
    private $render;

    public function __construct(string $view_name, stdClass $view_model = null, ViewRenderInterface $render)
    {
        $this->viewName = $view_name;
        $this->viewModel = $view_model;
        $this->render = $render;
    }

    public function getViewName()
    {
        return $this->viewName;
    }

    public function getViewModel()
    {
        return $this->viewModel;
    }

    public function getRenderedContent()
    {
        if (empty($this->renderedContent)){
            $this->render->set($this->viewName, $this->viewModel);
            $this->renderedContent = $this->render->render();
        }
        return $this->renderedContent;
    }
}