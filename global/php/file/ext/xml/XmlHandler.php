<?php

namespace Library\File\Ext\Xml;

require_once('resource/php/my/file/prototype/IFileHandler.php');

use \Library\Error\ErrorInfo;
use \Library\File\Prototype\IFileHandler;

class XmlHandler implements IFileHandler {
    public function Load($url) {        
        $ret = array();
        try {
            $ret = simplexml_load_file($url);
        } catch (\Exception $e) {
             ErrorInfo::SetMessage("XmlHandler::Load -- " . $e->getMessage);
             return false;
        }
        return $ret;
    }
    public function Write($filePath, $data) {
        
    }
    
    public function Xml2Table($args) {
        $ret = array();
        if(!isset($args["url"])) { return false; } 
        
        $url = $args["url"];
        $contents = self::LoadXml($url);
        foreach ($contents as $currentRow) {
            $index = (string)$currentRow->index;
            $rowContent = (array)$currentRow->field;
            $field = array();
            foreach ($rowContent as $col => $val) {
                if(is_a($val, "SimpleXMLElement")) {
                    $field[$col] = "";
                } else {
                    $field[$col] = $val;
                }
            }
            $ret[$index] = $field;
        }
        return $ret;
    }
    public function Table2Xml($args) {
        
        if(!isset($args["table"])) { return false; } 
     
        $table = $args["table"];   
        $ret = '<?xml version="1.0" encoding="utf-8"?>';
        $ret .= "<table>";
        foreach ($table as $row => $field) {
            $ret .= "<row>";
            $ret .= "<index>$row</index>";
            $ret .= "<field>";
            foreach ($field as $col => $value) {
                $ret .= "<$col>" . htmlentities($value) . "</$col>";
            }
            $ret .= "</field></row>";
        }
        $ret .= "</table>";
        return $ret;
    }
}

?>
