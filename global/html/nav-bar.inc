<?php
if(!defined("_APP_ENTRY_")) {
    header("HTTP 1.0 404 Not Found");
    exit();
}
$modConfig['nav'] = array();
/*
$modConfig['nav'] =array(   'Profile' => '#',
                            'Blog' => '#',
                            'Service' => '#');
  
*/
?>
<style>
    #nav-div .navbar-default {
        background-color: black;
        color: white;
    }
    #nav-div .navbar-default .navbar-nav > li > a { color: white; }
    #nav-div .navbar-default .navbar-nav > li > a:hover { background-color: #1F5C99; }
    #nav-div .navbar-default .navbar-nav > .active > a { background-color: #0C253D; }
</style>
<div id='nav-div'>
    <nav class="navbar navbar-default">
        <div class="container-fluid" style='padding:0px'>
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar-app">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-navbar-app">
                <ul class="nav navbar-nav">
                <?php foreach ($modConfig['nav'] as $title=>$link) {
                    $class = '';
                    if($modConfig['active'] === $title) {
                        $class = 'active';
                    }
                ?>  
                    <li class='<?=(!empty($class)? $class : '')?>'><a href="<?=$link?>"><?=$title?></a></li>
                <?php } ?>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</div>