<?php
namespace  SafeJo\Base\Bootstrap;

use SafeJo\Base\Application;
use SafeJo\Base\Exception\ErrorException;
use SafeJo\Base\Exception\ShutdownException;
use SafeJo\Base\Unit\JoException;

class HandleException {
    protected $app;

    public function bootstrap(Application $app) {
        $this->app = $app;

        set_error_handler([$this, 'handleError']);
        set_exception_handler([$this, 'handleException']);
        register_shutdown_function([$this, 'handleShutDown']);

    }

    public function handleError($level, $message, $file = '', $line = 0, $context = []) {
        $msg = sprintf('level:%s, message:%s, file:%s, line:%s', $level, $message, $file, $line);
        throw new ErrorException($msg);
    }

    public function handleException($e){
        if ($e instanceof JoException) {

        }
        else if($e instanceof \Exception) {

        }
        echo($e->getMessage());
    }

    public function handleShutDown() {
        if($msg = error_get_last()) {
            $this->handleException(new ShutdownException($msg));
        }
    }
}