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


use App\Modules\Mvc\Routing\RequestInterface;

interface ModuleArgumentInterface
{
    public function __construct(RequestInterface $request);
    public function getRequest() : RequestInterface;
    public function getResponse() : ResponseInterface;
}