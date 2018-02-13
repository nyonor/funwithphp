<?php
/**
 * Created by PhpStorm.
 * User: NyoNor
 * Date: 2/9/2018
 * Time: 12:16 PM
 */

// Инклудим автозагрузчик
require_once("../app/Autoload/PipelineAutoloader.php");

/**
 * Массив-связка: неймспейс к базовой директории.
 * конфиг для автозагрузчика Pipeline
 */
$requireArray = [
    'App\Autoload\Interfaces' => '/app/Autoload/Interfaces',
    'App\Autoload' => '/app/Autoload',
    'App\Ioc' => '/app/Ioc'
];

$pipeLineAutoloader = new App\Autoload\PipelineAutoloader($requireArray);
$pipeLineAutoloader -> register();