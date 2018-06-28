<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 4/5/18
 * Time: 12:18 PM
 */

namespace App\Modules\Mvc\View\Render;


use function App\Helpers\Globals\container;
use App\Helpers\PathInterface;
use App\Ioc\Ioc;
use Twig_Environment;
use Twig_Loader_Filesystem;

final class TwigRender implements ViewRenderInterface
{
    const VIEW_EXTENSION = '.twig';

    protected $viewName;
    protected $viewModel;
    protected $templatesPath = [];

    protected $twigLoader;
    protected $twig;

    public function __construct(array $helpers)
    {
        $this->twigLoader = new Twig_Loader_Filesystem(null, getcwd().'/..');
        $this->twig = new Twig_Environment($this->twigLoader);

        //регистрируем хелперы

        //globals
        foreach ($helpers['globals'] as $key => $val) {
            $this->twig->addGlobal($key, $val);
        }

        $this->twig->addExtension(new \Twig_Extension_Debug());

    }

    public function render()
    {
        $this->twigLoader->setPaths($this->templatesPath);
        $template = $this->twig->load($this->viewName);
        return $template->render($this->viewModel ?? []);
    }

    public function setViewName($view_name)
    {
        $this->viewName = $view_name . self::VIEW_EXTENSION;
    }

    public function setTemplatesPath(array $templates_path)
    {
        foreach ($templates_path as $path) {
            array_push($this->templatesPath, ltrim($path, '/'));
        }
    }

    public function setViewModel($view_model)
    {
        $this->viewModel = $view_model;
    }
}