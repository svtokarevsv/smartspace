<?php
namespace App\models;
use App\lib\App;
use App\lib\Model;

class Geo extends Model
{
    // Get ALL Schools
    public static function getCities(){
        $q = 'SELECT * FROM cities 
        ORDER BY city;';
        $pdostm = App::$db->prepare($q);
        $pdostm->execute();
        return $pdostm->fetchAll(\PDO::FETCH_OBJ) ;
    }

    // Get ALL Programs
    public static function getCountries(){
        $q = 'SELECT * FROM countries 
        ORDER BY country;';
        $pdostm = App::$db->prepare($q);
        $pdostm->execute();
        return $pdostm->fetchAll(\PDO::FETCH_OBJ) ;
    }

    // Get city and country by id
    public static function getGeoData($cityId){
        $q = 'SELECT * FROM countries 
        JOIN cities ON countries.id = cities.country_id 
        WHERE cities.id = :cityId';
        $stm = App::$db->prepare($q);
        $stm->setFetchMode(\PDO::FETCH_OBJ);
        $stm->bindParam(':cityId', $cityId);
        $stm->execute();
        return $stm->fetch();
    }

    public static function getCitiesByCountryId($countryId){
        $q =   'SELECT cities.* FROM cities 
                JOIN countries 
                ON countries.id = cities.country_id';
        if ($countryId) {
            $q .= ' WHERE countries.id = :countryId';
        }
        $q .=' ORDER BY city';
        $stm = App::$db->prepare($q);
        $stm->setFetchMode(\PDO::FETCH_OBJ);
        if ($countryId) {
            $stm->bindParam(':countryId', $countryId);
        }
        $stm->execute();
        return $stm->fetchAll();
    }

    public static function getCountryByCityId($cityId){
        $q =   'SELECT cities.* FROM cities 
                JOIN countries 
                ON countries.id = cities.country_id';
        if ($countryId) {
            $q .= ' WHERE countries.id = :countryId';
        }
        $q .= 'ORDER BY country';
        $stm = App::$db->prepare($q);
        $stm->setFetchMode(\PDO::FETCH_OBJ);
        if ($countryId) {
            $stm->bindParam(':countryId', $countryId);
        }
        $stm->execute();
        return $stm->fetchAll();
    }

}