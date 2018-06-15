<?php
/**
 * Позволяет хранить и извлекать данные в/из сессии
 *
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 6/5/18
 * Time: 8:02 PM
 */

namespace App\Http;


use App\Helpers\SingletonTrait;

class Session implements SessionInterface
{
    use SingletonTrait;

    protected function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Установить значение по ключу
     *
     * @param $key
     * @param $value
     * @return mixed
     */
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Извлечь значение по ключу
     *
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        return $_SESSION[$key];
    }

    /**
     * Регенерирует сессию
     */
    public function regenerateSession(): void
    {
        session_regenerate_id();
    }
}