<?php

namespace includes\php;

class CArrayUtils 
{   
    public static function toHash($array) 
    {
        $ret = array();
        if(is_array($array)) {
            $key = '';
            for($i = 0; $i < count($array); $i++) {
                if(($i % 2) === 0) {
                    $key = trim($array[$i]);
                } else {
                    $ret[$key] = trim($array[$i]);
                }
            }
        } else {
            $ret = $array;
        }
        return $ret;
    }
    public static function isArrayEmpty($array)
    {
        $status = true;
        if(is_array($array)) {
            foreach($array as $a) {
                if(is_array($a)) {
                    $temp = self::isArrayEmpty($a);
                    if(!$temp) { return false; }
                } else {
                    if(!empty($a)) {
                        return false;
                    }
                }
            }
        } else {
            $status = empty($array);
        }
        return $status;
    }
}

?>
