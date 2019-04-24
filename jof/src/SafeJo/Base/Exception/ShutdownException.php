<?php
namespace SafeJo\Base\Exception;


use SafeJo\Base\Unit\JoException;

class ShutdownException extends JoException
{
    public function __construct($message)
    {
        if(is_array($message)) {
            $message = implode('--', $message);
        }
        parent::__construct($message);
    }
}