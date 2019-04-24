<?php
namespace SafeJo\Http;

use SafeJo\Base\Application;

class Response {
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function render() {
        echo("dd");
    }
}