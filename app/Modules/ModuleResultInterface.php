<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 4/13/18
 * Time: 5:09 PM
 */

namespace App\Modules;


interface ModuleResultInterface
{
    /**
     * Возвращает модуль в результате которого был создан объект
     * @return ModuleInterface
     */
    public function getSubjectModule() : ModuleInterface;

    /**
     * Возвращает объект, который модуль передал в качестве результата
     * @return mixed
     */
    public function getTheResult();
}