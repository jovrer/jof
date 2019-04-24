<?php
namespace SafeJo\Contracts;

interface Kernel {
    public function bootstrap();

    public function handle($request);

    public function terminate($request, $response);

}