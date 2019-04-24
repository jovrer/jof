<?php

namespace SafeJo\Variable\Unit;

class VarBase {
    protected $isTaint = false;
    protected $value = null;

    public function __construct($var, $isTaint=false)
    {
        $this->value = $var;
        $this->isTaint = $isTaint;
    }

    public function assign()
    {

    }

    public function combine(array $params=[]) {

    }

}

