<?php
/**
 * Возвращается модулями для сохранения результатов работы
 *
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 4/13/18
 * Time: 5:09 PM
 */

namespace App\Modules;


use App\Modules\Mvc\MvcModule;

class ModuleResult implements ModuleResultInterface
{
    protected $module;

    /**
     * На основании модуля, который сгенерировал
     * данный объект
     * ModuleResult constructor.
     * @param ModuleInterface $module
     */
    public function __construct(ModuleInterface $module)
    {
        $this->module = $module;
    }

    /**
     * Возвращает модуль в результате которого был создан объект
     * @return ModuleInterface
     */
    public function getSubjectModule(): ModuleInterface
    {
        return $this->module;
    }
}