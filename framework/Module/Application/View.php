<?php

namespace Application;

if(!defined("_APP_ENTRY_")) {
    header("HTTP 1.0 404 Not Found");
    exit();
}

class View
{
    protected $mParams = array();
    protected $mInvoke = '';
    
    public function __construct($params) 
    {
        $this->mParams = $params;
    }
    
    public function checkView()
    {
        if(!isset($this->mParams['viewOn'])) {
            header("HTTP 1.0 404 Not Found");
            exit(); 
        }
        $this->mInvoke = 'show'.$this->mParams['viewOn'];
        if(!method_exists($this, $this->mInvoke)) {
            header("HTTP 1.0 404 Not Found");
            exit();
        }
    }
    
    public function get() 
    {
        $this->checkView();
        $invoke = $this->mInvoke;
        $this->$invoke();
    }
    
    public function show() 
    {
        global $sys_config;
        
        $this->checkView();
        
        $invoke = $this->mInvoke;
        $params = $this->mParams;
        $params['module'] = $this->mModule;
        require_once($sys_config['doc_dir'] . 'includes/html/header.inc');
        $this->$invoke();
        require_once($sys_config['doc_dir'] . 'includes/html/footer.inc');
    }
}

?>
