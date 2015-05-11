<?php

namespace Application;

if(!defined("_APP_ENTRY_")) {
    header("HTTP 1.0 404 Not Found");
    exit();
}

/************Common***************/
global $modConfig;
$modConfig["include_js"]    = array();
$modConfig["include_css"]   = array();

/************Specific***************/
switch($modConfig["view"]) {
    case "DuplicateRow":
        $modConfig["include_js"][]  = "resource/js/bootstrap-multiselect/bootstrap-multiselect.js";
        $modConfig["include_css"][] = "resource/js/bootstrap-multiselect/bootstrap-multiselect.css"; 
        break;
}

?>