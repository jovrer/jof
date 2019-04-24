<?php
namespace SafeJo\Routing;

use SafeJo\Routing\Exception\MethodNotExistException;

abstract class Controller {
    protected $router;

    public function callAction($method, $parameters=[]) {

        if(method_exists($this, $method)) {
            return call_user_func_array([$this, $method], $parameters);
        }

        throw new MethodNotExistException();
    }
}