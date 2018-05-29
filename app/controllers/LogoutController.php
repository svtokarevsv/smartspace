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

class LogoutController extends Controller
{



    public function index(){

        //destroy all the session variable
        $_SESSION = [];
        //destroy session id and the file
        session_destroy();
        header('Location: '.ROOT_URI . "logout");
        die;
    }


}