<?php

namespace Application\Module;

if(!defined("_APP_ENTRY_")) {
    header("HTTP 1.0 404 Not Found");
    exit();
}
require_once('modules/Application/Controller.php');

use \Application\Controller;
use \Library\CUtils;

class UserController extends Controller {
    private $mKey = "id";
    
    public function Read() {
        global $modConfig;
        $value = $modConfig['RouteValue'];
        if(isset($value[$this->mKey]) && !empty($value[$this->mKey])) {
            $data = array("first_name"=>"Cheong", "last_name"=>"Zee Swee");
            echo json_encode($data);
            //echo "Read Single";
        } else {
            echo "Read List";
        }
    }
    public function Create() {
        global $mResponse;
        global $modConfig;
        
        CUtils::Log(array("PUT"=>$mResponse->GetInput(), "GET"=>$_GET, 
                        "Route"=>$modConfig['RouteValue'], "POST"=>$_POST), 'Create Function');
        $data = array("id"=>"new_id", "method"=>"create");
        echo json_encode($data);
    }
    public function Update() {
        global $mResponse;
        global $modConfig;
        
        CUtils::Log(array("PUT"=>$mResponse->GetInput(), "GET"=>$_GET, 
                        "Route"=>$modConfig['RouteValue'], "POST"=>$_POST), 'Update Function');
        $data = array("id"=>"new_id", "method"=>"update");
        echo json_encode($data);
    }
}