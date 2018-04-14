<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 4/4/18
 * Time: 3:50 PM
 */

namespace App\Modules\Mvc\Controller;


use App\Modules\Mvc\Routing\RequestInterface;
use App\Modules\Mvc\Routing\ResponseInterface;

interface MvcControllerInterface
{
    public function getControllerClassName();

    /**
     * Возвращает ассоциированный с контроллером реквест
     * @return RequestInterface
     */
    public function getRequest() : RequestInterface;

    /**
     * Возвращает соответствующий респонс
     * @return ResponseInterface
     */
    public function getResponse() : ResponseInterface;
}