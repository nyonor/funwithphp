<?php
/**
 * Created by PhpStorm.
 * User: NyoNor
 * Date: 3/15/2018
 * Time: 2:52 PM
 */

namespace App\Modules\Routing;


interface RequestInterface
{
    public function GetRawRequestArray();
}