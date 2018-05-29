<?php
/**
 * Created by PhpStorm.
 * User: tomosadchyi
 * Date: 10Apr18--
 * Time: 9:49 PM
 */

namespace App\models;


use App\lib\App;
use App\lib\Config;
use App\lib\Model;

class Events extends Model
{

    public function createEvent($event_name, $event_location,
                                $event_start, $event_start_time,
                                $event_end, $event_end_time,
                                $event_description, $new_file_id,
                                $current_user_id)
    {

        $sql = "INSERT INTO events (event_name, event_location, 
                                    event_start, event_start_time, 
                                    event_end, event_end_time,
                                    event_description, image_id, 
                                    creator_id)
                VALUES (:event_name, :event_location, 
                        :event_start, :event_start_time,
                        :event_end, :event_end_time,
                        :event_description, :image_id, 
                        :creator_id)";
        $pdoStm = $this->db->prepare($sql);
        $pdoStm->bindValue(':event_name', $event_name, \PDO::PARAM_STR);
        $pdoStm->bindValue(':event_location', $event_location, \PDO::PARAM_STR);
        $pdoStm->bindValue(':event_start', $event_start, \PDO::PARAM_STR);
        $pdoStm->bindValue(':event_start_time', $event_start_time, \PDO::PARAM_STR);
        $pdoStm->bindValue(':event_end', $event_end, \PDO::PARAM_STR);
        $pdoStm->bindValue(':event_end_time', $event_end_time, \PDO::PARAM_STR);
        $pdoStm->bindValue(':event_description', $event_description, \PDO::PARAM_STR);
        $pdoStm->bindValue(':image_id', $new_file_id, \PDO::PARAM_INT);
        $pdoStm->bindValue(':creator_id', $current_user_id, \PDO::PARAM_INT);
        $pdoStm->execute();

        return $this->db->lastInsertId();


    }


    public function editEvent($event_name, $event_location,
                                $event_start, $event_start_time,
                                $event_end, $event_end_time,
                                $event_description, $new_file_id,
                                $current_user_id, $event_id)
    {
        $sql = "UPDATE events SET event_name = :event_name, event_location = :event_location, 
                                    event_start = :event_start, event_start_time = :event_start_time,
                                    event_end = :event_end, event_end_time = :event_end_time,
                                    event_description = :event_description, 
                                    creator_id = :creator_id";
        if($new_file_id){
            $sql.=",
                image_id=:image_id ";
        }
        $sql.=" WHERE id=:id";


        $pdoStm = $this->db->prepare($sql);
        $pdoStm->bindValue(':event_name', $event_name, \PDO::PARAM_STR);
        $pdoStm->bindValue(':event_location', $event_location, \PDO::PARAM_STR);
        $pdoStm->bindValue(':event_start', $event_start, \PDO::PARAM_STR);
        $pdoStm->bindValue(':event_start_time', $event_start_time, \PDO::PARAM_STR);
        $pdoStm->bindValue(':event_end', $event_end, \PDO::PARAM_STR);
        $pdoStm->bindValue(':event_end_time', $event_end_time, \PDO::PARAM_STR);
        $pdoStm->bindValue(':event_description', $event_description, \PDO::PARAM_STR);
        $pdoStm->bindValue(':creator_id', $current_user_id, \PDO::PARAM_INT);
        if($new_file_id){
            $pdoStm->bindValue(':image_id', $new_file_id, \PDO::PARAM_INT);
        }
        $pdoStm->bindValue(':id', $event_id, \PDO::PARAM_INT);

        return $pdoStm->execute();




    }


    public function deleteEventById($id){

        $query = "DELETE FROM events WHERE id= :id" ;
        $pdostm = $this->db->prepare($query);
        $pdostm->bindValue(':id',$id, \PDO::PARAM_INT);
        $count = $pdostm->execute();
        return $count;
    }



    public function getAllEvents($page, $search_term)
    {
        $per_page = Config::get('per_page');
        $from_page = $per_page * $page;
        $number_to_select = $per_page;
        $sql = "SELECT e.*, concat(u.first_name, ' ',  u.last_name) AS 'user_name',u.id AS userid, f.path AS imgpath 
                FROM events e 
                JOIN users u ON e.creator_id = u.id
                LEFT JOIN files f ON e.image_id = f.id
                WHERE e.event_name LIKE :search_term
                ORDER BY creation_date DESC
                LIMIT :from_page,:number_to_select";
        $search_term = "%$search_term%";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(':search_term', $search_term, \PDO::PARAM_STR);
        $stm->bindParam(':from_page', $from_page, \PDO::PARAM_INT);
        $stm->bindParam(':number_to_select', $number_to_select, \PDO::PARAM_INT);
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        $stm->execute();

        return $stm->fetchAll();
    }


    public function getEventById($id)
    {

        $sql = "SELECT e.*,u.role_id, concat(u.first_name, ' ',  u.last_name) AS 'user_name',u.id AS userid, f.path AS imgpath 
                FROM events e 
                JOIN users u ON e.creator_id = u.id
                LEFT JOIN files f ON e.image_id = f.id 
                WHERE e.id = :id";
        $stm = $this->db->prepare($sql);
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        $stm->bindParam(':id', $id);
        $stm->execute();

        return $stm->fetch();
    }




}