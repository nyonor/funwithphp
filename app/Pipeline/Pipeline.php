<?php
/**
 * Регистрирует порядок подключения модулей
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
    protected $request = null;
    protected $response = null;
    protected $result = null;
    protected $exceptions = [];

    function __construct()
    {
        $this->request = Ioc::factory(RequestInterface::class); //todo inject through constructor
        $this->response = Ioc::factory(ResponseInterface::class); //todo inject thought constructor
    }

    /**
     * Регистрирует модуль в пайпе
     * @param ModuleInterface $module
     * @return $this
     * @throws PipelineException
     */
    function registerModule(ModuleInterface $module)
    {
        $foundModuleKey = array_search($module, $this->registeredModules);
        $foundModule = $this->registeredModules[$foundModuleKey];
        if (isset($foundModule) && get_class($module) == get_class($foundModule)) {
            throw new PipelineException("Модуль уже зарегистрирован в пайплайне!");
        }
        $this->registeredModules[get_class($module)] = $module;
        return $this;
    }

    /**
     * Запускает обработку запроса через все зарегистрированные модули
     * в первый зарегистрированный модуль, затем в следующий и так далее
     * пока массив всех модулей не будет пройден.
     * @return void
     */
    public function go()
    {
        foreach ($this->registeredModules as $module) {

            if ($this->result == null) {
                $args = ['request' => $this->request, 'response' => $this->response];
            } else {
                $args = $this->result;
            }
            /**
             * @var $module ModuleInterface
             */
            $this->result = $module->process(Ioc::factoryWithArgs(ModuleArgumentInterface::class, $args)); //todo inject throug constructor

        }

        $this->handleResponse($this->result);
    }

    public function handleResponse(ModuleArgumentInterface $moduleArgument)
    {
        if (!empty($this->exceptions)){
            $this->handleExceptions($this->exceptions);
        }

        //TODO вывод результатов
    }

    protected function handleExceptions(array $exceptions)
    {
        foreach ($exceptions as $exception) {
            throw new $exception;
        }
        //todo
    }
}