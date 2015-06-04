<?php

namespace Application\Module;

if(!defined("_APP_ENTRY_")) {
    header("HTTP 1.0 404 Not Found");
    exit();
}
require_once('modules/Application/Module.php');

use \Application\Module;

class UserIndex extends Module
{
    protected $mRouteFilter = array('id');
}

?>