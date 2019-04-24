<?php

namespace SafeJo\Http\Request;

use SafeJo\Variable\Unit;

class RequestData
{
//    private $varFrom = ['_GET', '_POST', '_COOKIE', '_REQUEST', '_FILE'];

    protected $method;
    protected $gets = [];
    protected $posts = [];
    protected $cookies = [];
    protected $requests = [];
    protected $files = [];

    protected $urlData = null;

    public function boot()
    {
        foreach ($GLOBALS['_GET'] as $k => $v) {
            $this->gets[$k] = new Unit\VarBase($v, true);
        }
        unset($GLOBALS['_GET']);
        foreach ($GLOBALS['_POST'] as $k => $v) {
            $this->posts[$k] = new Unit\VarBase($v, true);
        }
        unset($GLOBALS['_POST']);
        foreach ($GLOBALS['_COOKIE'] as $k => $v) {
            $this->cookies[$k] = new Unit\VarBase($v, true);
        }
        unset($GLOBALS['_COOKIE']);
        unset($GLOBALS['_POST']);
        if(isset($GLOBALS['_FILE'])) {
            foreach ($GLOBALS['_FILE'] as $k => $v) {
                $this->files[$k] = new Unit\VarBase($v, true);
            }
            unset($GLOBALS['_FILE']);
        }
        foreach ($GLOBALS['_REQUEST'] as $k => $v) {
            $this->requests[$k] = new Unit\VarBase($v, true);
        }
        unset($GLOBALS['_REQUEST']);


        $this->method = strtolower($_SERVER['REQUEST_METHOD']);
        $this->parseUrl();
    }

    public function input($key)
    {
        return isset($this->requests[$key]) ?: '';
    }

    protected function getUri() {
        $url = $_SERVER['REQUEST_URI'];
        return $url;
    }

    protected function parseUrl() {
        $url = $this->getUri();
        $urlData = parse_url($url);

        $param = [];
        if(isset($urlData['query'])) {
            $param = explode('=', $urlData['query']);
        }

        $this->urlData = new UrlData();
        $this->urlData->uri = $urlData['path'];
        $this->urlData->param = $param;
    }

    public function getMethod() {
        return $this->method;
    }

    public function getUrl() {
        return $this->urlData->uri;
    }

    public function getUrlSign() {
        return $this->urlData->uri;
    }

    public function getUrlData() {
        return $this->urlData;
    }


}