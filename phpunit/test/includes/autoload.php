<?php
require_once('sys_config.php');

function autoloadMap($class) {
    global $sys_config;
    
    $map = array('includes\\php\\cpdo' => '/../framework/includes/php/CPDO.php');
    $cn = strtolower($class);
    if(isset($map[$cn])) {
        require_once($sys_config['base_dir'] . $map[$cn]);
    }
}

spl_autoload_register('autoloadMap');
?>
