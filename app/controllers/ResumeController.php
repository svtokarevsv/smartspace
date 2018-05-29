<?php

namespace App\controllers;

use App\lib\Controller;
use App\lib\Validation;
use App\models\Student;
use App\lib\StudentVM;
use App\models\File;
use App\lib\FileUpload;
use App\lib\Session;
use App\models\Tag;


class ResumeController extends Controller
{
    
    public function __construct(array $data = array())
    {
        parent::__construct($data);
        $this->data['headTitle'] = "Resume page";
        $this->data['errors'] = [];

        // Models that required to this controller
        $this->model['student'] = new Student;
        $this->model['file'] = new File;
        $this->data['student_resume'] = $this->model['student']->getResumeById($_SESSION['current_user']['id']);
        $resumeId = '';
    }

    // Display resume and tags
    public function index()
    {
        $this->displayResume($_SESSION['current_user']['id']);
    }

    // Add, Update or Delete resume
    public function Edit(){
        if(isset($_POST['resume__submit'])){
            $this->createResume();
        }
        if(isset($_POST['resume__delete'])){
            $this->deleteResume();
        }

    } // end of edit()


    public function View(){
        $friendsId = $this->params[0];

        if($_SESSION['current_user']['role_id']==2){
            $this->data['student_resume'] = $this->model['student']->getResumeById($friendsId);
            $this->displayResume($friendsId);  
        } else{
            $this->displayResume($_SESSION['current_user']['id']);  
        }

      
    }

    private function displayResume($sid){
        if($this->data['student_resume']->resume_id != null){
            $resume = $this->data['student_resume']->path;
            $this->data['display_resume_link'] = "<a href='".ROOT_URI.$resume."' class='btn btn-default'><i class='fa fa-download'></i>Download Resume</a>";
            $this->data['display_resume'] = "<embed src='".ROOT_URI.$resume."' type='application/pdf' width='100%' height='500px' />";
            $this->data['display_keywords'] = Tag::getTagsOfStudent($sid);
        } else{
            $this->data['display_resume_link'] = "<span>No resume available.</span>";
        }
    }

    private function createResume(){
        $resume = null;

        // 1. the resume and keywords are submitted
        // upload resume
        if(Validation::isEmpty($_FILES['form__resume']['name'])){
            $resumeId = $this->data['student_resume']->resume_id;
        } else{
            $resume =  new FileUpload('form__resume', $_SESSION['current_user']['id'], 3000000, ['pdf']);
            if($resume->isError()){
                return $this->data['errors'] = $resume->errors;
            }
            $resumeId = $resume->getFileId();
        }

        // add resume id to student table
        $this->model['student']->addResume( $_SESSION['current_user']['id'], $resumeId);
        
        // process tags
        if(!empty($_POST['resume__tags'])){
            // get user input
            $tagString = $_POST['resume__tags'];
            $tagsFromUserInput = explode(',', $tagString);
            array_pop($tagsFromUserInput);
            // get id of the keyword from db. if tag does not exist, create a new tag
            $tagsFromDb = [];
            foreach ($tagsFromUserInput as $key) {
                if(preg_match('/^[a-z0-9_]+$/', $key)==0){
                    return array_push($this->data['errors'], 'Invalid tag(s). Only a-z, 0-9, underscore(_) are allowed.');
                }
                if(Tag::getTagbyKeyword($key)==""){
                    //add new tag
                    Tag::addNewTag(strtolower($key));
                } 
                array_push($tagsFromDb, Tag::getTagbyKeyword($key));
            }

            // connect $tagsFromDb to student using keywords_in_students
            Tag::deleteCurrentTags($_SESSION['current_user']['id']);
            foreach ($tagsFromDb as $key) {
                Tag::addTagsToStudent($_SESSION['current_user']['id'], $key->id);
            }
            
        }
            
        Session::setFlash("Your resume has been uploaded.");
        header('Location: Index');

    }

    private function deleteResume(){
        $resumeId = $this->data['student_resume']->resume_id;
        // delete resume and keywords
        Tag::deleteCurrentTags($_SESSION['current_user']['id']);
        $this->model['student']->deleteResume($resumeId);

        Session::setFlash("Your resume has been deleted.");
        header('Location: Index');
    }


}