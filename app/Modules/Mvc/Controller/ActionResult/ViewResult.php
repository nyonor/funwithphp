<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 4/4/18
 * Time: 7:26 PM
 */

namespace App\Modules\Mvc\Controller\ActionResult;


use App\Modules\Mvc\View\Render\ViewRenderInterface;
use Exception;

final class ViewResult extends AbstractActionResult implements ViewResultInterface
{
    private $options;
    private $render;
    private $renderedContent;

    public function __construct(array $options, ViewRenderInterface $render)
    {
        $this->options = $options;
        $this->render = $render;
    }

    public function getViewName()
    {
        return $this->options['view_name'];
    }

    public function getViewModel()
    {
        return $this->options['view_model'];
    }

    public function getRenderedContent()
    {
        try {

            if (empty($this->renderedContent)){
                $this->render->setTemplatesPath($this->options['templates_path']);
                $this->render->setViewName($this->options['view_name']);
                $this->render->setViewModel($this->options['view_model']);
                $this->renderedContent = $this->render->render();
            }

            $this->isSuccessful = true;

            return $this->renderedContent;

        } catch (Exception $e) {
            $this->isSuccessful = false;
        } finally {
            return $this->renderedContent;
        }
    }

    public function isSuccessful(): bool
    {
        return $this->isSuccessful;
    }
}