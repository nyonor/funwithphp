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
use App\Modules\Mvc\Controller\ActionResultFactoryInterface;
use App\Modules\Mvc\Controller\MvcControllerFactoryInterface;
use App\Modules\Mvc\MvcModuleInterface;
use App\Modules\Mvc\Routing\RoutingInterface;
use App\Modules\Mvc\View\Render\ViewRenderInterface;
use App\Pipeline\PipelineInterface;

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
 * @var $pipe_line PipelineInterface
 */
$pipe_line = Ioc::factory(PipelineInterface::class);
$action_result_factory = Ioc::factoryWithArgs(ActionResultFactoryInterface::class,
    Ioc::factory(ViewRenderInterface::class));
$mvc_module = Ioc::factoryWithVariadic(MvcModuleInterface::class,
    Ioc::factory(RoutingInterface::class),
    Ioc::factory(MvcControllerFactoryInterface::class),
    $action_result_factory);
$pipe_line->registerModule($mvc_module);

//стартуем пайплан
$pipe_line->go();
