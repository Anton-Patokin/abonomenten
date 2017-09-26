<?php

class Router
{
    private $_routes;

    function __construct()
    {
        $this->_routes = $GLOBALS["config"]["routes"];
        $route = $this->findRoute();
        if (class_exists($route["controller"])) {
            $controller = new $route["controller"];
            if (method_exists($controller, $route['method'])) {
                call_user_func_array([$controller,$route["method"]],[]);
            } else {
                CustomErrors::show('404');
            }
        } else {
            CustomErrors::show('404');

        }
    }

    private function routePart($route)
    {
        if (is_array($route)) {
            $route = $route["url"];
        }
        $parts = explode("/", $route);
        return $parts;
    }

    static function uri($part)
    {
        $parts = explode('/', $_SERVER["REQUEST_URI"]);
        if ($parts[1] == $GLOBALS["config"]["path"]['index']) {
            $part++;
        }
        return (isset($parts[$part]))? $parts[$part] : "";
    }

    private function findRoute()
    {
        foreach ($this->_routes as $route) {
            $parts = $this->routepart($route);
            $allMath = true;
            foreach ($parts as $key => $value) {
                if ($value != "*") {
                    if (router::uri($key) != $value) {
                        $allMath = false;
                    }
                }
            }
            if ($allMath) {
                return $route;
            }
        }
        $uri_1 = router::uri(1);
        $uri_2 = router::uri(2);
        if ($uri_1 == "") {
            $uri_1 = $GLOBALS["config"]["default"]['controller'];
        }
        if ($uri_2 == "") {
            $uri_2 = $GLOBALS["config"]["default"]['method'];
        }
        $route = [
            "controller" => $uri_1 . "Controller",
            "method"     => $uri_2
        ];
        return $route;
    }

}

?>