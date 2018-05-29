<?php


namespace App\controllers;

use App\lib\App;
use App\lib\Controller;
use App\lib\Router;
use App\lib\Session;
use App\lib\Validation;
use App\models\Geo;
use App\models\Industry;
use App\models\Job;
use App\models\User;

class JobsController extends Controller
{
    public function __construct(array $data = array())
    {
        parent::__construct($data);
        $this->data['headTitle'] = 'Job page';
        // models for this controller
        $this->model['user'] = new User();
        $this->model['job'] = new Job();
        $this->model['industry'] = new Industry();
    }
    public function index()
    {
        if ($_SESSION['current_user']['role_id'] === "1") {
            header('Location: ' . ROOT_URI);
        }
        $this->data['industries'] = $this->model['industry']->getAll();
        $this->data['countries'] = Geo::getCountries();
        //$this->data['jobs'] = $this->model['job']->getJobByCreatorId($_SESSION['current_user']['id']);
    }

    public function ajax_getJobList()
    {
        $this->data['jobs'] = $this->model['job']->getJobByCreatorId($_SESSION['current_user']['id'], $_GET['page']);
    }

    public function view()
    {
        if ($_SESSION['current_user']['role_id'] === "1") {
            header('Location: ' . ROOT_URI);
        }
        $this->data['jobs'] = $this->model['job']->getJobByCreatorId($_SESSION['current_user']['id'], $_GET['page']);
    }

    public function create()
    {
        if ($_SESSION['current_user']['role_id'] === "1") {
            header('Location: ' . ROOT_URI);
        }
        // For dropdown list
        $this->data['industries'] = $this->model['industry']->getAll();
        $this->data['countries'] = Geo::getCountries();
        $this->data['cities'] = Geo::getCities();

        $title = $description = $type = $dateClosed = $salary = $industry = $city = '';
        $this->data['titleErr'] = $this->data['descriptionErr'] = $this->data['typeErr'] =
        $this->data['dateClosedErr'] = $this->data['salaryErr'] =
        $this->data['industryErr'] = $this->data['cityErr'] = '';
        $error = false;

        if (isset($_POST['create'])) {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $type = $_POST['type'];
            $dateClosed = empty($_POST['dateclosed']) ? null : $_POST['dateclosed'];
            $salary = $_POST['salary'];
            $industry = empty($_POST['industry']) ? null : $_POST['industry'];
            $city = empty($_POST['city']) ? null : $_POST['city'];

            if (Validation::isEmpty($title)) {
                $this->data['titleErr'] = "Job title is required.";
                $error = true;
            }
            if (Validation::isGreaterThan($title, 50)) {
                $this->data['titleErr'] = "Job title must be less than 50 characters.";
                $error = true;
            }
            if (!Validation::isText($title)) {
                $this->data['titleErr'] = "Name can only contain characters.";
                $error = true;
            }
            if (Validation::isEmpty($description)) {
                $this->data['descriptionErr'] = "Description is required.";
                $error = true;
            }
            if (Validation::isGreaterThan($description, 800)) {
                $this->data['descriptionErr'] = "Description must be less than 800 characters.";
                $error = true;
            }
            if (Validation::isEmpty($type)) {
                $this->data['typeErr'] = "Type of job is required.";
                $error = true;
            }
            if (Validation::isGreaterThan($type, 50)) {
                $this->data['typeErr'] = "Type of job must be less than 50 characters.";
                $error = true;
            }
            if ($dateClosed == null){
                $this->data['dateClosedErr'] = '';
            } else if (Validation::compareDates(new \DateTime($dateClosed), new \DateTime()) !== -1 || !Validation::isDate($dateClosed)){
                $this->data['dateClosedErr'] = 'Invalid date, date cannot be in the past.';
            }
            if (Validation::isEmpty($salary)) {
                $this->data['salaryErr'] = "Salary is required.";
                $error = true;
            }
            if (Validation::isGreaterThan($salary, 50)) {
                $this->data['salaryErr'] = "Salary must be less than 50 characters.";
                $error = true;
            }
            if (Validation::isEmpty($city)) {
                $this->data['cityErr'] = "City is required.";
                $error = true;
            }
            if (Validation::isEmpty($industry)) {
                $this->data['industryErr'] = "Industry is required.";
                $error = true;
            }

            if (!$error) {
                $this->model['job']->createJob($title, $description, $type, $dateClosed, $salary, $_SESSION['current_user']['id'], $industry, $city);
                header('Location: index');
            }
        }
    }

    public function ajax_getJobById() {
        $this->data['cities'] = Geo::getCities();
        $title = $description = $type = $dateClosed = $salary = $industry = $city = '';

        $update_id = $_GET['edit_id'];
        $this->data['jobById'] = $this->model['job']->getJobById($update_id);
    }

