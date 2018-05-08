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


use App\Http\RequestInterface;
use App\Http\ResponseInterface;

interface ModuleArgumentInterface
{
    public function __construct(array $request_and_response);
    /**
     * Возвращает ассоциированый с запросом реквест
     * @return RequestInterface
     */
    public function getRequest() : RequestInterface;

    /**
     * Возвращает ассоциированый с запросом респонс
     * @return ResponseInterface
     */
    public function getResponse() : ResponseInterface;

    /**
     * Устанавливает новый респонс
     * @param ResponseInterface $new_response_instance
     */
    public function setResponse(ResponseInterface $new_response_instance) : void;

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

    /**
     * Возвращает последний результат выполнения
     * @return ModuleResultInterface
     */
    public function getLastResult() : ?ModuleResultInterface;

    /**
     * Вернет результат выполнения модуля по имени его класса,
     * если таковой существует
     * @param string $module_class_name
     * @return ModuleResultInterface|null
     */
    public function getModuleResult(string $module_class_name) : ?ModuleResultInterface;
}