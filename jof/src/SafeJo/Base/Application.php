<?php
namespace SafeJo\Base;

use SafeJo\Base\Bootstrap\BootProviders;
use SafeJo\Base\Bootstrap\HandleException;
use SafeJo\Base\Unit\Container;
use SafeJo\Http\Request;
use SafeJo\Routing\Router;
use SafeJo\Routing\RoutingServiceProvider;

class Application extends Container
{
    protected $appPath;
    protected $frameworkPath;

    protected $config = [];

//    protected $mustRequired = [
//        Loader::class,
//    ];


    public function __construct($appPath)
    {
        $this->appPath = $appPath;

        $this->frameworkPath = dirname(dirname(dirname(__FILE__)));


        $this->instance('app', $this);
        $this->instance(static::class, $this);

        (new Loader($this))->boot();
        (new ConfigLoadService($this))->boot();


        $this->registerServiceProvider();
    }


    protected function registerServiceProvider() {
        $this->register(new RoutingServiceProvider($this));

//        $this->register(new BootProviders($this));
//        $this->register(new HandleException($this));

    }



    protected function register($provider) {
//        $provider = $this->getProvider($provider);

        if(!in_array($provider, $this->serviceProviders)) {
            $this->serviceProviders[] = $provider;
        }

        if(is_string($provider)) {
            $provider = $this->resolveProvider($provider);
        }

        if(method_exists($provider, "register")) {
            $provider->register();
        }

    }

    protected function getProvider($provider) {
        $name = is_string($provider)?$provider:get_class($provider);
        if(isset($this->serviceProviders[$name])) {

        }
        else {
            $provider = null;
        }
        return $provider;
    }

    protected function resolveProvider($provider) {
        return new $provider;
    }

    public function bootstrap($bootstraps)
    {
        foreach ($bootstraps as $bootstrap) {
            $this->make($bootstrap)->bootstrap($this);
        }
    }


    public function classLoaded($className, $forceSign = false)
    {
        $loaded = isset($this->classLoaded[$className]);
//        if ($forceSign) {
//            $this->classLoaded[$className] = true;
//        }
        return $loaded;
    }




    public function run(Request $request)
    {
        $this->instance('request', $request);


    }

    public function terminate()
    {

    }

    public function getFrameworkPath()
    {
        return $this->frameworkPath;
    }

    public function getAppPath()
    {
        return $this->appPath;
    }

    public function setConfig($key, $item)
    {
        $this->config[$key] = $item;
    }
}