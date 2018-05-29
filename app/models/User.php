<?php

namespace App\models;

use App\lib\App;
use App\lib\Config;
use App\lib\Model;

class User extends Model
{

    // get all users including employer and student
    public static function getAll()
    {
        $sql = "SELECT * FROM users";
        $stm = App::$db->prepare($sql);
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        $stm->execute();
        return $stm->fetchAll();
    }

    // get a single user by id 
    public static function getUserById($id)
    {
        $sql = "SELECT u.*,concat(u.first_name, ' ', u.last_name) AS 'user_name',f.path 
                FROM users u
                LEFT JOIN files f ON u.avatar_id = f.id 
                WHERE u.id = :id";
        $stm = App::$db->prepare($sql);
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        $stm->bindParam(':id', $id);
        $stm->execute();
        return $stm->fetch();
    }

    public static function getShortUserInfoById($id)
    {
        $sql = "SELECT concat(u.first_name, ' ',  u.last_name) AS 'user_name',
                f.path  as avatar_img, u.display_email,u.id
                FROM users u
                LEFT JOIN files f ON u.avatar_id = f.id 
                 WHERE u.id = :id";
        $stm = App::$db->prepare($sql);
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        $stm->bindParam(':id', $id);
        $stm->execute();
        return $stm->fetch();
    }

    //get user by email and password for login form
    public function getUserByEmail($email)
    {

        $sql = "SELECT u.*,f.path  FROM users u
                LEFT JOIN files f ON u.avatar_id = f.id 
                WHERE email = :email";
        $stm = App::$db->prepare($sql);
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        $stm->bindParam(':email', $email, \PDO::PARAM_STR);
        $stm->execute();

        return $stm->fetch();
    }


    //creates a new user at the database
    public function createNewUser($fname, $lname, $occupation, $gender, $email, $password)
    {

        $sql = "INSERT INTO users (first_name, last_name, email, password, role_id, gender)
                VALUES (:f_name, :l_name, :email, :password, :occupation, :gender)";
        $stm = App::$db->prepare($sql);
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        $stm->bindParam(':f_name', $fname, \PDO::PARAM_STR);
        $stm->bindParam(':l_name', $lname, \PDO::PARAM_STR);
        $stm->bindParam(':email', $email, \PDO::PARAM_STR);
        $stm->bindParam(':password', $password, \PDO::PARAM_STR);
        $stm->bindParam(':occupation', $occupation, \PDO::PARAM_INT);
        $stm->bindParam(':gender', $gender, \PDO::PARAM_STR);
        $stm->execute();

        return $this->db->lastInsertId();
    }

    public function searchUsers($search_term,$page, $exclude_id)
    {
        $per_page=Config::get('per_page');
        $from_page=$per_page*$page;
        $number_to_select=$per_page;
        $sql = "SELECT u.id,concat(u.first_name, ' ',  u.last_name) AS 'user_name',
                avatars.path AS 'avatar_path',ctry.country,s.school_name,p.program_name
                FROM users u 
                LEFT JOIN files avatars 
                ON u.avatar_id=avatars.id
                LEFT JOIN cities cit
                ON u.city_id = cit.id
                LEFT JOIN countries ctry
                ON cit.country_id = ctry.id
                LEFT JOIN schools s 
                ON u.school_id = s.id
                LEFT JOIN programs p
                ON u.program_id = p.id
                WHERE u.id!=:exclude_id
                AND (concat(u.first_name, ' ',  u.last_name) LIKE :search_term 
                OR s.school_name LIKE :search_term 
                OR ctry.country LIKE :search_term 
                OR cit.city LIKE :search_term 
                OR p.program_name LIKE :search_term 
                OR u.display_email LIKE :search_term
                )                
                LIMIT :from_page,:number_to_select";
        $stm = $this->db->prepare($sql);
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        $stm->bindParam(':exclude_id', $exclude_id, \PDO::PARAM_INT);
        $stm->bindParam(':from_page', $from_page, \PDO::PARAM_INT);
        $stm->bindParam(':number_to_select', $number_to_select, \PDO::PARAM_INT);
        $search_term="%$search_term%";
        $stm->bindParam(':search_term', $search_term, \PDO::PARAM_STR);
        $stm->execute();
        return $stm->fetchAll();
    }
    public function searchUsersByNameOrEmail($search_term, $exclude_id)
    {
        $number_to_select=Config::get('per_page');

        $sql = "SELECT u.id,concat(u.first_name, ' ',  u.last_name) AS 'label',
                avatars.path AS 'avatar_path'
                FROM users u 
                LEFT JOIN files avatars 
                ON u.avatar_id=avatars.id
                WHERE u.id!=:exclude_id
                AND (concat(u.first_name, ' ',  u.last_name) LIKE :search_term 
                OR u.display_email LIKE :search_term)
                LIMIT :number_to_select";
        $stm = $this->db->prepare($sql);
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        $stm->bindParam(':exclude_id', $exclude_id, \PDO::PARAM_INT);
        $search_term="%$search_term%";
        $stm->bindParam(':search_term', $search_term, \PDO::PARAM_STR);
        $stm->bindParam(':number_to_select', $number_to_select, \PDO::PARAM_INT);

        $stm->execute();
        return $stm->fetchAll();
    }
}

