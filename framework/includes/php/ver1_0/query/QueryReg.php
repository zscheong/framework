<?php

namespace Library\Query;

class QueryReg {
    public static function GetQueryTable($query) {
        $match1= array();
        $match2 = array();
        $allTable = array();
        preg_match_all("/from\s+(\S+)/i", $query, $match1);
        preg_match_all("/join\s+([^\(]\S+)/i", $query, $match2);
        
        foreach (array_merge($match1[1], $match2[1]) as $table) {
            if(!in_array($table, $allTable)) {
                $allTable[] = $table;
            }
        }
        return $allTable;
    }
}

?>
