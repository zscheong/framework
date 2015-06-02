<?php

namespace Library\Database;

require_once('resource/php/my/database/prototype/IConnector.php');
require_once('resource/php/my/database/connector/ADOCon.php');
require_once('resource/php/my/database/connector/COMCon.php');

use \Library\Error\ErrorInfo;
use \Library\Database\Prototype\IConnector;
use \Library\Database\Connector\ADOCon;
use \Library\Database\Connector\COMCon;

class DBAgent implements IConnector 
{
    private $mCon;
    private $mMsgPrefix;
    
    public function __construct(IConnector $con) {
        $this->mCon = $con;
        $this->mMsgPrefix = "<br>" . __CLASS__ . ":";
    }
    
    //Extend Methods 
    public function AddRecord($whereClause, $table, $data, $needQuote = true) {
        $mode = "insert";
        $id = "";
        
        //Check Insert or Update
        $queryBefore = "select * from $table where $whereClause";
        $resultBefore = $this->RunQuery($queryBefore);

        if(count($resultBefore) == 0) {
            $id = $this->Insert($whereClause, $table, $data, $needQuote);
        } else {
            $mode = "update"; 
            $id = $this->Update($resultBefore, $whereClause, $table, $data, $needQuote);
        }
        
        $result = array("mode"=>$mode, "id"=>$id);
        return array($result);
    }
    private function Insert($whereClause, $table, $data, $needQuote=true) {
        $fieldList = "";
        $fieldVal = "";
        $query = "insert into " . $table;
        foreach ($data as $field=>$val) {
            //$val = str_replace("'", "\\'", $val);
            $val = addslashes($val);
            $fieldList .= $field . ",";
            $fieldVal .= ($needQuote)?"'" . $val . "',": $val;
        }
        $fieldList = trim($fieldList, ",");
        $fieldVal = trim($fieldVal, ",");
        $nonQuery = "$query ($fieldList) values ($fieldVal)";
        $this->RunNonQuery($nonQuery);

        //Get ID
        $queryAfter = "select id from $table where $whereClause";
        $resultAfter = $this->RunQuery($queryAfter);

        ErrorInfo::Assert(!empty($resultAfter), 'Unable to Insert|Update record, Query: ' . $queryAfter);
        
        return $resultAfter[0]["id"];
    }
    private function Update($result, $whereClause, $table, $data, $needQuote=true) {       
        $fieldUpdate = "";
        $query = "update " .  $table;
        $resultData = $result[0];
        foreach ($data as $field=>$val) {
            if($resultData[$field] === $val) { continue; }
//            $val = str_replace("'", "\\'", $val);
            $val = addslashes($val);
            $fieldUpdate .= ($needQuote)? "$field='$val'," : "$field=$val,";
        }
        $fieldUpdate = trim($fieldUpdate, ",");

        if(!empty($fieldUpdate)) {
            $nonQuery = $query . " Set " . $fieldUpdate . " where $whereClause";
           
            $this->RunNonQuery($nonQuery);
        }
        $id = $resultData["id"];

        return $id;
    }
    
    public function CreateTable($tableName, $query, $version='1.0') {
        $ret = true;
        $query .= " Engine=InnoDB Default Charset=utf8";
        $preVersion = $this->GetTableVersion($tableName, $version);
        if(!$this->CheckTables($tableName)) {
            $status = $this->RunNonQuery($query);           
            if(!$status) {
                echo "<br>" . __NAMESPACE__ . ":" . __FUNCTION__ . "-Created Table Failed: " . $tableName;
                $ret = false;
            } 
        } else {                
            if($preVersion !== $version) {
                $this->DropConstraintTable($tableName);
                $status = $this->RunNonQuery($query);
                if(!$status) {
                    echo "<br>" . __NAMESPACE__ . ":" . __FUNCTION__ . "-Upgrade Table Failed: $tableName";
                    $ret = false;
                }
            }
        }
        return $ret;
    }
    
    private function GetTableVersion($table, $ver='1.0') {
        $ret = $ver;
        $listTableName = "db_TableList";
        $queryCreate = "Create Table " . $listTableName . " (
                        id INT(19) NOT NULL AUTO_INCREMENT,
                        TableName varchar(50) NOT NULL,
                        Version varchar(10) NOT NULL DEFAULT '1.0',
                        CreatedDate datetime NOT NULL,
                        PRIMARY KEY (id)
                    ) Engine=InnoDB Default Charset=utf8";
        
