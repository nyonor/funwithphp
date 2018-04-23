<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 4/23/18
 * Time: 7:40 PM
 */

namespace App\Pipeline;


use App\Modules\ModuleArgumentInterface;
use App\Modules\ModuleResultInterface;

class PipelineHandler implements PipelineHandlerInterface
{

    /**
     * Финальная обработка
     * @param ModuleArgumentInterface $argument
     */
    public function handle(ModuleArgumentInterface $argument): void
    {
        $results = $argument->getAllResults();

        foreach ($results as $result)
        {
            /**
             * @var $result ModuleResultInterface
             */
            $closure = $result->getResultClosure();
            echo $closure();
        }
    }
}