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
use App\Modules\Mvc\ModuleResultTest;
use App\Modules\Mvc\Routing\RequestInterface;
use App\Modules\Mvc\Routing\ResponseInterface;

interface ModuleArgumentInterface
{
    public function __construct(array $request_and_response);
    public function getRequest() : RequestInterface;
    public function getResponse() : ResponseInterface;

    /**
     * Добавляет результат выполнеия модуля к объекту
     * @param ModuleResultInterface $result
     * @return mixed
     */
    public function addResult(ModuleResultInterface $result);

    /**
     * Возвращает все результаты выполнения
     * @return array @type ModuleResultInterface
     */
    public function getAllResults() : array;
}