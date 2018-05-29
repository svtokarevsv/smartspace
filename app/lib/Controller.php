<?php
namespace App\lib;
class Controller
{
    protected $data;
    protected $model;
    protected $params;
    protected $customViewPath='';//by default view path is defined by controller name and action name, yet you may
    // change this rule and set your custom view path

    public function getData()
    {
        return $this->data;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function getParams()
    {
        return $this->params;
    }
    public function getCustomViewPath()
    {
        return $this->customViewPath;
    }
    public function __construct($data=array())
    {
        $this->data=$data;
        $this->params=App::getRouter()->getParams();

    }
}