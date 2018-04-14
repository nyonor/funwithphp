<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 4/13/18
 * Time: 4:09 PM
 */

namespace App\Modules\Mvc;

use App\Modules\ModuleArgument;
use App\Modules\ModuleResult;
use App\Modules\Mvc\Controller\ActionResultFactoryInterface;
use App\Modules\Mvc\Controller\MvcControllerFactoryInterface;;
use App\Modules\Mvc\Routing\RoutingInterface;
use PHPUnit\Framework\TestCase;

class MvcModuleTest extends TestCase
{
    public function testThatItImplementsNeededInterfaceAndMethods()
    {
        $routing = $this->createMock(RoutingInterface::class);
        $controller_factory = $this->createMock(MvcControllerFactoryInterface::class);
        $action_result_factory = $this->createMock(ActionResultFactoryInterface::class);

        $mvc_module = new MvcModule($routing, $controller_factory, $action_result_factory);
        $this->assertInstanceOf(MvcModuleInterface::class, $mvc_module);

        $this->assertTrue(method_exists($mvc_module, 'getRequest'));
        $this->assertNotNull(method_exists($mvc_module, 'getResponse'));
    }
}
