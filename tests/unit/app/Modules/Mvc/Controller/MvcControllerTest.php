<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 4/12/18
 * Time: 8:35 PM
 */

namespace unit\app\Modules\Mvc\Controller;


use App\Modules\Mvc\Controller\AbstractMvcController;
use App\Modules\Mvc\Controller\ActionResultFactoryInterface;
use App\Http\RequestInterface;
use App\Http\ResponseInterface;
use App\Modules\Mvc\Routing\RouteInterface;
use PHPUnit\Framework\TestCase;

class MvcControllerTest extends TestCase
{
    protected $controller;

    public function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $action_res_fac = $this->createMock(ActionResultFactoryInterface::class);
        $route = $this->createMock(RouteInterface::class);
        $request = $this->createMock(RequestInterface::class);
        $response = $this->createMock(ResponseInterface::class);
        $this->controller = new \App\Modules\Mvc\Controller\MvcController($action_res_fac, $route, $request, $response);
    }

    public function testItsExtendsFromNeededAbstract()
    {
        $this->assertInstanceOf(AbstractMvcController::class, $this->controller);
    }

    public function testConsumerCanGetRequestInterfaceObjectFromAction()
    {
        $this->assertNotNull($this->controller->getRequest());
        $this->assertInstanceOf(RequestInterface::class, $this->controller->getRequest());
    }

    public function testConsumerCanGetResponseInterfaceObjectFromAction()
    {
        $this->assertNotNull($this->controller->getResponse());
        $this->assertInstanceOf(ResponseInterface::class, $this->controller->getResponse());
    }

}