<?php

use App\Controller\Session;

beforeEach(function () {
    // Démarrer une session pour les tests
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    // Nettoyer la session avant chaque test
    $_SESSION = [];
});

test('Session::Exists retourne false pour une clé inexistante', function () {
    expect(Session::Exists('inexistante'))->toBeFalse();
});

test('Session::Exists retourne true pour une clé existante', function () {
    Session::Set('test_key', 'test_value');
    expect(Session::Exists('test_key'))->toBeTrue();
});

test('Session::IsEmpty retourne true pour une clé vide', function () {
    expect(Session::IsEmpty('inexistante'))->toBeTrue();
    
    Session::Set('empty_key', '');
    expect(Session::IsEmpty('empty_key'))->toBeTrue();
});

test('Session::IsEmpty retourne false pour une clé avec valeur', function () {
    Session::Set('filled_key', 'value');
    expect(Session::IsEmpty('filled_key'))->toBeFalse();
});

test('Session::Get retourne null pour une clé inexistante', function () {
    expect(Session::Get('inexistante'))->toBeNull();
});

test('Session::Get retourne la valeur par défaut pour une clé inexistante', function () {
    expect(Session::Get('inexistante', 'default'))->toBe('default');
});

test('Session::Get retourne la valeur stockée', function () {
    Session::Set('user', 'John Doe');
    expect(Session::Get('user'))->toBe('John Doe');
});

test('Session::Set stocke une valeur', function () {
    Session::Set('test', 'value');
    expect($_SESSION['test'])->toBe('value');
});

test('Session::Set peut stocker différents types de valeurs', function () {
    Session::Set('string', 'text');
    Session::Set('number', 42);
    Session::Set('array', ['key' => 'value']);
    Session::Set('boolean', true);
    
    expect(Session::Get('string'))->toBe('text');
    expect(Session::Get('number'))->toBe(42);
    expect(Session::Get('array'))->toBe(['key' => 'value']);
    expect(Session::Get('boolean'))->toBeTrue();
});

test('Session::Delete supprime une clé de la session', function () {
    Session::Set('to_delete', 'value');
    expect(Session::Exists('to_delete'))->toBeTrue();
    
    Session::Delete('to_delete');
    expect(Session::Exists('to_delete'))->toBeFalse();
});

test('Session::Id retourne un ID de session', function () {
    $sessionId = Session::Id();
    expect($sessionId)->not->toBeEmpty();
    expect(strlen($sessionId))->toBeGreaterThan(0);
});

