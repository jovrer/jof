<?php

namespace SafeJo\Base\Bootstrap;

use SafeJo\Base\Application;
use SafeJo\Config\Repository;

class LoadConfiguration
{
    protected $app;
    protected $sysConfigPath = ['SafeJo', 'Config', 'Default', 'app.php'];
    protected $useDefaultRouter = ['route', 'use_default_router'];
    protected $customConfigPath = ['route', 'config_file'];
    protected $hasBoot = false;

    public function bootstrap(Application $app) {
        if($this->hasBoot) return ;

        $this->app = $app;

        $this->sysConfigPath = $this->app->getFrameworkPath().DIRECTORY_SEPARATOR.implode(DIRECTORY_SEPARATOR, $this->sysConfigPath);

        $this->app->instance('config', new Repository());

        if($this->loadConfigSystem()) {
            $this->loadConfigCustom();
        }

        $this->hasBoot = true;
    }

    protected function loadConfigSystem() {
        if(file_exists($this->sysConfigPath)) {
            $config = require $this->sysConfigPath;

            $this->app->make('config')->push($config);

            return true;
        }
        else {

            return false;
        }
    }

    protected function loadConfigCustom() {

        $configPathCustom = $this->app->make('config')->get(implode('.', $this->customConfigPath));
        if(file_exists($configPathCustom)) {
            $config = require $configPathCustom;

            $this->app->make('config')->combine($config);
        }
    }

}