<?php
/**
 * todo
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 4/4/18
 * Time: 12:45 PM
 */

namespace App\Modules\Mvc\Controller\ActionResult;


use Exception;

interface ActionResultInterface
{
    public function getResult();
    public function getException();
    public function isSuccessful() : bool;
}