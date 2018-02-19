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
require_once("../app/Autoload/PipelineAutoloaderInterface.php");

//Инклудим константы
require_once ("../app/Config/AppConfig.php");

// Инклудим автозагрузчик
require_once("../app/Autoload/PipelineAutoloader.php");

/**
 * Массив-связка: неймспейс к базовой директории.
 * конфиг для автозагрузчика PipelineAutoloader
 */
$requireArray = [
    'App\Autoload' => '/app/Autoload',
    'App\Ioc' => '/app/Ioc'
];

//регистрируем автолоадер
$pipeLineAutoloader = new App\Autoload\PipelineAutoloader($requireArray);
$pipeLineAutoloader -> register();

//здесь можно зарегистрировать еще!
