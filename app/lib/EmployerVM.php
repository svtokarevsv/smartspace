<?php
/**
 * Created by NgocTo.
 * Date: 2018-04-12
 * Time: 12:28 PM
 */

namespace App\lib;


class EmployerVM
{
    private $roleId = 2;
    private $firstName;
    private $lastName;
    private $email;
    private $avatarId;
    private $cityId;
    private $website;
    private $description;
    private $company;
    private $industryId;
    private $displayEmail;
    private $errors = [];

    public function __construct($firstName, $lastName, $email, $avatarId, $cityId, $website, $description, $company, $industryId, $displayEmail)
    {
        if(Validation::isEmpty($firstName) ){
            $this->errors['fnErrMsg'] = 'First name is required';
        }
        if(!Validation::isText($firstName) ){
            $this->errors['fnErrMsg'] = 'First name must be text only.';
        }
        if(!Validation::isLessThan($firstName, 50) ) {
            $this->errors['fnErrMsg'] = 'First name must be less than 50 letters.';
        }
        if(Validation::isEmpty($lastName) ){
            $this->errors['lnErrMsg'] = 'Last name is required';
        }
        if(!Validation::isText($lastName) ){
            $this->errors['lnErrMsg'] = 'Last name must be text only.';
        }
        if(!Validation::isLessThan($lastName, 50) ){
            $this->errors['lnErrMsg'] = 'Last name must be less than 50 letters.';
        }
        if(!Validation::isEmpty($email)&&(!Validation::isEmail($email))){
            $this->errors['emailErrMsg'] = 'Invalid email address';
        }
        if(!Validation::isLessThan($email, 100)){
            $this->errors['emailErrMsg'] = 'Email address must be less than 100 characters.';
        }
        if(!Validation::isUrl($website)){
            $this->errors['websiteErrMsg'] = 'Invalid URL.';
        }
        if(!Validation::isLessThan($website, 100)){
            $this->errors['websiteErrMsg'] = 'URL must be less than 100 characters.';
        }
        if(!Validation::isLessThan($description, 500)){
            $this->errors['descriptionErrMsg'] = 'Company description must be less than 500 characters.';
        }
        if(!Validation::isLessThan($company,100)){
            $this->errors['companyErrMsg'] = 'Company name must be less than 100 characters.';
        }
        if(!Validation::isEmpty($displayEmail)&&(!Validation::isEmail($displayEmail))){
            $this->errors['displayEmailErrMsg'] = 'Invalid company email address';
        }
        if(!Validation::isLessThan($displayEmail, 100)){
            $this->errors['displayEmailErrMsg'] = 'Company email address must be less than 100 characters.';
        }

        $this->avatarId = $avatarId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->cityId = $cityId;
        $this->website = $website;
        $this->description = $description;
        $this->company = $company;
        $this->industryId = $industryId;
        $this->displayEmail = $displayEmail;
    }
    public function isValid()
    {
        return \count($this->errors) === 0;
    }
    public function getRoleId(){
        return $this->roleId;
    }
    public function getFirstName(){
        return $this->firstName;
    }
    public function getLastName(){
        return $this->lastName;
    }
    public function getAvatarId(){
        return $this->avatarId;
    }
    public function getCityId(){
        return $this->cityId;
    }
    public function getWebsite(){
        return $this->website;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getDescription(){
        return $this->description;
    }
    public function getCompany(){
        return $this->company;
    }
    public function getIndustryId(){
        return $this->industryId;
    }
    public function getDisplayEmail(){
        return $this->displayEmail;
    }
    public function getErrors(){
        return $this->errors;
    }
}