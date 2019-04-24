<?php

namespace SafeJo\Base\Unit;

use SafeJo\Contracts\Container as ContainerConstract;
use Closure;
use ReflectionClass;

abstract class Container implements ContainerConstract
{
    protected $bindings = [];
    protected $instances = [];
    protected $aliases = [];
    protected $serviceProviders = [];

    protected $classLoaded = [];


    public function bind($abstract, $concrete = null)
    {
        if (!isset($this->bindings[$abstract])) {
            $this->bindings[$abstract] = compact('concrete', 'shared');
        }
    }

    public function boot() {
        array_walk($this->serviceProviders, function($provider) {
            $this->bootProvider($provider);
        });
    }

    protected function bootProvider(ServiceProvider $provider) {
        if (method_exists($provider, 'boot')) {
            call_user_func([$provider, "boot"]);
        }
    }

    public function instance($abstract, $instance)
    {
        $this->instances[$abstract] = $instance;
    }

    public function singleton($abstract, $concrete = null)
    {
        $this->instances[$abstract] = $concrete;
    }

    public function alias($abstract, $alias)
    {
        $this->aliases[$abstract] = $alias;
    }


    public function make($abstract)
    {
        return $this->resolve($abstract);
    }

    protected function build($concrete)
    {
        if ($concrete instanceof Closure) {
            return $concrete($this);
        }

        $reflector = new ReflectionClass($concrete);

        $constructor = $reflector->getConstructor();

        if (is_null($constructor)) {

            return new $concrete;
        }

        $dependencies = $constructor->getParameters();

        $paramInsts = $this->resolveDependencies(
            $dependencies
        );

        return $reflector->newInstanceArgs($paramInsts);
    }

    protected function resolveDependencies(array $dependencies)
    {
        $result = [];
        foreach ($dependencies as $dependency) {
            $result[] = is_null($dependency->getClass())?null:$this->resolveClass($dependency);
        }
        return $result;
    }

    protected function resolveClass($dependency) {
        return $this->make($dependency->getClass()->name);
    }

    protected function resolve($abstract)
    {
        $object = null;
        if (isset($this->instances[$abstract])) {
            $object = $this->instances[$abstract];
        }
        else {
            $concrete = $this->getConcrete($abstract);

            if ($this->isBuildable($concrete, $abstract)) {
                $object = $this->build($concrete);
            } else {
                $object = $this->make($concrete);
            }
        }

        return $object;
    }

    protected function isBuildable($concrete, $abstract)
    {
        return $concrete === $abstract || $concrete instanceof Closure;
    }

    protected function getConcrete($abstract)
    {
        if (isset($this->bindings[$abstract])) {
            $abstract = $this->bindings[$abstract]['concrete'];
        }
        return $abstract;
    }
}