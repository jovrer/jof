<?php

return [
    'appNameSpace'=>'App\\Controller',
    'route' => [
        'use_default_router' => true,
        'config_file' => 'route.php',
        'default_method' => 'index',
        'default_routes' => [
            [
                'url'=>'/',
                'method'=>['get', 'post'],
//                'action' => function () {
//                    return "hello jo";
//                },
            'action' => 'TestController@test',
                'before' => [

                ],
                'after' => [

                ]
            ],

        ]
    ],

];
