<!doctype html>
<html>
    <head>
        <meta charset='utf-8'/>
        <title><?=$modConfig['module'] . ' - ' . $modConfig['view']?></title>
        
        <link rel="stylesheet" href='<?=$appConfig['doc_dir'].'global/js/bootstrap/css/bootstrap.min.css'?>'>
        <link rel="stylesheet" href='<?=$appConfig['doc_dir'].'global/css/general.css'?>'>
        <link rel="stylesheet" href='<?=$appConfig['doc_dir'].'global/js/jext/jclick.css'?>'>
        
        <script src='<?=$appConfig['doc_dir'] . 'global/js/jquery/jquery.js'?>'></script>
        <script src='<?=$appConfig['doc_dir'] . 'global/js/bootstrap/js/bootstrap.min.js'?>'></script>
        <script src='<?=$appConfig['doc_dir'] . 'global/js/angular/lib/angular.min.js'?>'></script>
        <script src='<?=$appConfig['doc_dir'] . 'global/js/angular/lib/angular-animate.min.js'?>'></script>
        
        <script src='<?=$appConfig['doc_dir'] . 'global/js/jext/jclick.js'?>'></script>
        
        
<?php
    if(isset($modConfig['css']) && !empty($modConfig['css'])) {
        foreach ($modConfig['css'] as $script) {
?>
        <link type='text/css' href='<?=$script?>'>
<?php
        }
    }
    if(isset($modConfig['js']) && !empty($modConfig['js'])) {
        foreach ($modConfig['js'] as $script) {
?>        
        <script src='<?=$script?>'></script>
<?php
        }
    }
?>
        <script>
            $(document).ready(function() {
                $('.btn').jclick();
                $('.input-click').jinput();
            });
        </script>
    </head>
    <body>
    <?php require_once($appConfig['doc_dir'] . 'global/html/nav-bar.inc');?>
        