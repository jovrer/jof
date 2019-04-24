<?php
namespace SafeJo\Routing\Exception;

use SafeJo\Base\Unit\JoException;

class RouteNotExistException extends JoException
{
    public function __construct()
    {
        parent::__construct('RouteNotExistException error');
    }
}