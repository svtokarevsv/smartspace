<?php

namespace App\lib;


class StudentVM {

    private $roleId = 1;
    private $firstName;
    private $lastName;
    private $email;
    private $schoolId;
    private $programId;
    private $avatarId;
    private $cityId;
    private $dob;
    private $gender;
    private $occupation;
    private $website;
    private $description;
    private $errors = [];
    
    // setter
    public function __construct($avatarId, $fn, $ln, $dob, $gender, $city, $school, $program, $work, $email, $web, $dscr)
    {
        

        if(Validation::isEmpty($fn) || !Validation::isText($fn) || !Validation::isLessThan($fn, 50)){
            $this->errors['fnErrMsg'] = 'First name is required and must be less than 50 letters.';
        }
        if(Validation::isEmpty($ln) || !Validation::isText($ln) || !Validation::isLessThan($ln, 50) ){
            $this->errors['lnErrMsg'] = 'Last name is required and must be less than 50 letters.';
        }
        if(!$dob==null&&(Validation::compareDates(new \DateTime($dob), new \DateTime())!==-1||
           !Validation::isDate($dob))){
            $this->errors['dobErrMsg'] = 'Invalid date of birth. Date must be in the past.';
        }
        if(!$gender=='Female'||!$gender=='Male'||!$gender=='Other'){
            $this->errors['genderErrMsg'] = 'Gender is required. Please select a valid option.';
        }
        // TODO: AJAX
        if(!Validation::isLessThan($school, 50)){
            $this->errors['schoolErrMsg'] = 'School name must be less than 50 characters.';
        }
        if(!Validation::isLessThan($program, 50)){
            $this->errors['programErrMsg'] = 'Program name must be less than 50 characters.';
        }
        if(!Validation::isLessThan($work, 50)){
            $this->errors['workErrMsg'] = 'Occupation must be less than 50 characters.';
        }
        // TODO: CITY AND COUNTRY VALIDAITON with DB VALUES
        if(!Validation::isEmpty($email)&&(!Validation::isEmail($email) || !Validation::isLessThan($email, 100))){
            $this->errors['emailErrMsg'] = 'Invalid email address. Email address must be less than 100 characters.';
        }
        if(!Validation::isEmpty($web)&&(!Validation::isUrl($web) || !Validation::isLessThan($web, 100))){
            $this->errors['webErrMsg'] = 'Invalid URL. URL must be less than 100 characters.';
        }
        if(!Validation::isLessThan($dscr, 500)){
            $this->errors['dscrErrMsg'] = 'Profile description must be less than 500 characters.';
        }

        $this->avatarId = $avatarId;
        $this->firstName = $fn;
        $this->lastName = $ln;
        $this->gender = $gender;
        $this->dob = $dob;
        $this->schoolId = $school;
        $this->programId = $program;
        $this->cityId = $city;
        $this->occupation = $work;
        $this->email = $email;
        $this->website = $web;
        $this->description = $dscr;
        
    }
    public function isValid()
    {
        return \count($this->errors)===0;
    }
    // getter
    public function getRoleId(){
        return $this->roleId;
    }
    public function getFn(){
        return $this->firstName;
    }
    public function getLn(){
        return $this->lastName;
    }
    public function getSchoolId(){
        return $this->schoolId;
    }
    public function getProgramId(){
        return $this->programId;
    }
    public function getAvatarId(){
        return $this->avatarId;
    }
    public function getCityId(){
        return $this->cityId;
    }
    public function getDob(){
        return $this->dob;
    }
    public function getGender(){
        return $this->gender;
    }
    public function getOccupation(){
        return $this->occupation;
    }
    public function getWeb(){
        return $this->website;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getDscr(){
        return $this->description;
    }
    public function getErrors(){
        return $this->errors;
    }

}

?>