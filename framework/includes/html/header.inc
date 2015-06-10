<!doctype html>
<html>
    <head>
        <meta charset='utf-8'/>
        <title>Application</title>
        <?php if(!empty($sys_config['base_url'])) { ?>
        <base href="<?=$sys_config['base_url']?>">    
        <?php } ?>
        <link rel="stylesheet" href='includes/js/bootstrap/css/bootstrap.min.css'>
        <link rel="stylesheet" href='includes/css/general.css'>
        <link rel="stylesheet" href='includes/js/jext/janim.css'>
        
        <script src='includes/js/jquery/jquery.js'></script>
        <script src='includes/js/bootstrap/js/bootstrap.min.js'></script>
        <script src='includes/js/angular/lib/angular.min.js'></script>
        <script src='includes/js/angular/lib/angular-animate.min.js'></script>
               
        <script src='includes/js/jext/jutils.js'></script>
        <script src='includes/app/app.js'></script>
        
        <script src='includes/js/jext/janim.js' defer></script>
               
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
    <?php if(!isset($params['module']) || $params['module'] != 'UnitTest') {
        require_once($sys_config['doc_dir'] . 'includes/html/nav-bar.inc');
    }?>
        