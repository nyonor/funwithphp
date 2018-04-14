<?php
/**
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
    protected $moduleResult = null;

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
            $this->moduleResult = $request_response_result_assoc_arr['result'];
        }
    }

    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    public function getResponse() : ResponseInterface
    {
        return $this->response;
    }

    public function getModuleResult() : ModuleResultInterface
    {
        return $this->moduleResult;
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
}