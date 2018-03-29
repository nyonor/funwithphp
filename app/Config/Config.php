<?php
/**
 * todo проверить класс - не хватает описаний, также вероятно понадобится сделать отдельный класс для конфигов сегментов
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
const SEGMENT_CONTROLLER_LAST_NAMESPACE = "Controllers";
const SEGMENT_ACTION_KEYWORD = "Action";


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

    public static $projectSegments = [
        'backend' => [
            'domain_name' => 'localhost:8080',
            'autoload_data' => [
                'Segments\Nyo\Backend\\' . SEGMENT_CONTROLLER_LAST_NAMESPACE => '/segments/nyo/backend/Controllers'
                //todo соминтельно конечно
            ],
        ]
    ];

    public static $routeTemplates = [
        '{controller}',
        '{controller}/{action}',
        '{controller}/{action}/{parameter:id}'
    ];
    //todo конфиг приложения в виде констант?
}