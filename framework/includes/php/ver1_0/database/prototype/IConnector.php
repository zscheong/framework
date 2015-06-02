<?php

namespace Library\Database\Prototype;

interface IConnector {
    public function SetDataSource($ds);
    public function ConnectDatabase($db);
    public function Connect();
    public function Close();
    public function GetConnection();
    public function RunNonQuery($query, $param='');
    public function RunQuery($query, $param='', $rawResult=false);
    public function GetDatabases();
    public function GetColumns($table);
    public function GetColumnsInfo($table);
    public function CheckTables($table);
    public function GetTables();
    public function GetDBName();
    public function IsConnected();
    public function GetErrorMessage();
}

?>
