<?php
if(!defined("_APP_ENTRY_")) {
    header("HTTP 1.0 404 Not Found");
    exit();
}

$appConfig = array();
$appConfig["app_dir"] = __DIR__ . "/../";
$appConfig['doc_dir'] = './';
$appConfig['base_path'] = '/framework/';

//define database
$appConfig['db_config'] = array();
$appConfig['db_config']['dsn'] = 'mysql:host=localhost;dbname=test';
$appConfig['db_config']['user'] = 'root';
$appConfig['db_config']['pass'] = 'new_root';


$modConfig = array();

?>