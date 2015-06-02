<?php

namespace Library\Database\Connector;

require_once('resource/php/my/table/ArrayTable.php');
require_once('resource/php/my/database/prototype/IConnector.php');

use \Library\Table\ArrayTable;
use \Library\Database\Prototype\IConnector;

class COMCon implements IConnector
{
    private $mProvider = '';
    private $mConnStr;
    
    private $mMsg;
    private $mConn;
    private $mIsConnected = false;
    
    private $mType = 'vfp';
    private $mHost;
    private $mUserName;
    private $mPass;
    private $mDBName;
    
    public function __construct($type, $host='', $dbName='', $userName='', $pass='') {
        if($type === 'vfp') {
            
            $this->mType = $type;
            $this->mProvider = 'Provider=VFPOLEDB.1';
        } else if ($type === 'mssql') {
            
            $this->mType = $type;
            $this->mProvider = 'Provider=SQLOLEDB';
        }
        $dataSource = array("Host"=>$host, "DBName"=>$dbName, "UserName"=>$userName, "Pawd"=>$pass);
//        var_dump($dataSource);
        $this->SetDataSource($dataSource);
    }
    public function SetDataSource($ds) {
        if($this->mType === 'vfp') {
            if(!isset($ds["Host"]) || empty($ds["Host"])) {
                $this->mMsg = "Data Source can't be Empty!";
            } else {
                $this->mHost = $ds["Host"];
                $this->mMsg = '';                
            }
        } else if($this->mType === 'mssql') {
            $statusHost = (!isset($ds["Host"]) || empty($ds["Host"]));
            $statusUser = (!isset($ds["UserName"]) || empty($ds["UserName"]));
            $statusPawd = (!isset($ds["Pawd"]) || empty($ds["Pawd"]));
            if($statusHost || $statusUser || $statusPawd) {
                $this->mMsg = "Data Source can't be Empty!";
            } else {
                $this->mHost = $ds["Host"];
                $this->mDBName = $ds["DBName"];
                $this->mUserName = $ds["UserName"];
                $this->mPass =$ds["Pawd"];

                $this->mMsg = '';
            }
        }
    }
    public function Connect() {
        if(!empty($this->mMsg)) {
            //echo "<br>Unable to Establish Connection as " . $this->mMsg;
            return;
        }
        try {
            $this->mConn = new \COM("ADODB.Connection");
            if($this->mType === 'vfp') {
                $this->mConnStr = "$this->mProvider;Data Source=$this->mHost;Collate=general;";
                
            } else if($this->mType === 'mssql') {
                $this->mConnStr = "$this->mProvider;Server=$this->mHost;UID=$this->mUserName;PWD=$this->mPass;";
                $this->mConnStr .= (empty($this->mDBName))?"":"DATABASE=$this->mDBName;";
            }   
            //var_dump($this->mConnStr);
            $this->mConn->Open($this->mConnStr);
            $this->mMsg = '';
            $this->mIsConnected = true;
        } catch(\Exception $e) {
            $m = array();
            preg_match('/.*\<b\>Description:\<\/b\>(.*)\' in.*/',$e, $m); 
            //echo "<br>" .__FUNCTION__ . "-$m[1]";
            $this->mMsg = $m[1];
            $this->mIsConnected = false;
        }
    }
    public function ConnectDatabase($db) {
        $this->mDBName = $db;
        $this->Connect();
        if($this->mIsConnected) {
            return true;
        } else {
            return false;
        }
    }
    public function Close() {
        if(!empty($this->mConn) && $this->mIsConnected) {
            $this->mConn->Close();
            $this->mConn = '';
            $this->mIsConnected = false;
        }
    }
    public function GetErrorMessage() {
        return $this->mMsg;
    }
    public function IsConnected() {
        return $this->mIsConnected;
    }
    public function __destruct() {
        if($this->mIsConnected) {
            $this->Close();
        }
    }
    public function GetConnection() {
        if(!$this->mIsConnected) {
            $this->Connect();
        }
    }
    public function RunNonQuery($query, $params='') {
        if(!$this->mIsConnected) {
            $this->GetConnection();
        }
        try {
            if(empty($params)) {
                $this->mConn->Execute($query);
            } else {
                foreach ($params as $param) {
                    $query = preg_replace('/\?/', "'$param'", $query);
                }
                $this->mConn->Execute($query, $params);
            }
        } catch (exception $e) { 	
            echo "<br>" . __FUNCTION__ ."-" . $e->getMessage() . "<br>Query: $query";
            return false;
        }
        return true;
    }
    public function RunQuery($query, $params='', $rawResult=false) {
        if(!$this->mIsConnected) {
            $this->GetConnection();
        }
        $result = null;
        try {
            if(empty($params)) {
                $result = $this->mConn->Execute($query);
            } else {
                foreach ($params as $param) {
                    $query = preg_replace('/\?/', "'$param'", $query);
                }
                $result = $this->mConn->Execute($query);
            }
        } catch (exception $e) { 	
            echo "<br>" . __FUNCTION__ ."-" . $e->getMessage() . "<br>Query: $query";
            return array();
        }
        if($rawResult) { return $result; }
        $ret = $this->ReadResult($result);
        return $ret;
    }
    private function ReadResult($result) {
        
        $num_columns = $result->Fields->Count();
        $row = 0;
        $ret = array();
        while(!$result->EOF) {
            for($i=0; $i<$num_columns; $i++) {
                $field_name = $result->Fields($i)->name;
                $ret[$row][$field_name] = trim($result->Fields($i)->value);
            }
            $result->MoveNext();
            $row++;
        }
        return $ret;
    }
    public function GetDatabases() {
        if($this->mType !== 'mssql') {
            return array();
        }
        $query = "select name as 'database' from sys.databases where sys.databases.database_id>4 order by name";
        $ret = $this->RunQuery($query);
        return $ret;
    }
    public function CheckTables($table) {
       $ret = false;
       if($this->mType === 'vfp') {
           foreach (glob("$this->mHost/*.dbf") as $table) {
               $a = basename($table, ".dbf");
               if($a == $table) { 
                   $ret = true;
                   break;
               }
           }        
       } else if($this->mType === 'mssql') {
           $query = "select table_name from information_schema.tables where table_name=?";
           $result = $this->RunQuery($query, array($table));
           $ret = (count($result) != 0)? true: false;
       }
       return $ret;
    }
    private function GetTypeInfo($typeNumber) {
        $ret = '';
        switch($typeNumber) {
            case 11: 
                $ret = 'Boolean'; break;
            case 129:
                $ret = 'Char'; break;
            case 131:
                $ret = 'Decimal'; break;
            case 133:
                $ret = 'Date'; break;
            case 134:
                $ret = 'Time'; break;
            case 135:
                $ret = 'DateTime'; break;
            default:
                $ret = "Unknown($typeNumber)"; break;
        }
        return $ret;
    }
    public function GetColumnsInfo($table) {
        $ret = array(); 
        if($this->mType === 'vfp') {
            $result = $this->RunQuery("select top 1 * from $table order by 1", '', true);
            $num_columns = $result->Fields->Count();
//            com_print_typeinfo($result);

            for($i=0; $i<$num_columns; $i++) {
                $fieldObj = $result->Fields($i);

                $field_name = $fieldObj->name;
                $field_type = $this->GetTypeInfo($fieldObj->type);
                $ret[] = array("column_name"=>$field_name, "data_type"=>$field_type);
            }
        } else if($this->mType === 'mssql') {            
            $query = "select column_name, data_type from information_schema.columns where table_name=?";
            $ret = $this->RunQuery($query, array($table));   
        }
        return $ret;
    }
    public function GetColumns($table) {
        $columnInfo = $this->GetColumnsInfo($table);
        $table = new ArrayTable($columnInfo);
        $ret = $table->GetColumnValue('column_name');
        return $ret;
    }
    public function GetTables() { 
       $ret = array();
       if($this->mType === 'vfp') {
           foreach (glob("$this->mHost/*.dbf") as $table) {
               $a = basename($table, ".dbf");
               $ret[] = array("table_name" => $a);
           }        
       } else if($this->mType === 'mssql') {
           $query = "select table_name from information_schema.tables order by table_name";
           $ret = $this->RunQuery($query);
       }
       return $ret;
    }

    public function GetDBName() {
        return $this->mDBName;
    }
    
}

//if(!isset($comCon)) {
////    $comCon = new COMCon('vfp','C:\UBSSTK90\DATA');
////    $comCon->Connect();
////    $ret = $comCon->GetColumns('arcust');
////    var_dump($ret);
//    $comCon = new COMCon('mssql', 'localhost\A2006', 'AED_GETHA_0', 'SA', "oCt2005-ShenZhou6_A2006");
//    $comCon->Connect();
//    $ret = $comCon->GetColumns("do");
//    var_dump($ret);
//}

?>
