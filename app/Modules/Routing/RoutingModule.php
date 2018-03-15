<?php
/**
 * Created by PhpStorm.
 * User: NyoNor
 * Date: 3/15/2018
 * Time: 2:09 PM
 */

namespace App\Modules\Routing;


use App\Modules\ModuleArgumentInterface;

class RoutingModule implements RoutingModuleInterface
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