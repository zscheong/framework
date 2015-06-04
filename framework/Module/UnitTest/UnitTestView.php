<?php

namespace Application\Module;

if(!defined("_APP_ENTRY_")) {
    header("HTTP 1.0 404 Not Found");
    exit();
}
require_once('modules/Application/View.php');

use \Application\View;

class UnitTestView extends View
{
  /*
    protected $mDefaultStep = 'ShowSimple';
    
    public function stepShowSimple() {
        global $modConfig;

        $message = (isset($modConfig['message']))? $modConfig['message'] : "";
        
        $this->SetVar('message', $message);
        $this->Show('simple_template');
    }
   
   */
    public function Display($layout='') {
        global $modConfig;
        
        //$modConfig['active'] = 'Profile';
        parent::Display($layout);
    }
}

?>