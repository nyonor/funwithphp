<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 4/4/18
 * Time: 7:24 PM
 */

namespace App\Modules\Mvc\Controller;


abstract class AbstractActionResult implements ActionResultInterface
{
    protected $renderedContent;

    public function getRenderedContent()
    {
        return $this->renderedContent;
    }
}