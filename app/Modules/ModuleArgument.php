<?php
/**
 * Используется в качестве аргумента на входе ModuleInterface
 * будет передаваться всем модулям зарегстрированным в пайпе, последовательно
 * каждый модуль будет добавлять сюда свои ModuleResult
 *
 * Created by PhpStorm.
 * User: NyoNor
 * Date: 3/15/2018
 * Time: 6:16 PM
 */

namespace App\Modules;


use App\Modules\Mvc\Controller\ActionResultInterface;
use App\Modules\Mvc\Routing\RequestInterface;
use App\Modules\Mvc\Routing\ResponseInterface;

class ModuleArgument implements ModuleArgumentInterface
{
    protected $request = null;
    protected $response = null;

    /**
     * Массив для хранения результатов выполнения
     * @var array
     */
    protected $allResults = [];

    public function __construct(array $request_response_result_assoc_arr)
    {
        $this->request = $request_response_result_assoc_arr['request'];
        $this->response = $request_response_result_assoc_arr['response'];

        if (array_key_exists('result', $request_response_result_assoc_arr)) {
            $this->addResult($request_response_result_assoc_arr['result']);
        }
    }

    /**
     * Возвращает реквест ассоциированый с запросом
     * @return RequestInterface
     */
    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    /**
     * Возвращает респонс ассоциированый с запросом
     * @return ResponseInterface
     */
    public function getResponse() : ResponseInterface
    {
        return $this->response;
    }

    /**
     * Добавляет результат выполнеия модуля к объекту
     * @param ModuleResultInterface $result
     * @return mixed
     */
    public function addResult(ModuleResultInterface $result)
    {
        array_push($this->allResults, $result);
    }

    /**
     * Возвращает все результаты выполнения
     * @return array @type ModuleResultInterface
     */
    public function getAllResults(): array
    {
        return $this->allResults;
    }

    /**
     * Возвращает последний результат или null
     * @return ModuleResultInterface
     */
    public function getLastResult(): ?ModuleResultInterface
    {
        $result = end($this->allResults);
        reset($this->allResults);
        return $result == false ? null : $result;
    }

    /**
     * Вернет результат выполнения модуля по имени его класса,
     * если таковой существует
     * @param string $module_class_name
     * @return ModuleResultInterface|null
     */
    public function getModuleResult(string $module_class_name): ?ModuleResultInterface
    {
        foreach ($this->allResults as $result)
        {
            /**
             * @var $result ModuleResultInterface
             */
            if ($result->getSubjectModule()->getNameOfModule() === $module_class_name) {
                return $result;
            }
        }

        return null;
    }
}