<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 4/13/18
 * Time: 4:09 PM
 */

namespace App\Modules\Mvc;


use App\Modules\ModuleArgumentInterface;
use App\Modules\ModuleResultInterface;
use App\Modules\Mvc\Controller\ActionResult\ActionResultFactoryInterface;
use App\Modules\Mvc\Controller\ActionResult\ActionResultInterface;
use App\Modules\Mvc\Controller\MvcControllerFactory;
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

    public function testThatMvcControllerFactoryMethodCreateAndCallWillBeExecutedDuringProcess()
    {
        $routing = $this->createMock(RoutingInterface::class);

        $controller_factory = $this->getMockBuilder(MvcControllerFactory::class)
            ->setMethods(['createAndCall'])
            ->getMock();
        $controller_factory
            ->expects($this->once())
            ->method('createAndCall')
            ->willReturn($this->createMock(ActionResultInterface::class));

        $action_result_factory = $this->createMock(ActionResultFactoryInterface::class);

        $module_argument = $this->createMock(ModuleArgumentInterface::class);

        $mvc_module = new MvcModule($routing, $controller_factory, $action_result_factory);
        $module_result = $mvc_module->process($module_argument);

        $this->assertNotNull($module_result);
        $this->assertInstanceOf(ModuleResultInterface::class, $module_result);
    }
}
