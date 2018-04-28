<?php
/**
 * //todo
 * Created by PhpStorm.
 * User: NyoNor
 * Date: 3/15/2018
 * Time: 2:52 PM
 */

namespace App\Http;


use Psr\Http\Message\MessageInterface;

interface RequestInterface extends \Psr\Http\Message\RequestInterface
{
    public function getMethod();
    public function getUri();
    public function getRawParameters();
    public function getDomain();
}