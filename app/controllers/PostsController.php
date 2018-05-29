<?php
/**
 * Created by PhpStorm.
 * User: Gurinder
 * Date: 2018-04-03
 * Time: 2:20 AM
 */

namespace App\controllers;
use App\lib\App;
use App\lib\Controller;
use App\lib\FileUpload;
use App\lib\Validation;
use App\models\Post;
use App\models\User;

use App\models\File;

class PostsController extends Controller
{
    public function __construct(array $data = array())
    {
        parent::__construct($data);
        $this->data['headTitle'] = "Posts page";
        $this->model = new Post();
    }
    public function index()
    {
        $page= $_GET['page'];
        $this->data['posts'] = $this->model->getAll($page,$_SESSION['current_user']['id']);
    }
    //get all posts
    public function ajax_get_posts() {
        $page= $_GET['page'];
        $this->data['posts'] = $this->model->getAll($page,$_SESSION['current_user']['id']);
    }
    //get post by id
    public function ajax_getPostsById() {
        $this->data = $this->model->getPostById($_GET['id']);
    }
    public function ajax_get_friends_recent_posts() {
        $number =(int)$_GET['number'];
        $this->data['posts'] = $this->model->getFriendsPosts($_SESSION['current_user']['id'],$number);
    }
    //create a new post
    public function ajax_create_post()
    {
        $errors = [];
        $new_file_id = null;
        $post_message = $_POST['new_post_message'];
        $group_id = $_POST['group_id']??null;
        if (Validation::isEmpty($post_message) &&empty($_FILES['post_image']['name'] )) {
            $errors[] = 'Please Enter Message';
        }

        if (\count($errors) === 0 &&!empty($_FILES['post_image']['name'])) {
            $new_file = new FileUpload('post_image', $_SESSION['current_user']['id'], 3000000, ['jpeg', 'jpg', 'png']);
            $new_file_id=$new_file->getFileId();
            $errors = array_merge($errors, $new_file->getErrors());
        }

        if (\count($errors) > 0) {
            $this->data['errors'] = $errors;
            return;
        }
        else {
            $errors = [];
        }
        $this->data['create_post'] = $this->model->createPost($post_message,$new_file_id, $_SESSION['current_user']['id'],$group_id);
        $this->data['result'] = 'ok';

    }
    public function ajax_upload_image()
    {
        $errors = [];
        $new_file = null;
        if (\count($errors) === 0) {
            $new_file = new FileUpload('post_image', $_SESSION['current_user']['id'], 3000000, ['jpeg', 'jpg', 'png']);
            $errors = array_merge($errors, $new_file->getErrors());
        }
        if (\count($errors) > 0 || !$new_file) {
            $this->data['errors'] = $errors;
            return;
        }
        $new_post_id = $this->model->upload_image($_SESSION['current_user']['id'],
            $new_file->getFileId());
        if (!$new_post_id) {
            $this->data['errors'][] = "couldn't create a post, contact administration";
            return;
        }
        $this->data['post_id'] = $new_post_id;
        $this->data['result'] = 'ok';
    }
    //update post by id
    public function ajax_update_post_by_id()
    {
        $errors = [];
        $post_id = $_POST['edit_post_id'];
        $post = $this->model->getPostById($post_id);
        $post_message = $_POST['edit_post_message'];

        if((int)$post['creator_id']!==(int)$_SESSION['current_user']['id']){
            $errors[]='unauthorized operation, you are not the owner';
        }

        $file_id = null;
        if (!empty($_FILES['edit_post_image']['name'])&&\count($errors) === 0) {
            $new_file = new FileUpload('edit_post_image', $_SESSION['current_user']['id'], 3000000, ['jpeg', 'jpg', 'png']);
            $file_id=$new_file->getFileId();
            $errors = array_merge($errors, $new_file->getErrors());
        }

        if (\count($errors) > 0 ) {
            $this->data['errors'] = $errors;
            return;
        }
        $result = $this->model->updatePostById($post_id, $post_message,$file_id);
        if($result){
            $this->data['result'] = 'ok';
        }else{
            $this->data['errors'][]='something went wrong, contact administration';
        }
    }
    //delete post by id
    public function ajax_delete_post_by_id()
    {
        $errors = [];
        $post_id = $_POST['delete_post_id'];
        $post = $this->model->getPostById($post_id);
        $post_message = $_POST['delete_post_message'];

        if((int)$post['creator_id']!==(int)$_SESSION['current_user']['id']){
            $errors[]='unauthorized operation, you are not the owner';
        }
        if (\count($errors) > 0 ) {
            $this->data['errors'] = $errors;
            return;
        }
        $result = $this->model->deletePostById($post_id);
        if($result){
            $this->data['result'] = 'ok';
        }else{
            $this->data['errors'][]='something went wrong, contact administration';
        }
    }
}