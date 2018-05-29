<?php
/**
 * Created by PhpStorm.
 * User: baong
 * Date: 2018-04-12
 * Time: 11:13 AM
 */

namespace App\models;


use App\lib\App;
use App\lib\Model;
use App\lib\EmployerVM;

class Employer extends Model
{
    // get all employers - not used
    public function getAll()
    {
        $sql = "SELECT * FROM users WHERE role_id = 2;";
        $stm = App::$db->prepare($sql);
        $stm->setFetchMode(\PDO::FETCH_OBJ);
        $stm->execute();
        return $stm->fetchAll();
    }
    public static function getEmployerById($id)
    {
        $sql = "SELECT * FROM users u
        LEFT JOIN files f ON u.avatar_id = f.id
        LEFT JOIN industries i ON u.industry_id = i.id
        LEFT JOIN cities c ON u.city_id = c.id
        LEFT JOIN countries cn ON c.country_id = cn.id
        WHERE u.id = :id";
        $stm = App::$db->prepare($sql);
        $stm->setFetchMode(\PDO::FETCH_OBJ);
        $stm->bindParam(':id', $id);
        $stm->execute();
        return $stm->fetch();
    }
    public function updateEmployerProfile($id, $EmployerVM)
    {

        $q = 'UPDATE users
        SET first_name = :b_fn, 
            last_name = :b_ln, 
            email = :b_email, 
            avatar_id = :b_aid, 
            city_id = :b_cid,
            website = :b_web, 
            description = :b_desc, 
            company_name = :b_cpn, 
            industry_id = :b_iid, 
            display_email = :b_demail
        WHERE id = :b_id';
        $stm = $this->db->prepare($q);
        $stm->bindValue(':b_fn', $EmployerVM->getFirstName(), \PDO::PARAM_STR);
        $stm->bindValue(':b_ln', $EmployerVM->getLastName(), \PDO::PARAM_STR);
        $stm->bindValue(':b_email', $EmployerVM->getEmail(), \PDO::PARAM_STR);
        $stm->bindValue(':b_aid', $EmployerVM->getAvatarId(), \PDO::PARAM_INT);
        $stm->bindValue(':b_cid', $EmployerVM->getCityId(), \PDO::PARAM_INT);
        $stm->bindValue(':b_web', $EmployerVM->getWebsite(), \PDO::PARAM_STR);
        $stm->bindValue(':b_desc', $EmployerVM->getDescription(), \PDO::PARAM_STR);
        $stm->bindValue(':b_cpn', $EmployerVM->getCompany(), \PDO::PARAM_STR);
        $stm->bindValue(':b_iid', $EmployerVM->getIndustryId(), \PDO::PARAM_INT);
        $stm->bindValue(':b_demail', $EmployerVM->getDisplayEmail(), \PDO::PARAM_STR);
        $stm->bindValue(':b_id', $id, \PDO::PARAM_INT);
        return $stm->execute();
    }
    public function getStudentByTags($keyword) {
        $sql = "SELECT u.id, u.first_name, u.last_name, k.keyword FROM users u 
                JOIN keywords_in_students student ON u.id = student.user_id
                JOIN keywords k ON student.keyword_id = k.id
                WHERE k.keyword LIKE concat('%',:b_keyword,'%')";
        $stm = App::$db->prepare($sql);
        $stm->bindValue(':b_keyword', $keyword, \PDO::PARAM_STR);
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        $stm->execute();
        return $stm->fetchAll();
    }
}