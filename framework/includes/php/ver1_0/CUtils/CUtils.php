<?php

namespace Library;

if(!defined("_APP_ENTRY_")) {
    header("HTTP 1.0 404 Not Found");
    exit();
}

class CUtils {
    public static function Display($message, $isHidden = false) {
        if($isHidden) { echo "<!--"; }
        echo "<pre>". print_r($message, true) . "</pre>";
        if($isHidden) { echo "-->"; }
    }
    public static function Log($message, $extra) {
        $dir = "logs/" . date("Ymd");
        if(!file_exists($dir)) { mkdir($dir); }
        $file = $dir . '/develop.log';
        $f_handler = fopen($file, "a+");
        
        if(!empty($f_handler)) {
            fwrite($f_handler, date("Y-m-d H:i:s") . "\t$extra\n" . 
                (is_array($message)?print_r($message, true): $message));
            fclose($f_handler);
        }
    }
    public static function UploadFile($file) {
        $ret ="";
        $target_dir = "uploads/";

        if(!file_exists($target_dir)) {
            mkdir($target_dir);
        } 
        $target_file = $target_dir . basename($_FILES[$file]["name"]);
        if(move_uploaded_file($_FILES[$file]["tmp_name"], $target_file)) {
            $ret = $target_file;
        }    
        return $ret;
    }
    public static function IsJSON($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
    public static function SendJSON($data) {
        header('Content-type: application/json');
        echo json_encode($data);
    }
    public static function RandomString($length = 10) {       
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public static function IncludeCSS($css_list) {
        $ret = "";
        foreach ($css_list as $file) {
            $ret .= "<link rel='stylesheet' href='$file'>\n";
        }
        return $ret;
    }
    public static function IncludeJS($js_list) {
        $ret = "";
        foreach ($js_list as $file) {
            $ret .= "<script src='$file'></script>\n";
        }
        return $ret;
    }
}

?>
