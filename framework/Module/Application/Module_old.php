<?php

namespace Application;

if(!defined("_APP_ENTRY_")) {
    header("HTTP 1.0 404 Not Found");
    exit();
}

use \Library\CUtils;

class Module {
    
    public static function Config($module, $action) {
        global $modConfig;
        global $appConfig;
        global $mResponse;
        
        //Module Config
        $modConfig['module']  = $module;
        $modConfig['mod_dir'] = $appConfig['app_dir'] . "modules/$module/";
        $modConfig['mod_doc_dir'] = $appConfig['doc_dir'] . "modules/$module/"; 
        $config_file = $appConfig['app_dir'] . "modules/$module/config.php";
        if(file_exists($config_file)) {
            require_once($config_file);
        }
        
        //Module action (map to defined controller and view)
        $modConfig['action'] = $action;
        if(!empty($modConfig['action'])) {
            $modConfig['controller'] = $modConfig['view'] = '';
            $map_file = $modConfig['mod_dir'] . 'map.php';
            if(file_exists($map_file)) {
                require_once($map_file);
            }
        } else {
            $modConfig['controller'] = $mResponse->GetResponse('controller');
            $modConfig['view'] = $mResponse->GetResponse('view');
        }
    }
    
    private static function CheckCSRFKey($refresh = true) {
        global $mResponse;
        global $modConfig;
        
        $step = $mResponse->GetResponse("step");
        $csrf_key = $mResponse->GetResponse("csrf_key");
        if(!empty($step)) {
            $session_key = $mResponse->GetSession("csrf_key");
            if(empty($session_key)) {
                $modConfig['CRSF_error'] = true;
            } else {
                if($csrf_key !== $session_key) {
                    $modConfig['CRSF_error'] = true;
                }
            }
        }
        
        if($refresh) {
            $key = CUtils::RandomString(32);
            $mResponse->SetSession("csrf_key",$key);
        }
    }
    
    public static function Run() {
        global $modConfig;
        
        $refresh = true;
        if(isset($modConfig['refresh'])) { $refresh = $modConfig['refresh']; }
        self::CheckCSRFKey($refresh);
        
        if(!empty($modConfig['controller'])) {
            $controller_file = $modConfig['mod_dir'] . "controller/" . $modConfig['controller'] . "Controller.php";  

            if(file_exists($controller_file)) {
                require_once($controller_file);
                $class_name = "\\Application\\Module\\" . $modConfig['controller'] . "Controller";
                $inst = new $class_name();
                $inst->Process();
            } else {

                header("HTTP 1.0 404 Not Found");
                exit();
            }
        }
        if(!empty($modConfig['view'])) {
            $view_file = $modConfig['mod_dir'] . "view/" . $modConfig['module'] . "View.php";
            if(file_exists($view_file)) {
                require_once($view_file);
                $class_name = "\\Application\\Module\\" . $modConfig['module'] . 'View';
                $inst = new $class_name();
                if(method_exists($inst, $modConfig['view'])) {
                    $inst->$modConfig['view']();
                }
            } else {
                header("HTTP 1.0 404 Not Found");
                exit();
            }
        }
    }
}

?>