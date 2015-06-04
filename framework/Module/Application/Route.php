<?php

namespace Application;

if(!defined("_APP_ENTRY_")) {
    header("HTTP 1.0 404 Not Found");
    exit();
}

use \includes\php\CURLParser;
use \includes\php\CStringUtils;

class Route 
{
    private $mURLParser;
    private $mBackendAction = array("create", "update", "delete", "load", "manage");
    
    public function __construct() 
    {
        global $sys_config;
        
        $this->mURLParser = new CURLParser();
        $this->mURLParser->parseURL($sys_config['base_request_uri'], $_SERVER['REQUEST_URI']);
    }
    
    private function enableSession() 
    {
        global $sys_config;
        
        session_start();
        $session_folder = $sys_config["doc_dir"] . "session";
        if(!file_exists($session_folder)) {
            mkdir($session_folder);
        } else {
            session_save_path($session_folder);
        }
    }
    
    private function preRoute() {
        //enable session on all request
        $this->enableSession();

        //XSRF token
        $action = $this->mURLParser->GetAction();
        if(!in_array($action, $this->mBackendAction)) { 
            
            //generate token
            $_SESSION['XSRF-TOKEN'] = CStringUitls::getRandomString(32);
            setcookie('XSRF-TOKEN', $_SESSION['XSRF_TOKEN']);
        } else {
            $xsrf_token = $_SERVER['X-XSRF-TOKEN'];
            if($xsrf_token != $_SESSION['XSRF_TOKEN']) {
                header("HTTP 1.0 404 Invalid Request");
                exit();
            }
        }
    }
    
    public function route() 
    {
        $this->preRoute();
        
        $module = $this->mURLParser->GetModule();
        $action = $this->mURLParser->GetAction();
        $class = "";
        $file = "";
        
        if(in_array($action, $this->mBackendAction)) {
            $file = "./modules/$module/{$module}Controller.php";
            $class = "\\Application\\Module\\{$module}Controller";
        } else {
            $file = "./modules/$module/{$module}View.php";
            $class = "\\Application\\Module\\{$module}View";
        }
        
        require_once($file);
        $instance = new $class();
        if(method_exists($instance, $action)) {
            $params = $this->mURLParser->GetHashValue();
            $instance->loadParams($params);
            $instance->$action();
        } else {
            header("HTTP 1.0 404 Not Found");
             exit();
        }
    }
}

?>
