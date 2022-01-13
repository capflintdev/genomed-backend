<?php

namespace App;

use App\Exceptions\RouteNotFoundException;

class App
{
    public function __construct(
        protected Router $router,
        protected array $request
    )
    {
    }

    public function run()
    {
        try {
            echo $this->router->resolve($this->request['uri'], strtolower($this->request['method']));
        } catch (RouteNotFoundException $e) {
//            http_response_code(404);
                echo $e->getMessage() . $e->getTraceAsString() . ' on line: ' . $e->getLine();
        }
    }
}