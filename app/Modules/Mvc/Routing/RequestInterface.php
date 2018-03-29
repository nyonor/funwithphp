<?php
/**
 * Created by PhpStorm.
 * User: NyoNor
 * Date: 3/15/2018
 * Time: 2:52 PM
 */

namespace App\Modules\Mvc\Routing;


interface RequestInterface
{
    public function getMethod();
    public function getUri();
    public function getRawParameters();
    public function getDomain();
}