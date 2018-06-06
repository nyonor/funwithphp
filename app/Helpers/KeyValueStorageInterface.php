<?php
/**
 * Обобщеный интерфейс, который позволяет хранить и
 * извлекать значения по ключу.
 *
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 6/5/18
 * Time: 8:04 PM
 */

namespace App\Helpers;


interface KeyValueStorageInterface
{
    /**
     * Установить значение по ключу
     *
     * @param $key
     * @param $value
     * @return mixed
     */
    public function set($key, $value);

    /**
     * Извлечь значение по ключу
     *
     * @param $key
     * @return mixed
     */
    public function get($key);
}