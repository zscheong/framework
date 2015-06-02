<?php

namespace Application;

if(!defined("_APP_ENTRY_")) {
    header("HTTP 1.0 404 Not Found");
    exit();
}

class CURLParser {
    private $mValue = array();
    private $mModule = '';
    
    public function __construct() {
        $this->ParseURL();
    }
    
    private function ParseURL() {
        global $appConfig;

        $url_query = str_replace($appConfig['base_path'], '', $_SERVER['REQUEST_URI']);
        $url = preg_replace('/\?.*/', '', $url_query);
        $url_list = explode('/', $url);
        
        $this->mModule = array_shift($url_list);
        $this->mValue = $url_list;
        echo '<pre>'.print_r($url_list, true).'</pre>';
    }
    
    public function GetModule() { return $this->mModule; }
    public function GetValue() { return $this->mValue; }
}
if(!isset($mURLParser)) {
    $mURLParser = new CURLParser();
}
?>
