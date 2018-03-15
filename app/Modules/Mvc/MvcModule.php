<?php
/**
 * Created by PhpStorm.
 * User: NyoNor
 * Date: 3/15/2018
 * Time: 1:50 PM
 */

namespace App\Modules\Mvc;


use App\Modules\ModuleArgumentInterface;

class MvcModule implements MvcModuleInterface
{
    /**
     * Запуск модуля, начало работы и инциализация
     * @param ModuleArgumentInterface $argument
     * @return ModuleArgumentInterface ;
     */
    public function Process(ModuleArgumentInterface $argument = null): ModuleArgumentInterface
    {
        // TODO: Implement StartModule() method.
    }
}