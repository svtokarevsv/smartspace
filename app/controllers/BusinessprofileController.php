<?php
/**
 * Created by PhpStorm.
 * User: baong
 * Date: 2018-04-12
 * Time: 9:07 AM
 */

namespace App\controllers;

use App\lib\App;
use App\lib\Controller;
use App\lib\Router;
use App\lib\Validation;
use App\lib\EmployerVM;
use App\lib\FileUpload;
use App\models\Employer;
use App\models\Geo;
use App\models\Industry;
use App\models\File;
use App\models\Job;
use App\models\User;

class BusinessprofileController extends Controller
{
    public function __construct(array $data = array())
    {
        parent::__construct($data);
        $this->data['headTitle'] = "Profile page";
        $this->data['successMsg'] = '';

        // Models that required to this controller
        $this->model['employer'] = new Employer();
        $this->model['file'] = new File();
        $this->model['industry'] = new Industry();

        $this->data['employer'] = $this->model['employer']->getEmployerById($_SESSION['current_user']['id']);
    }

    public function index()
    {
        if ($_SESSION['current_user']['role_id'] === "1") {
            header('Location: ' . ROOT_URI . 'profile');
        }
    }

    public function edit()
    {
        // redirect to normal profile if not employer
        if ($_SESSION['current_user']['role_id'] === "1") {
            header('Location: ' . ROOT_URI . 'profile/edit');
        }
        $this->data['countries'] = Geo::getCountries();
        $this->data['cities'] = Geo::getCities();
        $this->data['industries'] = $this->model['industry']->getAll();
        $this->data['errors'] = [];

        if (isset($_POST['form__submit'])) {
            $firstName = $_POST['form__fname'];
            $lastName = $_POST['form__lname'];
            $email = $_POST['form__email'];
            $city = Validation::isEmpty($_POST['form__city']) ? null : $_POST['form__city'];
            $website = $_POST['form__website'];
            $description = $_POST['form__description'];
            $companyName = $_POST['form__company'];
            $industry = Validation::isEmpty($_POST['form__industry']) ? null : $_POST['form__industry'];
            $displayEmail = $_POST['form__displayEmail'];

            if (Validation::isEmpty($_FILES['form__profile_pic']['name'])) {
                $avatarId = $this->data['employer']->avatar_id;
            } else {
                $pic = new FileUpload('form__profile_pic', $_SESSION['current_user']['id'], 3000000, ['jpeg', 'jpg', 'png']);
                $avatarId = $pic->getFileId();
            }

            // assign values
            $employer = new EmployerVM($firstName, $lastName, $email, $avatarId, $city, $website, $description, $companyName, $industry, $displayEmail);
            $this->data['errors'] = $employer->getErrors();

            // if validation success, save to the db
            if ($employer->isValid()) {
                // UPDATE
                if (!Validation::isEmpty($_SESSION['current_user']['id'])) {
                    $this->model['employer']->updateEmployerProfile($_SESSION['current_user']['id'], $employer);
                }

                $this->data['employer'] = $this->model['employer']->getEmployerById($_SESSION['current_user']['id']);
                $this->data['successMsg'] = 'Your profile has been updated.';
                $_SESSION['current_user']=(new User())->getUserByEmail($_SESSION['current_user']['email']);
            }
        }
    }

    public function View()
    {
        $userId = $this->params[0];
        $this->data['employer'] = $this->model['employer']->getEmployerById($userId);
        if($this->data['employer']->role_id==1){
            Router::redirect(ROOT_URI.'profile/view/'.$userId);
        }
        $this->data['userId'] = $userId;
        $this->model['job'] = new Job();
        $this->data['jobs'] = $this->model['job']->getAll();
    } // end of public view()

    public function ajax_get_student_by_tags()
    {
        $keyword = $_GET['search_by_tag'];
        $results = $this->model['employer']->getStudentByTags($keyword);
        $existing_ids = [];
        $distinct_students = [];
        foreach ($results as $key => $result) {
            if (\in_array($result['id'], $existing_ids)) {
                foreach ($distinct_students as &$item) {
                    if ($item['id'] === $result['id']) {
                        $item['tags'][] = $result['keyword'];
                    }
                }
            } else {
                $existing_ids[] = $result['id'];
                $result['tags'][] = $result['keyword'];
                $distinct_students[] = $result;
            }
        }
        $this->data['studentByTag'] = $distinct_students;
    }
}