        if(!$this->CheckTables($listTableName)) {
            $this->RunNonQuery($queryCreate);           
            $this->SetTableVersion($table, $ver);
        } else {
            $query = "select version from " . $listTableName . " where TableName=?";
            $result = $this->RunQuery($query, array($table, $ver));
            if(count($result) != 0) { 
                $ret = $result[0]["version"];
                if($ret != $ver) {
                    $this->SetTableVersion($table, $ver, false);
                }
            } else {
                $this->SetTableVersion($table, $ver);
            }
        }
        return $ret;
    }
    private function SetTableVersion($table, $ver='1.0', $isNew=true) {
        $listTableName = "db_Tablelist";
        $queryUpdate = "update " . $listTableName . " set Version=?, CreatedDate=? where TableName=?";
        $queryInsert = "insert into " . $listTableName . " (TableName, Version, CreatedDate) values (?,?,?)";
        
        if($isNew) { 
            $this->RunNonQuery($queryInsert, array($table, $ver, date('Y-m-d H:i:s')));
        } else {
            $this->RunNonQuery($queryUpdate, array($ver, date('Y-m-d H:i:s'), $table));
        }
    }
    public static function DropConstraintTable($tableName) {
        
        $query = "select table_name from information_schema.key_column_usage "
                . "where referenced_table_name = ? and constraint_schema = ?";
        $result = $this->RunQuery($query, array($tableName, $this->GetDBName()));
        
        foreach ($result as $cells) {
            $table = $cells["table_name"];
            $query = "Drop table " . $table;
            $this->RunNonQuery($query);
        }

    }
    public static function GetDBAgent($type, $host, $dbname, $user, $pass) {
        $con = '';
        switch($type) {
            case "vfp":
                $con = new COMCon('vfp', $host);
                break;
            case "mssql":
                $con = new COMCon('mssql', $host, $dbname, $user, $pass);
                break;
            case "mysql":
                $con = new ADOCon($host, $dbname, $user, $pass);
                break;
        }
//        var_dump($con);
        $agent = '';
        if(!empty($con)) {
            $agent = new DBAgent($con);
        }
        
        return $agent; 
    }
    
    //Interface methods
    public function SetDataSource($ds) {
        $this->mCon->SetDataSource($ds);
    }
    public function ConnectDatabase($db) {
        $ret = false;
        if(empty($db)) {
            echo "<br>" . __NAMESPACE__ . ":" . __FUNCTION__ . "- database can't be empty!";
        } else {
            $ret = $this->mCon->ConnectDatabase($db);
        }
        return $ret;
    }
    public function Connect() {
        $this->mCon->Connect();
    }
    public function Close() {
        $this->mCon->Close();
    }
    public function IsConnected() {
        return $this->mCon->IsConnected();
    }
    public function GetConnection() {      
        $this->mCon->GetConnection();
    }
    public function GetErrorMessage() {
        return $this->mCon->GetErrorMessage();
    }
    public function RunNonQuery($query, $param='') {
        $ret = false;
        if(empty($query)) {
            echo "<br>" . __NAMESPACE__ . ":" . __FUNCTION__ . "- query can't be empty!";
        } else {
            $ret = $this->mCon->RunNonQuery($query, $param);
        }
        return $ret;
    }
    public function RunQuery($query, $param='', $rawResult=false) {       
         $ret = array();
        if(empty($query)) {
            echo "<br>" . __NAMESPACE__ . ":" . __FUNCTION__ . "- query can't be empty!";
        } else {
            $ret = $this->mCon->RunQuery($query, $param, $rawResult);
        }
        return $ret;
    }
    public function GetDatabases() {
        return $this->mCon->GetDatabases();
    }
    public function CheckTables($table) {
        $ret = false;
        if(empty($table)) {
            echo "<br>" . __NAMESPACE__ . ":" . __FUNCTION__ . "- table can't be empty!";
        } else {
            $ret = $this->mCon->CheckTables($table);
        }
        return $ret;
    }
    public function GetTables() {
        return $this->mCon->GetTables();
    }
    public function GetColumnsInfo($table) {
        $ret = array();
        if(empty($table)) {
            echo "<br>" . __NAMESPACE__ . ":" . __FUNCTION__ . "- table can't be empty!";
        } else {
            $ret = $this->mCon->GetColumnsInfo($table);
        }
        return $ret;
    } 
    public function GetColumns($table) {
        $ret = array();
        if(empty($table)) {
            echo "<br>" . __NAMESPACE__ . ":" . __FUNCTION__ . "- table can't be empty!";
        } else {
            $ret = $this->mCon->GetColumns($table);
        }
        return $ret;
    }  
    public function GetDBName() {
        return $this->mCon->GetDBName();
    }
}
?>
