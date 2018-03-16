<?php
/**
 * Created by PhpStorm.
 * User: NyoNor
 * Date: 3/15/2018
 * Time: 6:16 PM
 */

namespace App\Modules;


use App\Modules\Mvc\Routing\RequestInterface;

class ModuleArgument implements ModuleArgumentInterface
{
    protected $currentRequest = null;

    public function __construct(RequestInterface $request)
    {
        $this->currentRequest = $request;
    }

    public function GetRequest(): RequestInterface
    {
        return $this->currentRequest;
    }
}