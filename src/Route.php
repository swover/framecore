<?php

namespace Swover\Framework;

use Ruesin\Utils\Config;

class Route
{

    private static $instance = null;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @param $request
     * @return string
     * @throws SwoverException
     */
    public function dispatch($request)
    {
        $route = $this->parse($request['action']);

        //extract($route);
        $class = $route['class'];
        $method = $route['method'];

        //TODO reflection
        $instance = new $class($request);

        if (!method_exists($instance, $method)) {
            throw new SwoverException('Has Not method');
        }

        return call_user_func_array([$instance, $method], []);
    }

    /**
     * @param $action
     * @return array
     * @throws SwoverException
     */
    private function parse($action)
    {
        $route = Config::get('route.' . $action);

        if (is_string($route)) {
            $array = explode('::', $route);
            return [
                'class'  => $array[0],
                'method' => isset($array[1]) ? $array[1] : 'run'
            ];
        }

        throw new SwoverException('Has Not route');
    }
}