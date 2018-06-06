<?php
/**
 * Функционал IoC контейнера
 *
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 6/6/18
 * Time: 12:21 PM
 */

namespace App\Ioc;


interface IocInterface
{
    /**
     * Создает инстанс класса с переданными параметрами
     *
     * @param string $ioc_key
     * @param mixed ...$parameter
     * @return mixed
     */
    public function create(string $ioc_key, ... $parameter);

    /**
     * Создает привязку - интерфейс класса к имени класса или
     * функции
     *
     * @param string $ioc_key
     * @param mixed $bind_subject
     * @return IocInterface
     */
    public function bind(string $ioc_key, $bind_subject) : IocInterface;
}