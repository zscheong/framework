<?php

namespace Application\Module\UnitTest;

if(!defined("_APP_ENTRY_")) {
    header("HTTP 1.0 404 Not Found");
    exit();
}
require_once('Module/Application/View.php');

use \Application\View;

class UnitTestView extends View
{
    public function showNavBar() {
        global $sys_config;
        
        $params = $this->mParams;
        require_once($sys_config['mod_dir'] . 'view/navbar.inc');
    }
}

?>