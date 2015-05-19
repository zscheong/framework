<?php

namespace Application\Module;

if(!defined("_APP_ENTRY_")) {
    header("HTTP 1.0 404 Not Found");
    exit();
}
require_once('modules/Application/Controller.php');

use \Application\Controller;

class SimpleTemplateController extends Controller
{
    
    public function Processing() {
        global $modConfig;
        
        $modConfig['message'] = 'Have Been Controller Processing';
    } 
    
}

?>