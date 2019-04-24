<?php
namespace SafeJo\Contracts;

interface Container {

    public function bind($abstract, $concrete = null) ;

    public function make($abstract) ;

    public function instance($abstract, $instance);

//    public function resolved($abstract);
//
//    public function when($concrete);
//
//    public function tag($abstracts, $tags);
//
//    public function alias($abstract, $alias);
//
//    public function bound($abstract);
//
    public function singleton($abstract, $concrete = null);



}