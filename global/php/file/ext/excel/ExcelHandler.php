<?php
namespace Library\File\Ext\Excel;

require_once('resource/php/lib/PHPExcel/Classes/PHPExcel.php');
require_once('resource/php/my/file/prototype/IFileHandler.php');

use \Library\Error\ErrorInfo;
use \Library\File\Prototype\IFileHandler;

class ExcelHandler implements IFileHandler {
	
	public function Write($fileName, $data) {
            $ret = array();
            try {
//		$pathInfo = pathinfo($fileName);
//		$extension = $pathInfo["extension"];
//                if($extension == "xlsx") {
                $ret = $this->WriteExcel($fileName, $data);
//		} else {
//                    echo "Unrecognized file type: $fileName";
//		}
            } catch (\Exception $e) {
                ErrorInfo::SetMessage("ExcelHandler::Write -- " . $e->getMessage());
                return false;
            }
            return $ret;
	}
	
	private function WriteExcel($fileName, $data, $title='Sheet1') {
            $objPHPExcel = new \PHPExcel();
            $objPHPExcel->getProperties()->setCreator("User");
            $objPHPExcel->getProperties()->setLastModifiedBy("User");
            $objPHPExcel->getProperties()->setTitle("Excel2007");
            $objPHPExcel->getProperties()->setSubject("Excel2007");
            //$objPHPExcel->createSheet($sheetIndex);
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->setTitle($title);

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
            $objWriter->save($fileName);

            unset($objWriter);
            unset($objPHPExcel);
	}
	
	public function Load($url) {
            $ret = array();
            
            try {
//            $pathInfo = pathinfo($url);
//            $extension = $pathInfo['extension'];
//            if($extension == "xlsx" || $extension == "xls") {
                $ret = $this->ReadExcel($url, 0, true);
//            } else {
//                echo "Unrecognized file type: $url";
//            }
            } catch (\Exception $e) {
                ErrorInfo::SetMessage("ExcelHandler::Load -- " . $e->getMessage());
                return false;
            }
            return $ret;
	}
	
	private function ReadExcel($fileName, $sheetIndex, $hasHeader) {
		$ret = array();
		//Global Access
		$objReader = \PHPExcel_IOFactory::createReader('Excel2007');
		//$objReader->setReadDataOnly(false);
		$objPHPExcel = $objReader->load($fileName);
		
		if(is_numeric($sheetIndex)) { $sheetIndex = strval($sheetIndex); }
		$objWorksheet = $objPHPExcel->setActiveSheetIndex($sheetIndex) ;
		
		$header = array();
		$rowCount = 0; 
		$colCount = 0;
		foreach ($objWorksheet->getRowIterator() as $row) 
		{
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(false); 
	    
			$colCount = 0;
			foreach ($cellIterator as $cell) 
			{   
				if($hasHeader && $rowCount == 0) {
					array_push($header, $cell->getValue());
				} else {
					if($hasHeader) {
						if(\PHPExcel_Shared_Date::isDateTime($cell)) {
							$dateValue = date('Y-m-d', \PHPExcel_Shared_Date::ExcelToPHP($cell->getValue()));
							$ret[$rowCount-1][$header[$colCount]] = $dateValue;
						} else {
							$ret[$rowCount-1][$header[$colCount]] = trim($cell->getValue());
						}
						//$temp = $ret[$rowCount-1][$header[$colCount]];
					} else {
                                            if(\PHPExcel_Shared_Date::isDateTime($cell)) {
                                                $dateValue = date('Y-m-d', \PHPExcel_Shared_Date::ExcelToPHP($cell->getValue()));
                                                $ret[$rowCount][$colCount] = $dateValue;
                                            } else {
						$ret[$rowCount][$colCount] = trim($cell->getValue());
                                            }    
                                        }
				}
				$colCount++;
    		}
			$rowCount++;
		}
		return $ret;
	}
}//End of Class ExcelManager
?>
