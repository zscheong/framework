<?php

namespace Application;

if(!defined("_APP_ENTRY_")) {
    header("HTTP 1.0 404 Not Found");
    exit();
}

use \Library\CUtils;

class Module {
    protected $mModule = '';
    protected $mRouteFilter = array();
    protected $mRouteValue = array();
    
    public function __construct() {
        global $modConfig;
        global $appConfig;
        global $mURLParser;
        
        $module = $this->mModule = $mURLParser->GetModule();
        
        $modConfig['module']  = $module;
        $modConfig['mod_dir'] = $appConfig['app_dir'] . "modules/$module/";
        $modConfig['mod_doc_dir'] = $appConfig['doc_dir'] . "modules/$module/";
        
        $config_file = $appConfig['app_dir'] . "modules/$module/config.php";
        if(file_exists($config_file)) {
            require_once($config_file);
        }
    }
    
    private function FilterRouteValue() {
        global $mURLParser;
        
        $value = $mURLParser->GetValue();
        $filter_list = array_merge($this->mRouteFilter, array('func', 'view'));
        foreach ($filter_list as $filter) {
            if(in_array($filter, $value)) {
                $index = array_search($filter, $value);
                $filter_value = $value[intval($index)+1];
                $this->mRouteValue[$filter] = $filter_value;
            }
        }
    }
    
    public function Route() {
        global $modConfig;
        
        $this->FilterRouteValue();
        $this->SpecialRoute();
        
        if(empty($modConfig['controller']) && empty($modConfig['view'])) {
            $this->DefaultRoute();
        }
        $modConfig['RouteValue'] = $this->mRouteValue;
        $this->RunController();
        $this->DisplayView();
    }
    private function DefaultRoute() {
        switch($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $modConfig['controller'] = 'Read';
                $modConfig['view'] = 'Read';
                break;
            case 'POST':
                $modConfig['controller'] = 'Create';
                $modConfig['view'] = 'Read';
                break;
            case 'PUT':
                $modConfig['controller'] = 'Update';
                $modConfig['view'] = 'Read';
                break;
        }
    }
    private function DisplayView() {
        global $modConfig;
        global $appConfig;
        
        $module = $this->mModule;
        $view = isset($modConfig['view']) ? $modConfig['view'] : '';
        
        $view_file = $appConfig['app_dir'] . "modules/$module/{$module}View.php";
        if(file_exists($view_file)) {
            require_once($view_file);
            $class_name = "\\Application\\Module\\" . $module . "View";
            $inst = new $class_name();
            if(method_exists($inst, $view)) {
                $inst->$view();
            } else {
                $inst->DefaultView();
            }
        }
    }
    private function RunController() {
        global $modConfig;
        global $appConfig;
        
        $module = $this->mModule;
        $controller = isset($modConfig['controller'])? $modConfig['controller'] : '' ;
        
        $controller_file = $appConfig['app_dir'] . "modules/$module/{$module}Controller.php";
        if(file_exists($controller_file)) {
            
            require_once($controller_file);
            $class_name = "\\Application\\Module\\" . $module . "Controller";
            $inst = new $class_name();
            if(method_exists($inst, $controller)) {
                $inst->$controller();
            }
        } else {
            header("HTTP 1.0 404 Not Found");
            exit();
        }
    }
    private function SpecialRoute() {
        //global $appConfig;
        global $modConfig;
        
        //$module = $this->mModule;
        
        if(isset($this->mRouteValue['func'])) {
            $modConfig['controller'] = $this->mRouteValue['func'];
        }
        if(isset($this->mRouteValue['view'])) {
            $modConfig['view'] = $this->mRouteValue['view'];
        }
    }
    
}

?>