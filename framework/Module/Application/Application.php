<?php

namespace Application;

if(!defined("_APP_ENTRY_")) {
    header("HTTP 1.0 404 Not Found");
    exit();
}

require_once("config/sys_config.php");
require_once("includes/php/include.php");
require_once('Route.php');

use \includes\php\CPDO;

class Application 
{
    public static function config() 
    {
        global $global_pdo;
        global $sys_config;
        
        //config Database        
        if(isset($sys_config['db']['dsn']) && isset($sys_config['db']['user']) 
                && isset($sys_config['db']['pass'])) {
            $global_pdo = new CPDO($sys_config['db']['dsn'], $sys_config['db']['user'], 
                    $sys_config['db']['pass']);
        }
    }
    
    public static function Run() 
    {
        global $appConfig;
        global $mURLParser;
        
        self::config();
        $route = new Route();
        $route->route();
        
        
//        $module = $mURLParser->GetModule();
//        
//        $index_file = $appConfig['app_dir'] . "modules/$module/index.php";
//        if(file_exists($index_file)) {
//            require_once($index_file);
//            
//            $class = "\\Application\\Module\\" . $module . "Index";
//            $mod_inst = new $class();
//            $mod_inst->Route();
//        } else {
//            header("HTTP 1.0 404 Not Found");
//            exit();
//        }
    }
    
//    public static function Run() {
//        global $mResponse;
//        
//        self::Config();
//        
//        $module = $mResponse->GetResponse("module");
//        $action = $mResponse->GetResponse("action");
//        
//        Module::Config($module, $action);
//        
//        Module::Run();
//        
//        $parser = new CURLParser();
//    }
    
}

?>