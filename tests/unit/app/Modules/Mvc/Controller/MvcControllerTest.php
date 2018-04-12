<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 4/12/18
 * Time: 8:35 PM
 */

namespace unit\app\Modules\Mvc\Controller;


use App\Modules\Mvc\Controller\AbstractMvcController;
use App\Modules\Mvc\Controller\ActionResultFactory;
use App\Modules\Mvc\Controller\ActionResultFactoryInterface;
use App\Modules\Mvc\Routing\RequestInterface;
use App\Modules\Mvc\Routing\RouteInterface;
use PHPUnit\Framework\TestCase;

class MvcControllerTest extends TestCase
{
    public function testItsExtendsFromNeededAbstract()
    {
        $action_res_fac = $this->createMock(ActionResultFactoryInterface::class);
        $route = $this->createMock(RouteInterface::class);
        $request = $this->createMock(RequestInterface::class);
        $controller = new \App\Modules\Mvc\Controller\MvcController($action_res_fac, $route, $request);
        $this->assertInstanceOf(AbstractMvcController::class, $controller);
    }

    public function testConsumerCanGetRequestInterfaceObjectFromAction()
    {
        $action_res_fac = $this->createMock(ActionResultFactoryInterface::class);
        $route = $this->createMock(RouteInterface::class);
        $request = $this->createMock(RequestInterface::class);
        $controller = new \App\Modules\Mvc\Controller\MvcController($action_res_fac, $route, $request);
        $this->assertNotNull($controller->getRequest());
        $this->assertInstanceOf(RequestInterface::class, $controller->getRequest());
    }

    public function testConsumerCanGetResponseInterfaceObjectFromAction()
    {
        //todo
    }
}