<?php
namespace  SafeJo\Base\Unit;

use SafeJo\Base\Application;

abstract class ServiceProvider {
    protected $app;
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public abstract function register();
}