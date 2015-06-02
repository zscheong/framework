<?php
namespace Library;

if(!defined("_APP_ENTRY_")) {
    header("HTTP 1.0 404 Not Found");
    exit();
}

class ArrayTable {
    private $mTable = array();
    private $mNumRow = 0;
    private $mColumns = array();
    
    public function __construct($table=array()) {
        if(!empty($table)) {
            $this->mTable = $table;
            $this->GetRowsNum();
            $this->GetColumns();
        }
    }
    
    public function InstanceFromArray($array) {
        $table = array();
        
        $this->mColumns = $array[0];
        $this->mNumRow = count($array) - 1;
        for($i = 1; $i < count($array); $i++) {
            for ($j = 0; $j < count($this->mColumns); $j++ ) {
                $table[$i-1][$this->mColumns[$j]] = $array[$i][$j];
            }
        }
        $this->mTable = $table;
    }
    
    //desc: return number of row
    //return: int
    public function GetRowsNum() {
        if($this->mNumRow === 0 && !empty($this->mTable)) {
            $this->mNumRow = count(array_keys($this->mTable));
        }
        return $this->mNumRow;
    }
    
    //desc: return array of columns
    //return: array(column1, column2)
    public function GetColumns() {
        if(empty($this->mColumns) && !empty($this->mTable)) {
            $this->mColumns = array_keys($this->mTable[0]);
        }
	return $this->mColumns;
    }
    
    //desc: return true if column exist
    //return: boolean
    public function IsColumnExist($column) {
        if(empty($this->mColumns)) {
            $this->GetColumns();
        }
       return in_array($column, $this->mColumns);
    }
    
    //desc: return array of value for specific column
    //return: array(valueForRow1, valueForRow2)
    public function GetColumnValue($column, $unique=false) {
        $ret = array();
        if($this->IsColumnExist($column)) {
            for($i = 0; $i <$this->mNumRow; $i++ ){
                if($unique) {
                    if(in_array($this->mTable[$i][$column], $ret)) { 
                        continue; 
                    }
                }
                array_push($ret, $this->mTable[$i][$column]);
            }
        } 
        return $ret;
    }
    
    //desc: return array of row that match the specific value
    //return: array(row1, row2)
    public function GetRowByValue($value) {
        if(empty($this->mTable)) { return array(); }
        $ret = array();
        for($i = 0; $i < count($this->mTable); $i++) {
            $buffer = array_search($value, $this->mTable[$i]);
            if($buffer) {
                array_push($ret, $this->mTable[$i]);
            }
        }
        return $ret;
    }
    
    //target: return array of row that match specific column and value
    //return: array(row1, row2)
    public function GetRowByColValue($keyValue) {
        //$keyValue format -- array($column=>$value)
        if(empty($this->mTable)) { return array(); }
        $ret = array();
        foreach (array_keys($keyValue) as $k) {
            if(!$this->IsColumnExist($k)) { unset($keyValue[$k]); }
        }

        for($i = 0; $i < count($this->mTable); $i++) {
            foreach ($keyValue as $key=>$value) {
                if($this->mTable[$i][$key] === $value) {
                    array_push($ret, $this->mTable[$i]);
                    break;
                }
            }
        }
        //$ret format -- $row=>$column=>$value
        return $ret;
    }
    
    //target: return value for specific row and column
    //return: string|int
    public function GetValue($row, $col) {
        $ret = "";
        if(isset($this->mTable[$row][$col])) {
            $ret = $this->mTable[$row][$col];
        }
        return $ret;
    }
    
    //target: return the specific row
    //return: row<array(col1=>value1, col2=>value2)>
    public function GetRow($row) {
        if(!is_numeric($row) || $row > $this->mNumRow || empty($this->mTable)) {
            return array();
        }
        
        return $this->mTable[$row];
    }
    
    //target: return the table
    //return: array(row=>array(column=>value))
    public function GetTable() {
        if(empty($this->mTable)) {
            return array();
        }
        
        return $this->mTable;
    }
    public function __destruct() {
        if(isset($this->mDBResult)) {
            unset($this->mDBResult);
        }
    }
}

?>
