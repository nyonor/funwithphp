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
use Exception;

/**
 * Class Pipeline
 * @package App\Pipeline
 * @property RequestInterface $request
 */
class Pipeline implements PipelineInterface
{
    protected $registeredModules = [];
    protected $request = null;
    protected $result = null;
    protected $exceptions = [];

    function __construct()
    {
        $this->request = Ioc::factory(RequestInterface::class); //todo inject throug constructor
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
     * в этом методе входные параметры будут преобразованы в ModuleArgument
     * и будут переданы в первый зарегистрированный модуль, затем в следующий и так далее
     * пока массив всех модулей не будет пройден.
     * @param $request_array
     * @return void
     */
    public function go($request_array = null)
    {
        //создаем объект запроса (Request)
        if ($request_array != null) {
            $this->request = Ioc::factoryWithArgs(RequestInterface::class, $request_array); //todo inject throug constructor
        }

        foreach ($this->registeredModules as $module) {
            try{
                if ($this->result == null) {
                    $args = $this->request;
                } else {
                    $args = $this->result;
                }
                /**
                 * @var $module ModuleInterface
                 */
                $this->result = $module->process(Ioc::factoryWithArgs(ModuleArgumentInterface::class, $args)); //todo inject throug constructor
            } catch (Exception $e) {
                array_push($this->exceptions, $e);
            }
        }

        $this->handleResponse($this->result);
    }

    public function handleResponse(ModuleArgumentInterface $moduleArgument)
    {
        if (!empty($this->exceptions)){
            $this->handleExceptions();
        }

        //TODO вывод результатов
    }

    protected function handleExceptions()
    {
        //todo
    }
}