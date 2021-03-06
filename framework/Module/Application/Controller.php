<?php

namespace Application;

if(!defined("_APP_ENTRY_")) {
    header("HTTP 1.0 404 Not Found");
    exit();
}

class Controller 
{
    protected $mParams = array();
    protected $mKeyFields = array();
    
    public function __construct($params) {
        $this->mParams = $params;
    }
    
    public function manage() 
    {        
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        switch($method) {
            case 'post':
                $this->create();
                break;
            case 'put':
                $this->update();
                break;
            case 'get':
                $this->load();
                break;
            case 'delete':
                $this->delete();
                break;
        }
    }
    
    public function create() 
    {
        
    }
    
    public function update()
    {
        
    }
    
    public function load()
    {
        $invoke = '';
        if(isset($this->mParams['by'])) {
            $invoke = 'loadBy' . $this->mParams['by'];
        } else if(empty($this->mParams)) {
            $invoke = 'loadAll';
        } else {
            $invoke = 'loadByCriteria';
        }
        
        if(!method_exists($this, $invoke)) {
            $invoke = 'loadAll';
        }
        
        $this->$invoke();
    }
    
    public function delete()
    {
        
    }
}