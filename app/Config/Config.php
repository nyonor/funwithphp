<?php
/**
 * Класс для хранения настроек приложения
 *
 * Created by PhpStorm.
 * User: NyoNor
 * Date: 2/13/2018
 * Time: 11:08 AM
 */

namespace App\Config;

const APP_DIR = '/var/www/html';

class Config
{
    public static $routeTemplates = [
        "{controller}/{action}/{id}"
    ];
    //todo конфиг приложения в виде констант?
}