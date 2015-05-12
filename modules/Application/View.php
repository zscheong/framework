<?php

namespace Application;

if(!defined("_APP_ENTRY_")) {
    header("HTTP 1.0 404 Not Found");
    exit();
}

class View {
    public function Display($layout = '') {
        global $appConfig, $modConfig, $mResponse;
        
        $modConfig['js'][] = $appConfig['doc_dir'] . 'global/directive/AppModule.js';
        require_once($appConfig['app_dir'] . 'global/html/header.inc');
        
        $file_path = $modConfig['mod_dir'] . 'view/' . $layout;
        if(!empty($layout) && file_exists($file_path)) {
            require_once($file_path);
        } else {
            $file_path = $mod['mod_dir'] . 'view/app.inc';
            if(file_exists($file_path)) {
                require_once($file_path);
            }
        }
        require_once($appConfig['app_dir'] . 'global/html/footer.inc');
    }
}

?>