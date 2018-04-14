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
     * Обработка модулем аргумента и возращение результатов
     * @param ModuleArgumentInterface $argument
     * @return ModuleResultInterface ;
     */
    public function process(ModuleArgumentInterface $argument): ModuleResultInterface;

    /**
     * Возвращает полное имя модуля
     * @return string
     */
    public function getNameOfModule() : string;
}