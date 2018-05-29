<?php
/**
 * Created by PhpStorm.
 * User: tomosadchyi
 * Date: 10Apr18--
 * Time: 9:17 PM
 */

namespace App\controllers;


use App\lib\Controller;
use App\lib\FileUpload;
use App\lib\Validation;
use App\models\Events;

class EventsController extends Controller
{

    public function __construct(array $data = array())
    {
        parent::__construct($data);
        $this->data['headTitle'] = "Events page";
        $this->model = new Events();
    }


    public function index()
    {
        // $this->data['events'] = $this->model->getAll($_SESSION['current_user']['id']);
    }


    public function ajax_get_events()
    {
        $this->data['events'] = $this->model->getAll($_SESSION['current_user']['id']);
    }


    public function ajax_getAllEvents()
    {
        $this->data['events']=$this->model->getAllEvents($_GET['page'], $_GET['search_term']);
    }


    public function ajax_getEventById()
    {
        $this->data = $this->model->getEventById($_GET['id']);
    }


    public function ajax_create_event()
    {
        $errors = [];
        $new_file_id = null;
        $event_name = $_POST['new_event_name'];
        $event_location = $_POST['new_event_location'];
        $event_start = $_POST['new_event_date_start'];
        $event_start_time = $_POST['new_event_time_start'];
        $event_end = $_POST['new_event_date_end'];
        $event_end_time = $_POST['new_event_time_end'];
        $event_description = $_POST['new_event_description'];
        if (Validation::isEmpty($event_name)) {
            $errors[] = 'Please Enter Name of the event';
        }
        if (Validation::isEmpty($event_location)) {
            $errors[] = 'Please Enter Location';
        }
        if (!Validation::isDate($event_start)) {
            $errors[] = 'Incorrect format of the date';
        }
        if (!Validation::isDate($event_end)) {
            $errors[] = 'Incorrect format of the date';
        }

        if (Validation::compareDates(\DateTime::createFromFormat('Y-m-d', $event_start),
                                     \DateTime::createFromFormat('Y-m-d', $event_end)) === 1) {
            $errors[] = 'End date can\'t be less than start date';
        }
        if (Validation::isGreaterThan($event_description, 2000)) {
            $errors[] = 'Description can\'t be more than 2000 characters';
        }
        if(empty($_FILES['event_image']['name'] )){
            $errors[] = 'Please add an image to your event';
        }
        if (\count($errors) === 0) {
            $new_file = new FileUpload('event_image', $_SESSION['current_user']['id'], 1000000, ['jpeg', 'jpg', 'png']);
            $new_file_id = $new_file->getFileId();
            $errors = array_merge($errors, $new_file->getErrors());
        }

        if (\count($errors) > 0) {
            $this->data['errors'] = $errors;
            return;
        }

        $this->data['create_event'] = $this->model->createEvent($event_name, $event_location,
                                                                $event_start, $event_start_time,
                                                                $event_end, $event_end_time,
                                                                $event_description, $new_file_id,
                                                                $_SESSION['current_user']['id']);
        $this->data['result'] = 'ok';
    }





    public function ajax_edit_event()
    {
        $errors = [];
        $new_file_id = null;
        $event_name = $_POST['edit_event_name'];
        $event_location = $_POST['edit_event_location'];
        $event_start = $_POST['edit_event_start'];
        $event_start_time = $_POST['edit_event_time_start'];
        $event_end = $_POST['edit_event_end'];
        $event_end_time = $_POST['edit_event_time_end'];
        $event_description = $_POST['edit_event_description'];
        $event_id = $_POST['edit_event_id'];

        if (Validation::isEmpty($event_name)) {
            $errors[] = 'Please Enter Name of the event';
        }
        if (Validation::isEmpty($event_location)) {
            $errors[] = 'Please Enter Location';
        }
        if (!Validation::isDate($event_start)) {
            $errors[] = 'Incorrect format of the date';
        }
        if (!Validation::isDate($event_end)) {
            $errors[] = 'Incorrect format of the date';
        }

        if (Validation::compareDates(\DateTime::createFromFormat('Y-m-d', $event_start),
                \DateTime::createFromFormat('Y-m-d', $event_end)) === 1) {
            $errors[] = 'End date can\'t be less than start date';
        }
        if (Validation::isGreaterThan($event_description, 2000)) {
            $errors[] = 'Description can\'t be more than 2000 characters';
        }

        if (\count($errors) === 0 && !empty($_FILES['edit_event_image']['name'] )) {
            $new_file = new FileUpload('edit_event_image', $_SESSION['current_user']['id'], 1000000, ['jpeg', 'jpg', 'png']);
            $new_file_id = $new_file->getFileId();
            $errors = array_merge($errors, $new_file->getErrors());
        }

        if (\count($errors) > 0) {
            $this->data['errors'] = $errors;
            return;
        }

        $this->data['edit_event'] = $this->model->editEvent($event_name, $event_location,
                                                            $event_start, $event_start_time,
                                                            $event_end, $event_end_time,
                                                            $event_description, $new_file_id,
                                                            $_SESSION['current_user']['id'], $event_id);

        $this->data['result'] = 'ok';
    }


    public function ajax_delete_event()
    {
        $errors = [];
        $event_id = $_POST['delete_event_id'];
        $event = $this->model->getEventById($event_id);

        if((int)$event['creator_id'] != $_SESSION['current_user']['id']){
            $errors[]='You can delete only your events';
        }
        if (\count($errors) > 0 ) {
            $this->data['errors'] = $errors;
            return;
        }
        $result = $this->model->deleteEventById($event_id);
        if($result){
            $this->data['result'] = 'ok';
        }else{
            $this->data['errors'][]='something went wrong, contact administration';
        }
    }


    public function event_details()
    {
        $event_id = $this->params[0];
        if (!$event_id) {
            header('Location: Index');
            die;
        }
        $this->data['event'] = $this->model->getEventById($event_id);

    }


}




















