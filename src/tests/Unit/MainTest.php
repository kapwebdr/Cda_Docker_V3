<?php

use App\Controller\Main;
use Tests\Helpers\TestController;

beforeEach(function () {
    // Réinitialiser les variables superglobales avant chaque test
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = '/';
    TestController::reset();
});

test('Router retourne 404 pour une route inexistante', function () {
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = '/route-inexistante';
    
    ob_start();
    Main::Router([]);
    $output = ob_get_clean();
    
    expect($output)->toContain('404');
});

test('Router retourne 405 pour une méthode non autorisée', function () {
    $routes = [
        '/test' => [
            'method' => ['GET'],
            'controller' => ['App\Controller\Main', 'Router']
        ]
    ];
    
    $_SERVER['REQUEST_METHOD'] = 'POST';
    $_SERVER['REQUEST_URI'] = '/test';
    
    ob_start();
    Main::Router($routes);
    $output = ob_get_clean();
    
    expect($output)->toContain('Methode interdite');
});

test('Router peut dispatcher une route valide', function () {
    $routes = [
        '/test' => [
            'method' => ['GET'],
            'controller' => [TestController::class, 'testMethod']
        ]
    ];
    
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = '/test';
    
    Main::Router($routes);
    
    expect(TestController::$called)->toBeTrue();
});

test('Router gère correctement les paramètres de route', function () {
    $routes = [
        '/user/{id:\d+}' => [
            'method' => ['GET'],
            'controller' => [TestController::class, 'testMethodWithParam']
        ]
    ];
    
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = '/user/123';
    
    Main::Router($routes);
    
    expect(TestController::$capturedVars['id'])->toBe('123');
});

test('Router décode correctement les URIs encodées', function () {
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = '/test%20avec%20espaces';
    
    ob_start();
    Main::Router([]);
    $output = ob_get_clean();
    
    // Le router devrait décoder l'URI avant de chercher la route
    expect($output)->toContain('404');
});

test('Router ignore les paramètres de requête dans l\'URI', function () {
    $routes = [
        '/test' => [
            'method' => ['GET'],
            'controller' => [TestController::class, 'testMethod']
        ]
    ];
    
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = '/test?param1=value1&param2=value2';
    
    Main::Router($routes);
    
    expect(TestController::$called)->toBeTrue();
});

