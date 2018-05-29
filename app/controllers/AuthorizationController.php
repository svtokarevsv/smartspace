<?php
/**
 * Created by PhpStorm.
 * User: tomosadchyi
 * Date: 10Apr18--
 * Time: 8:42 PM
 */

namespace App\controllers;


use App\lib\Controller;
use App\lib\Validation;
use App\models\User;

class AuthorizationController extends Controller
{
    public function __construct(array $data = array())
    {
        parent::__construct($data);
        $this->model = new User();
        $this->data['headTitle'] = "Authorization";
    }


    public function ajax_login_with_fb()
    {
        $email = $_POST['email'];
        if(!Validation::isEmail($email)){
            $this->data['errors'][]= "Invalid email or you are not registered on our website $email";
            return;
        }
        $user = $this->model->getUserByEmail($email);
        if(!$user){
            $this->data['errors'][]= "Such user doesn't exist on our website";
        }else{
            $user = $this->model::getUserById($user['id']);
            $_SESSION['current_user'] = $user;
            $this->data['redirect']=ROOT_URI;
        }
    }




    //authorization
    public function index()
    {
        $errors = [];

        //login
        if(isset($_POST['email_login'])){//login form submitted
            $email = $_POST['email_login'];
            $password = $_POST['password_login'];
            if(!Validation::isEmail($email)){
                $errors['login']['email']= "Invalid email";
            }
            if(Validation::isLessThan($password, 5)){
                $errors['login']['password']= "Password should be more than 4 characters";
            }

            if(count($errors) === 0){
                $user = $this->model->getUserByEmail($email);
                $isPasswordValid = password_verify($password, $user['password']);
                if(!empty($user) && $isPasswordValid){
                    $_SESSION['current_user'] = $user;
                    header('Location: '.ROOT_URI);
                }else{
                    $errors['login']['email&password']= "Email or password doesn't match";
                }
            }

        }

        //registration
        if(isset($_POST['email_registration'])){//registration form submitted
            $fname = $_POST['f_name_registration'];
            $lname = $_POST['l_name_registration'];
            $occupation = $_POST['occupation_registration'];
            $gender = $_POST['gender_registration'];
            $email = $_POST['email_registration'];
            $password = $_POST['password_registration'];
            $confirm_password = $_POST['confirm_password_registration'];

            if(Validation::isEmpty($fname) || Validation::isNumeric($fname)){
                $errors['registration']['fname']= "Please provide your first name (no numbers)";
            }

            if(Validation::isEmpty($lname) || Validation::isNumeric($lname)){
                $errors['registration']['lname']= "Please provide your last name (no numbers)";
            }

            if(Validation::isEmpty($occupation)){
                $errors['registration']['occupation']= "Please select your occupation";
            }

            if(Validation::isEmpty($gender)){
                $errors['registration']['gender']= "Please select your gender";
            }

            if(!Validation::isEmail($email)){
                $errors['registration']['email']= "Invalid email";
            }

            if (Validation::isLessThan ($password, 5)){
                $errors['registration']['password']= "Password should be more than 4 characters";
            }

            if($password != $confirm_password){
                $errors['registration']['confirm_password']= "The password doesn't match";
            }else{
                $password = password_hash($_POST['password_registration'],PASSWORD_BCRYPT);
            }

            if(count($errors) === 0){
                try{
                    $userId = $this->model->createNewUser($fname, $lname, $occupation, $gender, $email, $password);
                }catch(\PDOException $exception){
                    $errors['registration']['email']= "User with this email already exists";
                }
                if(!empty($userId)){
                    $user = $this->model::getUserById($userId);
                    $_SESSION['current_user'] = $user;
                    header('Location: '.ROOT_URI);
                }
            }
        }

        $this->data['errors'] = $errors;
    }

}