    public function ajax_editJob() {
        if (isset($_POST['job__edit-id'])) {
            $update_id = $_POST['job__edit-id'];
            $title = $_POST['job__edit-title'];
            $description = $_POST['job__edit-description'];
            $type = $_POST['job__edit-type'];
            $dateClosed = empty($_POST['job__edit-dateclosed']) ? null : $_POST['job__edit-dateclosed'];
            $salary = $_POST['job__edit-salary'];
            $industry = $_POST['job__edit-industry'];
            $city = $_POST['job__edit-city'];

            if (Validation::isEmpty($title)) {
                $this->data['errors']['titleErr'] = "Job title is required.";
            }
            if (Validation::isGreaterThan($title, 50)) {
                $this->data['errors']['titleErr'] = "Job title must be less than 50 characters.";
            }
            if (!Validation::isText($title)) {
                $this->data['errors']['titleErr'] = "Name can only contain characters.";
            }
            if (Validation::isEmpty($description)) {
                $this->data['errors']['descriptionErr'] = "Description is required.";
            }
            if (Validation::isGreaterThan($description, 800)) {
                $this->data['errors']['descriptionErr'] = "Description must be less than 800 characters.";
            }
            if (Validation::isEmpty($type)) {
                $this->data['errors']['typeErr'] = "Type of job is required.";
            }
            if (Validation::isGreaterThan($type, 50)) {
                $this->data['errors']['typeErr'] = "Type of job must be less than 50 characters.";
            }
            if ($dateClosed == null) {
                $this->data['dateClosedErr'] = '';
            } else if (Validation::compareDates(new \DateTime($dateClosed), new \DateTime()) !== -1 || !Validation::isDate($dateClosed)) {
                $this->data['errors']['dateClosedErr'] = 'Invalid date, date cannot be in the past.';
            }
            if (Validation::isEmpty($salary)) {
                $this->data['errors']['salaryErr'] = "Salary is required.";
            }
            if (Validation::isGreaterThan($salary, 50)) {
                $this->data['errors']['salaryErr'] = "Salary must be less than 50 characters.";
            }
            if (Validation::isEmpty($city)) {
                $this->data['errors']['cityErr'] = "City is required.";
            }
            if (Validation::isEmpty($industry)) {
                $this->data['errors']['industryErr'] = "Industry is required.";
            }
            if (\count($this->data['errors']) > 0) {
                return;
            }
            $this->model['job']->editJob($update_id, $title, $description, $type, $dateClosed, $salary, $industry, $city);
            $this->data['result'] = 'ok';
        }
    }

    public function edit()
    {
        if ($_SESSION['current_user']['role_id'] === "1") {
            header('Location: ' . ROOT_URI);
        }
        $this->data['industries'] = $this->model['industry']->getAll();
        $this->data['countries'] = Geo::getCountries();
        $this->data['cities'] = Geo::getCities();
        $title = $description = $type = $dateClosed = $salary = $industry = $city = '';
        $this->data['titleErr'] = $this->data['descriptionErr'] = $this->data['typeErr'] =
        $this->data['dateClosedErr'] = $this->data['salaryErr'] =
        $this->data['industryErr'] = $this->data['cityErr'] = '';
        $error = false;

        $update_id = $this->params[0];
        $this->data['jobsById'] = $this->model['job']->getJobById($update_id);

        if (isset($_POST['save'])) {
            $jid = $_POST['jid'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $type = $_POST['type'];
            $dateClosed = empty($_POST['dateclosed']) ? null : $_POST['dateclosed'];
            $salary = $_POST['salary'];
            $industry = $_POST['industry'];
            $city = $_POST['city'];

            if (Validation::isEmpty($title)) {
                $this->data['titleErr'] = "Job title is required.";
                $error = true;
            }
            if (Validation::isGreaterThan($title, 50)) {
                $this->data['titleErr'] = "Job title must be less than 50 characters.";
                $error = true;
            }
            if (!Validation::isText($title)) {
                $this->data['titleErr'] = "Name can only contain characters.";
                $error = true;
            }
            if (Validation::isEmpty($description)) {
                $this->data['descriptionErr'] = "Description is required.";
                $error = true;
            }
            if (Validation::isGreaterThan($description, 800)) {
                $this->data['descriptionErr'] = "Description must be less than 800 characters.";
                $error = true;
            }
            if (Validation::isEmpty($type)) {
                $this->data['typeErr'] = "Type of job is required.";
                $error = true;
            }
            if (Validation::isGreaterThan($type, 50)) {
                $this->data['typeErr'] = "Type of job must be less than 50 characters.";
                $error = true;
            }
            if ($dateClosed == null){
                $this->data['dateClosedErr'] = '';
            } else if (Validation::compareDates(new \DateTime($dateClosed), new \DateTime()) !== -1 || !Validation::isDate($dateClosed)){
                $this->data['dateClosedErr'] = 'Invalid date, date cannot be in the past.';
            }
            if (Validation::isEmpty($salary)) {
                $this->data['salaryErr'] = "Salary is required.";
                $error = true;
            }
            if (Validation::isGreaterThan($salary, 50)) {
                $this->data['salaryErr'] = "Salary must be less than 50 characters.";
                $error = true;
            }
            if (Validation::isEmpty($city)) {
                $this->data['cityErr'] = "City is required.";
                $error = true;
            }
            if (Validation::isEmpty($industry)) {
                $this->data['industryErr'] = "Industry is required.";
                $error = true;
            }
            if (!$error) {
                $this->model['job']->editJob($update_id, $title, $description, $type, $dateClosed, $salary, $industry, $city);
                header('Location: ' . ROOT_URI . 'jobs/index');
            }
        }
    }

    public function ajax_deleteJob()
    {
        $deleteId = $_POST['job__delete-id'];
        $job = $this->model['job']->getJobById($deleteId);

        if (Validation::isEmpty($deleteId)) {
            $this->data['errors'][] = "Job id is required.";
        }

        if ($_SESSION['current_user']['id'] !== $job->creator_id) {
            $this->data['errors'][] = "Only job owner can delete this job.";
        }

        if (\count($this->data['errors']) > 0) {
            return;
        }

        $this->model['job']->deleteJob($deleteId);
        $this->data['result'] = 'ok';
    }
}