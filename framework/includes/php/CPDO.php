<?php

namespace includes\php;

class CPDO {
    private $mPDO = null;
    private $mDSN = "";
    private $mUser = "";
    private $mPass = "";
    private $mError = "";
    
    public function __construct() {
    }
    public function __destruct() {
        if(!empty($this->mPDO)) { $this->mPDO = null; }
    }
    public function connect($dsn, $user, $pass) {
        $ret = false;
        try {
            $this->mDSN = $dsn;
            $this->mUser = $user;
            $this->mPass = $pass;
            $this->mPDO = new \PDO($dsn, $user, $pass);
            $ret = true;
        } catch (\PDOException $e) {
            $this->mPDO = null;
            $this->mDSN = $this->mUser = $this->mPass = "";
            $this->mError = "DB Connection Error: " . $e->getMessage();
        }
        return $ret;
    }
    public function query($query, $value = array()) {
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
    public function nonQuery($query, $value = array()) {
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
