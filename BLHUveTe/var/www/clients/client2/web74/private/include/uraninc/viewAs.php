<?php
$hallgato=$_SESSION["user"];
$self=$hallgato["urancode"];
//echo("ASD:".$_SESSION["viewAsHallgato"]);
if(isset($_POST["hallgato"])||isset($_SESSION["viewAsHallgato"])){
    $hallgatoSql=sql_select($adatb,"hallgato,szak",["*"],"WHERE ".sql_col_of_table("hallgato","urancode")."='".($_POST["hallgato"] ?? $_SESSION["viewAsHallgato"])."' AND ".sql_col_of_table("hallgato","szakkod")."=".sql_col_of_table("szak","szakkod"));
    $hallgato=mysqli_fetch_assoc($hallgatoSql);
    mysqli_free_result($hallgatoSql);
    echo "<p>Őt szerkeszted: ".$hallgato["urancode"]."(".$hallgato["nev"].")</p>";
    $_SESSION["viewAsHallgato"]=$hallgato["urancode"];
}
$self=$self==$hallgato["urancode"];
?>