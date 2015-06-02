<?php

namespace Library\Error;

class ErrorInfo {
    public static $mErrMsg = array();
    public static $mCount = 10;
    
    public static function SetMessage($msg) {
        if(count($this->mErrMsg) > $this->mCount) {
            array_shift($this->mErrMsg);
        }
        array_push($this->mErrMsg, $msg);
    }
    public static function GetLastMessage() {
        if(!empty($this->mErrMsg)) {
            $last = count($this->mErrMsg) -1;
            return $this->mErrMsg[$last];
        }
    }
    public static function Assert($status, $msg) {
        if(empty($status)) {
            echo $msg;
        }
        assert($status);
    }
}

?>
