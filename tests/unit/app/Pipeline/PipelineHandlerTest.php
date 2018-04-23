<?php

use App\Modules\ModuleArgumentInterface;
use App\Modules\ModuleInterface;
use App\Modules\ModuleResultInterface;
use App\Pipeline\Pipeline;
use App\Pipeline\PipelineHandler;
use App\Pipeline\PipelineHandlerInterface;
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
        $pipeline_handler = $this->createMock(PipelineHandler::class);
        $pipeline = new Pipeline($pipeline_handler);
        $this->assertInstanceOf(PipelineHandlerInterface::class, $pipeline_handler);
        $this->assertNotNull($pipeline);
    }
}