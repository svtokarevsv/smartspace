<?php
/**
 * Created by PhpStorm.
 * User: Gurinder
 * Date: 2018-04-15
 * Time: 10:44 PM
 */

namespace App\controllers;

use App\lib\App;
use App\lib\Controller;
use App\lib\FileUpload;
use App\lib\Validation;
use App\models\Post;
use App\models\User;
use App\models\File;

class FeedController extends Controller
{
    public function __construct(array $data = array())
    {
        parent::__construct($data);
        $this->data['headTitle'] = "News Feed page";
        $this->model = new Post();
    }
    public function index()
    {

    }
    //get posts of friends and user
    public function ajax_get_feed() {
        $page= $_GET['page'];
        $this->data['posts'] = $this->model->getAllFeed($_SESSION['current_user']['id'],$page);
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




}