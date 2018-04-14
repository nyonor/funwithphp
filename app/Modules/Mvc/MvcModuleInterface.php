<?php
/**
 * Created by PhpStorm.
 * User: NyoNor
 * Date: 3/15/2018
 * Time: 1:48 PM
 */

namespace App\Modules\Mvc;


use App\Modules\ModuleInterface;
use App\Modules\Mvc\Routing\RequestInterface;
use App\Modules\Mvc\Routing\ResponseInterface;

interface MvcModuleInterface extends ModuleInterface
{
    /**
     * Возвращает ассоциированый с запросом реквест
     * @return RequestInterface
     */
    public function getRequest() : RequestInterface;

    /**
     * Возвращает ассоциированый с запросом реквест
     * @return ResponseInterface
     */
    public function getResponse() : ResponseInterface;
}