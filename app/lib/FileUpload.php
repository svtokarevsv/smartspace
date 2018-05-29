<?php


namespace App\lib;

use App\models\File;
class FileUpload
{
    public $filename;
    public $errors = [];
    private $file_id;
    private $public_path;

    public function __construct(string $field_name,
                                string $path_to_save = '',
                                int $max_file_size = 3000000,
                                array $allowed_file_extensions = ['png', 'jpeg', 'jpg', 'gif', 'pdf', 'docx'])
    {
        $file_temp = $_FILES[$field_name]['tmp_name'];
        $file_name = $_FILES[$field_name]['name'];
        $file_size = (int)$_FILES[$field_name]['size'];
//        $file_type = $_FILES[$field_name]['type'];
        $file_error = $_FILES[$field_name]['error'];
        $this->checkExtensions($file_name, $allowed_file_extensions);
        $this->checkSize($file_size, $max_file_size);
        $this->checkProcessErrors($file_error);

        //create unique filename for name collisions prevention
        $file_name=time().'_'.$file_name;
        $dir_path='uploads'.'/'.$path_to_save.($path_to_save?'/':'');
        $target_path=UPLOADS_PATH.DS.$path_to_save.($path_to_save?DS:'').$file_name;
        $this->public_path=$dir_path.$file_name;
        //check if there were errors
        if (\count($this->errors) === 0) {
            // check if destination folder exists
            if (!file_exists($dir_path)) {
                mkdir($dir_path, 0700, true);
            }
            //if couldn't save the image write an error message
            if (!move_uploaded_file($file_temp, $target_path)) {
                $this->errors[]='there was an error uploading a file on the server, try later';
            }else{
                // $file_id=(new File())->create($this->getPublicFilePath());
                // if($file_id>0){
                //     $this->file_id=(new File())->create($this->getPublicFilePath());
                // }else{
                //     $this->errors[]='couldn\'t upload the file, sorry';
                // }
                $this->file_id = -1;
                $this->file_id=(new File())->create($this->getPublicFilePath());
                if($this->file_id == -1){
                    $this->errors[]='couldn\'t upload the file, sorry';

                }
            }
        }
    }

    public function isError()
    {
        return \count($this->errors)>0;
    }

    public function getPublicFilePath()
    {
        return $this->public_path;
    }

    public function getFileId()
    {
        return $this->file_id;
    }
    public function getErrors()
    {
        return $this->errors;
    }
    private function checkExtensions(string $file_name, array $allowed_file_extensions)
    {
        $ext = \pathinfo($file_name, PATHINFO_EXTENSION);
        if (!in_array($ext, $allowed_file_extensions)) {
            //$errors[] = 'this file type is not allowed';
            $this->errors[] = 'this file type is not allowed';
        }
    }

    private function checkSize(int $file_size, int $max_file_size)
    {
        if ($file_size > $max_file_size) {
            // $errors[] = 'this file is too big';
            $this->errors[] = 'this file is too big';
            
        }
    }

    private function checkProcessErrors(int $file_error)
    {
        if ($file_error <= 0) return;
        $error = '';
        switch ($file_error) {
            case 1:
                $error = "File exceeded upload_max_filesize.";
                break;
            case 2:
                $error = "File exceeded max_file_size";
                break;
            case 3:
                $error = "File only partially uploaded.";
                break;
            case 4:
                $error = "No file uploaded.";
                break;
        }
        $this->errors[] = $error;
    }
}