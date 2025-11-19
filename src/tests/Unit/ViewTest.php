<?php

use App\Controller\View;

beforeEach(function () {
    // Réinitialiser la propriété statique avant chaque test
    $reflection = new ReflectionClass(View::class);
    $property = $reflection->getProperty('smarty');
    $property->setAccessible(true);
    $property->setValue(null, null);
});

test('View::Init initialise une instance Smarty', function () {
    // Définir les constantes nécessaires si elles n'existent pas
    if (!defined('DIR_PROJECT_VIEWS')) {
        define('DIR_PROJECT_VIEWS', __DIR__ . '/../../Projects/Altera/Views/');
    }
    if (!defined('DIR_PROJECT_PRIVATE')) {
        define('DIR_PROJECT_PRIVATE', __DIR__ . '/../../Projects/Altera/Private/');
    }
    
    View::Init();
    
    $reflection = new ReflectionClass(View::class);
    $property = $reflection->getProperty('smarty');
    $property->setAccessible(true);
    $smarty = $property->getValue();
    
    expect($smarty)->toBeInstanceOf(\Smarty\Smarty::class);
});

test('View::Init configure les répertoires Smarty correctement', function () {
    if (!defined('DIR_PROJECT_VIEWS')) {
        define('DIR_PROJECT_VIEWS', __DIR__ . '/../../Projects/Altera/Views/');
    }
    if (!defined('DIR_PROJECT_PRIVATE')) {
        define('DIR_PROJECT_PRIVATE', __DIR__ . '/../../Projects/Altera/Private/');
    }
    
    View::Init();
    
    $reflection = new ReflectionClass(View::class);
    $property = $reflection->getProperty('smarty');
    $property->setAccessible(true);
    $smarty = $property->getValue();
    
    // Vérifier que les répertoires sont configurés
    $templateDir = $smarty->getTemplateDir();
    $compileDir = $smarty->getCompileDir();
    $cacheDir = $smarty->getCacheDir();
    
    expect($templateDir)->not->toBeEmpty();
    expect($compileDir)->not->toBeEmpty();
    expect($cacheDir)->not->toBeEmpty();
});

test('View::Init utilise le singleton pattern', function () {
    if (!defined('DIR_PROJECT_VIEWS')) {
        define('DIR_PROJECT_VIEWS', __DIR__ . '/../../Projects/Altera/Views/');
    }
    if (!defined('DIR_PROJECT_PRIVATE')) {
        define('DIR_PROJECT_PRIVATE', __DIR__ . '/../../Projects/Altera/Private/');
    }
    
    View::Init();
    
    $reflection = new ReflectionClass(View::class);
    $property = $reflection->getProperty('smarty');
    $property->setAccessible(true);
    $smarty1 = $property->getValue();
    
    View::Init();
    $smarty2 = $property->getValue();
    
    // Les deux appels devraient retourner la même instance
    expect($smarty1)->toBe($smarty2);
});

