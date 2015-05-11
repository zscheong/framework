<?php
namespace Application;

if(!defined("_APP_ENTRY_")) {
    header("HTTP 1.0 404 Not Found");
    exit();
}

require_once("modules/ExcelUtils/model/ExcelUtils.php");

use \Application\Modules\ExcelUtils;

$file = "C:/xampp/htdocs/project/ExcelUtils/data/file/MOLWallet App Checklist Matrix.xlsx";
$mExcelUtils = new ExcelUtils();
$data = $mExcelUtils->Read($file);
echo "<pre>";
print_r($data);
echo "</pre>";
?>