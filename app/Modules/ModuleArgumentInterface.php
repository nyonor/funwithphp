<?php
/**
 * Унифицированный интерфейс объектов для инициализации и
 * передачи аргументов между модулями. Наследование от этого базового интерфейса
 * позволит расширять функционал общения между модулями
 *
 * Created by PhpStorm.
 * User: NyoNor
 * Date: 3/15/2018
 * Time: 12:06 PM
 */

namespace App\Modules;


use App\Modules\Mvc\Controller\ActionResultInterface;
use App\Modules\Mvc\Routing\RequestInterface;
use App\Modules\Mvc\Routing\ResponseInterface;

interface ModuleArgumentInterface
{
    public function __construct(RequestInterface $request);
    public function getRequest() : RequestInterface;
    public function getResponse() : ResponseInterface;
    public function getActionResult() : ActionResultInterface;
}