<?php
namespace SafeJo\Routing;


use SafeJo\Base\Application;

class ControllerDispatcher
{
    protected $app;


    public function __construct(Application $app)
    {

        $this->app = $app;
    }

    public function dispatch(Route $route, $controller, $method) {
        $parameters = [];

        if(method_exists($controller, 'callAction')) {
            $controller->callAction($method, $parameters);
        }

    }
}