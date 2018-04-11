<?php
/**
 * Created by PhpStorm.
 * User: NyoNor
 * Date: 3/22/2018
 * Time: 1:23 PM
 */

namespace Segments\Nyo\Backend\Controllers;


use App\Modules\Mvc\Controller\AbstractMvcController;

class HomeController extends AbstractMvcController
{
    protected function indexAction()
    {
        return $this->view();
    }

    protected function pageAction(int $x)
    {
        echo "<h1>HomeController -> PageAction(page $x)</h1>";
    }

    protected function elseAction(string $some, $andAnother)
    {
        echo "<h1>HomeController -> elseAction($some, $andAnother)</h1>";
    }

    protected function simpleViewAction(int $x)
    {
        return $this->view();
    }

    protected function withViewModelAction($some_arg)
    {
        return $this->viewWithModel(['some_arg' => $some_arg, 'and_another' => 'this is another!']);
    }
}