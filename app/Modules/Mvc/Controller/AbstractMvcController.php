<?php
/**
 * todo
 * Created by PhpStorm.
 * User: NyoNor
 * Date: 3/23/2018
 * Time: 1:57 PM
 */

namespace App\Modules\Mvc\Controller;


use App\Config\Config;
use App\Http\RequestInterface;
use App\Http\ResponseInterface;
use App\Modules\Mvc\Controller\ActionResult\ActionResultFactoryInterface;
use App\Modules\Mvc\Controller\ActionResult\ActionResultInterface;
use App\Modules\Mvc\Routing\RouteInterface;

abstract class AbstractMvcController implements MvcControllerInterface
{
    /**
     * @var $callChain array
     * @var $actionResultFactory ActionResultFactoryInterface
     */
    private $callChain = [];
    private $actionResultFactory;

    protected $route;
    protected $request;
    protected $response;

    public function __construct(ActionResultFactoryInterface $action_result_factory, RouteInterface $route,
                                RequestInterface $request, ResponseInterface $response)
    {
        $this->actionResultFactory = $action_result_factory;
        $this->route = $route;
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * Все вызванные экшены будут помещены в $callChain
     * @param $name
     * @param $arguments
     * @return ActionResultInterface
     * @throws ControllerException
     */
    public function __call($name, $arguments)
    {
        if (method_exists($this, $name) === false) {
            throw new ControllerException('Method not exists!');
        }

        if (strrpos($name, Config::SEGMENT_ACTION_KEYWORD) != false) {
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
        return get_class($this);
    }

    /**
     * Возвращает объект для отрисовки вьюхи,
     * в данном случае имя вьюхи будет соответствовать имени метода из
     * которого был вызван данный метод
     * @return ActionResultInterface
     * @throws ControllerException
     */
    protected function view() : ActionResultInterface
    {
        $last_action_method_name = $this->getLastActionMethodName();
        if (empty($last_action_method_name)) {
            throw new ControllerException("Ни один экшен не был вызван!"); //todo NEW????
        }
        $view_name = $this->getCurrentViewName($last_action_method_name);
        return $this->getViewResult($view_name, null);
    }

    protected function viewWithModel(array $view_model)
    {
        $last_action_method_name = $this->getLastActionMethodName();
        if (empty($last_action_method_name)) {
            throw new ControllerException("Ни один экшен не был вызван!"); //todo NEW????
        }
        $view_name = $this->getCurrentViewName($last_action_method_name);
        $view_result = $this->getViewResult($view_name, $view_model);
        return $view_result;
    }

    protected function redirect(string $controller_name, string $action_name, array $parameters = null)
    {
        return $this->actionResultFactory->getRedirectResult($controller_name, $action_name, $parameters);
    }

    protected function redirectToUrl(string $url)
    {
        return $this->actionResultFactory->getRedirectResultToUrl($url);
    }

    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }

    /**
     * Результат работы экшена в виде вьюхи
     * @param string|null $view_name
     * @param array|null $view_model
     * @return ActionResultInterface
     */
    private function getViewResult(string $view_name = null, array $view_model = null) : ActionResultInterface
    {
        $options = [
            'view_name' => $view_name,
            'view_model' => $view_model,
            'templates_path' => $this->getTemplatesPath()
        ];
        return $this->actionResultFactory->getViewResult($options);
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

    private function getTemplatesPath()
    {
        $current_view_directory = $this->route->getSegmentConfig()['view_path'] . '/' .
            $this->route->getRouteArgument()->getControllerName();
        $base_template_directory = $this->route->getSegmentConfig()['view_path'];
        return [$current_view_directory, $base_template_directory];
    }

    private function getCurrentViewName($last_action_method_name)
    {
        return ucfirst(str_replace(Config::SEGMENT_ACTION_KEYWORD, '', $last_action_method_name));
    }
}