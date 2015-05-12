<?php

namespace Application;

if(!defined("_APP_ENTRY_")) {
    header("HTTP 1.0 404 Not Found");
    exit();
}

class Controller {
    
    public function __construct() {
    
    }
    protected function PreProcess() {
        global $modConfig;
        
        $ret = true;
        //if(isset($modConfig['CRSF_error']) && $modConfig['CRSF_error']) { $ret = false; }
        return true;
    }
    protected function PostProcess() {}
    protected function Processing() {}
    
    
    public function Process() {
        //Checking Before Process
        if(!$this->PreProcess()) {
            return;
        }
        
        $this->Processing();
        
        //Fine Tuning After Process
        $this->PostProcess();
    }
}

?>