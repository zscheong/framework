<?php

namespace Library\Database\Connector;

require_once('resource/php/lib/adodb/adodb-exceptions.inc.php');
require_once('resource/php/lib/adodb/adodb.inc.php');
require_once('resource/php/my/database/prototype/IConnector.php');
require_once('resource/php/my/table/ArrayTable.php');

use \Library\Table\ArrayTable;
use \Library\Database\Prototype\IConnector;

class ADOCon implements IConnector
{
    private $mHost;
    private $mDBName;
    private $mUserName;
    private $mPass;
    
    private $mConn;
    
    private $mIsConnected = false;
    private $mMsg;
    private $mType = 'mysql';
    private $mDebug = false;
    
    public function __construct($host='', $dbName='', $userName='', $pass='') {
        $dataSource = array("Host"=>$host, "DBName"=>$dbName, "UserName"=>$userName, "Pawd"=>$pass);
        $this->SetDataSource($dataSource);
    }
    public function SetDataSource($ds) {
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
    public function Connect() {
       
        if(!empty($this->mMsg)) {
//            echo "<br>Unable to Establish Connection as " . $this->mMsg;
            return;
        }
        
        try {
            $this->mConn = ADONewConnection($this->mType);        
            $this->mConn->PConnect($this->mHost, $this->mUserName, $this->mPass, $this->mDBName);
            $this->mIsConnected = true;
            $this->mMsg = '';
        } catch (\Exception $e) {
            $this->mIsConnected = false;
            $this->mMsg = $e->getMessage();
            //echo "Hiiii<br>" . __FUNCTION__ ."-" . $e->getMessage();
        }
    }
//    public function TryConnect($type = 'mysql') {
//        global $log;
//        $this->mDBObj = ADONewConnection($type);
//        $status = $this->mDBObj->PConnect($this->mHost, $this->mUserName, $this->mPasswd, $this->mDBName);
//        
//        $create_db = true;
//        if(!$status && $create_db) {
//            $this->mDBObj = ADONewConnection($type);
//            $status = $this->mDBObj->PConnect($this->mHost, $this->mUserName, $this->mPasswd);
//            if($status) {
//                $dict = NewDataDictionary($this->mDBObj);
//                $sql = $dict->CreateDatabase($this->mDBName);
//                if($status = ($dict->ExecuteSQLArray($sql) == 2)) {
//                    $status = $this->mDBObj->PConnect($this->mHost, $this->mUserName, $this->mPasswd, $this->mDBName);
//                    echo "Succesfully Create and Connect to Database, Host:" . $this->mHost . " Database:" . $this->mDBName;
//                }
//                else {
//                    echo  str_repeat("!", 5) . "Unable to Create the Database: " . $this->mDBName;
//                    exit;
//                }
//            }
//        } else {
//            if($this->mDebug) {
//                echo "Establish Database Connection, Host:" . $this->mHost . " Database:" . $this->mDBName;
//            }
//        }
//    }
    public function GetErrorMessage() {
        return $this->mMsg;
    }
    public function IsConnected() {
        return $this->mIsConnected;
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
            //mysql_close($this->mConn);
            $this->mConn->disconnect();
            $this->mConn = '';
            $this->mIsConnected = false;
        }
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
    public function RunNonQuery($query, $params = '') {
        //$params is one dimension array
        if(!$this->mIsConnected) {
            $this->GetConnection();
        }
        
        $status = NULL;
        //$logParams = '';
        try {
            if(empty($params)) {
                $status = $this->mConn->Execute($query);
            } else {
                $status = $this->mConn->Execute($query, $params);
                //$logParams = join(",", $params);
            }
        } catch (exception $e) {
           echo "<br>" . __FUNCTION__ ."-" . $e->getMessage() . "<br>Query: $query";
        }
        
        return $status;
    }
    public function RunQuery($query, $params = '', $rawQuery=false) {
        //$params is one dimension array
        if(!$this->mIsConnected) {
//            var_dump("connect...");
            $this->GetConnection();
        }
       
        $result = NULL;
        //$logParams = '';
        try {
            if(empty($params)) {
                $result = $this->mConn->Execute($query);
            } else {
//                var_dump($this->mConn);
                $result = $this->mConn->Execute($query, $params);
                //$logParams = join(",", $params);
                
            }
        } catch (Exception $e) {
            echo "<br>" . __FUNCTION__ ."-" . $e->getMessage() . "<br>Query: $query";
            return array();
        }
        //var_dump($result);
        if($rawQuery) { return $result; }
        $ret = $this->ReadResult($result);
        
        return $ret;
    }
    private function ReadResult($result) {
        $ret = array();
        try {
            if(empty($result)) { return $ret; }
            $numRow = $result->RecordCount();
            for($i = 0; $i<$numRow; $i++) {
                $rowData = array_change_key_case($result->GetRowAssoc(False));
                $ret[$i] = $rowData;
                $result->MoveNext();
            }       
        } catch (Exception $e) {
             echo "<br>" . __FUNCTION__ ."-" . $e->getMessage();
        }
        return $ret;
    }
    public function GetDatabases() {
        $ret = $this->RunQuery("select schema_name as 'database' from INFORMATION_SCHEMA.SCHEMATA order by schema_name");
        
        return $ret;
    } 
    public function CheckTables($table) {
        $result = $this->RunQuery("select table_name from information_schema.tables "
                . "where table_schema=? and table_name=?", array($this->mDBName, $table));
        $ret = (count($result) != 0)? true : false;
     
        return $ret;
    }
    public function GetTables() {
        $ret = array();
        $ret = $this->RunQuery("select table_name from information_schema.tables "
                . "where table_schema=? order by table_name", array($this->mDBName));
        return $ret;
    } 
    public function GetColumnsInfo($table) {
        $query = "select column_name, data_type from information_schema.columns where table_schema=? and table_name=? order by column_name";
        $ret = $this->RunQuery($query, array($this->mDBName, $table));
       
        return $ret;
    }
    public function GetColumns($table) {
        $columnInfo = $this->GetColumnsInfo($table);
        $table = new ArrayTable($columnInfo);
        $ret = $table->GetColumnValue('column_name');
        return $ret;
    }
    public function GetDBName() {
        return $this->mDBName;
    }
}

//if(!isset($adoCon)) {
//************************Connect to MySQL***************************************
//    $adoCon = new ADOCon('mysql', 'localhost:3306', 'vtigercrm540', 'root', 'root');
//    $adoCon->Connect();
//    $ret = $adoCon->GetColumns('vtiger_account');
//    $ret = $adoCon->GetDatabases();
//    $table = new ArrayTable($ret);
//    var_dump($table->GetTable());
//    var_dump($table->GetColumnValue("database")); 
 //**********************************************************************************/
    
//    $adoCon = new ADOCon('mssql', 'localhost\A2006', '', 'SA', 'oCt2005-ShenZhou6_A2006');
//    $adoCon->Connect();
//    $ret = $adoCon->GetDatabases();
//    var_dump($ret);
//}

//$myServer = "localhost\A2006";
//$myUser = "SA";
//$myPass = "oCt2005-ShenZhou6_A2006";
//$myDB = "AED_getha"; 
//
////create an instance of the  ADO connection object
//$conn = new \COM("ADODB.Connection")
//  or die("Cannot start ADO");
//
////define connection string, specify database driver
//$connStr = "PROVIDER=SQLOLEDB;SERVER=".$myServer.";UID=".$myUser.";PWD=".$myPass.";DATABASE=$myDB"; 
//  $conn->open($connStr); //Open the connection to the database
//
////declare the SQL statement that will query the database
//$query = "select * from sys.databases";
////execute the SQL statement and return records
//$result = $conn->Execute($query);
//
//$num_columns = $result->Fields->Count();  
//
//$ret = array(); $row=0;
//while(!$result->EOF) {
//    for($i=0; $i<$num_columns; $i++) {
//        $field_name = $result->Fields($i)->name;
//      
//        $ret[$row][$field_name] = trim($result->Fields($i)->value);
//    }
//    $result->MoveNext();
//    $row++;
//}
//var_dump($ret);

?>