<?php
namespace SafeJo\Routing\Exception;

use SafeJo\Base\Unit\JoException;

class RouteCallableException extends JoException
{
    public function __construct()
    {
        parent::__construct('RouteCallableException error');
    }
}