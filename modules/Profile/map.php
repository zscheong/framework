<?php

if(!defined("_APP_ENTRY_")) {
    header("HTTP 1.0 404 Not Found");
    exit();
}

switch ($modConfig['action']) {
    case "Show":
        $modConfig['controller']    = '';
        $modConfig['view']          = 'Display';
        break;
}

?>