<?php

use App\Model\Db;

beforeEach(function () {
    // Réinitialiser la connexion statique avant chaque test
    $reflection = new ReflectionClass(Db::class);
    $property = $reflection->getProperty('db');
    $property->setAccessible(true);
    $property->setValue(null, null);
});

test('Db::Init initialise une connexion PDO', function () {
    // Définir les constantes nécessaires pour la connexion
    if (!defined('DB_HOST')) {
        define('DB_HOST', getenv('DB_HOST') ?: 'mariadb');
    }
    if (!defined('DB_DATABASE')) {
        define('DB_DATABASE', getenv('DB_DATABASE') ?: 'formation');
    }
    if (!defined('DB_USER')) {
        define('DB_USER', getenv('DB_USER') ?: 'root');
    }
    if (!defined('DB_PASSWORD')) {
        define('DB_PASSWORD', getenv('DB_PASSWORD') ?: 'root');
    }
    
    Db::Init();
    
    $reflection = new ReflectionClass(Db::class);
    $property = $reflection->getProperty('db');
    $property->setAccessible(true);
    $db = $property->getValue();
    
    expect($db)->toBeInstanceOf(PDO::class);
});

test('Db::Init utilise le singleton pattern', function () {
    if (!defined('DB_HOST')) {
        define('DB_HOST', getenv('DB_HOST') ?: 'mariadb');
    }
    if (!defined('DB_DATABASE')) {
        define('DB_DATABASE', getenv('DB_DATABASE') ?: 'formation');
    }
    if (!defined('DB_USER')) {
        define('DB_USER', getenv('DB_USER') ?: 'root');
    }
    if (!defined('DB_PASSWORD')) {
        define('DB_PASSWORD', getenv('DB_PASSWORD') ?: 'root');
    }
    
    Db::Init();
    
    $reflection = new ReflectionClass(Db::class);
    $property = $reflection->getProperty('db');
    $property->setAccessible(true);
    $db1 = $property->getValue();
    
    Db::Init();
    $db2 = $property->getValue();
    
    // Les deux appels devraient retourner la même instance
    expect($db1)->toBe($db2);
});

test('Db::__construct appelle Init automatiquement', function () {
    if (!defined('DB_HOST')) {
        define('DB_HOST', getenv('DB_HOST') ?: 'mariadb');
    }
    if (!defined('DB_DATABASE')) {
        define('DB_DATABASE', getenv('DB_DATABASE') ?: 'formation');
    }
    if (!defined('DB_USER')) {
        define('DB_USER', getenv('DB_USER') ?: 'root');
    }
    if (!defined('DB_PASSWORD')) {
        define('DB_PASSWORD', getenv('DB_PASSWORD') ?: 'root');
    }
    
    $db = new Db();
    
    $reflection = new ReflectionClass(Db::class);
    $property = $reflection->getProperty('db');
    $property->setAccessible(true);
    $dbInstance = $property->getValue();
    
    expect($dbInstance)->toBeInstanceOf(PDO::class);
});

test('Db configure PDO avec UTF-8 et FETCH_ASSOC', function () {
    if (!defined('DB_HOST')) {
        define('DB_HOST', getenv('DB_HOST') ?: 'mariadb');
    }
    if (!defined('DB_DATABASE')) {
        define('DB_DATABASE', getenv('DB_DATABASE') ?: 'formation');
    }
    if (!defined('DB_USER')) {
        define('DB_USER', getenv('DB_USER') ?: 'root');
    }
    if (!defined('DB_PASSWORD')) {
        define('DB_PASSWORD', getenv('DB_PASSWORD') ?: 'root');
    }
    
    Db::Init();
    
    $reflection = new ReflectionClass(Db::class);
    $property = $reflection->getProperty('db');
    $property->setAccessible(true);
    $db = $property->getValue();
    
    // Vérifier que le mode de récupération par défaut est FETCH_ASSOC
    $fetchMode = $db->getAttribute(PDO::ATTR_DEFAULT_FETCH_MODE);
    expect($fetchMode)->toBe(PDO::FETCH_ASSOC);
});

