<?php
use App\lib\Config;

\define('DS', DIRECTORY_SEPARATOR);
\define('ROOT', \dirname(\dirname(__DIR__)));
\define('VIEWS_PATH', ROOT . DS . 'app' . DS . 'views');
\define('UPLOADS_PATH', ROOT . DS . 'public' . DS . 'uploads');
//we need to define our root URI since our project may be not the root of the website
\define('ROOT_URI', substr(
    $_SERVER['PHP_SELF'],
    0,
    strpos($_SERVER['PHP_SELF'], 'public/index.php')));

Config::set('default_controller', 'Feed');
Config::set('default_action', 'index');

Config::set('db.host', 'web-programmer.xyz');
Config::set('db.user', '');
Config::set('db.password', "");
Config::set('db.db_name', '');

Config::set('salt','');
Config::set('per_page','15');
Config::set('comments_per_page','3');
Config::set('defaultImageId','1');
