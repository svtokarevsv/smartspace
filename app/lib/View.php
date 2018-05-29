<?php namespace App\lib;
use App\lib\Session;
class View
{
    private static function getDefaultViewPath()
    {
        $router=App::getRouter();
        if(!$router){
            return false;
        }
        $controller_dir= strtolower($router->getControllerName());
        $template_name=$router->getActionName().'.php';
        return VIEWS_PATH.DS.$controller_dir.DS.$template_name;
    }

    public static function br2nl($string)
    {
        return preg_replace("/<br[^>]*>\s*\r*\n*/is", "\n", $string);
    }
    public static function render($data=array(),$path=null){
        if(!$path){
            $path=self::getDefaultViewPath();
        }
        if(!file_exists($path)){
            throw new \Exception("Template file is not found in path: ".$path);
        }
        include ($path);
    }
}