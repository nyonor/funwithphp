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
use App\Ioc\Ioc;

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

//регистрируем автозагрузчик composer'a
require_once '../vendor/autoload.php';

//здесь можно зарегистрировать еще автозагрузчики!

//регистрация модулей в пайплайне
/**
 * @var $pipe_line \App\Pipeline\PipelineInterface
 */
$pipe_line = Ioc::factory(\App\Pipeline\PipelineInterface::class);
$action_result_factory = Ioc::factoryWithArgs(\App\Modules\Mvc\Controller\ActionResultFactoryInterface::class,
    Ioc::factory(\App\Modules\Mvc\View\Render\TwigRenderInterface::class));
$mvc_module = Ioc::factoryWithVariadic(\App\Modules\Mvc\MvcModuleInterface::class,
    Ioc::factory(\App\Modules\Mvc\Routing\RoutingInterface::class),
    Ioc::factory(\App\Modules\Mvc\Controller\MvcControllerFactoryInterface::class),
    $action_result_factory);
$pipe_line->registerModule($mvc_module);

//стартуем пайплан
$pipe_line->go();
