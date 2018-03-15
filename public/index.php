<?php
/**
 * todo описание
 *
 * Created by PhpStorm.
 * User: NyoNor
 * Date: 2/9/2018
 * Time: 12:16 PM
 */

//Инклудим интерфейс автозагрузчика //todo внедрить в систему IOC?
require_once("../app/Autoload/AutoloaderInterface.php");

//Инклудим константы
require_once("../app/Config/Config.php");

// Инклудим автозагрузчик
require_once("../app/Autoload/Autoloader.php");

/*
 * Массив-связка: неймспейс к базовой директории.
 * конфиг для автозагрузчика Autoloader
 */
$require_array = [
    'App\Autoload' => '/app/Autoload',
    'App\Ioc' => '/app/Ioc',
    'App\Pipeline' => '/app/Pipeline',
    'App\Modules' => '/app/Modules',
    'App\Modules\Mvc' => '/app/Modules/Mvc',
    'App\Modules\Routing' => '/app/Modules/Routing'
];

//регистрируем автолоадер
$autoloader = new App\Autoload\Autoloader($require_array);
$autoloader -> register();

//здесь можно зарегистрировать еще!

//регистрация модулей в пайплайне
/**
 * @var $pipe_line \App\Pipeline\PipelineInterface
 */
$pipe_line = App\Ioc\Ioc::Factory(\App\Pipeline\PipelineInterface::class);
$mvc_module = App\Ioc\Ioc::Factory(\App\Modules\Mvc\MvcModuleInterface::class);
$routing_module = App\Ioc\Ioc::Factory(\App\Modules\Routing\RoutingModuleInterface::class);
$pipe_line
    ->RegisterModule($routing_module)
    ->RegisterModule($mvc_module);

//стартуем пайплан
$request_array = $_REQUEST;
$pipe_line->Process($request_array);
