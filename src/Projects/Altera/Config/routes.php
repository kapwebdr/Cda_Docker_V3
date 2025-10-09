<?php

$routes = 
[
    '/' => [
            'method'=>['GET','POST'],
            'controller'=>['Projects\Altera\Controller\Home','Index']
    ],
    '/user/{id:\d+}' => [
            'method'=>['GET'],
            'controller'=>['Projects\Altera\Controller\User','getUserById']
        ]
];