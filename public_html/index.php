<?php
session_start();
//exit('ssdd');
error_reporting(-1);
date_default_timezone_set('UTC');

/**
 * Important Define Constants
 */
define("APP_BASE_PATH", __DIR__.'/');



include_once "app/app.php";
include_once "app/vendor/functions.php";
require_once "app/vendor/PHPImageWorkshop/autoload.php";

$application = Application::getInstance();
$application->run();
