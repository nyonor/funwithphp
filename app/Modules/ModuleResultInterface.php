<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 4/13/18
 * Time: 5:09 PM
 */

namespace App\Modules;


use App\Http\RequestInterface;
use App\Http\ResponseInterface;
use Closure;

interface ModuleResultInterface
{
    /**
     * Возвращает модуль в результате которого был создан объект
     * @return ModuleInterface
     */
    public function getSubjectModule(): ModuleInterface;

    /**
     * Возвращает объект, который модуль передал в качестве результата
     * @return mixed
     */
    public function getTheResult();

    /**
     * Устанавливает функцию которую можно будте выполнить для получения результатов
     * @param Closure $result_closure
     * @return void
     */
    public function setResultClosure(Closure $result_closure): void;

    /**
     * Вызывав результат данного метода можно получить результат
     * выполнения модуля. Используется для lazy получения результатов
     * работы модуля
     * @return Closure
     */
    public function getResultClosure(): Closure;

    /**
     * Получить модифицированный модулем объект респонс
     * через клозюр
     * @return Closure
     */
    public function getModifiedResponseClosure();

    /**
     * Устанавливает модифицированный модулем объект респонс
     * через клозюр
     * @param Closure $modify_response_closure
     * @return void
     */
    public function setModifiedResponseClosure(Closure $modify_response_closure);

    /**
     * Получить модифицированный модулем объект реквест
     * через клозюр
     * @return Closure
     */
    public function getModifiedRequestClosure();

    /**
     * Устанавливает модифицированный модулем объект реквест
     * через клозюр
     * @param Closure $modify_request_closure
     * @return void
     */
    public function setModifiedRequestClosure(Closure $modify_request_closure);
}