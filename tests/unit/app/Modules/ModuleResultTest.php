<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 4/13/18
 * Time: 4:35 PM
 */

namespace App\Modules\Mvc;


use App\Modules\ModuleResult;
use PHPUnit\Framework\TestCase;

class ModuleResultTest extends TestCase
{
    public function testItWillReturnModuleWhichReturnedOrCreatedIt()
    {
        $module = $this->createMock(MvcModule::class);
        $module->method('getNameOfModule')->willReturn(MvcModule::class);
        $module_result = new ModuleResult($module);
        $this->assertEquals(MvcModule::class, $module_result->getSubjectModule()->getNameOfModule());
    }
}