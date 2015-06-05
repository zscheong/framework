<?php

namespace Application\Module;

if(!defined("_APP_ENTRY_")) {
    header("HTTP 1.0 404 Not Found");
    exit();
}
require_once('modules/Application/View.php');

use \Application\View;

class UserView extends View {
    public function Display($layout='') {
        parent::Display($layout);
    }
}

?>
