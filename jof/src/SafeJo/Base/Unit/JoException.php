<?php

namespace SafeJo\Base\Unit;

abstract class JoException extends \Exception
{
    protected $message = "";

    public function toString() {
        return $this->message;
    }
}