<?php
/**
 * Результат работы Pipeline
 *
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 4/23/18
 * Time: 7:40 PM
 */

namespace App\Pipeline;


use App\Http\ResponseInterface;
use App\Http\StringStream;
use App\Modules\ModuleArgumentInterface;
use App\Modules\ModuleResultInterface;

class ModuleArgumentHandler implements ModuleArgumentHandlerInterface
{
    /**
     * Финальная обработка
     * @param ModuleArgumentInterface $argument
     */
    public function handle(ModuleArgumentInterface $argument): void
    {
        $results = $argument->getAllResults();

        /**
         * @var $result ModuleResultInterface
         */
        foreach ($results as $result)
        {
            //если модуль изменяет респонс
            $modified_response_closure = $result->getModifiedResponseClosure();
            if (empty($modified_response_closure) == false) {
                //изменяем респонс на основе модуля
                $modified_response_closure();
            }

        }
    }
}