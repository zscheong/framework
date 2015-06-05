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
            $_SESSION['XSRF-TOKEN'] = CStringUtils::getRandomString(32);
            setcookie('XSRF-TOKEN', $_SESSION['XSRF-TOKEN']);
        } else {
            $xsrf_token = $_SERVER['X-XSRF-TOKEN'];
            if($xsrf_token != $_SESSION['XSRF-TOKEN']) {
                header("HTTP 1.0 404 Invalid Request");
                exit();
            }
        }
    }
    
    private function gatherParams($params) {
        $input = file_get_contents('php://input');
        if(!empty($input) && CStringUtils::isJSON($input)) {
            $input = json_decode($input);
            $params = array_merge($params, $input);
        }
        if(!empty($_POST)) {
            $params = array_merge($params, $_POST);
        }
        if(!empty($_GET)) {
            $params = array_merge($params, $_GET);
        }
        
        return $params;
    }
    
    public function route() 
    {
        global $sys_config;
        
        $this->preRoute();
        
        $module = $this->mURLParser->GetModule();
        $action = $this->mURLParser->GetAction();
        $class = "";
        $file = "";
        
        if(in_array($action, $this->mBackendAction)) {
            $file = "./Module/$module/{$module}Controller.php";
            $class = "\\Application\\Module\\$module\\{$module}Controller";
        } else {
            $file = "./Module/$module/{$module}View.php";
            $class = "\\Application\\Module\\$module\\{$module}View";
        }

        if(!file_exists($file)) {
            header("HTTP 1.0 404 Not Found");
            exit();
        }
        
        require_once($file);
        
        $sys_config['mod_dir'] = "./Module/$module/";
        $params = $this->gatherParams($this->mURLParser->GetHashValue());
        
        $instance = new $class($params);
        if(method_exists($instance, $action)) {
            $instance->$action();
        } else {
            header("HTTP 1.0 404 Not Found");
            exit();
        }
    }
}

?>
