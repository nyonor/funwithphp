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
use function App\Helpers\Globals\container;
use App\Http\RequestInterface;
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
            $mapping_result = $this->map($template, $request);

            if ($mapping_result == null) {
                continue;
            }

            $new_route = container()->create(RouteInterface::class, $mapping_result);
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

        $template_parts = explode('/', $template);
        $uri_parts = explode('/', $current_uri);

        if (count($template_parts) != count($uri_parts)){
            return null;
        }

        $uri_parts = array_values(array_filter($uri_parts));

        $controller = null;
        $action = null;
        $route_params_arr = [];
        $uri_assoc_arr = null;
        $form_parameters_assoc_arr = [];
        foreach ($template_parts as $template_part) {

            if (strstr($template_part, 'controller') != false)
            {
                $controller = $this->getControllerNameFromUriString($current_uri);
                if (empty($controller)) {
                    $controller = Config::ROUTING_DEFAULT_CONTROLLER_NAME;
                }
            }

            if (strstr($template_part, 'action') != false)
            {
                $action = $this->getActionNameFromExplodedUriString($uri_parts);

                if (empty($action)) {
                    $action = Config::ROUTING_DEFAULT_ACTION_NAME;
                }
            }

            if (strstr($template_part, 'parameter') != false) {
                $route_params_arr = $this->getRouteParametersFromExplodedUriString($uri_parts, $template_parts);
            }
        }

        $uri_assoc_arr = $this->getUriParametersPartFromUriString($current_uri) ?? [];

        $arg = [
            'template' => $template,
            'controller' => $controller,
            'action' => $action,
            'route_parameters' => $route_params_arr,
            'uri_parameters' => $uri_assoc_arr,
            'form_parameters' => $form_parameters_assoc_arr, //todo,
            'domain_name' => $request->getDomain()
        ];

        $route_argument = container()->create(RouteArgumentInterface::class, $arg);
        return $route_argument;
    }

    protected function getControllerNameFromUriString($uri)
    {
        $controller_value = substr($uri, 1, stripos(ltrim($uri, '/'), '/'));
        if (empty($controller_value) == false) {
            return $controller_value;
        }
    }

    protected function getActionNameFromExplodedUriString(array $exploded_uri)
    {
        $q_mark_pos = stripos($exploded_uri[1], '?');
        $action_value = $q_mark_pos == false ? $exploded_uri[1] : substr($exploded_uri[1], 0, $q_mark_pos);
        if (empty($action_value) == false) {
            return $action_value;
        }
    }

    protected function getRouteParametersFromExplodedUriString(array $exploded_uri, $exploded_route_parttern)
    {
        $offset = null;
        for ($i = 0; $i < count($exploded_route_parttern); $i++) {
            $pattern_part = $exploded_route_parttern[$i];
            if (strstr($pattern_part, 'controller') || strstr($pattern_part, 'action')) {
                continue;
            }
            $offset = $i;
        }

        $result = array_slice($exploded_uri, $offset);

        return $result;
    }

    protected function getUriParametersPartFromUriString($uri)
    {
        $result_assoc_arr = null;

        $q_mark_pos = stripos($uri, '?');

        if ($q_mark_pos == false)
            return null;

        $uri_params_string = substr($uri, $q_mark_pos + 1);
        $uri_params_arr = array_filter(explode('&', $uri_params_string));

        foreach ($uri_params_arr as $param_pare_string) {
            $exploded = explode('=', $param_pare_string);
            $result_assoc_arr[$exploded[0]] = $exploded[1];
        }

        return $result_assoc_arr;
    }
}