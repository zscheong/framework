<?php

namespace Application\Module;

if(!defined("_APP_ENTRY_")) {
    header("HTTP 1.0 404 Not Found");
    exit();
}
require_once('modules/Application/Model.php');

use \Application\Model;
use \Library\CUtils;

class UserModel extends Model {
    protected $mTable = 'diagram_user';
    protected $mColumn = array('id', 'user_name', 'password', 'first_name', 'last_name', 'email', 'created_time');
   
}


?>
