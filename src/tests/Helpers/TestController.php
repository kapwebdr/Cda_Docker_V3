<?php

namespace Tests\Helpers;

/**
 * Classe helper pour les tests du routeur
 */
class TestController
{
    public static $called = false;
    public static $capturedVars = [];
    
    public function testMethod()
    {
        self::$called = true;
    }
    
    public function testMethodWithParam($id)
    {
        self::$capturedVars['id'] = $id;
    }
    
    public static function reset()
    {
        self::$called = false;
        self::$capturedVars = [];
    }
}

