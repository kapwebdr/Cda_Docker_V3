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
    ],
    '/upload'=>
    [
        'method'=>['GET','POST'],
        'controller'=>['Projects\Altera\Controller\User','uploadAvatar']
    ],
    '/img/avatar/{file}'=>
    [
        'method'=>['GET'],
        'controller'=>['Projects\Altera\Controller\User','getAvatar']
    ]
];
/*
categories/ liste des categories
categories/ecrans-12 => listes des produits de la cat écran.
/categories/{slug}-{id:\d+}
*/