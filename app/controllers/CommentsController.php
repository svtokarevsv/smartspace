<?php


namespace App\controllers;


use App\lib\Controller;
use App\lib\FileUpload;
use App\lib\Validation;
use App\models\Comment;

class CommentsController extends Controller
{
    public function __construct(array $data = array())
    {
        parent::__construct($data);
        $this->data['headTitle'] = "Groups page";
        $this->model = new Comment();
    }

    public function ajax_create_comment()
    {
        $errors = [];
        $new_file_id = null;
        $message = $_POST['message'];
        $post_id = $_POST['post_id'];
        if (!$post_id) {
            $errors[] = 'Comment should belong to post';
        }
        if (Validation::isEmpty($message) && empty($_FILES['comment_image']['name'])) {
            $errors[] = 'Please enter message or add image';
        }

        if (\count($errors) === 0 && !empty($_FILES['comment_image']['name'])) {
            $new_file = new FileUpload('comment_image', $_SESSION['current_user']['id'], 3000000, ['jpeg', 'jpg', 'png']);
            $new_file_id = $new_file->getFileId();
            $errors = array_merge($errors, $new_file->getErrors());
        }

        if (\count($errors) > 0) {
            $this->data['errors'] = $errors;
            return;
        }
        $this->data['created_comment_id'] = $this->model->create($message, $new_file_id, $post_id, $_SESSION['current_user']['id']);
        $this->data['result'] = 'ok';
    }

    public function ajax_get_comments_by_post_id()
    {
        $post_id = (int)$_GET['post_id'];
        $page = (int)$_GET['page'];
        $this->data['comments'] = $this->model->getCommentsByPostId($post_id, $page);
    }
}