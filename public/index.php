<?php
use App\lib\App;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);
// start autoloading of classes using namespaces (done by composer)
require_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php');


App::start();
/*We'll skip try/catch for now so that we could debug errors. You may also skip try/catch anywhere in code*/
//try {
//    App::start();
//
//} catch (Exception $e) {
//    ---redirect and log errors---
//}