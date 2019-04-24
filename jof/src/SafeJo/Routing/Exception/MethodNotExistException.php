<?php
namespace SafeJo\Routing\Exception;

use SafeJo\Base\Unit\JoException;

class MethodNotExistException extends JoException
{
    public function __construct()
    {
        parent::__construct('method not found');
    }
}