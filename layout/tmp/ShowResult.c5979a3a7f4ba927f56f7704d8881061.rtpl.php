<?php if(!class_exists('raintpl')){exit;}?><!doctype>
<html>
    <head>
        <?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("layout/tpl/Application/header") . ( substr("layout/tpl/Application/header",-1,1) != "/" ? "/" : "" ) . basename("layout/tpl/Application/header") );?>
    </head>
    <body>
        <div class="container-fluid">
            <h4></h4>
            <pre><?php echo print_r( $result );?></pre>
            
        </div>
    </body>
</html>