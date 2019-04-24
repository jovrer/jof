<?php
namespace  SafeJo\Routing;

use SafeJo\Base\Application;
use SafeJo\Base\Unit\ServiceProvider;

class RoutingServiceProvider extends ServiceProvider {
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function register()
    {
        $this->app->instance('router', $this->app->make(Router::class));
        $this->app->instance(Controller::class, Controller::class);
    }

    public function boot() {
        $useDefaultRouter = $this->app->make('config')->get('route.use_default_router');
        if($useDefaultRouter) {
            $request = $this->app->make('request');
            $this->app->make('router')->initDefaultRoute($request->getUrl(), $request->getMethod());
        }
        else {
            $defalutRoutes = $this->app->make('config')->get('route.default_routes');
            $this->app->make('router')->initConfigRoutes($defalutRoutes);
        }
    }
}