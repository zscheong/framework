<?php

namespace Application\Controller;

if(!defined("_APP_ENTRY_")) {
    header("HTTP 1.0 404 Not Found");
    exit();
}

require_once("modules/Application/Controller.php");
require_once("modules/ExcelUtils/model/ExcelUtils.php");

use \Application\Module\ExcelUtils;
use \Application\Application_Controller;
use \Library\ArrayTable;
use \Library\Common;

global $mResponse;
$controller = new Application_Controller();

$json = array("status"=>false, "result"=>array());
$json["result"] = $mResponse->mVar;
//process data
//$file = $controller->UploadFile("excel_file", true);
//if(!empty($file)) {
//    $mExcel = new ExcelUtils();
//    $data = $mExcel->Read($file);
//    $mTable = new ArrayTable();
//    $mTable->InstanceFromArray($data);
//    $columns = $mTable->GetColumns();
//
//    $json['status'] = true;
//    if(!empty($columns)) {
//        $json["result"] = $columns;
//    }
//} else {
//    $json["result"]["message"] = "Unable to upload the file!";
//}

Common::SendJSON($json);
?>
