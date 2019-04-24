<?php

namespace SafeJo\Http;

use SafeJo\Http\Request\RequestData;

class Request extends RequestData{




    public function create() {
        $this->boot();
        return $this;
    }




}