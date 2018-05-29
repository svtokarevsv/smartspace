<?php

namespace App\controllers;

use App\lib\Controller;
use App\lib\Validation;
use App\models\Task;
use App\lib\Session;

class TaskController extends Controller
{

    public function __construct(array $data = array())
    {
        parent::__construct($data);
        // Models that required to this controller
        $this->model['task'] = new Task;
    }

    public function index(){

        $this->data['headTitle'] = 'Task Manager';
        $this->data['successMsg'] = '';   

        if(isset($_POST['task__submit'])){
            $this->createTask();
        }
        $this->ajax_getTasks();
        
    } // end of index()

    // For handling ajax request
    // Update status of the subtask
    public function ajax_updateSubtaskStatusBySubtaskId(){

        $subtaskId = $_GET['checkboxId'];
        $task = $this->model['task']->getTaskBySubtaskId($subtaskId);

        // Check current status and reverse it
        $subtask = $this->model['task']->getSubtaskStatus($subtaskId, $_SESSION['current_user']['id']);
        $stStatus = $subtask->status;
        $stStatus = !$stStatus;
        $this->model['task']->updateSubtask($subtaskId, $_SESSION['current_user']['id'], intval($stStatus));
        
        // Calculate progress and reflect it to the progress bar
        $currentProgress = $this->getTaskProgress($task);
        $taskId = $task->id; 
        $arr = ['progress'=>$currentProgress, 'taskId'=>$taskId];
        echo json_encode($arr);
    }

    public function ajax_deleteTaskByTaskId(){
        $taskId = $_GET['taskId'];
        $this->model['task']->deleteTask($taskId, $_SESSION['current_user']['id']);
    }

    public function ajax_getTasks(){
        $this->data['task'] = $this->model['task']->getTasksById($_SESSION['current_user']['id']);
        foreach ($this->data['task'] as $task) {
            $task->progress = $this->getTaskProgress($task);
        }
    }

    // private function getTasks(){
    //     $this->data['task'] = $this->model['task']->getTasksById($_SESSION['current_user']['id']);
    //     foreach ($this->data['task'] as $task) {
    //         $task->progress = $this->getTaskProgress($task);
    //     }
    // }

    private function createTask(){

        $this->data['errors']=[];

        // Get task from the form
        $tName= $_POST['task__task'];
        $tDue= $_POST['task__due'];
        $taskString = $_POST['task__subtasks'];

        $this->taskValidation($tName, $tDue, $taskString);
        if(\count($this->data['errors'])!==0){
            return $this->data['errors'];
        }

        // Add task to tasks table
        $this->model['task']->addTask($_SESSION['current_user']['id'], $tName, $tDue);
        $newTask = $this->model['task']->getLastTaskById($_SESSION['current_user']['id']);
        // Create subtasks
        $tasksFromUserInput = explode(',', $taskString);
        foreach ($tasksFromUserInput as $key) {
            if(!Validation::isLessThan($key, 50)){
                $this->data['errors']['taskString'] = 'Subtask must be less than 50 letters.';
            }
                
        }
        array_pop($tasksFromUserInput);
        $step = 1;
        foreach ($tasksFromUserInput as $key) {
            $this->model['task']->addSubtask($newTask->id, $key, $step);
            $step++;
        }
        $this->data['successMsg'] = 'Task has been created.';

    }

    private function getTaskProgress($task){
        // count number of subtasks belong to the task
        $task->subtaskOfTaskId = $this->model['task']->getSubtasksByTaskId($task->id);
        $task->numOfSubtasks = count($task->subtaskOfTaskId);

        // count number of completed subtasks
        foreach ($task->subtaskOfTaskId as $key) {
            if($key->status == true){
                $task->completedSubtasks += 1;
            } 
        }
        // calculate
        return 100/$task->numOfSubtasks * $task->completedSubtasks;
    }

    private function taskValidation($tName, $ptDue, $taskString){
        $tDue = \DateTime::createFromFormat('Y-m-d', $ptDue);
        $today = new \DateTime();
        $today->setTime(0,0,0);

        if(Validation::isEmpty($tName) || !Validation::isLessThan($tName, 50)){
            $this->data['errors']['tName'] = 'Task name is required and must be less than 50 letters.';
        }
        if($tDue===false||Validation::compareDates($tDue, $today)===-1){
            $this->data['errors']['tDue'] = 'Invalid due date. Date must be a future date.';
        }
        if(Validation::isEmpty($taskString)){            
            $this->data['errors']['taskString'] = 'At least one subtask is required and must be less than 50 letters.';
        }

    }

}