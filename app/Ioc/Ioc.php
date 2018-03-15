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
use App\Modules\Mvc\MvcModule;
use App\Modules\Mvc\MvcModuleInterface;
use App\Modules\Routing\Request;
use App\Modules\Routing\RequestInterface;
use App\Modules\Routing\RoutingModule;
use App\Modules\Routing\RoutingModuleInterface;
use App\Pipeline\Pipeline;
use App\Pipeline\PipelineInterface;

class Ioc
{
    //todo видимо это должно быть вынесено в конфиг? или куда то еще
    protected static $autoloadBinds = [
        PipelineInterface::class => Pipeline::class,
        MvcModuleInterface::class => MvcModule::class,
        RoutingModuleInterface::class => RoutingModule::class,
        RequestInterface::class => Request::class,
        ModuleArgumentInterface::class => ModuleArgument::class
    ];

    /**
     * @todo описание
     * @param $interface
     * @return mixed
     */
    public static function Factory($interface){
        $class = Ioc::$autoloadBinds[$interface];
        return new $class;
    }

    /**
     * @todo описание
     * @param $interface
     * @param $arguments
     * @return mixed
     */
    public static function FactoryWithArgs($interface, $arguments){
        $class = Ioc::$autoloadBinds[$interface];
        return new $class($arguments);
    }
}