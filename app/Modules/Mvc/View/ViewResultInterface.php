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

interface ViewResultInterface extends ActionResultInterface
{
    public function getViewName();
    public function getViewModel();
}