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
    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getUri()
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function getRawParameters()
    {
        return $_REQUEST;
    }

    public function getDomain()
    {
        return $_SERVER['HTTP_HOST'];
    }
}