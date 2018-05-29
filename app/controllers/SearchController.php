<?php


namespace App\controllers;


use App\lib\Controller;
use App\models\Group;
use App\models\User;

class SearchController extends Controller
{
    public function __construct(array $data = array())
    {
        parent::__construct($data);
        $this->data['headTitle'] = "Search results";
        $this->model['user']=new User();
        $this->model['group']=new Group();
    }

    public function index()
    {
    }

    public function ajax_searchUsers()
    {
        $search_term = $_GET['search_term'];
        $page= (int)$_GET['page'];
        $this->data['users']=$this->model['user']->searchUsers($search_term,$page,$_SESSION['current_user']['id']);
    }
    public function ajax_searchUsersByNameOrEmail()
    {
        $search_term = $_GET['search_term'];
//        $page= (int)$_GET['page'];
        $this->data['users']=$this->model['user']->searchUsersByNameOrEmail($search_term,$_SESSION['current_user']['id']);
    }
    public function ajax_searchGroups()
    {
        $search_term = $_GET['search_term'];
        $page= $_GET['page'];
        $this->data['groups']=$this->model['group']->searchGroups($search_term,$page);
    }
}