<?php


namespace App\controllers;


use App\lib\Controller;
use App\lib\FileUpload;
use App\lib\Validation;
use App\models\Gallery;
use App\models\User;

class PhotosController extends Controller
{
    public function __construct(array $data = array())
    {
        parent::__construct($data);
        $this->data['headTitle'] = "Photo gallery";
        $this->model = new Gallery();
    }

    public function index()
    {

    }

    public function view()
    {
        $user_id = $this->params[0];
        $this->data['user'] = User::getUserById($user_id);
    }

    public function ajax_add_image()
    {
        $errors = [];

        $new_file = null;
        $image_title = $_POST['image_title'];
        if (Validation::isEmpty($image_title)) {
            $errors[] = 'Image title shouldn\'t be empty';
        }
        if (!\count($errors) && !empty($_FILES['gallery_image']['name'])) {
            $new_file = new FileUpload('gallery_image', $_SESSION['current_user']['id'], 2000000, ['jpeg', 'jpg', 'png']);
            $errors = array_merge($errors, $new_file->getErrors());
        } else {
            $errors[] = 'Add an image file';
        }
        if (\count($errors) > 0 || !$new_file) {
            $this->data['errors'] = $errors;
            return;
        }
        $new_image_id = $this->model->add_image($_SESSION['current_user']['id'], $image_title, $new_file->getFileId());
        if (!$new_image_id) {
            $this->data['errors'][] = "couldn't add an image, server error";
            return;
        }
        $this->data['image_id'] = $new_image_id;
        $this->data['result'] = 'ok';
    }

    public function ajax_get_current_user_images()
    {
        $this->data = $this->model->getGalleryImagesByUserId($_SESSION['current_user']['id']);
    }

    public function ajax_get_user_images()
    {
        $user_id = $_GET['user_id'];
        $this->data = $this->model->getGalleryImagesByUserId($user_id);
    }

    public function ajax_delete_image_by_id()
    {
        $image_id = (int)$_POST['delete_image_id'];
        if (!$image_id) {
            $this->data['errors'][] = 'No image selected';
            return;
        }
        $this->data = $this->model->delete_image_by_id($image_id);
    }
}