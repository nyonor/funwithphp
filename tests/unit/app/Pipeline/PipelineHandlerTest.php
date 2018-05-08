<?php

use App\Modules\ModuleArgumentInterface;
use App\Modules\ModuleInterface;
use App\Modules\ModuleResultInterface;
use App\Pipeline\Pipeline;
use App\Pipeline\ModuleArgumentHandler;
use App\Pipeline\ModuleArgumentHandlerInterface;
use App\Pipeline\ResponseHandlerInterface;
use PHPUnit\Framework\TestCase;

/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 4/21/18
 * Time: 11:35 AM
 */

class PipelineHandlerTest extends TestCase
{
    public function testPipelineHandlerInterfaceIsExistingAndImplemented()
    {
        $pipeline_handler = $this->createMock(ModuleArgumentHandler::class);
        $response_handler = $this->createMock(ResponseHandlerInterface::class);
        $pipeline = new Pipeline($pipeline_handler, $response_handler);
        $this->assertInstanceOf(ModuleArgumentHandlerInterface::class, $pipeline_handler);
        $this->assertNotNull($pipeline);
    }
}