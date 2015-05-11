<?php

namespace Application\View;

if(!defined("_APP_ENTRY_")) {
    header("HTTP 1.0 404 Not Found");
    exit();
}

require_once("modules/Application/View.php");
require_once("modules/ExcelUtils/model/ExcelUtils.php");

//use \Application\Module\ExcelUtils;
use \Application\Application_View;
use \Library\Common;
//use \Library\ArrayTable;

$view = new Application_View($modConfig["module"], $modConfig["view"]);

/*********Begin Data Processing************/
//$file="C:/xampp/htdocs/project/ExcelUtils/data/file/MOLWallet App Checklist Matrix.xlsx";
//$mExcelUtils = new ExcelUtils();
//$data = $mExcelUtils->Read($file);

//$mTable = new ArrayTable();
//$mTable->InstanceFromArray($data);
//$columns = $mTable->GetColumns();
/*********End Data Processing*************/



//$view->SetVar("column_list", $columns);
$view->SetVar("form_id", Common::RandomString(16));
//$view->SetVar("data", $data);
$view->Show($modConfig["view"]);

?>