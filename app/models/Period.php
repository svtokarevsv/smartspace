<?php
/**
 * Created by PhpStorm.
 * User: baong
 * Date: 2018-04-18
 * Time: 7:08 PM
 */

namespace App\models;


use App\lib\Model;
use App\lib\App;
class Period extends Model
{
    public static function getPeriods()
    {
        $sql = "SELECT * FROM time_periods";
        $stm = App::$db->prepare($sql);
        $stm->setFetchMode(\PDO::FETCH_OBJ);
        $stm->execute();
        return $stm->fetchAll();
    }
}