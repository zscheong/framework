<?php

namespace Library\Display\DisplayTarget;

require_once('resource/php/my/display/prototype/IDisplayTarget.php');

use \Library\Display\Prototype\IDisplayTarget;

class DisplayArray implements IDisplayTarget {
    private $mArray = array();
    
    public function __construct($array) {
        $this->mArray = $array;
        return $this;
    }
    public function __destruct() {
        $this->mArray = array();
    }
    
    //desc: return 1-dimensional array by transforming the muliple dimensional array
    //return: array(value1, value2)
    public static function FlattenArray($array) {
        //arg: $array -- array(array(value1), value2){multiple dimensional array}
        if(empty($array)) { return array(); }
        $ret = array();
        
        foreach ($array as $elem) {
            $val = $elem;
            if(is_array($elem)) {
                $val = self::FlattenArray($elem);                
            } 
            array_push($ret, $val);
        }
        return $ret;
    }
    
    //desc: return 1-dimensional Assoc Array by transformating the multiple dimensional Assoc Array
    //return: array(key1=>value1, key2=>value2)
    public static function FlattenAssoc($array) {
        //arg: $array(key1=>value1, key2=>array(value1, value2)) 
        if(empty($array)) { return array(); }
        $ret = array();
        
        foreach ($array as $key => $elem) {
            $val = $elem;
            if(is_array($elem)) {
                $val = self::FlattenArray($elem);                
            } 
            $ret[$key] = $val;
        }
        return $ret;
    }
    
    //desc: return true if array is an assoc array
    //return: boolean
    public static function isAssoc($array) {
        return array_keys($array) !== range(0, count($array) - 1);
    }
    
    //desc: create a pre tag to display array information
    //return: --
    public function display() {
        echo "<pre>";
        foreach ($this->mArray as $col=>$val) {
            $strVal = '';
            if(is_array($val)) {
                if(self::isAssoc($val)) {
                    $temp = self::FlattenAssoc($val);
                    $strVal = print_r($temp, true);
                } else {
                    $temp = self::FlattenArray($val);
                    $strVal = print_r($temp, true);
                }
            } else {
                $strVal = $val;
            }
            echo "$col => $strVal\n";
        }
        echo "</pre>";
    }
}

?>
