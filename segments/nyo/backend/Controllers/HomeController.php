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
        echo "<h1>HomeController -> IndexAction</h1>";
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
        return $this->View();
    }
}