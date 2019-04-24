<?php

namespace SafeJo\Base\Http;

use SafeJo\Base\Application;
use SafeJo\Base\Bootstrap\BootProviders;
use SafeJo\Base\Bootstrap\HandleException;
use SafeJo\Base\Bootstrap\LoadConfiguration;
use SafeJo\Contracts\Kernel as HttpKernel;
use SafeJo\Routing\Router;

class Kernel implements HttpKernel
{
    protected $app;
//    protected $router;
    protected $bootstrappers=[
        LoadConfiguration::class,
        HandleException::class,
        BootProviders::class,
    ];

//    public function __construct(Application $app, Router $router)
//    {
//        $this->app = $app;
//        $this->router = $router;
//    }

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function bootstrap()
    {
        if($this->bootstrappers) {
            $this->app->bootstrap($this->bootstrappers);
        }
    }

    public function handle($request)
    {
        $this->app->instance('request', $request);

        $this->bootstrap();

        $this->dispatchToRouter($request);

    }

    protected function dispatchToRouter($request)
    {
        $this->app->make('router')->dispatch($request);
    }

    public function terminate($request, $response)
    {
        $i = 111;
        // TODO: Implement terminate() method.
    }


}