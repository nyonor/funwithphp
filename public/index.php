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

//Инклудим конфиг
require_once("../app/Config/Config.php");

// Инклудим автозагрузчик
require_once("../app/Autoload/Autoloader.php");

//регистрируем автолоадер
$autoloader = new App\Autoload\Autoloader(App\Config\Config::$appAutoloadArray);
$autoloader -> register();

//регистрируем автолоадер сегментов
$segment_autoloader = new \App\Autoload\SegmentAutoloader(App\Config\Config::$projectSegments);
$segment_autoloader->register();

//здесь можно зарегистрировать еще!

//регистрация модулей в пайплайне
/**
 * @var $pipe_line \App\Pipeline\PipelineInterface
 */
$pipe_line = App\Ioc\Ioc::factory(\App\Pipeline\PipelineInterface::class);
$mvc_module = App\Ioc\Ioc::factory(\App\Modules\Mvc\MvcModuleInterface::class);
$pipe_line
    ->registerModule($mvc_module);

//стартуем пайплан
$pipe_line->process();
