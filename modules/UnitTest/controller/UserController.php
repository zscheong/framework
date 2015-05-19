<?php

namespace Application\Module;

if(!defined("_APP_ENTRY_")) {
    header("HTTP 1.0 404 Not Found");
    exit();
}
require_once('modules/Application/Controller.php');
require_once('modules/UnitTest/UserModel.php');

use \Application\Controller;
use \Application\Module\UserModel;

class UserController extends Controller {
    public function Process() {
        //$this->Create();
        $this->Query();
    }
    
    private function Query() {
        global $mPDO;
        
        $user = new UserModel($mPDO);
        //$user->SetWhere("id", '2');
        $result = $user->Read();
        print_r($result);
    }
    
    private function Create() {
        global $mPDO;
        
        $user = new UserModel($mPDO);
        $user->SetAttr("first_name", "Cheong");
        $user->SetAttr("last_name", "Zee Swee");
        $user->SetAttr("email", "zscheong22@gmail.com");
        $user->Save();
    }
}
?>