<?php
namespace Application;

if(!defined("_APP_ENTRY_")) {
    header("HTTP 1.0 404 Not Found");
    exit();
}

class Model {

    public $mTable = "";
    public $mColumn = array();
    public $mWhere = array();
    public $mWhereStr = "";
    public $mOffset = "";
    public $mAttr = array();
    
    protected $mDB = null;
    protected $mErrorCode = "";
    protected $mErrorMsg = "";
    
    public function __construct($db) {
       $this->mDB = $db;
    }
    private function FilterDBParams($options) {
        $var = array();
        foreach ($this->mAttr as $opt=>$value) {
            if(in_array($opt, $this->mColumn)) {
                $var[$opt] = $value;
            }
        }
        
        foreach ($options as $opt=>$value) {
            if(in_array($opt, $this->mColumn)) {
                $var[$opt] = $value;
            }
        }
        return $var;
    }
    private function GenerateWhere(){
        $ret = array();
        $query = "";
        $value = array();
        foreach ($this->mWhere as $opt=>$val) {
            if(in_array($opt, $this->mColumn)) {
                $query = (empty($ret)) ? "$opt=?" : " and $opt=?";
            
                $value[] = $val; 
            }
        }
        if(!empty($query)) { $ret = array("query"=>$query, "value"=>$value); }
        
        return $ret;
    }
    public function Update($options=array()) {
        if(empty($this->mDB)) { 
            $this->mErrorCode = "1001";
            $this->mErrorMsg = "Database object does not exist.";
            return false; 
        }
        $where = array();
        if(empty($this->mWhere)) {
            $where = $this->GenerateWhere();
            return false;
        }
        $ret = false;
        $var = $this->FilterDBParams($options);
        
        //query
        if(!empty($var)) {
            $query = "update " . $this->mTable . " set ";
            $set = "";
            foreach (array_keys($var) as $opt) {
                $set .= (empty($set)) ? "$opt=?" : ", $opt=?";
            }
            $query = $query . $set . " where " . $where["query"];
            $this->mDB->NonQuery($query, array_merge(array_values($var), $where["value"]));
        
            $ret = true;
        }
        return $ret;
    }
    public function Save($options=array()) {
        
        if(empty($this->mDB)) { 
            $this->mErrorCode = "1001";
            $this->mErrorMsg = "Database object does not exist.";
            return false; 
        }
        $ret = false;
        $var = $this->FilterDBParams($options);
        
        //query
        if(!empty($var)) {
            $query = "insert into " . $this->mTable . " (" 
                    . implode(", ", array_keys($var)) . ") values (?" 
                    . str_repeat(",?", count($var)-1) . ")"; 
            $this->mDB->NonQuery($query, array_values($var));
        
            $ret = true;
        }
        return $ret;
    }
    
    public function SetAttr($var, $value) {
        $this->mAttr[$var] = $value;
    }
    public function GetAttr($var) {
        $ret = "";
        if(isset($this->mAttr[$var]) && !empty($this->mAttr[$var])) {
            $ret = $this->mAttr[$var];
        }
        return $ret;
    }
    
    public function CheckColumns($cols) {
        $ret = true;
        $temp = array();

        $this->ClearError();
        
        foreach ($cols as $col) {
            if(in_array($col, $this->mColumn)) {
                $ret = false;
                $temp[] = $col;
            }
        }
        if(!$ret) {
            $this->mErrorCode = "1000";
            $this->mErrorMsg = implode(", ", $temp) . " not exist.";
        }
        
        return $ret;
    }
    
    public function GetError() {
        $ret = array();
        if (!empty($this->mErrorCode)) {
            $ret = array("error_code"=>$this->mErrorCode, "error_message"=>$this->mErrorMsg);
        }
        return $ret;
    }
    
    protected function ClearError() {
        $this->mErrorCode = "";
        $this->mErrorMsg = "";
    }
}

?>
