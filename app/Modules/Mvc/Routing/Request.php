<?php
/**
 * Created by PhpStorm.
 * User: NyoNor
 * Date: 3/15/2018
 * Time: 2:39 PM
 */

namespace App\Modules\Mvc\Routing;


class Request implements RequestInterface
{
    public function GetMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function GetUri()
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function GetParameters()
    {
        return $_REQUEST;
    }
}