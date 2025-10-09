<?php
$array_directories = explode('/',__DIR__);
define('PROJECT',$array_directories[count($array_directories)-2]);
require_once(__DIR__.'/../../../Config/config.php');
use \App\Controller\Main;
Main::Router();