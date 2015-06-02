<?php

namespace Application\Module;

if(!defined("_APP_ENTRY_")) {
    header("HTTP 1.0 404 Not Found");
    exit();
}
require_once('modules/Application/Controller.php');

use \Application\Controller;
use \Library\CUtils;

class UnitTestController extends Controller {
    public function TestRoute() {
        global $modConfig;
        
        CUtils::Display($modConfig);
    }
}

?>
