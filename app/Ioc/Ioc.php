<?php
/**
 * todo описание
 *
 * Created by PhpStorm.
 * User: NyoNor
 * Date: 2/12/2018
 * Time: 10:04 PM
 */

namespace App\Ioc;

use App\Modules\ModuleArgument;
use App\Modules\ModuleArgumentInterface;
use App\Modules\Mvc\Controller\ActionResultFactory;
use App\Modules\Mvc\Controller\ActionResultFactoryInterface;
use App\Modules\Mvc\Controller\MvcControllerFactory;
use App\Modules\Mvc\Controller\MvcControllerFactoryInterface;
use App\Modules\Mvc\MvcModule;
use App\Modules\Mvc\MvcModuleInterface;
use App\Modules\Mvc\Routing\Request;
use App\Modules\Mvc\Routing\RequestInterface;
use App\Modules\Mvc\Routing\Response;
use App\Modules\Mvc\Routing\ResponseInterface;
use App\Modules\Mvc\Routing\Route;
use App\Modules\Mvc\Routing\RouteArgument;
use App\Modules\Mvc\Routing\RouteArgumentInterface;
use App\Modules\Mvc\Routing\RouteInterface;
use App\Modules\Mvc\Routing\Routing;
use App\Modules\Mvc\Routing\RoutingInterface;
use App\Modules\Mvc\View\Render\TwigRender;
use App\Modules\Mvc\View\Render\TwigRenderInterface;
use App\Modules\Mvc\View\Render\ViewRenderInterface;
use App\Modules\Mvc\View\ViewResult;
use App\Modules\Mvc\View\ViewResultInterface;
use App\Pipeline\Pipeline;
use App\Pipeline\PipelineInterface;

class Ioc
{
    //todo видимо это должно быть вынесено в конфиг?
    protected static $autoloadBinds = [
        PipelineInterface::class => Pipeline::class,
        MvcModuleInterface::class => MvcModule::class,
        RoutingInterface::class => Routing::class,
        RouteInterface::class => Route::class,
        RouteArgumentInterface::class => RouteArgument::class,
        RequestInterface::class => Request::class,
        ResponseInterface::class => Response::class,
        ModuleArgumentInterface::class => ModuleArgument::class,
        MvcControllerFactoryInterface::class => MvcControllerFactory::class,
        ActionResultFactoryInterface::class => ActionResultFactory::class,
        ViewRenderInterface::class => TwigRender::class,
        ViewResultInterface::class => ViewResult::class
    ];

    /**
     * @todo описание
     * @param $interface
     * @return mixed
     */
    public static function factory($interface)
    {
        $class = Ioc::$autoloadBinds[$interface];
        return new $class;
    }

    /**
     * @todo описание
     * @param $interface
     * @param $arguments
     * @return mixed
     */
    public static function factoryWithArgs($interface, $arguments)
    {
        $class = Ioc::$autoloadBinds[$interface];
        return new $class($arguments);
    }

    public static function factoryWithVariadic($interface, ...$argument)
    {
        $class = Ioc::$autoloadBinds[$interface];
        return new $class(...$argument);
    }
}