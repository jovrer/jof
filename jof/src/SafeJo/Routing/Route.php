<?php

namespace SafeJo\Routing;

use SafeJo\Base\Unit\Container;
use SafeJo\Routing\Exception\ControllerNotExistException;
use SafeJo\Routing\Exception\MethodNotExistException;
use SafeJo\Routing\Exception\UrlParseException;
use yii\web\MethodNotAllowedHttpException;

class Route
{
    protected $url = "";
    protected $methods = [];
    protected $action;
    protected $app;
    protected $defaultRoute = [
        [
            'url' => ['route', 'default_route', 'url'],
            'method' => ['route', 'default_route', 'method'],
            'action' => ['route', 'default_route', 'action'],
        ]
    ];
    protected $defaultMethod = ['route', 'default_method'];
    protected $appNameSpace = [
        'appNameSpace',
    ];
    protected $prefix = [];
    protected $controllerName = '';
    protected $methodName = '';


    public function __construct($url, $methods = [], $action = null)
    {
        $this->url = $url;
        $this->methods = (array)$methods;
        $this->action = $action;

        if (!$this->action) {
            $this->initControllerAction();
        }
    }

    public function getInitRoute()
    {

    }

    protected function initControllerAction()
    {
        $ok = false;
        if($this->action && !$this->action instanceof \Closure) {
            $controller = $method = '';
            $prefix = [];

            list($controller, $method) = explode('@', $this->action);
            if($controller) {
                $controller = trim('\\', $controller);
                $prefixData = array_filter(explode('\\', $controller)) ;
                if(is_array($prefixData) && count($prefixData) >= 1) {
                    $controller = array_pop($prefixData);

                    if(!$method) {
                        $method = $this->app->make('config')->get(implode('.', $this->defaultMethod));
                    }

                    if($prefixData) {
                        $prefix = $prefixData;
                    }

                    if ($controller && $method) {
                        $this->controllerName = ucfirst($controller);
                        $this->methodName = $method;

                        if($prefix) {
                            $this->prefix = $prefix;
                        }
                        $ok = true;
                    }
                }
            }
        }
        else {
            if ($urlInfo = UrlParser::parse($this->url)) {
                if (is_array($urlInfo) && count($urlInfo['pathArr']) >= 1) {
                    $controller = $method = '';
                    $prefix = [];

                    if(count($urlInfo['pathArr']) == 1) {
                        $controller = array_pop($urlInfo['pathArr'])[0];
                        $method = $this->app->make('config')->get(implode('.', $this->defaultMethod));
                    }
                    else {
                        $method = array_pop($urlInfo['pathArr'])[0];;
                        $controller = array_pop($urlInfo['pathArr'])[0];
                        if(count($urlInfo['pathArr']) > 0) {
                            $prefix = $urlInfo['pathArr'];
                        }
                    }

                    if ($controller && $method) {
                        $this->controllerName = ucfirst($controller);
                        $this->methodName = $method;

                        if($prefix) {
                            $this->prefix = $prefix;
                        }
                        $ok = true;
                    }
                }
            }
        }


        $ok = true;
        $this->controllerName = 'Test';
        $this->methodName = 'test';
        if (!$ok) {
            throw new UrlParseException();
        }
        else {
            $this->controllerName .= 'Controller';
        }
    }

    public function setContainer(Container $app)
    {
        $this->app = $app;
        return $this;
    }

    public function run()
    {
        if ($this->action instanceof Closure) {
            $this->runCallable();
        }
        else {
            if($this->controllerName && $this->methodName) {
                $this->runController();
            }
        }
    }

    protected function runController()
    {
        $this->getControllerDispatcher()->dispatch($this, $this->getController(), $this->getControllerMethod());
    }

    protected function getControllerDispatcher()
    {
        return $this->app->make(ControllerDispatcher::class);
    }

    protected function getControllerMethod()
    {
        return $this->methodName;
    }

    protected function getController()
    {
        $object = null;
        $className = $this->controllerName;
        if ($appNameSpace = ltrim($this->app->make('config')->get(implode('.', $this->appNameSpace)), '\\')) {
            if($this->prefix) {
                $className = implode('\\', explode('\\', $appNameSpace)) . '\\'. implode('\\', $this->prefix). '\\' . $className;
            }
            else {
                $className = implode('\\', explode('\\', $appNameSpace)) . '\\' . $className;
            }

            $object = $this->app->make($className);

        }

        if (!$object) {
            throw new ControllerNotExistException();
        }

        return $object;
    }

    protected function runCallable()
    {
        try {
            $callale = $this->action;
//        return $callback();
        } catch (\Exception $e) {


        }
    }

    public function getMethods()
    {
        return $this->methods;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getUrlSign()
    {
        return $this->url; //?
    }


    public static function match($methods = [], $url, $action)
    {

    }

    public static function group($property = [])
    {

    }


}