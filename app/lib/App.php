<?php

namespace App\lib;

class App
{
    private static $router;
    private static $controller_object;
    public static $db;

    /**
     * @return mixed
     */
    public static function getRouter()
    {
        return self::$router;
    }

    public static function start()
    {
        self::init();
        self::runController();
        self::runView();
    }

    private static function init()
    {
        \session_start();
        require_once \dirname(\dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'app' .
            DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php';
        self::checkInputAndRewritePostAndGetArray();
        self::$router = new Router($_SERVER['REQUEST_URI']);
        self::$db = Database::getDb();
    }

    private static function runController()
    {
        $controller_class = 'App\controllers\\' . self::$router->getControllerName() . 'Controller';
        $controller_method = self::$router->getActionName();
        self::$controller_object = new $controller_class;
        if (!isset($_SESSION['current_user']) &&
            self::$router->getControllerName() !== "Authorization") {
            header('Location: ' . ROOT_URI . "authorization");
            die;
        }
        if (method_exists(self::$controller_object, $controller_method)) {
            self::$controller_object->$controller_method();
            self::finishIfAjax($controller_method);
        } else {
            throw new \Exception('Method ' . $controller_method . ' of class ' . $controller_class . ' does not exist.');
        }
    }

    private static function runView()
    {
        $view_path = self::$controller_object->getCustomViewPath();//this variable will by default be empty, unless
        // you'll change it during controller action
        View::render(self::$controller_object->getData(), $view_path);
    }

    private static function checkInputAndRewritePostAndGetArray()
    {
        foreach ($_POST as &$item) {
            $item = Validation::sanitize($item);
        }
        unset($item);
        foreach ($_GET as &$item) {
            $item = Validation::sanitize($item);
        }
    }

    private static function finishIfAjax(string $controllerName)
    {
        if (strpos($controllerName, 'ajax_') === 0) {
            header('Content-Type: application/json');
            die(json_encode(self::$controller_object->getData()));
        }
    }

    //shortcut for varDump&Die
    public static function dd($param1, $param2 = null, $param3 = null)
    {
        echo "<pre>";
        $param1 ? var_dump($param1) : null;
        $param2 ? var_dump($param2) : null;
        $param3 ? var_dump($param3) : null;
        echo "</pre>";
        die;
    }
}