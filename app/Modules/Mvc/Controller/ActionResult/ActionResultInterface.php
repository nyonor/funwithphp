<?php
/**
 * todo
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 4/4/18
 * Time: 12:45 PM
 */

namespace App\Modules\Mvc\Controller\ActionResult;


interface ActionResultInterface
{
    //todo перенести в интерфейс ViewResultInterface
    public function getRenderedContent();

    public function isSuccessful() : bool;
}