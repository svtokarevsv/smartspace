<?php

namespace App\controllers;

use App\lib\Controller;
use App\models\Education;

class EducationController extends Controller
{
    public function __construct(array $data = array())
    {
        parent::__construct($data);
    }

    public function ajax_getProgramsBySchoolId(){
        // 3. $_GET[] is comming from js {couuntryId}
        $schoolId = $_GET['schoolId']; 

        // 4. use this $countryId to execute the sql statement
        // $this->data['cities'] is a cities from db
        $this->data['programs'] = Education::getProgramsBySchoolId($schoolId);
    }

    public function ajax_getSchoolsByCountryId(){
        $countryId = $_GET['countryId']; 

        $this->data['schools'] = Education::getSchoolsByCountry($countryId);
    }


}

