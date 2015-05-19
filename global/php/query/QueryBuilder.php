<?php

namespace Library\Query;

class QueryBuilder {
    private $mColumns = array();
    private $mMasterTable = "";
    private $mTableList = array();
    private $mTableStack = array();
    
    private $mFilterStack = array();
    private $mOrderStack = array();
    
    public function __construct($table) {
        $this->mMasterTable = $table;
        array_push($this->mTableList, $table);
    }
    
    public function AssignSelectColumns($data) {
        //data format -- array("table|column" => $label)
        foreach(array_keys($data) as $key) {
            $table = explode("|", $key)[0];
            if(!in_array($table, $this->mTableList)) { return; }
        }
        
        $this->mColumns = $data;
    }
    
    public function AssignTable($table, $criteria, $join="left join") {
        //criteria format -- array("table1"=>"id", "table2"=>"id2")
        if($table === $this->mMasterTable) { return; }
        if(!in_array($table, $this->mTableList)) {
            array_push($this->mTableList, $table);
            $this->mTableStack[$table] = array("criteria", "join");
        }
//        var_dump($criteria);
        $tableJoin = array_keys($criteria);
        foreach ($tableJoin as $tab) { 
            if(!in_array($tab, $this->mTableList)) { return; }
        }
        
        $this->mTableStack[$table]["criteria"] = $criteria;
        $this->mTableStack[$table]["join"] = $join;
    }
    
    public function AssignFilter($condition, $join = "and") {
        //$condition format -- string "$column $exp $values"
        $this->mFilterStack[$condition] = $join; 
    }
    public function AssignOrder($column, $asc=true) {
        //$column format -- table.column
        $this->mOrderStack[$column] = $asc;
    }
    
    public function CreateQuery($offset=0, $limit=100) {
        $colStr = $this->GetColumns();
        $tableStr = $this->GetTables();
        $filterStr = $this->GetFilters();
        $order = $this->GetOrders();
        
        $ret = "select $colStr from $tableStr";
        
        if(!empty($filterStr)) { $ret .= " where $filterStr"; }
        if(!empty($order)) { $ret .= " $order"; }
        if(!empty($limit)) { $ret .= " limit $offset,$limit"; } 
//        var_dump($ret);
        return $ret;
    }
    
    private function GetColumns() {
        $ret = "";
        foreach ($this->mColumns as $key=>$value) {
            $comp = explode("|", $key);
            $col = "`$comp[0]`.$comp[1]";
            if(!empty($value)) { $col .= " as '$value'"; }
            $ret .= $col . ",";
        }
        $ret = trim($ret, ",");
        return $ret;
    }
    private function GetTables() {
        $ret = $this->mMasterTable;
        foreach ($this->mTableStack as $table=>$value) {
            $join = $value["join"];
            $criteria = $value["criteria"];
            $tab = array_keys($criteria);
            $criteriaStr = "`$tab[0]`." . $criteria[$tab[0]] . "=`$tab[1]`." . $criteria[$tab[1]];
            $ret .= " $join $table on $criteriaStr";
        }
        return $ret;
    }
    private function GetFilters() {
        $ret = "";
        foreach ($this->mFilterStack as $cond=>$join) {
            $ret .= ($ret === "") ? $cond : "$join $cond";
        }
        return $ret;
    }
    private function GetOrders() {
        $ret = "";
        foreach ($this->mOrderStack as $col=>$asc) {
            $dir = ($asc)? "asc" : "desc";
            $ret .= (empty($ret))? "order by $col $dir": ", $col $dir";
        }
        return $ret;
    }
}

?>
