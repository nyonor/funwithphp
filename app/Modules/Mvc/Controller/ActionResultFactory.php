<?php
/**
 * //todo вероятно этот класс лишний
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 4/4/18
 * Time: 4:35 PM
 */

namespace App\Modules\Mvc\Controller;


use App\Ioc\Ioc;
use App\Modules\Mvc\View\ViewResultInterface;

class ActionResultFactory implements ActionResultFactoryInterface
{

    public function getViewResult($view_name, $view_model): ActionResultInterface
    {
        return Ioc::factoryWithArgs(ViewResultInterface::class, ['view_name' => $view_name, 'view_model' => $view_model]);
    }

    public function getJsonResult($to_json_content): ActionResultInterface
    {
        // TODO: Implement getJsonResult() method.
    }
}