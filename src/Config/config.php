<?php
header('Content-Type: text/html; charset=utf-8'); 
date_default_timezone_set("Europe/Paris");
ini_set('memory_limit', '1G');

define('DIR_SRC',__DIR__.'/../');
define('DIR_APP',DIR_SRC.'App/');
define('DIR_CONFIG',DIR_SRC.'Config/');
define('DIR_PROJECTS',DIR_SRC.'Projects/');

define('DIR_PROJECT',DIR_PROJECTS.PROJECT.'/');
define('DIR_PROJECT_CONFIG',DIR_PROJECT.'Config/');
define('DIR_PROJECT_MODEL',DIR_PROJECT.'Model/');
define('DIR_PROJECT_CONTROLLER',DIR_PROJECT.'Controller/');
define('DIR_PROJECT_VIEWS',DIR_PROJECT.'Views/');
define('DIR_PROJECT_PUBLIC',DIR_PROJECT.'Public/');
define('DIR_PROJECT_PRIVATE',DIR_PROJECT.'Private/');

$routes = [];
if(file_exists(DIR_PROJECT_CONFIG.'routes.php'))
{
    require_once(DIR_PROJECT_CONFIG.'routes.php');
}
if(file_exists(DIR_PROJECT_CONFIG.'config.php'))
{
    require_once(DIR_PROJECT_CONFIG.'config.php');
}

require_once(DIR_SRC.'vendor/autoload.php');

\App\Controller\Session::Start();