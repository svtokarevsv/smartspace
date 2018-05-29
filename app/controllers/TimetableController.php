<?php
/**
 * Created by PhpStorm.
 * User: baong
 * Date: 2018-04-18
 * Time: 7:07 PM
 */

namespace App\controllers;

use App\lib\Controller;
use App\models\Timetable;
use App\models\Period;
use App\lib\Validation;

class TimetableController extends Controller
{
    public function __construct(array $data = array())
    {
        parent::__construct($data);
        $this->data['headTitle'] = 'Timetable page';
        $this->model['timetable'] = new Timetable();
    }

    public function index()
    {
        $this->data['periods'] = Period::getPeriods();
        $this->data['timetables'] = $this->model['timetable']->getTimetableByCreatorId($_SESSION['current_user']['id']);
        $day =  date("w");

        $start_week = date('Y-m-d', strtotime('-'.$day.' days'));
        $monday = date('Y-m-d', strtotime($start_week. ' + 1 days'));
        $tuesday = date('Y-m-d', strtotime($start_week. ' + 2 days'));
        $wednesday = date('Y-m-d', strtotime($start_week. ' + 3 days'));
        $thursday = date('Y-m-d', strtotime($start_week. ' + 4 days'));
        $friday = date('Y-m-d', strtotime($start_week. ' + 5 days'));
        $saturday = date('Y-m-d', strtotime($start_week. ' + 6 days'));
        $sunday = date('Y-m-d', strtotime($start_week. ' + 7 days'));

        $end_week = date('m-d-Y', strtotime('+'.(6-$day).' days'));
        $this->data['weekdays']['sun'] = $this->model['timetable']->getNotesByDate($sunday, $_SESSION['current_user']['id']);
        $this->data['weekdays']['mon'] = $this->model['timetable']->getNotesByDate($monday, $_SESSION['current_user']['id']);
        $this->data['weekdays']['tue'] = $this->model['timetable']->getNotesByDate($tuesday, $_SESSION['current_user']['id']);
        $this->data['weekdays']['wed'] = $this->model['timetable']->getNotesByDate($wednesday, $_SESSION['current_user']['id']);
        $this->data['weekdays']['thu'] = $this->model['timetable']->getNotesByDate($thursday, $_SESSION['current_user']['id']);
        $this->data['weekdays']['fri'] = $this->model['timetable']->getNotesByDate($friday, $_SESSION['current_user']['id']);
        $this->data['weekdays']['sat'] = $this->model['timetable']->getNotesByDate($saturday, $_SESSION['current_user']['id']);
    }

    public function ajax_create_new_note()
    {
        $note = $_POST['timetable__create-note'];
        $date = $_POST['timetable__create-date'];
        $endDate = $_POST['timetable__create-endDate'];
        $startTimeId = $_POST['timetable__create-startTime'];
        $endTimeId = $_POST['timetable__create-endTime'];
        $errors = [];

        if (Validation::isEmpty($note)) {
            $errors['noteErr'] = "Note is required.";
        }
        if (Validation::isEmpty($date)) {
            $errors['startDateErr'] = "Date is required.";
        }
        if (!Validation::isDate($date)) {
            $errors['startDateErr'] = "Date needs to be in correct format.";
        }
        if (!Validation::isEmpty($endDate) && !Validation::isDate($endDate)) {
            $errors['endDateErr'] = "Date needs to be in correct format.";
        }
        if (Validation::isEmpty($startTimeId)) {
            $errors['startTimeErr'] = "Start time is required.";
        }
        if (Validation::isEmpty($endTimeId)) {
            $errors['endTimeErr'] = "End time is required.";
        }
        if ($endTimeId < $startTimeId) {
            $errors['endTimeErr'] = "End time must be later than start time.";
        }
        if (\count($errors) > 0) {
            $this->data['errors'] = $errors;
            return;
        }
        if (!empty($endDate)) {
            while ($date <= $endDate) {
                $this->model['timetable']->createNote($note, $date, $startTimeId, $endTimeId, $_SESSION['current_user']['id']);
                $date = date('Y-m-d', strtotime($date . ' + 7 day'));
            }
        } else if (empty($endDate)) {
            $this->model['timetable']->createNote($note, $date, $startTimeId, $endTimeId, $_SESSION['current_user']['id']);
        }
        $this->data['result'] = 'success';
    }

    public function ajax_edit_note()
    {
        $id = $_POST['timetable__edit-id'];
        $note = $_POST['timetable__edit-note'];
        $date = $_POST['timetable__edit-date'];
        $startTimeId = $_POST['timetable__edit-startTime'];
        $endTimeId = $_POST['timetable__edit-endTime'];
        $errors = [];

        if (Validation::isEmpty($note)) {
            $errors['noteErr'] = "Note is required.";
        }
        if (Validation::isEmpty($date) || !Validation::isDate($date)) {
            $errors['dateErr'] = "Date is required.";
        }
        if (Validation::isEmpty($startTimeId)) {
            $errors['startTimeErr'] = "Start time is required.";
        }
        if (Validation::isEmpty($endTimeId)) {
            $errors['endTimeErr'] = "End time is required.";
        }
        if ($endTimeId < $startTimeId) {
            $errors['endTimeErr'] = "End time must be later than start time.";
        }
        if (\count($errors) > 0) {
            $this->data['errors'] = $errors;
            return;
        }
        $this->model['timetable']->editNote($id, $note, $date, $startTimeId, $endTimeId, $_SESSION['current_user']['id']);
        $this->data['result'] = 'success';
    }

    public function ajax_delete_note()
    {
        $id = $_POST['timetable__edit-id'];
        $this->model['timetable']->deleteNote($id);
        $this->data['result'] = 'success';
    }
}
