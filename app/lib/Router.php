<?php

namespace App\lib;
class Router
{
    protected $uri;
    protected $controller;
    protected $action;
    protected $params;


    public function getUri(): string
    {
        return $this->uri;
    }


    public function getControllerName(): string
    {
        return $this->controller;
    }


    public function getActionName(): string
    {
        return $this->action;
    }

    public function getParams()
    {
        return $this->params;
    }


    public function __construct($uri)
    {
        //remove unnecessary folders before ROOT
        // if there was a URI like 'folder/subfolder/WEBSITE_NAME/controller/action',
        // now it becomes only 'controller/action'
        if (substr($uri, 0, strlen(ROOT_URI)) == ROOT_URI) {
            $uri = substr($uri, strlen(ROOT_URI));
        }
        //remove slash before and after URI '/controller/action/' => 'controller/action'
        $this->uri = urldecode(trim($uri, '/'));
        //Get defaults so that default controller would be triggered if root url is called like 'example.com'
        $this->controller = Config::get('default_controller');
        $this->action = Config::get('default_action');

        //divide URL from its GET parameters (everything that goes after '?' we don't need here)
        $uri_parts = explode('?', $this->uri);

        //Get path like controller/action/param
        $path = $uri_parts[0];
        //make our URI an array
        $path_parts = explode('/', $path);

        //Get controller name - next element of array
        if (current($path_parts)) {
            $this->controller = ucfirst(strtolower(current($path_parts)));
            array_shift($path_parts);
        }
        //Get action name
        if (current($path_parts)) {
            $this->action = strtolower(current($path_parts));
            array_shift($path_parts);
        }

        //Get params - all the rest
        $this->params = $path_parts;
    }

    public static function redirect($location)
    {
        header("Location: $location");
    }
}