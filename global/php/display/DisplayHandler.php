<?php

namespace Library\Display;

require_once('resource/php/my/display/prototype/IDisplayTarget.php');

use \Library\Display\Prototype\IDisplayTarget;

class DisplayHandler {
    
    public static function Display(IDisplayTarget $target) {
        $target->display();
    }
    
}

?>
