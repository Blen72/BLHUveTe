<?php
const DBNAME="blhuvete";

function db_open(){
    $adatb = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
    return $adatb;
}

function db_close($adatb){
    oci_close($adatb);
}

//Oracle MySQL váltás BEG
function sql_col_mkr($col){
    if($col=="*")return $col;
    if(str_contains($col,"("))return $col;//TODO: SUM(asd) -> SUM(...)
    if(str_contains($col,"."))$col=sql_col_of_table(explode(".",$col)[0],explode(".",$col)[1]);
    return '"'.$col.'"';//MySQL: $col; Oracle: '"'.$col.'"';
}

function sql_table_mkr($table){
    $tables=explode(",", $table);
    foreach($tables as &$t)$t='"'.$t.'"';//MySQL: $t; Oracle: '"'.$t.'"';
    return implode(",", $tables);
}

function sql_col_of_table($table,$col){
    return sql_table_mkr($table).".".sql_col_mkr($col);
}
//Oracle MySQL váltás END

function sql_subselect_mkr($table,$cols,$whereetc="",$distinct=false){
    $table=sql_table_mkr($table);
    foreach($cols as &$col)$col=sql_col_mkr($col);
    return "SELECT ".($distinct?"DISTINCT ":"").implode(",",$cols)." FROM ".$table." ".$whereetc;
}

//ORACLE VERSION
/*


*/

//MYSQL VERSION
/**/
function sql_insert($adatb,$table,$cols,$types,$args){
    $table=sql_table_mkr($table);
    foreach($cols as &$col)$col=sql_col_mkr($col);
    $sql=mysqli_prepare( $adatb,"INSERT INTO ".$table."(".implode(",", $cols).") VALUES (".implode(",",str_split(str_repeat("?",count($cols)))).")");
    mysqli_stmt_bind_param($sql,$types,...array_values($args));
    return mysqli_stmt_execute($sql);
}

function sql_select($adatb,$table,$cols,$whereetc="",$distinct=false){
    $table=sql_table_mkr($table);
    foreach($cols as &$col)$col=sql_col_mkr($col);
    $sel="SELECT ".($distinct?"DISTINCT ":"").implode(",",$cols)." FROM ".$table." ".$whereetc;
    $stid = oci_parse($adatb, $sel);
    return $stid;
}

function sql_delete($adatb,$table,$whereetc){
    $table=sql_table_mkr($table);
    return mysqli_query($adatb, "DELETE FROM ".$table." ".$whereetc);
}

function sql_update($adatb,$table,$setKeyVal,$whereetc){
    $table=sql_table_mkr($table);
    $set=[];
    foreach($setKeyVal as $setKey=>$setVal){
        $set[]=sql_col_mkr($setKey)."='".$setVal."'";
    }
    return mysqli_query($adatb, "UPDATE ".$table." SET ".implode(",", $set)." ".$whereetc);
}

function print_sql($adatb,$table,$cols,$whereetc="",$headeractions="",$rowactions=[]){
    $table=sql_table_mkr($table);
    foreach($cols as &$col)$col=sql_col_mkr($col);
    echo "<table><thead><tr>";
    foreach($cols as $e){
        echo "<th>".substr($e, !str_contains($e, ".")?0:strpos($e,".")+1)."</th>";
    }
    echo $headeractions."</tr></thead>";
    $table=sql_select($adatb,$table,$cols,$whereetc);
    while(($row = mysqli_fetch_assoc($table))!==null){
        echo "<tr>";
        foreach($row as $attr)echo "<td>".$attr."</td>";
        foreach($rowactions as $ra){
            if(is_array($ra[1])){
                for($i=0;$i<count($ra[1]);$i++)$ra[1][$i]=$row[$ra[1][$i]];
                echo "<td><button type='submit' name='".$ra[0]."' value='".implode(",", $ra[1])."'>".$ra[2]."</button></td>";
            } else {
                echo "<td><button type='submit' name='".$ra[0]."' value='".$row[$ra[1]]."'>".$ra[2]."</button></td>";
            }
        }
        echo "</tr>";
    }
    mysqli_free_result($table);
    echo "</table>";
}
/**/

?>