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

/**
 * Class Pipeline
 * @package App\Pipeline
 * @property RequestInterface $request
 */
class Pipeline implements PipelineInterface
{
    protected $registeredModules = [];
    protected $request = null;

    function __construct()
    {
        $this->request = Ioc::factory(RequestInterface::class);
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
    public function process($request_array = null)
    {
        //создаем объект запроса (Request)
        if ($request_array != null) {
            $this->request = Ioc::factoryWithArgs(RequestInterface::class, $request_array);
        }

        $result = null;
        foreach ($this->registeredModules as $module) {
            if ($result == null) {
                $args = $this->request;
            } else {
                $args = $result;
            }
            /**
             * @var $module ModuleInterface
             */
            $result = $module->process(Ioc::factoryWithArgs(ModuleArgumentInterface::class, $args));
        }
    }
}