<?php

namespace Application;

if(!defined("_APP_ENTRY_")) {
    header("HTTP 1.0 404 Not Found");
    exit();
}

class Application_Controller {
    private $mFile = "";
    
    public function UploadFile($file, $tmp = false) {
        $ret ="";
        $target_dir = "uploads/";
        if($tmp) { $target_dir .= "tmp/"; }
        if(!file_exists($target_dir)) {
            mkdir($target_dir);
        } 
        $this->mFile = $target_file = $target_dir . basename($_FILES[$file]["name"]);
        if(move_uploaded_file($_FILES[$file]["tmp_name"], $target_file)) {
            $ret = $this->mFile;
        }    
        return $ret;
    }
    public function RemoveUploadFile() {
        if(file_exists($this->mFile)) {
            unlink($this->mFile);
        }
    }
}

?>