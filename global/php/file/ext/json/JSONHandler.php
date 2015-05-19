<?php

namespace Library\File\Ext\JSON;

require_once('resource/php/my/file/prototype/IFileHandler.php');

use \Library\File\Prototype\IFileHandler;

class JSONHandler implements IFileHandler {
    public function Load($url) {
        $json = file_get_contents($url);
        $ret = json_decode($json);
        return $ret;
    }
    public function Write($filePath, $data) {
        
    }
    
    public function ToJSON($args) {
        $ret = "";
        if(!isset($args["data"])) { return false; }
        
        $data = $args["data"];
        if(function_exists("json_encode")) {
            $ret = json_encode($data);
        }
        return $ret;
    }
}

?>
