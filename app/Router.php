<?php

namespace App;

use App\Exceptions\RouteNotFoundException;

class Router
{
    private array $routes = [];

    public function register(string $route, callable|array $action, string $method): self
    {
        $this->routes[$method][$route] = $action;
        return $this;
    }

    public function resolve(string $requestUri, string $method)
    {
        $route = explode('?', $requestUri)[0];
//        echo '<pre>';
//        var_dump($this->routes);
//        echo '</pre>';
//        exit;
        $action = $this->routes[$method][$route] ?? null;
//        var_dump($action);
//        exit;

        if (is_null($action)) {
            throw new RouteNotFoundException();
        }

        if(is_callable($action)){
            return call_user_func($action);
        }

        if(is_array($action)){
            [$class, $method] = $action;
            if (class_exists($class)){
                $class = new $class();

                if(method_exists($class, $method)){
                    return call_user_func_array([$class, $method], []);
                }
            }
        }

        throw new RouteNotFoundException();
    }
}