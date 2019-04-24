<?php
namespace SafeJo\Routing\Exception;

use SafeJo\Base\Unit\JoException;

class UrlParseException extends JoException
{
    public function __construct()
    {
        parent::__construct('url parse error');
    }
}