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

use App\DAL\Mysql\MysqlDbConnection;
use App\DAL\Mysql\MysqlDbConnectionInterface;
use App\Helpers\Path;
use App\Helpers\PathHelperInterface;
use App\Modules\ModuleArgument;
use App\Modules\ModuleArgumentInterface;
use App\Modules\Mvc\Controller\ActionResultFactory;
use App\Modules\Mvc\Controller\ActionResultFactoryInterface;
use App\Modules\Mvc\Controller\MvcControllerFactory;
use App\Modules\Mvc\Controller\MvcControllerFactoryInterface;
use App\Modules\Mvc\MvcModule;
use App\Modules\Mvc\MvcModuleInterface;
use App\Http\Request;
use App\Http\RequestInterface;
use App\Http\Response;
use App\Http\ResponseInterface;
use App\Modules\Mvc\Routing\Route;
use App\Modules\Mvc\Routing\RouteArgument;
use App\Modules\Mvc\Routing\RouteArgumentInterface;
use App\Modules\Mvc\Routing\RouteInterface;
use App\Modules\Mvc\Routing\Routing;
use App\Modules\Mvc\Routing\RoutingInterface;
use App\Modules\Mvc\View\Render\TwigRender;
use App\Modules\Mvc\View\Render\ViewRenderInterface;
use App\Modules\Mvc\View\ViewResult;
use App\Modules\Mvc\View\ViewResultInterface;
use App\Pipeline\Pipeline;
use App\Pipeline\ModuleArgumentHandler;
use App\Pipeline\ModuleArgumentHandlerInterface;
use App\Pipeline\PipelineInterface;
use App\Pipeline\ResponseHandler;
use App\Pipeline\ResponseHandlerInterface;

class Ioc
{
    //todo видимо это должно быть вынесено в конфиг?
    protected static $autoloadBinds = [
        ActionResultFactoryInterface::class => ActionResultFactory::class,
        ModuleArgumentHandlerInterface::class => ModuleArgumentHandler::class,
        ModuleArgumentInterface::class => ModuleArgument::class,
        MvcControllerFactoryInterface::class => MvcControllerFactory::class,
        MvcModuleInterface::class => MvcModule::class,
        PathHelperInterface::class => Path::class,
        PipelineInterface::class => Pipeline::class,
        RoutingInterface::class => Routing::class,
        RouteInterface::class => Route::class,
        RouteArgumentInterface::class => RouteArgument::class,
        RequestInterface::class => Request::class,
        ResponseInterface::class => Response::class,
        ResponseHandlerInterface::class => ResponseHandler::class,
        ViewRenderInterface::class => TwigRender::class,
        ViewResultInterface::class => ViewResult::class,
        MysqlDbConnectionInterface::class => MysqlDbConnection::class
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