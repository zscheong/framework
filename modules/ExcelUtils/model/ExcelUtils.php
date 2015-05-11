<?php
namespace Application\Module;

if(!defined("_APP_ENTRY_")) {
    header("HTTP 1.0 404 Not Found");
    exit();
}

require_once('resource/php/PHPExcel/Classes/PHPExcel/IOFactory.php');
require_once('resource/php/PHPExcel/Classes/PHPExcel.php');

class ExcelUtils {
    //private $mTable = array();
    //private $mExcelObj;
    
    public function __construct() {
    //    $this->mExcelObj = new PHPExcel();
    }
    public function CheckDuplicateRow($table, $col_list){
        $temp = array();
        $duplicate = array();
        foreach($table as $row_index => $row ) {
            $r = "";
            foreach ($col_list as $c) {
                $r .= (empty($r))? $row[$c] : "|".$row[$c];
            }
            if(!in_array($r, $temp)) {
                $temp[] = $r;
            } else {
                if(!isset($duplicate[$r])) { $duplicate[$r] = array(); }
                array_push($duplicate[$r], $row_index);
            }
        }
        return $duplicate;
    }
    public function RemoveDuplicateRow($table, $col_list) {
        $temp = array();
        $new_table = array();
        $rem_table = array();
        foreach($table as $row_index => $row ) {
            $r = ""; $skip = false;
            foreach ($col_list as $c) {
                if(empty($row[$c])) { $skip = true; }
                $r .= (empty($r))? $row[$c] : "|".$row[$c];
            }
            if(!in_array($r, $temp) && $skip === false) {
                $temp[] = $r;
                $row["no"] = $row_index;
                $new_table[] = $row;
            } else {
                $row["no"] = $row_index;
                $rem_table[] = $row;
            }
        }
        return array("new"=>$new_table, "rem"=>$rem_table);
    }
    public function Read($file_name, $has_column = true) {
        if(!file_exists($file_name)) {
            return "File does not exist: $file_name";
        }
        
        try {
            $file_type  = \PHPExcel_IOFactory::identify($file_name);
            $reader     = \PHPExcel_IOFactory::createReader($file_type);
            $obj_excel  = $reader->load($file_name);
        } catch (\Exception $ex) {
             echo "Error" . $ex->GetMessage();
        }
        $sheet      = $obj_excel->getSheet(0);
        
        $table = array();
        foreach ($sheet->getRowIterator() as $row) {                
            $row_data = array();
            $empty_row = true;
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);
            foreach ($cellIterator as $cell) {
                $value = $cell->getValue();
                if(!empty($value)) {
                    $empty_row = false;
                }
                if (\PHPExcel_Shared_Date::isDateTime($cell)) {
                    $row_data[] = date('d-M-Y',\PHPExcel_Shared_Date::ExcelToPHP($value));
                } else {
                    $row_data[] = trim($value);
                }
            }
            if(!$empty_row) {
                $table[] = $row_data;
            }
        }
        
        return $table;
    }
    public function Write($file_name, $data) {
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getProperties()->setCreator("User");
        $objPHPExcel->getProperties()->setLastModifiedBy("User");
        $objPHPExcel->getProperties()->setTitle("Excel2007");
        $objPHPExcel->getProperties()->setSubject("Excel2007");
        //$objPHPExcel->createSheet($sheetIndex);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle('Sheet1');

        $rowNo = count($data);
        $colNo = count($data[0]);

        //write header
        $header = array_keys($data[0]);
        for($i = 0; $i<$colNo; $i++) {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i, 1, $header[$i]);
        }
        for($i = 1; $i<=$rowNo; $i++) {
                for($j = 0; $j<$colNo; $j++) {
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j, $i+1, $data[$i-1][$header[$j]]);
                }
        }
        $objWriter =  new \PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save($file_name);

        unset($objWriter);
        unset($objPHPExcel);
    } 
}

?>