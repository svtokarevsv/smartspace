<?php
/**
 * Created by PhpStorm.
 * User: Gurinder
 * Date: 2018-04-16
 * Time: 1:18 AM
 */

namespace App\controllers;

use App\lib\App;
use App\lib\Controller;
use App\lib\FileUpload;
use App\lib\Validation;
use App\models\Friend;
use App\models\User;
use App\models\File;

class FriendsController extends  Controller
{
    public function __construct(array $data = array())
    {
        parent::__construct($data);
        $this->data['headTitle'] = "Friends List page";
        $this->model = new Friend();
    }
    //index.php
    public function index()
    {

    }
    //request.php
    public function requests() {

    }
    //find.php
    public function find() {
    }
    //list friends of friends
    public function list() {

        $friend_id = $this->params[0];
        $this->data['friend']=User::getShortUserInfoById($friend_id);
        $this->data['friendlist'] = $this->model->getFriendsOfFriends($friend_id);

    }
    //search users in find friend page
    public function ajax_searchUsers()
    {
        $search_term = $_GET['search_term'];
        $page= (int)$_GET['page'];
        $this->data['users'] = $this->model->searchUsers($search_term,$page,$_SESSION['current_user']['id']);
    }
    //get friends list
    public function ajax_get_friends() {
        $page= $_GET['page'];
        $this->data['friends'] = $this->model->getAll($page, $_SESSION['current_user']['id']);

    }

    //get friends by id
    public function ajax_getFriendsById() {
        $this->data = $this->model->getFriendsById($_GET['id']);
    }
    //delete or unfriend
    public function ajax_delete_friends_by_id()
    {
        $errors = [];
        $frnd_id = $_POST['remove_frnd_id'];
        $frnd = $this->model->getFriendsById($frnd_id);

        if (\count($errors) > 0 ) {
            $this->data['errors'] = $errors;
            return;
        }
        $result = $this->model->deleteFriendById($frnd_id);
        if($result){
            $this->data['result'] = 'ok';
        }else{
            $this->data['errors'][]='something went wrong, contact administration';
        }
    }
    //show friend requests
    public function ajax_get_friend_requests()
    {
        $this->data['friendRequests'] = $this->model->getFriendRequests($_SESSION['current_user']['id']);
    }
    //delete or decline  requests
    public function ajax_delete_requests_by_id() {
        $errors = [];
        $req_id = $_POST['remove_request_id'];
        $request = $this->model->getRequestsById($req_id);


        if (\count($errors) > 0 ) {
            $this->data['errors'] = $errors;
            return;
        }
        $result = $this->model->deleteRequestById($req_id);
        if($result){
            $this->data['result'] = 'ok';
        }else{
            $this->data['errors'][]='something went wrong, contact administration';
        }
    }
    //send a friend request
    public function ajax_send_request() {
        $errors= [];
        $user2_id = $_POST['reqId'];
        if (\count($errors) > 0 ) {
            $this->data['errors'] = $errors;
            return;
        }
        $result = $this->model->sendRequestById($_SESSION['current_user']['id'],$user2_id);
        if($result){
            $this->data['result'] = 'ok';
        }else{
            $this->data['errors'][]='something went wrong, contact administration';
        }
    }
    //delete request from table when user accept the request
    public function ajax_delete_request() {
        $errors = [];
        $req_id = $_POST['reqId'];
        $request = $this->model->getRequestsById($req_id);


        if (\count($errors) > 0 ) {
            $this->data['errors'] = $errors;
            return;
        }
        $result = $this->model->deleteRequestById($req_id);
        if($result){
            $this->data['result'] = 'ok';
        }else{
            $this->data['errors'][]='something went wrong, contact administration';
        }
    }

    public function ajax_getRequestsById(){
        $this->data = $this->model->getRequestsById($_GET['id']);
    }
    //add new friend to list after accepting request
    public function ajax_add_new_friend_fromrequest() {
        $req_id = $_POST['reqId'];
        $user2_id = $this->model->getUserByRequestID($req_id);
        $result_id=$this->model->addFriendToListById($_SESSION['current_user']['id'],$user2_id);
        if($result_id){
            $this->data['result'] = 'ok';
        }else{
            $this->data['errors'][]='couldn\'t add friend';
        }
    }

}