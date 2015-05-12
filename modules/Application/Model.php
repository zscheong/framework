<?php
namespace Application;

if(!defined("_APP_ENTRY_")) {
    header("HTTP 1.0 404 Not Found");
    exit();
}

use \Library\CUtils;

class Model {

    protected $mTable = "";
    protected $mColumn = array();
    protected $mColumnRead = array();
    protected $mWhere = array();
    protected $mOffset = array();
    protected $mAttr = array();
    
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
    private function FilterDBColumns($options) {
        $ret = "";
        if(!empty($options)) {
            foreach ($options as $opt) {
                if(in_array($opt, $this->mColumn)) {
                    $ret = (empty($ret))? $opt : ", $opt";
                }
            }
        } else {
            $ret = (empty($this->mColumnRead))? "*": implode(", ", $this->mColumnRead);
        }
        return $ret;
    }
    private function GenerateWhere(){
        $ret = array();
        $query = "";
        $value = array();
        foreach ($this->mWhere as $opt=>$val) {
            if(in_array($opt, $this->mColumn)) {
                $query = (empty($query)) ? "$opt=?" : " and $opt=?";
            
                $value[] = $val; 
            }
        }
        if(!empty($query)) { 
            $ret = array("query"=>$query, "value"=>$value); 
            $this->mWhere = array();
        }
        
        return $ret;
    }
    private function GenerateOffset() {
        $ret = "";
        if(!empty($this->mOffset['offset']) && !empty($this->mOffset['length'])) {
            $ret = " limit " . $this->mOffset['offset'] . ", " . $this->mOffset['length'];
        } else if(!empty($this->mOffset['length'])) {
            $ret = " limit 0, " . $this->mOffset['length'];
        }
        return $ret;
    }
    protected function BeforeQuery() {
        $ret = true;
        if(empty($this->mDB)) { 
            $this->mErrorCode = "1001";
            $this->mErrorMsg = "Database object does not exist.";
            $ret = false; 
        }
        return $ret;
    }
    public function Delete() {
        if(!$this->BeforeQuery()) { return false; }
        
        $where = array();
        if(!empty($this->mWhere)) {
            $where = $this->GenerateWhere();
            return false;
        }
        
        $ret = true;
        $query = "delete from " . $this->mTable . " where " . $where["query"];
        $this->mDB->NonQuery($query,  $where["value"]);
        
        return $ret;
    }
    public function Read($options=array()) {
        if(!$this->BeforeQuery()) { return false; }
        
        $where = array();
        if(!empty($this->mWhere)) {
            $where = $this->GenerateWhere();
        }
        $ret = array();
        $col_str = $this->FilterDBColumns($options);
        
        $offset = $this->GenerateOffset();
        
        //query
        if(!empty($col_str)) {
            $query = "select " . $col_str . " from " . $this->mTable;
            
            CUtils::Log(array("query"=>$query, "where"=>$where), "Model read");
            if(!empty($where["query"])) {
                $query .= " where " . $where["query"];
                if(!empty($offset)) { $query .= $offset; }
                $ret = $this->mDB->Query($query, $where["value"]);
            } else {
                if(!empty($offset)) { $query .= $offset; }
                $ret = $this->mDB->Query($query);
            }
        }
        return $ret;
    }
    public function Update($options=array()) {
        if(!$this->BeforeQuery()) { return false; }
        $where = array();
        if(!empty($this->mWhere)) {
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
        if(!$this->BeforeQuery()) { return false; }
        $ret = false;
        $var = $this->FilterDBParams($options);
        
        //query
        if(!empty($var)) {
            $query = "insert into " . $this->mTable . " (" 
                    . implode(", ", array_keys($var)) . ") values (?" 
                    . str_repeat(",?", count($var)-1) . ")"; 
            
            
            $result = $this->mDB->NonQuery($query, array_values($var));
            CUtils::Log(array("query"=>$query, "value"=>array_values($var), "result"=>$result), "Model save");
            $ret = true;
        }
        return $ret;
    }
    
    public function SetWhere($var, $value) {
        $this->mWhere[$var] = $value;
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
