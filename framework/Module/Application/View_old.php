<?php

namespace Application;

if(!defined("_APP_ENTRY_")) {
    header("HTTP 1.0 404 Not Found");
    exit();
}

require_once "resource/php/raintpl/rain.tpl.class.php";

use \Library\CUtils;

class View {
    
    private $mTpl;
    private $mModule;
    private $mView;
    protected $mDefaultStep;
    
    public function __construct() {
        global $modConfig;
        
        $this->mModule = $modConfig['module'];
        $this->mView = $modConfig['view'];
  
        \raintpl::configure("base_url", null);
        \raintpl::configure("tpl_dir", null);
        \raintpl::configure("cache_dir", "layout/tmp/"); 
        $this->mTpl = new \RainTPL;
        $this->SetVar('module', $this->mModule);
        $this->SetVar('view', $this->mView);
    }
    public function Display() {
        global $mResponse;
        global $modConfig;
        
        $step = $mResponse->GetResponse('step');
        if((isset($modConfig['CSRF_error']) && $modConfig['CSRF_error']) ||
                empty($step)) {
            $step = $this->mDefaultStep;
        }
        $step_name = 'step' . $step;
        
        if(method_exists($this, $step_name)) {
            $this->$step_name();
        }
    }
    public function SetVar($name, $value) {
        $this->mTpl->assign($name, $value);
    }
    public function Show($page) {
        global $modConfig;
        
        $module = $this->mModule;
        $css    = isset($modConfig['include_css'])? $modConfig['css'] : array();
        $js     = isset($modConfig['include_js']) ? $modConfig['js'] : array();
        
        $this->SetVar("include_css", CUtils::IncludeCSS($css));
        $this->SetVar("include_js", CUtils::IncludeJS($js));
        $html = $this->mTpl->draw("layout/tpl/$module/$page", $return_string = true);
        echo $html;
    }
}
?>