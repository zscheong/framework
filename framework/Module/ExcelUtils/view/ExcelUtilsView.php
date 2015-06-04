<?php

namespace Application\Module;

if(!defined("_APP_ENTRY_")) {
    header("HTTP 1.0 404 Not Found");
    exit();
}
require_once('modules/Application/View.php');

use \Application\View;

class ExcelUtilsView extends View
{
    public function Compare() {
        global $modConfig;
        
        parent::Display('compare.inc');
    }
    
    public function Display($layout='') {
        global $modConfig;
        
        //$modConfig['active'] = 'Profile';
        parent::Display($layout);
    }
}

?>