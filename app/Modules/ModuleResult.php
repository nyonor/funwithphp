<?php
/**
 * Возвращается модулями для сохранения результатов работы
 *
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 4/13/18
 * Time: 5:09 PM
 */

namespace App\Modules;


use App\Modules\Mvc\MvcModule;
use Closure;

class ModuleResult implements ModuleResultInterface
{
    protected $module;
    protected $theResult;

    /**
     * @var $resultClosure Closure
     */
    protected $resultClosure;

    /**
     * @var $modifiedResponseClosure Closure
     */
    protected $modifiedResponseClosure;

    /**
     * @var $modifiedRequestClosure Closure
     */
    protected $modifiedRequestClosure;

    /**
     * На основании модуля, который сгенерировал
     * данный объект
     * ModuleResult constructor.
     * @param ModuleInterface $module
     * @param $result mixed
     */
    public function __construct(ModuleInterface $module, $result)
    {
        $this->module = $module;
        $this->theResult = $result;
    }

    /**
     * Возвращает модуль в результате которого был создан объект
     * @return ModuleInterface
     */
    public function getSubjectModule(): ModuleInterface
    {
        return $this->module;
    }

    /**
     * Возвращает объект, который модуль передал в качестве результата
     * @return mixed
     */
    public function getTheResult()
    {
        return $this->theResult;
    }

    /**
     * Устанавливает функцию которую можно будте выполнить для получения результатов
     * @param Closure $result_closure
     * @return void
     */
    public function setResultClosure(Closure $result_closure): void
    {
        $this->resultClosure = $result_closure;
    }

    /**
     * Вызывав результат данного метода можно получить результат
     * выполнения модуля. Используется для lazy получения результатов
     * работы модуля
     * @return Closure
     */
    public function getResultClosure(): Closure
    {
        return $this->resultClosure;
    }

    /**
     * Получить модифицированный модулем объект респонс
     * через клозюр
     * @return Closure
     */
    public function getModifiedResponseClosure()
    {
        return $this->modifiedResponseClosure;
    }

    /**
     * Устанавливает модифицированный модулем объект респонс
     * через клозюр
     * @param Closure $modify_response_closure
     * @return void
     */
    public function setModifiedResponseClosure(Closure $modify_response_closure)
    {
        $this->modifiedResponseClosure = $modify_response_closure;
    }

    /**
     * Получить модифицированный модулем объект реквест
     * через клозюр
     * @return Closure
     */
    public function getModifiedRequestClosure()
    {
        return $this->modifiedRequestClosure;
    }

    /**
     * Устанавливает модифицированный модулем объект реквест
     * через клозюр
     * @param Closure $modify_request_closure
     * @return void
     */
    public function setModifiedRequestClosure(Closure $modify_request_closure)
    {
        $this->modifiedRequestClosure = $modify_request_closure;
    }
}