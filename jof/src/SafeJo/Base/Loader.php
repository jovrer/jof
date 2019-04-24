<?php
namespace  SafeJo\Base;

class Loader {
    protected $frameworkPath;
    protected $app;


    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function boot() {
        spl_autoload_register('self::loadClass', true, true);
    }

    protected function loadClass($className) {
        if(!$this->app->classLoaded($className)) {
            $pathArr = explode('\\', $className);
            if($pathArr) {
                $filePath = $this->app->getFrameworkPath().DIRECTORY_SEPARATOR.implode(DIRECTORY_SEPARATOR, $pathArr).'.php';
                if(file_exists($filePath)) {
                    include($filePath);
                    $this->app->classLoaded($className, true);
                }
                else {

                    $filePath = $this->app->getAppPath().DIRECTORY_SEPARATOR.strtolower(implode(DIRECTORY_SEPARATOR, array_slice($pathArr, 0, count($pathArr)-1))).DIRECTORY_SEPARATOR.$pathArr[count($pathArr)-1].'.php';
                    if(file_exists($filePath)) {
                        include($filePath);
                        $this->app->classLoaded($className, true);
                    }
                }
            }
        }
    }

}