<?php
header('Content-Type: text/html; charset=utf-8'); 
date_default_timezone_set("Europe/Paris");
ini_set('memory_limit', '1G');

define('DIR_SRC',__DIR__.'/../');
define('DIR_APP',DIR_SRC.'App/');
define('DIR_CONFIG',DIR_SRC.'Config/');
define('DIR_PROJECTS',DIR_SRC.'Projects/');

define('DIR_PROJECT',DIR_PROJECTS.PROJECT.'/');
define('DIR_PROJECT_CONFIG',DIR_PROJECTS.PROJECT.'/Config');
define('DIR_PROJECT_MODEL',DIR_PROJECTS.PROJECT.'/Model');
define('DIR_PROJECT_CONTROLLER',DIR_PROJECTS.PROJECT.'/Controller');
define('DIR_PROJECT_VIEWS',DIR_PROJECTS.PROJECT.'/Views');
define('DIR_PROJECT_PUBLIC',DIR_PROJECTS.PROJECT.'/Public');
