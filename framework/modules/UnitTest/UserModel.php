<?php

namespace Application\Module;

if(!defined("_APP_ENTRY_")) {
    header("HTTP 1.0 404 Not Found");
    exit();
}
require_once('modules/Application/Model.php');

use \Application\Model;

class UserModel extends Model {
    protected $mTable = "test_user";
    protected $mColumn = array("id", "first_name", "last_name", "email", "phone_numer");
    protected $mColumnRead = array("first_name", "last_name", "email");
}

?>