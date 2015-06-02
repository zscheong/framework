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

class UploadFileController extends Controller
{
    
    public function Process() {
        CUtils::Log($_FILES, "Compare Upload");
        
        $file_reference = CUtils::UploadFile('reference');
        $file_input = CUtils::UploadFile('input');
        
        $excel = new CExcelUtils();
        $reference_col = $excel->ReadColumn($file_reference);
        $input_col = $excel->ReadColumn($file_input);
        
        $response = array("reference"=>$reference_col, "input"=>$input_col);
        CUtils::SendJSON($response);
        exit();
        echo "File Upload Successfully";
    }
}

?>
