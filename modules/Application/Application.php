<?php
namespace Application;

if(!defined("_APP_ENTRY_")) {
    header("HTTP 1.0 404 Not Found");
    exit();
}

/* require area*/
require_once("config/appConfig.php");
require_once("resource/php/include.php");
/***************/

class Application {
    public static function Run() {
        global $mResponse;
        global $modConfig;
        
        $modConfig["module"] = $module = $mResponse->GetResponse("module");
        $action = $mResponse->GetResponse("action");
        $view   = $mResponse->GetResponse("view");
        
        if(!empty($action)) {
            $action_path = "modules/$module/controller/$action.php";  

            if(file_exists($action_path)) {
                $modConfig["action"] = $action;
                
                require_once($action_path);
            } else {

                header("HTTP 1.0 404 Not Found");
                exit();
            }
        }
        if(!empty($view)) {
            $view_path = "modules/$module/view/$view.php";
            if(file_exists($view_path)) {
                $modConfig["view"] = $view;
                require_once($view_path);
            } else {
                header("HTTP 1.0 404 Not Found");
                exit();
            }
        }
        exit();
    }
}

?>