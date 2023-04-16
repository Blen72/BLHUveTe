<?php
ob_start();//header miatt
session_start();
include_once("../private/include/func.php");
include_once "../private/include/sqlhelper.php";
if(isset($_SESSION["user"])){
    if(empty($_SESSION["user"]["uransession"]))$_SESSION["user"]["uransession"]=[];
    if(isset($_POST["toshow"]))$_SESSION["user"]["uransession"]["toshow"]=$_POST["toshow"];
    //var_dump($_SESSION["user"]["uransession"]);
    //if(isset($_SESSION["viewAsHallgato"]))var_dump($_SESSION["viewAsHallgato"]);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Disznóvágási Ferenc">
    <title>Uran</title>
    <link rel="stylesheet" href="css/main.css">
    <style>
        h4{
            margin-bottom: 0;
        }
        .noStyle{
            border: none;
            background-color: unset;
            color: inherit;
            cursor: inherit;
            width: 100%;
            padding: 0;
        }
    </style>
</head>
<body>
<div id="headernav">
    <header><h1>Uran</h1></header>
    <form action="UranIndex.php" method="post" style="margin: 0">
        <nav><a href="index.php">Elosztó</a><?php include_once("../private/include/uraninc/uranincmenu.php"); ?></nav>
    </form>
</div>
<?php
function print_selectElement($adatb,$table,$col,$selName,$canBeNull=false){
    echo "<select name='".$selName."'>";
    if($canBeNull)echo "<option value=''>-</option>";
    $tablerows=sql_select($adatb,$table,[$col]);
    oci_execute($tablerows);
    while($row = oci_fetch_assoc($tablerows)){
        echo "<option value='".$row[sql_col_mkr($col)]."'>".$row[sql_col_mkr($col)]."</option>";
    }
    oci_free_statement($tablerows);
    echo "</select>";
}

function updateArrayHelper($arr){
    $ret=[];
    for($i=0;$i<count($arr);$i+=2){
        if($arr[$i+1]!=="")$ret+=[$arr[$i]=>$arr[$i+1]];
    }
    return $ret;
}

if(isset($_SESSION["user"])){
    $adatb=db_open();
    echo "<p>Az Uran kódod: ".$_SESSION["user"]["urancode"]."</p>";
    error_reporting(E_ERROR | E_PARSE);
    
    if(isset($_SESSION["user"]["uransession"]["toshow"]))include_once("../private/include/uraninc/".$_SESSION["user"]["uransession"]["toshow"]);
    db_close($adatb);
}
ob_flush();
?>
</body>
</html>