<?php
namespace App\models;
use App\lib\App;
use App\lib\Model;
use App\lib\StudentVM;

class Student extends Model {

    // get all students including employer and student
    public static function getStudents()
    {
        $sql = "SELECT * FROM users WHERE role_id=1;"; // role_id = 1 means student
        $stm = App::$db->prepare($sql);
        $stm->setFetchMode(\PDO::FETCH_OBJ);
        $stm->execute();
        return $stm->fetchAll();
    }

    // get a single student by id 
    public static function getStudentById($id)
    {
        $sql = "SELECT users.*,
        files.id as file_id,
        files.path,
        cities.id as citie_id,
        countries.id as countrie_id,
        schools.id as school_id,
        programs.id as program_id,
        cities.country_id
        FROM users 
        LEFT JOIN files ON users.avatar_id = files.id
        LEFT JOIN cities ON users.city_id = cities.id
        LEFT JOIN countries ON cities.country_id = countries.id
        LEFT JOIN schools ON users.school_id = schools.id
        LEFT JOIN programs ON users.program_id = programs.id
        WHERE users.id =:id";
        $stm = App::$db->prepare($sql);
        $stm->setFetchMode(\PDO::FETCH_OBJ);
        $stm->bindParam(':id', $id);
        $stm->execute();
        return $stm->fetch();
    }

    // update student profile
    public function updateStudentProfile($id, $studentVM)
    {
        
        $q = 'UPDATE users 
        SET avatar_id=:b_aid, first_name=:b_fn, last_name=:b_ln, dob=:b_dob, gender=:b_gender, city_id=:b_city, 
        school_id=:b_school, program_id=:b_program, occupation=:b_occupation, display_email=:b_email, website=:b_website, description=:b_dscr
        WHERE id=:b_id';

        $pdostm = $this->db->prepare($q);

		$pdostm->bindValue(':b_id', $id, \PDO::PARAM_INT);
        $pdostm->bindValue(':b_aid', $studentVM->getAvatarId(), \PDO::PARAM_INT);
        $pdostm->bindValue(':b_school', $studentVM->getSchoolId(), \PDO::PARAM_INT);
		$pdostm->bindValue(':b_program', $studentVM->getProgramId(), \PDO::PARAM_INT);
		$pdostm->bindValue(':b_city', $studentVM->getCityId(), \PDO::PARAM_INT);
		$pdostm->bindValue(':b_fn', $studentVM->getFn(), \PDO::PARAM_STR);
        $pdostm->bindValue(':b_ln', $studentVM->getLn(), \PDO::PARAM_STR);
		$pdostm->bindValue(':b_dob', $studentVM->getDob(), \PDO::PARAM_STR);
		$pdostm->bindValue(':b_gender', $studentVM->getGender(), \PDO::PARAM_STR);
		$pdostm->bindValue(':b_occupation', $studentVM->getOccupation(), \PDO::PARAM_STR);
		$pdostm->bindValue(':b_website', $studentVM->getWeb(), \PDO::PARAM_STR);
        $pdostm->bindValue(':b_dscr', $studentVM->getDscr(), \PDO::PARAM_STR);
        $pdostm->bindValue(':b_email', $studentVM->getEmail(), \PDO::PARAM_STR);

        return $pdostm->execute();
    }

    public function addResume($sid, $resumeId){

        $q = 'UPDATE users 
        SET resume_id=:b_resumeId
        WHERE id=:b_id';

        $pdostm = $this->db->prepare($q);

        $pdostm->bindValue(':b_resumeId', $resumeId, \PDO::PARAM_INT);
        $pdostm->bindValue(':b_id', $sid, \PDO::PARAM_INT);

        return $pdostm->execute();

    }

    // get resume by student id 
    public static function getResumeById($sid)
    {
        $sql = "SELECT * FROM users 
        LEFT JOIN files ON resume_id = files.id
        WHERE users.id =:sid";
        $stm = App::$db->prepare($sql);
        $stm->setFetchMode(\PDO::FETCH_OBJ);
        $stm->bindParam(':sid', $sid);
        $stm->execute();
        return $stm->fetch();
    }

    public function deleteResume($resumeId){

        $q = 'DELETE FROM files WHERE id=:b_resumeId';
        $pdostm = $this->db->prepare($q);
        $pdostm->bindValue(':b_resumeId', $resumeId, \PDO::PARAM_INT);
        return $pdostm->execute();

    }
    

}

