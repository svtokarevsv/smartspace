<?php


namespace App\models;


use App\lib\App;
use App\lib\Config;
use App\lib\Model;

class Group extends Model
{
    //read
    public function getAll()
    {
        $sql = "SELECT * FROM groups";
        $stm = $this->db->prepare($sql);
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        $stm->execute();
        return $stm->fetchAll();
    }

    // find by group by name
    public function getGroupByName(string $group_name)
    {
        $sql = "SELECT * FROM groups WHERE name = :group_name";
        $stm = $this->db->prepare($sql);
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        $stm->bindParam(':group_name', $group_name, \PDO::PARAM_STR);
        $stm->execute();
        return $stm->fetch();
    }

    public function searchGroups($search_term, $page)
    {
        $per_page = Config::get('per_page');
        $from_page = $per_page * $page;
        $number_to_select = $per_page;
        $sql = 'SELECT g.id,g.name,g.description, f.path AS "avatar_path"
                FROM groups g 
                LEFT JOIN files f 
                ON g.avatar_id=f.id
                WHERE name LIKE :search_term OR description LIKE :search_term
                LIMIT :from_page,:number_to_select';
        $search_term = "%$search_term%";
        $stm = $this->db->prepare($sql);
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        $stm->bindParam(':search_term', $search_term, \PDO::PARAM_STR);
        $stm->bindParam(':from_page', $from_page, \PDO::PARAM_INT);
        $stm->bindParam(':number_to_select', $number_to_select, \PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll();
    }

    public function searchGroupsByNameAndDescription(string $search_term, $page, int $user_id)
    {
        $per_page = Config::get('per_page');
        $from_page = $per_page * $page;
        $number_to_select = $per_page;
        $sql = 'SELECT g.*,
                f.path AS "avatar_path",
                sum((CASE WHEN (uig.user_id = :user_id) 
                 THEN
                      1 
                 ELSE
                      0 
                 END))
                 AS isMember
                FROM groups g 
                LEFT JOIN files f 
                ON g.avatar_id=f.id
                LEFT JOIN users_in_group uig
                ON uig.group_id=g.id
                WHERE name LIKE :search_term OR description LIKE :search_term
                GROUP BY g.id,g.name,g.creator_id,g.creation_date,g.description,g.avatar_id,
                f.path
                LIMIT :from_page,:number_to_select';

        $stm = $this->db->prepare($sql);
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        $stm->bindParam(':user_id', $user_id, \PDO::PARAM_INT);
        $search_term = "%$search_term%";
        $stm->bindParam(':search_term', $search_term, \PDO::PARAM_STR);
        $stm->bindParam(':from_page', $from_page, \PDO::PARAM_INT);
        $stm->bindParam(':number_to_select', $number_to_select, \PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll();
    }

    public function create($name, $description, $creator_id, $avatar_id)
    {
        $sql = "INSERT INTO groups (name,description,creator_id,avatar_id)
            VALUES (:name,:description,:creator_id,:avatar_id)";
        $pdoStm = $this->db->prepare($sql);
        $pdoStm->bindValue(':name', $name, \PDO::PARAM_STR);
        $pdoStm->bindValue(':description', $description, \PDO::PARAM_STR);
        $pdoStm->bindValue(':creator_id', $creator_id, \PDO::PARAM_INT);
        $pdoStm->bindValue(':avatar_id', $avatar_id, \PDO::PARAM_INT);
        $pdoStm->execute();
        return $this->db->lastInsertId();
    }

    public function addMemberToGroupById(int $user_id, int $group_id)
    {
        $sql = "INSERT INTO users_in_group (user_id,group_id)
            VALUES (:user_id,:group_id)";
        $pdoStm = $this->db->prepare($sql);
        $pdoStm->bindValue(':user_id', $user_id, \PDO::PARAM_INT);
        $pdoStm->bindValue(':group_id', $group_id, \PDO::PARAM_INT);
        $pdoStm->execute();
        return $this->db->lastInsertId();
    }

    public function removeMemberFromGroupById(int $user_id, int $group_id)
    {
        $sql = "DELETE FROM users_in_group
            WHERE user_id=:user_id AND group_id=:group_id";
        $pdoStm = $this->db->prepare($sql);
        $pdoStm->bindValue(':user_id', $user_id, \PDO::PARAM_INT);
        $pdoStm->bindValue(':group_id', $group_id, \PDO::PARAM_INT);
        return $pdoStm->execute();
    }


    public function getGroupById(int $id)
    {
        $sql = "SELECT g.*,f.path AS path 
                FROM groups g
                LEFT JOIN files f
                ON g.avatar_id=f.id
                WHERE g.id = :id";
        $stm = $this->db->prepare($sql);
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        $stm->bindParam(':id', $id);
        $stm->execute();
        return $stm->fetch();
    }

    public function getIsMemberOfGroup(int $user_id, int $group_id)
    {
        $sql = 'SELECT id FROM users_in_group 
                WHERE user_id=:user_id
                AND group_id=:group_id';
        $stm = $this->db->prepare($sql);
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        $stm->bindParam(':user_id', $user_id);
        $stm->bindParam(':group_id', $group_id);
        $stm->execute();
        return $stm->fetch();
    }

    public function getGroupMembersById(int $group_id)
    {
        $sql = "SELECT concat(u.first_name, ' ',  u.last_name) AS 'user_name', img.path AS 'avatar_path',u.id
                FROM users u
                JOIN users_in_group uig
                ON u.id = uig.user_id
                JOIN groups
                ON uig.group_id = groups.id
                LEFT JOIN files img
                ON u.avatar_id = img.id
                WHERE group_id=:group_id";
        $stm = $this->db->prepare($sql);
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        $stm->bindParam(':group_id', $group_id);
        $stm->execute();
        return $stm->fetchAll();
    }

    public function updateGroupById($group_id, $group_name, $group_description, $file_id = null)
    {
        $sql = "UPDATE groups SET name = :name,
                description=:description ";
        if ($file_id) {
            $sql .= ",
                avatar_id=:avatar_id ";
        }
        $sql .= "WHERE id=:id";

        $stm = $this->db->prepare($sql);
        $stm->bindValue(':name', $group_name, \PDO::PARAM_STR);
        $stm->bindValue(':description', $group_description, \PDO::PARAM_STR);
        if ($file_id) {
            $stm->bindValue(':avatar_id', $file_id, \PDO::PARAM_INT);
        }
        $stm->bindValue(':id', $group_id, \PDO::PARAM_INT);
        return $stm->execute();
    }

    public function getGroupsByUserId(int $user_id)
    {
        $sql = "SELECT g.*,f.path AS 'avatar_path' FROM groups g 
                JOIN users_in_group uig
                ON g.id=uig.group_id
                JOIN files f 
                ON g.avatar_id=f.id
                WHERE uig.user_id = :user_id";
        $stm = $this->db->prepare($sql);
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        $stm->bindParam(':user_id', $user_id);
        $stm->execute();
        return $stm->fetchAll();
    }
}