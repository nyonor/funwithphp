<?php
/**
 * Подбирает роутинговый шаблон на основе запроса.
 * Создает Route на основе переданных данных,
 *
 * Created by PhpStorm.
 * User: NyoNor
 * Date: 3/15/2018
 * Time: 2:09 PM
 */

namespace App\Modules\Mvc\Routing;


use App\Config\Config;
use App\Ioc\Ioc;

class Routing implements RoutingInterface
{
    protected $argument;

    /**
     * Фабрика создания роутов
     * @param $request RequestInterface
     * @return RouteInterface
     */
    public function getRoute($request): RouteInterface
    {
        $templates = Config::$routeTemplates;
        foreach ($templates as $template) {
            $mapping_result = $this->Map($template, $request);

            if ($mapping_result == null) {
                continue;
            }

            $new_route = Ioc::factoryWithArgs(RouteInterface::class, $mapping_result);
            return $new_route;
        }
    }

    /**
     * Маппинг Request к шаблону
     * @param $template string
     * @param $request RequestInterface
     * @return RouteArgumentInterface
     */
    public function map($template, $request)
    {
        $current_uri = $request->getUri();
        $uri_splitted_arr = explode('/', ltrim($current_uri, '/'));
        $template_splitted_arr = explode('/', ltrim($template, '/'));

        if (count($uri_splitted_arr) != count($template_splitted_arr)) {
            echo 'NEXT <br/>';
            return null;
        }

        echo 'THIS ONE <br/>';

        $controller_uri_str = $uri_splitted_arr[0];
        $action_uri_str = lcfirst($uri_splitted_arr[1]);
        $other_uri_arr = array_slice($uri_splitted_arr, 2, count($uri_splitted_arr));
        $other_uri_str = implode('/', $other_uri_arr);
        $supposed_pos_of_q_mark = strripos($other_uri_str, '?') - 1;
        $route_params_arr = array_filter(explode('/', substr($other_uri_str, 0,
            $supposed_pos_of_q_mark == -1 ? strlen($other_uri_str) : $supposed_pos_of_q_mark)));
        $uri_params_part_str = ltrim(substr($other_uri_str, stripos($other_uri_str, '?'),
            strlen($other_uri_str)), '?');
        $uri_params_arr = array_filter(explode('&', $uri_params_part_str));
        $form_parameters = array_filter(array_diff($request->getRawParameters(), $uri_params_arr, $route_params_arr)); //todo

        $arg = [
            'template' => $template,
            'controller' => !empty($controller_uri_str) ? $controller_uri_str : Config::ROUTING_DEFAULT_CONTROLLER_NAME,
            'action' => !empty($action_uri_str) ? $action_uri_str : Config::ROUTING_DEFAULT_ACTION_NAME,
            'route_parameters' => $route_params_arr,
            'uri_parameters' => $uri_params_arr,
            'form_parameters' => $form_parameters, //todo,
            'domain_name' => $request->getDomain()
        ];

        $route_argument = Ioc::factoryWithArgs(RouteArgumentInterface::class, $arg);
        return $route_argument;
    }
}