<?php

namespace Application;

if(!defined("_APP_ENTRY_")) {
    header("HTTP 1.0 404 Not Found");
    exit();
}

require_once "resource/php/raintpl/rain.tpl.class.php";

use \Library\Common;

class Application_View {
    
    private $mTpl;
    private $mModule;
    private $mView;
    
    public function __construct($module, $view) {
        $this->mModule = $module;
        $this->mView = $view;
  
        require_once("modules/$module/view/config.php");
        
        \raintpl::configure("base_url", null);
        \raintpl::configure("tpl_dir", null);
        \raintpl::configure("cache_dir", "layout/tmp/"); 
        $this->mTpl = new \RainTPL;
        $this->SetVar('module', $module);
        $this->SetVar('view', $view);
    }
    public function SetVar($name, $value) {
        $this->mTpl->assign($name, $value);
    }
    public function Show($page) {
        global $modConfig;
        
        $module = $this->mModule;
        $this->SetVar("include_css", Common::IncludeCSS($modConfig['include_css']));
        $this->SetVar("include_js", Common::IncludeJS($modConfig['include_js']));
        $html = $this->mTpl->draw("layout/tpl/$module/$page", $return_string = true);
        echo $html;
    }
}
?>