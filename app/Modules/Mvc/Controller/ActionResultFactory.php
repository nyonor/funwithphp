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
use App\Modules\Mvc\View\Render\RenderInterface;
use App\Modules\Mvc\View\Render\ViewRenderInterface;
use App\Modules\Mvc\View\ViewResultInterface;

class ActionResultFactory implements ActionResultFactoryInterface
{
    protected $renders;

    public function __construct(RenderInterface... $renders)
    {
        $this->renders = $renders;
    }

    public function getViewResult($view_name, $view_model): ActionResultInterface
    {
        $render = $this->findRender(ViewRenderInterface::class);
        if (array_search(ViewResultInterface::class, class_implements($render)) != false) {
            throw new ActionResultException("Для метода нет подходящего рендерера!");
        }

        //todo проверка на совпадение установленного рендерера в конфиге с найденным...

        /**
         * @var $view_result ViewRenderInterface
         */
        $view_result = Ioc::factoryWithVariadic(ViewResultInterface::class, $view_name, $view_model, $render); //todo первый параметр сомнителен
        return $view_result;
    }

    public function getJsonResult($to_json_content): ActionResultInterface
    {
        // TODO: Implement getJsonResult() method.
    }

    protected function findRender($render_interface) : RenderInterface
    {
        foreach ($this->renders as $render) {
            $implements = class_implements($render);
            if (array_search($render_interface, $implements) != false) {
                return $render;
            }
        }
    }
}