<?php
/**
 * Created by PhpStorm.
 * User: baong
 * Date: 2018-04-18
 * Time: 7:10 PM
 */

namespace App\models;


use App\lib\Model;

class Timetable extends Model
{

    public function getTimetableByCreatorId($id) {
        $sql = "SELECT t.*,tp1.period AS 'startTime', tp2.period AS 'endTime' FROM timetables t
                JOIN time_periods tp1 on t.start_time = tp1.id 
                JOIN time_periods tp2 ON t.end_time = tp2.id 
                WHERE t.creator_id = :b_id";
        $stm = $this->db->prepare($sql);
        $stm->bindValue(':b_id', $id, \PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getNotesByDate($date, $creatorId) {
        $sql = "SELECT t.*, tp1.period AS 'startTime', tp2.period AS 'endTime' FROM timetables t
                JOIN time_periods tp1 on t.start_time = tp1.id 
                JOIN time_periods tp2 ON t.end_time = tp2.id 
                WHERE t.date = :b_date
                AND t.creator_id = :b_creator_id
                ORDER BY startTime";
        $stm = $this->db->prepare($sql);
        $stm->bindValue(':b_date', $date, \PDO::PARAM_STR);
        $stm->bindValue(':b_creator_id', $creatorId, \PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function createNote($note, $date, $startTimeId, $endTimeId, $creatorId) {
        $sql = "INSERT INTO timetables (note, date, start_time, end_time, creator_id) 
                VALUES (:b_note, :b_date, :b_startTimeId, :b_endTimeId, :b_creatorId)";
        $stm = $this->db->prepare($sql);
        $stm->bindValue(':b_note', $note , \PDO::PARAM_STR);
        $stm->bindValue(':b_date', $date , \PDO::PARAM_STR);
        $stm->bindValue(':b_startTimeId', $startTimeId , \PDO::PARAM_INT);
        $stm->bindValue(':b_endTimeId', $endTimeId , \PDO::PARAM_INT);
        $stm->bindValue(':b_creatorId', $creatorId , \PDO::PARAM_INT);
        return $stm->execute();
    }
    public function editNote($id, $note, $date, $startTimeId, $endTimeId, $creatorId) {
        $sql = "UPDATE timetables SET note = :b_note, date = :b_date,
                start_time = :b_startTimeId, end_time = :b_endTimeId, creator_id = :b_creatorId
                WHERE id = :b_id";
        $stm = $this->db->prepare($sql);
        $stm->bindValue(':b_id', $id , \PDO::PARAM_INT);
        $stm->bindValue(':b_note', $note , \PDO::PARAM_STR);
        $stm->bindValue(':b_date', $date , \PDO::PARAM_STR);
        $stm->bindValue(':b_startTimeId', $startTimeId , \PDO::PARAM_INT);
        $stm->bindValue(':b_endTimeId', $endTimeId , \PDO::PARAM_INT);
        $stm->bindValue(':b_creatorId', $creatorId , \PDO::PARAM_INT);
        return $stm->execute();
    }
    public function deleteNote($id) {
        $sql = "DELETE FROM timetables WHERE id = :id";
        $stm = $this->db->prepare($sql);
        $stm->bindValue(':id', $id, \PDO::PARAM_INT);
        return $stm->execute();
    }
}