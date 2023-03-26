<?php
$ishallgset=$_SESSION["user"]["hallgato"]||isset($_POST["hallgato"])||isset($_SESSION["viewAsHallgato"]);
if($ishallgset||$_SESSION["user"]["oktato"])include_once("../private/include/uraninc/viewAs.php");
if($ishallgset){
    echo "Szak: ".$hallgato["szaknev"]."<br/>";
    echo "Képzés: ".$hallgato["kepzesId"]."<br/>";
    echo "Jelenlegi félév: ".$hallgato["felev"]."<br/>";
    echo "Kreditindex félévenként: <ul>";
    $avgs=sql_select($adatb,"hallgatoja,kurzus",["felveteli_felev","SUM(".sql_col_mkr("erdemjegy")."*".sql_col_mkr("kredit").")/30 AS atlag"],"WHERE ".sql_col_of_table("hallgatoja","kurzuskod")."=".sql_col_of_table("kurzus","kurzuskod")." AND ".sql_col_of_table("hallgatoja","urancode")."='".$hallgato["urancode"]."' AND ".sql_col_of_table("hallgatoja","erdemjegy").">1 GROUP BY ".sql_col_mkr("felveteli_felev"));
    while(($felev = mysqli_fetch_assoc($avgs))!==null){
        echo "<li>".$felev["felveteli_felev"].": ".$felev["atlag"]."</li>";
    }
    mysqli_free_result($avgs);
    echo "</ul>";
}
?>