<?php
/**
 * Конвеер обработки запроса
 *
 * Created by PhpStorm.
 * User: NyoNor
 * Date: 19.02.2018
 * Time: 21:49
 */

namespace App\Pipeline;


use App\Ioc\Ioc;
use App\Modules\ModuleArgumentInterface;
use App\Modules\ModuleInterface;
use App\Modules\Mvc\Routing\RequestInterface;
use App\Modules\Mvc\Routing\Response;
use App\Modules\Mvc\Routing\ResponseInterface;
use Exception;

/**
 * Class Pipeline
 * @package app\Pipeline
 * @property RequestInterface $request
 */
class Pipeline implements PipelineInterface
{
    protected $registeredModules = [];
    protected $exceptions = [];
    protected $module_argument = null;

    /**
     * @var PipelineHandlerInterface
     */
    protected $pipelineHandler;

    public function __construct(PipelineHandlerInterface $pipeline_handler)
    {
        $this->pipelineHandler = $pipeline_handler;
    }

    /**
     * Регистрирует модуль в пайпе
     * @param ModuleInterface $module
     * @return $this
     * @throws PipelineException
     */
    public function registerModule(ModuleInterface $module)
    {
        $foundModuleKey = array_search($module, $this->registeredModules);
        if ($foundModuleKey != false) {
            $foundModule = $this->registeredModules[$foundModuleKey];
            if (isset($foundModule) && get_class($module) == get_class($foundModule)) {
                throw new PipelineException("Модуль уже зарегистрирован в пайплайне!");
            }
        }

        $this->registeredModules[get_class($module)] = $module;
        return $this;
    }

    /**
     * Запускает обработку запроса через все зарегистрированные модули
     * в первый зарегистрированный модуль, затем в следующий и так далее
     * пока массив всех модулей не будет пройден.
     * @param ModuleArgumentInterface $module_argument
     * @return void
     */
    public function go(ModuleArgumentInterface $module_argument)
    {
        $this->module_argument = $module_argument;

        foreach ($this->registeredModules as $module) {

            /**
             * @var $module ModuleInterface
             */
            $module_result = $module->process($this->module_argument);
            $this->module_argument->addResult($module_result);
        }

        $this->handleResponse();
    }

    /**
     * Обработка результатов модулей и ответ
     */
    protected function handleResponse()
    {
        $this->pipelineHandler->handle($this->module_argument);

        //todo обработка результатов и ответ
    }

    protected function handleExceptions(array $exceptions)
    {
        foreach ($exceptions as $exception) {
            throw new $exception;
        }
        //todo
    }
}