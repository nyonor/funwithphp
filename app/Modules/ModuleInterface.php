<?php
/**
 * @todo описание
 * Created by PhpStorm.
 * User: NyoNor
 * Date: 3/15/2018
 * Time: 11:29 AM
 */

namespace App\Modules;


use App\Modules\Mvc\Routing\RequestInterface;

interface ModuleInterface
{
    /**
     * Запуск модуля, начало работы и инциализация
     * @param ModuleArgumentInterface $argument
     * @return ModuleArgumentInterface ;
     */
    public function process(ModuleArgumentInterface $argument): ModuleArgumentInterface;

    /**
     * Возвращает ассоциированый с запросом реквест
     * @return RequestInterface
     */
    public function getRequest() : RequestInterface;
}