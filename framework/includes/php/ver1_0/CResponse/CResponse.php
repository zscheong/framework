<?php
namespace Library;

if(!defined("_APP_ENTRY_")) {
    header("HTTP 1.0 404 Not Found");
    exit();
}

use \Library\CUtils;

session_start();
$session_folder = $appConfig["app_dir"] . "session";
if(!file_exists($session_folder)) {
    mkdir($session_folder);
} else {
    session_save_path($session_folder);
}

class CResponse {
    protected $mInput = array();
    
    public function __construct() {
        $value = file_get_contents('php://input');
        if(CUtils::IsJSON($value)) {
            $value = json_decode($value);
        }
        $this->mInput = $value;
    }
    
    public function SetSession($name, $value) {
        $_SESSION[$name] = $value;
    }
    public function GetSession($name) {
        $ret = "";
        if(isset($_SESSION[$name])) {
            $ret = $_SESSION[$name];
        }
        return $ret;
    }
    
    public function GetPOST($key, $type="string") {
        $ret = ($type === "string") ? "" : 0;
        if(isset($_POST[$key])) {
            $ret = $_POST[$key];
        }
        return htmlentities($ret);
    }
    public function GetResponse($key, $type="string") {
        $ret = ($type==="string") ? "" : 0;
        if(isset($_POST[$key])) {
            $ret = $_POST[$key];
        } else if (isset($_GET[$key])) {
            $ret = $_GET[$key];
        }
        return htmlentities($ret);
    }
    public function GetDelete($key, $type="string") {
        $ret = ($type === "string") ? "" : 0;
        if(isset($_DELETE[$key])) {
            $ret = $_DELETE[$key];
        }
        return htmlentities($ret);
    }
    public function GetPut($key, $type="string") {
        $ret = ($type === "string") ? "" : 0;
        if(isset($this->mInput[$key])) {
            $ret = $this->mInput[$key];
        }
        return htmlentities($ret);
    }
    
    public function GetInput() { return $this->mInput; }
    
    public function Send($type, $data) {
        switch ($type) {
            case 'json':
            case 'JSON':
                header('Content-type: application/json');
                echo json_encode($data);
                break;
            case 'xml':
            case 'XML':
                header('Content-type: text/xml');
                echo $data;
        }
    }
}
if(!isset($mResponse)) {
    $mResponse = new CResponse();
}
?>
