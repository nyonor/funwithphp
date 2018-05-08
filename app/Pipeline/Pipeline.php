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


use App\Modules\ModuleArgumentInterface;
use App\Modules\ModuleInterface;
use App\Http\RequestInterface;

/**
 * Class Pipeline
 * @package app\Pipeline
 * @property RequestInterface $request
 * @property ResponseHandlerInterface $responseHandler
 */
class Pipeline implements PipelineInterface
{
    protected $registeredModules = [];
    protected $exceptions = [];
    protected $moduleArgument = null;
    protected $responseHandler;

    /**
     * @var ModuleArgumentHandlerInterface
     */
    protected $moduleArgumentHandler;

    public function __construct(ModuleArgumentHandlerInterface $module_argument_handler,
                                ResponseHandlerInterface $response_handler)
    {
        $this->moduleArgumentHandler = $module_argument_handler;
        $this->responseHandler = $response_handler;
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
        $this->moduleArgument = $module_argument;

        foreach ($this->registeredModules as $module) {

            //выполняется логика модуля
            /**
             * @var $module ModuleInterface
             */
            $module_result = $module->process($this->moduleArgument);

            //добавление результата
            $this->moduleArgument->addResult($module_result);

            //логика модуля на исполнение
            $this->moduleArgumentHandler->handle($this->moduleArgument);
        }

        //все рисуем ответ пользователю
        $this->responseHandler->handle($this->moduleArgument->getResponse());
    }

    protected function handleExceptions(array $exceptions)
    {
        foreach ($exceptions as $exception) {
            throw new $exception;
        }
        //todo
    }
}