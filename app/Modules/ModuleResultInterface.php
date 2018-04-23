<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 4/13/18
 * Time: 5:09 PM
 */

namespace App\Modules;


use Closure;

interface ModuleResultInterface
{
    /**
     * Возвращает модуль в результате которого был создан объект
     * @return ModuleInterface
     */
    public function getSubjectModule() : ModuleInterface;

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
    public function setResultClosure(Closure $result_closure) : void;

    /**
     * Вызывав результат данного метода можно получить результат
     * выполнения модуля. Используется для lazy получения результатов
     * работы модуля
     * @return Closure
     */
    public function getResultClosure() : Closure;
}