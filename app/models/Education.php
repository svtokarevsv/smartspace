<?php
namespace App\models;
use App\lib\App;
use App\lib\Model;

class Education extends Model
{
    // Get ALL Schools
    public static function getSchools(){
        $q = 'SELECT * FROM schools ORDER BY school_name;';
        $pdostm = App::$db->prepare($q);
        $pdostm->execute();
        return $pdostm->fetchAll(\PDO::FETCH_OBJ) ;
    }

    // Get ALL Programs
    public static function getPrograms(){
        $q = 'SELECT * FROM programs;';
        $pdostm = App::$db->prepare($q);
        $pdostm->execute();
        return $pdostm->fetchAll(\PDO::FETCH_OBJ) ;
    }

    // Get school by school_id
    public static function getSchool($schoolId){
        $q = 'SELECT * FROM schools WHERE id = :id;';
        $stm = App::$db->prepare($q);
        $stm->setFetchMode(\PDO::FETCH_OBJ);
        $stm->bindParam(':id', $schoolId);
        $stm->execute();
        return $stm->fetch();
    }

    // Get program by program_id
    public static function getProgram($programId){
        $q = 'SELECT * FROM programs WHERE id = :id;';
        $stm = App::$db->prepare($q);
        $stm->setFetchMode(\PDO::FETCH_OBJ);
        $stm->bindParam(':id', $programId);
        $stm->execute();
        return $stm->fetch();
    }

    public static function getProgramsBySchoolId($schoolId){
        $q =    'SELECT programs.* FROM programs 
                 WHERE programs.school_id = :schoolId
                 ORDER BY programs.program_name;';
        $stm = App::$db->prepare($q);
        $stm->setFetchMode(\PDO::FETCH_OBJ);
        $stm->bindParam(':schoolId', $schoolId);
        $stm->execute();
        return $stm->fetchAll();
    }


    // Get schools by country_id
    public static function getSchoolsByCountry($countryId){
        $q = 'SELECT * FROM schools WHERE country_id = :cid;';
        $stm = App::$db->prepare($q);
        $stm->setFetchMode(\PDO::FETCH_OBJ);
        $stm->bindParam(':cid', $countryId);
        $stm->execute();
        return $stm->fetchAll();
    }

}