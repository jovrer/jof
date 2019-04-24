<?php
namespace SafeJo\Routing\Exception;

use SafeJo\Base\Unit\JoException;

class ControllerNotExistException extends JoException
{
    public function __construct()
    {
        parent::__construct('controller not found');
    }
}