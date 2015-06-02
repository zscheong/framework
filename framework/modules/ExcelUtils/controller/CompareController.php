<?php

namespace Application\Module;

if(!defined("_APP_ENTRY_")) {
    header("HTTP 1.0 404 Not Found");
    exit();
}
require_once('modules/Application/Controller.php');
require_once('global/php/CUtils/CExcelUtils.php');

use \Application\Controller;
use \Library\CUtils;
use \Library\CExcelUtils;

class CompareController extends Controller
{
    
    public function Process() {
        $params = json_decode(file_get_contents('php://input'));
        CUtils::Log(array($_POST, $_GET, $params), "Compare");
    }
}


?>
