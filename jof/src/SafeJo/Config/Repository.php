<?php
namespace SafeJo\Config;

class Repository
{
    protected $configs = [];

    public function __construct()
    {
//        $this->configs = $configs;
    }

    public function push($configs) {
        $this->configs = $this->combine($this->configs, $configs);
    }

    protected function combine(&$arrayDesc, &$arrayNew=[]) {
        $arrayRtn = $arrayDesc;
        foreach ($arrayNew as $key=>$item) {
            if(is_array($item)) {
                if(!isset($arrayDesc[$key])) {
                    $arrayDesc[$key] = [];
                }
                $arrayRtn[$key] = $this->combine($arrayDesc[$key], $item);
            }
            else {
                $arrayRtn[$key] = $item;
            }
        }
        return $arrayRtn;
    }

    public function has($key) {
        $ok = false;
        if($key) {
            $tmpV = $this->configs;
            foreach(explode('.', $key) as $v)   {
                if(!isset($tmpV[$v])) {
                    $tmpV = null;
                    break;
                }
                else {
                    $tmpV = $tmpV[$v];
                }
            }
            if($tmpV) {
                $ok = true;
            }
        }
        return $ok;
    }

    public function get($key) {
        $tmpV = null;
        if($key) {
            $tmpV = $this->configs;
            foreach(explode('.', $key) as $v)   {
                if(!isset($tmpV[$v])) {
                    $tmpV = null;
                    break;
                }
                else {
                    $tmpV = $tmpV[$v];
                }
            }
        }
        return $tmpV;
    }


}