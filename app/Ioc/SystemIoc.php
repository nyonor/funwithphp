<?php
/**
 * todo описание
 *
 * Created by PhpStorm.
 * User: NyoNor
 * Date: 2/12/2018
 * Time: 10:04 PM
 */

namespace App\Ioc;

class SystemIoc
{
    protected static $autoloadBinds = [

    ];

    public static function Factory($interface){
        $class = SystemIoc::$autoloadBinds[$interface];
        return new $class;
    }
}