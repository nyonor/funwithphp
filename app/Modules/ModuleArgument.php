<?php
/**
 * Created by PhpStorm.
 * User: NyoNor
 * Date: 3/15/2018
 * Time: 6:16 PM
 */

namespace App\Modules;


use App\Modules\Mvc\Controller\ActionResultInterface;
use App\Modules\Mvc\Routing\RequestInterface;
use App\Modules\Mvc\Routing\ResponseInterface;

class ModuleArgument implements ModuleArgumentInterface
{
    protected $currentRequest = null;

    public function __construct(RequestInterface $request)
    {
        $this->currentRequest = $request;
    }

    public function getRequest(): RequestInterface
    {
        return $this->currentRequest;
    }

    public function getResponse() : ResponseInterface
    {
        // TODO: Implement getResponse() method.
    }

    public function getActionResult(): ActionResultInterface
    {
        // TODO: Implement getActionResult() method.
    }
}