<?php
namespace SafeJo\Base\Exception;

use SafeJo\Base\Unit\JoException;

class FileNotFoundException extends JoException {
    public function __construct()
    {
        $this->message = "File not Found111";
    }
}