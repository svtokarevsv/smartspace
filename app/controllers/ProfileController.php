<?php

namespace App\controllers;

use App\lib\Controller;
use App\lib\Router;
use App\lib\Validation;
use App\models\Student;
use App\models\User;
use App\models\Education;
use App\models\Geo;
use App\lib\StudentVM;
use App\models\File;
use App\lib\FileUpload;

class ProfileController extends Controller
{

    public function __construct(array $data = array())
    {
        parent::__construct($data);
        $this->data['headTitle'] = "Profile page";
        $this->data['successMsg'] = '';

        // Models that required to this controller
        $this->model['student'] = new Student;
        $this->model['file'] = new File;

        // get student by id
        $this->data['student'] = $this->model['student']->getStudentById($_SESSION['current_user']['id']);

    }

    // read profile
    public function index()
    {
        if ($_SESSION['current_user']['role_id'] === "2") {
            header('Location: ' . ROOT_URI . 'businessprofile');
        }
        $this->data['program_name'] = Education::getProgram($this->data['student']->program_id);
        $this->data['school_name'] = Education::getSchool($this->data['student']->school_id);
        $this->data['geo_name'] = Geo::getGeoData($this->data['student']->city_id);
    } // end of index()

    // Update profile
    public function Edit(){
        if ($_SESSION['current_user']['role_id'] === "2") {
            header('Location: ' . ROOT_URI . 'businessprofile/edit');
        }

        
        $this->data['errors']=[];

        // 2. when the form is submitted
        if(isset($_POST['form__submit'])){

            $fn = $_POST['form__fname'];
            $ln = $_POST['form__lname'];
            $dob = Validation::isEmpty($_POST['form__dob'])? null:$_POST['form__dob'];
            $gender = $_POST['form__gender']??'';
            $school = Validation::isEmpty($_POST['form__school'])? null:$_POST['form__school'];
            $program = Validation::isEmpty($_POST['form__program'])? null:$_POST['form__program'];
            $work = $_POST['form__work'];
            $city = Validation::isEmpty($_POST['form__city'])? null:$_POST['form__city'];
            $email = $_POST['form__email'];
            $web = $_POST['form__web'];
            $dscr = $_POST['form__dscr'];

            if(Validation::isEmpty($_FILES['form__profile_pic']['name'])){
                $avatarId = $this->data['student']->avatar_id;
            } else{
                $pic =  new FileUpload('form__profile_pic', $_SESSION['current_user']['id'], 3000000, ['jpeg', 'jpg', 'png']);
                $avatarId = $pic->getFileId();
            }

            // assign values
            $student = new StudentVM($avatarId, $fn, $ln, $dob, $gender, $city, $school, $program, $work, $email, $web, $dscr);
            $this->data['errors'] = $student->getErrors();

            // if validation success, save to the db
            if($student->isValid()){

                // UPDATE
                if(!Validation::isEmpty($_SESSION['current_user']['id'])){
                    $this->model['student']->updateStudentProfile($_SESSION['current_user']['id'], $student);
                }

                $this->data['student'] = $this->model['student']->getStudentById($_SESSION['current_user']['id']);
                $this->data['successMsg'] = 'Your profile has been updated.'; 
                $_SESSION['current_user']=(new User())->getUserByEmail($_SESSION['current_user']['email']);
            }
        } // form submission validation
        
        // create dropdowns
        $this->data['programs'] = Education::getProgramsBySchoolId($_SESSION['current_user']['school_id']);
        $this->data['current_school']=Education::getSchool($_SESSION['current_user']['school_id']);
        $this->data['countries'] = Geo::getCountries();
        $this->data['schools'] = Education::getSchoolsByCountry($this->data['current_school']->country_id);

        //$this->data['cities'] = Geo::getCities();
        $geo = Geo::getGeoData($_SESSION['current_user']['city_id']);
        $this->data['cities'] = Geo::getCitiesByCountryId($geo->country_id);

    } // end of edit()

    // view friends profile
    public function View()
    {

        $userId = $this->params[0];

        $this->data['student'] = $this->model['student']->getStudentById($userId);
        if($this->data['student']->role_id==2){
            Router::redirect(ROOT_URI.'businessprofile/view/'.$userId);
        }
        $this->data['userId'] = $userId;
        $this->data['program_name'] = Education::getProgram($this->data['student']->program_id);
        $this->data['school_name'] = Education::getSchool($this->data['student']->school_id);
        $this->data['geo_name'] = Geo::getGeoData($this->data['student']->city_id);

    } // end of view()
}