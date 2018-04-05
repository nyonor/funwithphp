<?php
/**
 * todo
 * Created by PhpStorm.
 * User: NyoNor
 * Date: 3/23/2018
 * Time: 1:57 PM
 */

namespace App\Modules\Mvc\Controller;


use const App\Config\SEGMENT_ACTION_KEYWORD;

abstract class AbstractMvcController implements MvcControllerInterface
{
    /**
     * @var $callChain array
     * @var $actionResultFactory ActionResultFactoryInterface
     */
    private $callChain = [];
    private $actionResultFactory;

    public function __construct(ActionResultFactoryInterface $action_result_factory)
    {
        $this->actionResultFactory = $action_result_factory;
    }

    /**
     * Все вызванные экшены будут помещены в $callChain
     * @param $name
     * @param $arguments
     * @return ActionResultInterface
     */
    public function __call($name, $arguments)
    {
        if (strrpos($name, SEGMENT_ACTION_KEYWORD) != false) {
            array_push($this->callChain, [
                'method_name' => $name,
                'args' => $arguments
            ]);
        }

        return call_user_func_array([$this, $name], $arguments);
    }

    public function getActionResultFactory()
    {
        return $this->actionResultFactory;
    }

    public function getControllerClassName()
    {
        //TODO Implement
    }

    /**
     * Возвращает объект для отрисовки вьюхи,
     * в данном случае имя вьюхи будет соответствовать имени метода из
     * которого был вызван данный метод
     * @return ActionResultInterface
     * @throws ControllerException
     */
    public function view() : ActionResultInterface
    {
        $last_action_method_name = $this->getLastActionMethodName();
        if (empty($last_action_method_name)) {
            throw new ControllerException("Ни один экшен не был вызван!"); //todo NEW????
        }
        return $this->getViewResult($last_action_method_name, null);
    }

    /**
     * Результат работы экшена в виде вьюхи
     * @param string|null $view_name
     * @param array|null $view_model
     * @return ActionResultInterface
     */
    private function getViewResult(string $view_name = null, array $view_model = null) : ActionResultInterface
    {

        return $this->actionResultFactory->getViewResult($view_name, $view_model);
    }

    /**
     * Получить имя последнего вызванного экшена контроллера
     * из $callChain
     * @return mixed
     */
    private function getLastActionMethodName()
    {
        return array_pop($this->callChain)['method_name'];
    }
}