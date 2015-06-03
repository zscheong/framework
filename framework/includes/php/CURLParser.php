<?php

namespace includes\php;

require_once('CArrayUtils.php');

class CURLParser 
{
    private $mValue = array();
    private $mHashValue = array();
    private $mModule = '';
    private $mAction = '';
    
    public function __construct() 
    {
    }
    
    public function parseURL($base_dir, $uri) 
    {
        //$url_query = str_replace($base_dir, '', $_SERVER['REQUEST_URI']);
        $url_query = str_replace($base_dir, '', $uri);
        $url = preg_replace('/^\/|\?.*|\/$/', '', $url_query);
        $url_list = explode('/', $url);
        
        $this->mAction = array_shift($url_list);
        $this->mModule = array_shift($url_list);
        $this->mValue = $url_list;
        $this->mHashValue = CArrayUtils::toHash($url_list);
    }
    
    public function GetAction() { return $this->mAction; }
    public function GetModule() { return $this->mModule; }
    public function GetValue() { return $this->mValue; }
    public function GetHashValue($filter=array()) 
    { 
        $ret = array();
        if(!empty($filter)) {
            foreach ($filter as $f) {
                if(isset($this->mHashValue[$f])) {
                    $ret[$f] = $this->mHashValue[$f];
                }
            }
        } else {
            $ret = $this->mHashValue;
        }
        
        return $ret; 
    }
}
//if(!isset($mURLParser)) {
//    $mURLParser = new CURLParser();
//}
?>
