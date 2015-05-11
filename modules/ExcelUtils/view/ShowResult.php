<?php

namespace Application\View;

if(!defined("_APP_ENTRY_")) {
    header("HTTP 1.0 404 Not Found");
    exit();
}

require_once("modules/Application/View.php");
require_once("modules/ExcelUtils/model/ExcelUtils.php");

use \Application\Module\ExcelUtils;
use \Application\Application_View;
use \Library\Common;
use \Library\ArrayTable;

global $mResponse;
$view = new Application_View($modConfig["module"], $modConfig["view"]);
/*********Begin Data Processing************/
//$file="C:/xampp/htdocs/project/ExcelUtils/data/file/MOLWallet App Checklist Matrix.xlsx";
$file = $mResponse->Get("excel_file");
$mExcel = new ExcelUtils();
$data = $mExcel->Read($file);

$mTable = new ArrayTable();
$mTable->InstanceFromArray($data);
$col = explode(",", $mResponse->Get("multiselect"));
$result = $mExcel->RemoveDuplicateRow($mTable->GetTable(), $col);
$mExcel->Write("data/new_". basename($file), $result["new"]);
$mExcel->Write("data/rem_". basename($file), $result["rem"]);
/*********End Data Processing*************/

$view->SetVar("excel_file", $file);
$view->SetVar("form_id", Common::RandomString(16));
$view->SetVar("result", $result);
$view->Show($modConfig["view"]);

?>