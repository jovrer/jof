<?php
namespace  SafeJo\Base\Bootstrap;

use SafeJo\Base\Application;

class BootProviders {
    protected $app;

    public function bootstrap(Application $app) {
        $this->app = $app;

        $this->app->boot();

    }
}