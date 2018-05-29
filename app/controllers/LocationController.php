<?php


namespace App\controllers;


use App\lib\Controller;
use App\models\UserLocation;

class LocationController extends Controller
{
    public function __construct(array $data = array())
    {
        parent::__construct($data);
        $this->data['headTitle'] = "Map locations";
        $this->model= new UserLocation();
    }

    public function index()
    {

    }

    public function ajax_update_user_location()
    {
        $lat=$_POST['lat'];
        $ln=$_POST['ln'];
        $result=$this->model->updateUserLocation($_SESSION['current_user']['id'],$lat,$ln);
        if($result){
            $this->data['result']='ok';
        }
    }

    public function ajax_get_current_user_location()
    {
        $this->data=$this->model->getUserLocationById($_SESSION['current_user']['id']);
    }

    public function ajax_search_friend_location_by_name()
    {
        $search=$_GET['search_term'];
        $this->data['friends']=$this->model->getFriendsLocationByName($search,$_SESSION['current_user']['id']);
    }
}