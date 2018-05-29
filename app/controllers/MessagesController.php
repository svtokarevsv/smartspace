<?php


namespace App\controllers;

use App\lib\Controller;
use App\lib\Validation;
use App\models\Message;
use App\models\User;

class MessagesController extends Controller
{
    public function __construct(array $data = array())
    {
        parent::__construct($data);
        $this->data['headTitle']="Messages";
        $this->model=new Message();
    }

    public function index()
    {
        $this->data['messages']=$this->model->getMessages();
    }

    public function ajax_get_contact_list()
    {
        $this->data=$this->model->get_contact_list($_SESSION['current_user']['id']);
    }
    public function ajax_get_messages_with_contact()
    {
        $contact_id=$_GET['contact_id'];
        $this->data['contact']=User::getShortUserInfoById($contact_id);
        $this->data['messages']=$this->model->get_messages_with_contact_by_id($contact_id,$_SESSION['current_user']['id']);
        $this->model->updateViewedMessages($contact_id,$_SESSION['current_user']['id']);
    }

    public function ajax_get_count_unviewed_messages()
    {
        $this->data=$this->model->getCountUnviewedMessages($_SESSION['current_user']['id']);
    }

    public function ajax_send_message()
    {
        $message = $_POST['message'];
        $contact_id=$_POST['contact_id']??null;
        $errors = [];
        if (Validation::isEmpty($contact_id)) {
            $errors[] = 'Select the contact before sending message';
        }
        if (Validation::isEmpty($message)) {
            $errors[] = 'Message cannot be empty';
        }
        if (\count($errors) > 0) {
            $this->data['errors'] = $errors;
            return;
        }
        $this->data['message_id']=$this->model->createMessage($_SESSION['current_user']['id'],$contact_id,$message);
    }
}