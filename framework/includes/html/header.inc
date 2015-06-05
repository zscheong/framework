<!doctype html>
<html>
    <head>
        <meta charset='utf-8'/>
        <title>Application</title>
        
        <link rel="stylesheet" href='<?=$sys_config['url_include'].'includes/js/bootstrap/css/bootstrap.min.css'?>'>
        <link rel="stylesheet" href='<?=$sys_config['url_include'].'includes/css/general.css'?>'>
        <link rel="stylesheet" href='<?=$sys_config['url_include'].'includes/js/jext/janim.css'?>'>
        
        <script src='<?=$sys_config['url_include'] . 'includes/js/jquery/jquery.js'?>'></script>
        <script src='<?=$sys_config['url_include'] . 'includes/js/bootstrap/js/bootstrap.min.js'?>'></script>
        <script src='<?=$sys_config['url_include'] . 'includes/js/angular/lib/angular.min.js'?>'></script>
        <script src='<?=$sys_config['url_include'] . 'includes/js/angular/lib/angular-animate.min.js'?>'></script>
               
        <script src='<?=$sys_config['url_include'] . 'includes/app/app.js'?>'></script>
        
        <script src='<?=$sys_config['url_include'] . 'includes/js/jext/janim.js'?>' defer></script>
               
<?php
    if(isset($sys_config['css']) && !empty($sys_config['css'])) {
        foreach ($sys_config['css'] as $script) {
?>
        <link type='text/css' href='<?=$script?>'>
<?php
        }
    }
    if(isset($sys_config['js']) && !empty($sys_config['js'])) {
        foreach ($sys_config['js'] as $script) {
?>        
        <script src='<?=$script?>'></script>
<?php
        }
    }
?>
    </head>
    <body ng-app='AppModule'>
    <?php require_once($sys_config['doc_dir'] . 'includes/html/nav-bar.inc');?>
        