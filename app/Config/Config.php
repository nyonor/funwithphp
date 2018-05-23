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
    const SEGMENT_ACTION_KEYWORD = "Action";

    const ENV_DEBUG = 'Debug';
    const ENV_PRODUCTION = 'Production';

    const CURRENT_ENV = self::ENV_DEBUG;

    /*
     * Массив-связка: неймспейс к базовой директории.
     * конфиг для автозагрузчика Autoloader
     */
    public static $appAutoloadArray = [
        'app\Autoload' => '/app/Autoload',
        'app\Ioc' => '/app/Ioc',
        'app\Pipeline' => '/app/Pipeline',
        'app\Modules' => '/app/Modules',
        'app\Modules\Mvc' => '/app/Modules/Mvc',
        'app\Modules\Mvc\Routing' => '/app/Modules/Mvc/Routing',
        'app\Modules\Mvc\Controller' => '/app/Modules/Mvc/Controller',
        'app\Modules\Mvc\View' => '/app/Modules/Mvc/View',
        'app\Modules\Mvc\View\Render' => '/app/Modules/Mvc/View/Render'
    ];

    /*
     * название_сегмента => [
     *  domain_name => имя_домена,
     *  view_path => путь_ко_вьюхам
     *  autoload_data => [
     *      неймспейс => путь
     *  ]
     * ]
     */
    public static $projectSegments = [
        'web' => [
            'domain_name' => 'localhost:8080',
            'view_path' => '/segments/nyo/web/Views',
            'autoload_data' => [
                'Segments\Nyo\Web\\' . SEGMENT_CONTROLLERS_LAST_NAMESPACE => '/segments/nyo/backend/Controllers',
                'Segments\Nyo\Web\\' . SEGMENT_VIEWS_LAST_NAMESPACE  => '/segments/nyo/backend/Views',
            ],
        ]
    ];

    public static $routeTemplates = [
        '{controller}',
        '{controller}/{action}',
        '{controller}/{action}/{parameter:id}',
        '{controller}/{action}/{parameter:some_string}/{parameter:some_other_parameter}'
    ];

    public static $assets = [
        'bootstrap' => '/assets/bootstrap',
        'images' => '/assets/images',
        'icons' => '/assets/images/icons',
    ];

    public static function getDbConnectionSettings($db_type)
    {
        if ($db_type == 'MYSQL') {
            return [
                'pdo' => [
                    'dsn' => 'mysql:host=127.0.0.1:3306;dbname=fightstarter_db',
                    'username' => 'askidans',
                    'password' => 'geekbrains',
                ],
            ];
        }
    }
    //todo конфиг приложения в виде констант?

    public static function getCurrentEnv()
    {
        return self::CURRENT_ENV;
    }
}