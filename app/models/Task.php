<?php
namespace App\models;
use App\lib\App;
use App\lib\Model;


class Task extends Model {

    // get all tasks belong to the student by id
    public function getTasksById($sid)
    {
        $q ="SELECT * FROM tasks 
            WHERE student_id=:sid
            ORDER BY due;";
        $stm = App::$db->prepare($q);
        $stm->setFetchMode(\PDO::FETCH_OBJ);
        $stm->bindParam(':sid', $sid);
        $stm->execute();
        return $stm->fetchAll();
    }

    // get the last task inserted to the tasks table
    public function getLastTaskById($sid)
    {
        $q ="SELECT * FROM tasks 
            WHERE student_id=:sid
            ORDER BY id
            DESC LIMIT 1;";
        $stm = App::$db->prepare($q);
        $stm->setFetchMode(\PDO::FETCH_OBJ);
        $stm->bindParam(':sid', $sid);
        $stm->execute();
        return $stm->fetch();
    }
    
    // get all subtasks belong to the task_id
    public function getSubtasksByTaskId($taskId)
    {
        $q ="SELECT * FROM subtasks
            WHERE task_id =:taskId
            ORDER BY step";
        $stm = App::$db->prepare($q);
        $stm->setFetchMode(\PDO::FETCH_OBJ);
        $stm->bindParam(':taskId', $taskId);
        $stm->execute();
        return $stm->fetchAll();
    }

    // get task by subtaskId
    public function getTaskBySubtaskId($stid)
    {
        $q ="SELECT tasks.* FROM tasks
            JOIN subtasks ON tasks.id = subtasks.task_id
            WHERE subtasks.id =:stid";
        $stm = App::$db->prepare($q);
        $stm->setFetchMode(\PDO::FETCH_OBJ);
        $stm->bindParam(':stid', $stid);
        $stm->execute();
        return $stm->fetch();
    }

    // add a new task
    public function addTask($sid, $tname, $due)
    {
        $q ="INSERT INTO tasks(student_id, task_name, due) 
            VALUES (:sid, :tname, :due)";
        $stm = App::$db->prepare($q);
        $stm->bindParam(':sid', $sid);
        $stm->bindParam(':tname', $tname);
        $stm->bindParam(':due', $due);
        return $stm->execute();
    }

    // add subtasks 
    public function addSubtask($tid, $stname, $step)
    {
        $q ="INSERT INTO subtasks(task_id, name, step) 
            VALUES (:tid, :stName, :step)";
        $stm = App::$db->prepare($q);
        $stm->bindParam(':tid', $tid);
        $stm->bindParam(':stName', $stname);
        $stm->bindParam(':step', $step);
        return $stm->execute();
    }

    // update update subtask status
    public function updateSubtask($stid, $sid, $status)
    {
        $q ='UPDATE subtasks 
            join tasks on subtasks.task_id = tasks.id
            SET subtasks.status=:status
            WHERE subtasks.id=:stid and tasks.student_id =:sid;';
        $stm = App::$db->prepare($q);
        $stm->bindParam(':stid', $stid);
        $stm->bindParam(':sid', $sid);
        $stm->bindParam(':status', $status);
        return $stm->execute();
    }

    public function getSubtaskStatus($stid, $sid){
        $q ="SELECT * FROM subtasks
            JOIN tasks on subtasks.task_id = tasks.id
            WHERE student_id=:sid AND subtasks.id=:stid;";
        $stm = App::$db->prepare($q);
        $stm->setFetchMode(\PDO::FETCH_OBJ);
        $stm->bindParam(':sid', $sid);
        $stm->bindParam(':stid', $stid);
        $stm->execute();
        return $stm->fetch();
    }

    // delete task
    public function deleteTask($tid, $sid){
        $q ='DELETE FROM tasks 
            WHERE id=:tid and student_id =:sid;';
        $stm = App::$db->prepare($q);
        $stm->bindParam(':tid', $tid);
        $stm->bindParam(':sid', $sid);
        return $stm->execute();
    }
}

?>

