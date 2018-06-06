<?php
/**
 * Реализует функционал синглтона
 *
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 6/6/18
 * Time: 12:06 PM
 */

namespace App\Helpers;


trait SingletonTrait
{
    protected static $instance = null;

    protected function __construct()
    {
    }

    protected function __clone()
    {
        // TODO: Implement __clone() method.
    }

    public static function getInstance()
    {
        if (null === self::$instance)
        {
            self::$instance = new self();
        }

        return self::$instance;
    }
}