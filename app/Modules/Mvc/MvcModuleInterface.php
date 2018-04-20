<?php
/**
 * Created by PhpStorm.
 * User: NyoNor
 * Date: 3/15/2018
 * Time: 1:48 PM
 */

namespace App\Modules\Mvc;


use App\Modules\ModuleArgumentInterface;
use App\Modules\ModuleInterface;
use App\Modules\Mvc\Controller\ActionResultInterface;

interface MvcModuleInterface extends ModuleInterface
{
    /**
     * Возвращает переданный аргумент
     * @return ModuleArgumentInterface
     */
    public function getArgument() : ModuleArgumentInterface;

    /**
     * Возвращает последний ActionResultInterface
     * полученный при выполнении контроллер->экшн
     * @return ActionResultInterface
     */
    public function getActionResult() : ActionResultInterface;
}