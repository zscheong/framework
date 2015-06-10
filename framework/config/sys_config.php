<?php

if(!defined("_APP_ENTRY_")) {
    header("HTTP 1.0 404 Not Found");
    exit();
}

$sys_config = array();
$sys_config["doc_dir"] = __DIR__ . "/../";
$sys_config['base_url'] = 'http://localhost:81/project/framework/framework/';
//$sys_config['url_include'] = '../../../';
$sys_config['base_request_uri'] = '/project/framework/framework/';

//define database
$sys_config['db'] = array();
$sys_config['db']['dsn'] = 'mysql:host=localhost;dbname=test';
$sys_config['db']['user'] = 'root';
$sys_config['db']['pass'] = 'new_root';

$mod_config = array();

?>
