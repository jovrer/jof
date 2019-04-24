<?php
namespace SafeJo\Routing;

class UrlParser {

    public static function parse($url) {
//        $urlInfo = [
//            'path'=>'',
//            'pathArr'=>[],
//            'params'=>[]
//        ];
//        if($urlInfoTmp = parse_url($url)) {
//            $urlInfo['path'] = trim($urlInfoTmp['path'], '/');
//            $urlInfo['pathArr'] = explode('/',  $urlInfoTmp['path']) ;
////            $urlInfo['pathArr'] = array_filter(explode('/',  $urlInfoTmp['path'])) ;
////            $urlInfo['pathArr'] = array_values($urlInfo['pathArr']) ;
//            $urlInfo['params'] = isset($urlInfoTmp['param'])?$urlInfoTmp['param']:[];
//        }


        $urlInfo['path'] = 'www/test';
        $urlInfo['pathArr'] = ['www','test'];
        $urlInfo['params'] = [];
        return $urlInfo;
    }
}