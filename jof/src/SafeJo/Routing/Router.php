<?php

namespace SafeJo\Routing;

use SafeJo\Base\Application;
use SafeJo\Http\Request;
use SafeJo\Routing\Exception\RouteNotExistException;

class Router
{
    protected $routes = [];
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    protected function addRoute(Route $route)
    {
        foreach ((array)($route->getMethods()) as $method) {
            $this->routes[$method][$route->getUrlSign()] = $route;
        }
    }

    public function dispatch(Request $request)
    {
        $this->runRoute($request, $this->findRoute($request));
    }

    public function findRoute(Request $request)
    {
        $route = null;

        if (isset($this->routes[$request->getMethod()]) && isset($this->routes[$request->getMethod()][$request->getUrlSign()])) {
            $route = $this->routes[$request->getMethod()][$request->getUrlSign()];
        }
        else {

        }

        if(!$route) {
            $route = $this->routes['get']['/'];

            throw new RouteNotExistException();
        }

        return $route;
    }


    protected function runRoute(Request $request, Route $route)
    {
        $route->run();
    }

    public function initDefaultRoute($url, $method) {
        $this->addRoute($this->newRoute($url, $method));
    }

    public function initConfigRoutes($routeConfig) {
        foreach ($routeConfig as $route) {
            $this->addRoute($this->newRoute($route['url'],$route['method'],$route['action']));
        }
    }

    protected function newRoute($url, $method = [], $action=null)
    {
        return (new Route($url, $method, $action))->setContainer($this->app);
    }

    public function get($url, $action)
    {
        $this->addRoute($this->newRoute(url, ['get'], $action));
    }

    public function post($url, $action)
    {
        $this->addRoute($this->newRoute(url, ['post'], $action));
    }

}