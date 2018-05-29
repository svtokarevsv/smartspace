<?php


namespace App\controllers;


use App\lib\App;
use App\lib\Controller;
use App\lib\FileUpload;
use App\lib\Validation;
use App\models\Group;
use App\models\Post;
use App\models\User;
use App\models\File;

class GroupsController extends Controller
{
    public function __construct(array $data = array())
    {
        parent::__construct($data);
        $this->data['headTitle'] = "Groups page";
        $this->model = new Group();
    }

    public function index()
    {
    }

    public function list()
    {
        $this->data['groups'] = $this->model->getAll();
    }

    public function view()
    {
        $group_id = $this->params[0];
        if (!$group_id) {
            header('Location: Index');
            die;
        }
        $this->data['group'] = $this->model->getGroupById($group_id);
        $this->data['group_members'] = $this->model->getGroupMembersById($group_id);
        $this->data['isGroupMember'] = $this->model->getIsMemberOfGroup($_SESSION['current_user']['id'],$group_id);
//        $this->data['isGroupMember']=$this->model->
    }

    public function ajax_getGroups()
    {
        $this->data['content'] = $this->model->getAll();
    }

    public function ajax_getGroupById()
    {
        $this->data = $this->model->getGroupById($_GET['id']);
    }

    public function ajax_getCurrentUserGroups()
    {
        $this->data['groups']=$this->model->getGroupsByUserId( $_SESSION['current_user']['id']);
    }

    public function ajax_create_group()
    {
        $errors = [];
        $group_name = $_POST['new_group_name'];
        $group_description = $_POST['new_group_description'];
        if (Validation::isEmpty($group_name)) {
            $errors[] = 'Group name shouldn\'t be empty';
        }
        if (Validation::isEmpty($group_description)) {
            $errors[] = 'Group description shouldn\'t be empty';
        }
        $existing_group = $this->model->getGroupByName($group_name);
        if ($existing_group) {
            $errors[] = 'Group with such name already exists';
        }
        $new_file = null;
        if (\count($errors) === 0) {
            $new_file = new FileUpload('group_image', $_SESSION['current_user']['id'], 3000000, ['jpeg', 'jpg', 'png']);
            $errors = array_merge($errors, $new_file->getErrors());
        }
        if (\count($errors) > 0 || !$new_file) {
            $this->data['errors'] = $errors;
            return;
        }
        $new_group_id = $this->model->create($group_name, $group_description, $_SESSION['current_user']['id'],
            $new_file->getFileId());
        $user_in_group_id = $this->model->addMemberToGroupById($_SESSION['current_user']['id'], $new_group_id);
        if (!$new_group_id || !$user_in_group_id) {
            $this->data['errors'][] = "couldn't create a group, contact administration";
            return;
        }
        $this->data['group_id'] = $new_group_id;
        $this->data['result'] = 'ok';
    }

    public function ajax_update_group_by_id()
    {
        $errors = [];
        $group_id = $_POST['edit_group_id'];
        $group = $this->model->getGroupById($group_id);
        $group_name = $_POST['edit_group_name'];
        $group_description = $_POST['edit_group_description'];
        if((int)$group['creator_id']!==(int)$_SESSION['current_user']['id']){
            $errors[]='unauthorized operation, you are not the owner';
        }
        if (Validation::isEmpty($group_name)) {
            $errors[] = 'Group name shouldn\'t be empty';
        }
        if (Validation::isEmpty($group_description)) {
            $errors[] = 'Group description shouldn\'t be empty';
        }
        $file_id = null;
        if (!empty($_FILES['edit_group_image']['name'])&&\count($errors) === 0) {
            $new_file = new FileUpload('edit_group_image', $_SESSION['current_user']['id'], 3000000, ['jpeg', 'jpg', 'png']);
            $file_id=$new_file->getFileId();
            $errors = array_merge($errors, $new_file->getErrors());
        }
        if (\count($errors) > 0 ) {
            $this->data['errors'] = $errors;
            return;
        }
        $result = $this->model->updateGroupById($group_id,$group_name, $group_description, $file_id);
        if($result){
            $this->data['result'] = 'ok';
        }else{
            $this->data['errors'][]='something went wrong, contact administration';
        }
    }

    public function ajax_searchGroups()
    {
        $search_term = $_GET['search_term'];
        $page= $_GET['page'];
        $this->data['groups']=$this->model->searchGroupsByNameAndDescription($search_term,$page,$_SESSION['current_user']['id']);
    }

    public function ajax_join_group()
    {
        $group_id = $_POST['groupId'];
        if(!$group_id){
            $this->data['errors'][]='no group id specified';
            return;
        }
        $result_id=$this->model->addMemberToGroupById($_SESSION['current_user']['id'],$group_id);
        if($result_id){
            $this->data['result'] = 'ok';
        }else{
            $this->data['errors'][]='couldn\'t join the group';
        }
    }

    public function ajax_leave_group()
    {
        $group_id = $_POST['groupId'];
        if(!$group_id){
            $this->data['errors'][]='no group id specified';
            return;
        }
        $result_id=$this->model->removeMemberFromGroupById($_SESSION['current_user']['id'],$group_id);
        if($result_id){
            $this->data['result'] = 'ok';
        }else{
            $this->data['errors'][]='couldn\'t leave the group';
        }
    }

    public function ajax_get_posts_by_group_id()
    {
        $this->data['posts']=(new Post())->get_posts_by_group_id((int)$_GET['group_id']);
    }
}