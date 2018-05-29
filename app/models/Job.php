<?php

namespace App\models;

use App\lib\model;
use App\lib\Config;
use App\lib\App;

class Job extends Model
{
    public function getAll() {
        $sql = "SELECT j.id, title, description, type, date_posted, date_closed, salary, creator_id, industry, country, city 
                FROM job_postings j 
                JOIN industries i ON j.industry_id = i.id
                JOIN cities c ON j.city_id = c.id
                JOIN countries cn ON c.country_id = cn.id";
        $stm = $this->db->prepare($sql);
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_OBJ);
    }
    public function getJobByCreatorId($creatorId, $page) {
        $per_page = Config::get('per_page');
        $from_page = $per_page * $page;
        $number_to_select = $per_page;
        $sql = "SELECT j.id, title, description, type, date_posted, date_closed, salary, creator_id, industry, country, city 
                FROM job_postings j 
                JOIN industries i ON j.industry_id = i.id
                JOIN cities c ON j.city_id = c.id
                JOIN countries cn ON c.country_id = cn.id
                WHERE j.creator_id = :creatorId
                ORDER BY date_posted DESC
                LIMIT :from_page,:number_to_select";
        $stm = $this->db->prepare($sql);
        $stm->bindValue(':creatorId', $creatorId, \PDO::PARAM_INT);
        $stm->bindParam(':from_page', $from_page, \PDO::PARAM_INT);
        $stm->bindParam(':number_to_select', $number_to_select, \PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getJobById($id) {
        $sql = "SELECT j.*, i.industry, c.city, cn.country , cn.id as country_id
                FROM job_postings j 
                JOIN industries i ON j.industry_id = i.id
                JOIN cities c ON j.city_id = c.id
                JOIN countries cn ON c.country_id = cn.id 
                WHERE j.id = :id";
        $stm = $this->db->prepare($sql);
        $stm->bindValue(':id', $id, \PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(\PDO::FETCH_OBJ);
    }
    public function createJob($title, $description, $type, $dateClosed, $salary, $creatorId, $industryId, $cityId) {
        $sql = "INSERT INTO job_postings (title, description, type, date_closed, salary, creator_id, industry_id, city_id) 
                VALUES (:title, :description, :type, :dateClosed, :salary, :creatorId, :industryId, :cityId)";
        $stm = $this->db->prepare($sql);
        $stm->bindValue(':title', $title , \PDO::PARAM_STR);
        $stm->bindValue(':description', $description , \PDO::PARAM_STR);
        $stm->bindValue(':type', $type , \PDO::PARAM_STR);
        $stm->bindValue(':dateClosed', $dateClosed , \PDO::PARAM_STR);
        $stm->bindValue(':salary', $salary , \PDO::PARAM_STR);
        $stm->bindValue(':creatorId', $creatorId , \PDO::PARAM_INT);
        $stm->bindValue(':industryId', $industryId , \PDO::PARAM_INT);
        $stm->bindValue(':cityId', $cityId , \PDO::PARAM_INT);
        return $stm->execute();
    }
    public function editJob($id, $title, $description, $type, $dateClosed, $salary, $industryId, $cityId) {

        $sql = "UPDATE job_postings SET title = :title, description = :description, type = :type, 
                date_closed = :dateClosed, salary = :salary, industry_id = :industryId, city_id = :cityId 
                WHERE id = :id";
        $stm = $this->db->prepare($sql);
        $stm->bindValue(':id', $id, \PDO::PARAM_INT);
        $stm->bindValue(':title', $title , \PDO::PARAM_STR);
        $stm->bindValue(':description', $description , \PDO::PARAM_STR);
        $stm->bindValue(':type', $type , \PDO::PARAM_STR);
        $stm->bindValue(':dateClosed', $dateClosed , \PDO::PARAM_STR);
        $stm->bindValue(':salary', $salary , \PDO::PARAM_STR);
        $stm->bindValue(':industryId', $industryId , \PDO::PARAM_INT);
        $stm->bindValue(':cityId', $cityId , \PDO::PARAM_INT);
        return $stm->execute();
    }
    public function deleteJob($id) {
        $sql = "DELETE FROM job_postings WHERE id = :id";
        $stm = $this->db->prepare($sql);
        $stm->bindValue(':id', $id, \PDO::PARAM_INT);
        return $stm->execute();
    }
}