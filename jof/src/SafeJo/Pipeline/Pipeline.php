<?php
namespace SafeJo\Pipeline;

use SafeJo\Http\Request;

class Pipeline {
    protected $request;
    protected $router;


    public function __construct()
    {
    }

    public function setRequest(Request $request) {
        $this->request = $request;
    }

    public function then() {

    }


}