<?php

if(!defined("_APP_ENTRY_")) {
    header("HTTP 1.0 404 Not Found");
    exit();
}

switch ($modConfig['action']) {
    case "Simple":
        $modConfig['controller']    = 'SimpleTemplate';
        $modConfig['view']          = 'SimpleTemplate';
        break;
}

?>