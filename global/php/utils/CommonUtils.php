<?php

namespace Library\Utils;

use \Library\Utils\ArrayLib;

class CommonUtils {
    
    public static function CheckEmpty($data, $msg="", $quit=false) {
        if(empty($data)) {
            if(!empty($msg)) {
                echo "<br>" . __CLASS__ . ":" . __FUNCTION__ . "- $msg";
            }
            if($quit) { exit; }
        } 
        return $data;
    }
    
    public static function CheckBool($data, $msg="", $quit=false) {
        if(!$data) {
            if(!empty($msg)) {
                echo "<br>" . __CLASS__ . ":" . __FUNCTION__ . "- $msg";
            }
            if($quit) { exit; }
        } 
        return $data;
    }
    
    public static function CheckTableFirstRow($data, $col, $default="", $msg="", $quit=false) {
        $ret = $default;
        if(count($data) == 0) {
            if(!empty($msg)) {
                echo "<br>" . __CLASS__ . ":" . __FUNCTION__ . "- $msg<br>" . ArrayLib::FlatternArray($data);
            }
            if($quit) { exit; }
        } else {
//            var_dump($data);
            $ret = $data[0][$col];
        }
        return $ret;
    }
}

?>
