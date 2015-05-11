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

global $mResponse;
$controller = new Application_Controller();

//process data
$file = $controller->UploadFile("excel_file");
$col = explode(",", $mResponse->Get("multiselect"));
if(!empty($file)) {
    $mExcel = new ExcelUtils();
    $data = $mExcel->Read($file);
    $mTable = new ArrayTable();
    $mTable->InstanceFromArray($data);
    
    $data = $mExcel->CheckDuplicateRow($mTable->GetTable(), $col);

    print_r($data);
}
?>
