<?php

namespace SafeJo\Base;

use SafeJo\Base\Unit\Service;

class ConfigLoadService extends Service
{
    protected $app;
    protected $configPath;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->configPath = $app->getAppPath() . DIRECTORY_SEPARATOR . 'config';
    }

    public function boot()
    {
        $this->loadConfig();
    }

    protected function loadConfig()
    {
        if (is_dir($this->configPath) && ($dirHandle = opendir($this->configPath))) {
            while($file=readdir($dirHandle)) {
                if($file != '.' && $file != '..') {
                    $this->app->setConfig($file, (include $file)) ;
                }
            }
            closedir($dirHandle);
        }

    }


}