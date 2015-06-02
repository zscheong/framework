<?php
namespace Application;

if(!defined("_APP_ENTRY_")) {
    header("HTTP 1.0 404 Not Found");
    exit();
}

/* require*/
require_once("config/appConfig.php");
require_once("global/php/include.php");
require_once("modules/Application/Module.php");

/***************/

//use \Application\Module;
use \Library\CPDO;
//use \Application\CURLParser;

class Application {
    public static function Config() {
        global $mPDO;
        global $appConfig;
        
        //Config Database
        $dsn = $user = $pass = "";
        if(isset($appConfig['db_config']['dsn'])) {
            $dsn = $appConfig['db_config']['dsn'];
        }
        if(isset($appConfig['db_config']['user'])) {
            $user = $appConfig['db_config']['user'];
        }
        if(isset($appConfig['db_config']['pass'])) {
            $pass = $appConfig['db_config']['pass'];
        }
        if(!empty($dsn) && !empty($user) && !empty($pass)) {
            $mPDO = new CPDO($dsn, $user, $pass);
        }
    }
    
    public static function Run() {
        global $appConfig;
        global $mURLParser;
        
        $module = $mURLParser->GetModule();
        
        $index_file = $appConfig['app_dir'] . "modules/$module/index.php";
        if(file_exists($index_file)) {
            require_once($index_file);
            
            $class = "\\Application\\Module\\" . $module . "Index";
            $mod_inst = new $class();
            $mod_inst->Route();
        } else {
            header("HTTP 1.0 404 Not Found");
            exit();
        }
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