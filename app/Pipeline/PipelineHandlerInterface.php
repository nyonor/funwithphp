<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 4/23/18
 * Time: 7:09 PM
 */

namespace App\Pipeline;


use App\Modules\ModuleArgumentInterface;

interface PipelineHandlerInterface
{
    /**
     * Финальная обработка
     * @param ModuleArgumentInterface $argument
     */
    public function handle(ModuleArgumentInterface $argument) : void;
}