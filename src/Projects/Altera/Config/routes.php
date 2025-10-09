<?php

$routes = 
[
    '/' => [
            'method'=>['GET','POST'],
            'controller'=>['Projects\Altera\Controller\Home','Index']
    ],
    '/user/{id:\d+}[/{title}]' => [
            'method'=>['GET'],
            'controller'=>['Projects\Altera\Controller\User','getUserById']
        ]
];