<?php
namespace  SafeJo\Event;

abstract class Dispatcher {
    protected $listeners = [];

    public function listen($events, $listener) {
        foreach(array($events) as $event) {
            $this->listeners[$event][] = $listener;
        }
    }

    public function trigger($events) {
        foreach(array($events) as $event) {
            if(isset($this->listeners[$event])) {
                foreach(array($this->listeners[$event]) as $listener) {
//                    handle
                }
            }
        }
    }




}