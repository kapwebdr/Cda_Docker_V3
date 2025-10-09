<?php
namespace App\Controller;

use \Smarty\Smarty;

class View
{
    static object $smarty;

    static function Init()
    {
        self::$smarty = new Smarty();
        self::$smarty->setTemplateDir(DIR_PROJECT_VIEWS);
        self::$smarty->setCacheDir(DIR_PROJECT_PRIVATE.'cache/');
        self::$smarty->setCompileDir(DIR_PROJECT_PRIVATE.'compile/');
    }

}