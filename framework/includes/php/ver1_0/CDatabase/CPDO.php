<?php

namespace Library;

if(!defined("_APP_ENTRY_")) {
    header("HTTP 1.0 404 Not Found");
    exit();
}

class CPDO {
    private $mPDO = null;
    private $mDSN = "";
    private $mUser = "";
    private $mPass = "";
    
    public function __construct($dsn, $user, $pass) {
        $this->Connect($dsn, $user, $pass);
    }
    public function __desctruc() {
        if(!empty($this->mPDO)) { $this->mPDO = null; }
    }
    public function Connect($dsn, $user, $pass) {
        //'mysql:host=localhost;dbname=test'
        try {
            $this->mDSN = $dsn;
            $this->mUser = $user;
            $this->mPass = $pass;
            $this->mPDO = new \PDO($dsn, $user, $pass);
        } catch (\PDOException $e) {
            $this->mPDO = null;
            $this->mDSN = $this->mUser = $this->mPass = "";
            print "Connection Error: " . $e->getMessage() . "<br/>";
            //die();
        }
    }
    public function Query($query, $value = array()) {
        $ret = array("status"=>false, "result"=>"");
        
        $stmt = $this->mPDO->prepare($query);
        for($i = 0; $i < count($value); $i++) {
            $stmt->bindParam($i + 1, $value[$i]);
        }
        if ($stmt->execute()) {
            $ret['status'] = true;
            $ret['result'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            //while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            //    $ret = $row;
            //}
        }
        
        return $ret;
    }
    public function NonQuery($query, $value = array()) {
        $ret = array("status"=>false, "result"=>"");
        
        $stmt = $this->mPDO->prepare($query);
        for($i = 0; $i < count($value); $i++) {
            $stmt->bindParam($i + 1, $value[$i]);
        }
        $ret['status'] = $stmt->execute();        
        
        return $ret;
    }
    
}
$mPDO = null;
//$host = "mysql:host=localhost;dbname=cdcol";
//$user = "root";
//$pass = "root";
//$dbObj = new CPDO($host, $user, $pass);
//$dbObj->Query("select * from cds where jahr > ?", array('1992'));

?>
