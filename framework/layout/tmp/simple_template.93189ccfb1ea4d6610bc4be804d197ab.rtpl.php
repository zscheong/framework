<?php if(!class_exists('raintpl')){exit;}?><!doctype>
<html>
    <head>
        <?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("layout/tpl/Application/header") . ( substr("layout/tpl/Application/header",-1,1) != "/" ? "/" : "" ) . basename("layout/tpl/Application/header") );?>
    </head>
    <body>
           <?php echo var_dump($GLOBALS); ?>
    </body>
</html>

