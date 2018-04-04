<?php
/**
 * todo проверить класс - не хватает описаний
 * todo необходимо чтобы свой конфиг был в каждом пользовательском сегменте... здесь хранить только конфу системы
 * Класс для хранения настроек приложения
 *
 * Created by PhpStorm.
 * User: NyoNor
 * Date: 2/13/2018
 * Time: 11:08 AM
 */

namespace App\Config;

const APP_DIR = '/var/www/html';
const SEGMENT_CONTROLLER_KEYWORD = "Controller";
const SEGMENT_CONTROLLERS_LAST_NAMESPACE = "Controllers";
const SEGMENT_ACTION_KEYWORD = "Action";
const SEGMENT_VIEWS_LAST_NAMESPACE = "Views";


class Config
{
    const ROUTING_DEFAULT_CONTROLLER_NAME = "Home";
    const ROUTING_DEFAULT_ACTION_NAME = "Index";

    /*
     * Массив-связка: неймспейс к базовой директории.
     * конфиг для автозагрузчика Autoloader
     */
    public static $appAutoloadArray = [
        'App\Autoload' => '/app/Autoload',
        'App\Ioc' => '/app/Ioc',
        'App\Pipeline' => '/app/Pipeline',
        'App\Modules' => '/app/Modules',
        'App\Modules\Mvc' => '/app/Modules/Mvc',
        'App\Modules\Mvc\Routing' => '/app/Modules/Mvc/Routing',
    ];

    /*
     * название_сегмента => [
     *  domain_name => имя_домена,
     *  autoload_data => [
     *      неймспейс => путь
     *  ]
     * ]
     */
    public static $projectSegments = [
        'backend' => [
            'domain_name' => 'localhost:8080',
            'autoload_data' => [
                'Segments\Nyo\Backend\\' . SEGMENT_CONTROLLERS_LAST_NAMESPACE => '/segments/nyo/backend/Controllers',
                'Segments\Nyo\Backend\\' . SEGMENT_VIEWS_LAST_NAMESPACE  => '/segments/nyo/backend/Views',
            ],
        ]
    ];

    public static $routeTemplates = [
        '{controller}',
        '{controller}/{action}',
        '{controller}/{action}/{parameter:id}',
        '{controller}/{action}/{parameter:some_string}/{parameter:some_other_parameter}'
    ];
    //todo конфиг приложения в виде констант?
}