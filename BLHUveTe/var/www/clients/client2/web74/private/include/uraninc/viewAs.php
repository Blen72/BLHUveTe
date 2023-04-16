<?php
$hallgato=$_SESSION["user"];
$self=$hallgato["urancode"];
//echo("ASD:".$_SESSION["viewAsHallgato"]);
if(isset($_POST["hallgato"])||isset($_SESSION["viewAsHallgato"])){
    $hallgatoSql=sql_select($adatb,"Hallgato,Szak",["*"],"WHERE ".sql_col_of_table("Hallgato","urancode")."='".($_POST["hallgato"] ?? $_SESSION["viewAsHallgato"])."' AND ".sql_col_of_table("Hallgato","szakkod")."=".sql_col_of_table("Szak","szakkod"));
    oci_execute($hallgatoSql);
    $hallgato=oci_fetch_assoc($hallgatoSql);
    oci_free_statement($hallgatoSql);
    echo "<p>Őt szerkeszted: ".$hallgato["urancode"]."(".$hallgato["nev"].")</p>";
    $_SESSION["viewAsHallgato"]=$hallgato["urancode"];
}
$self=$self==$hallgato["urancode"];
?>