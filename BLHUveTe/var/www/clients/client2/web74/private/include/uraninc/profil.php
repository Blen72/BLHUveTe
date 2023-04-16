<?php
$ishallgset=$_SESSION["user"]["hallgato"]||isset($_POST["hallgato"])||isset($_SESSION["viewAsHallgato"]);
if($ishallgset||$_SESSION["user"]["oktato"])include_once("../private/include/uraninc/viewAs.php");
if($ishallgset){
    $sql = "SELECT \"Szak\".\"szaknev\", \"Kepzes\".\"nev\", \"felev\" FROM \"Szak\", \"Kepzes\", \"Hallgato\" WHERE \"Szak\".\"szakkod\" = \"Hallgato\".\"szakkod\" AND \"Kepzes\".\"kepzesId\" = \"Hallgato\".\"kepzesId\"";
    $stid = oci_parse($adatb, $sql);
    oci_execute($stid);
    $row = oci_fetch_array($stid);
    echo "Szak: ".$row[0]."<br/>";
    echo "Képzés: ".$row[1]."<br/>";
    echo "Jelenlegi félév: ".$row[2]."<br/>";
    echo "Kreditindex félévenként: <ul>";
    $avgs=sql_select($adatb,"Hallgatoja,Kurzus",["felveteli_felev","SUM(".sql_col_mkr("erdemjegy")."*".sql_col_mkr("kredit").")/30 AS atlag"],"WHERE ".sql_col_of_table("Hallgatoja","kurzuskod")."=".sql_col_of_table("Kurzus","kurzuskod")." AND ".sql_col_of_table("Hallgatoja","urancode")."='".$hallgato["urancode"]."' AND ".sql_col_of_table("Hallgatoja","erdemjegy").">1 GROUP BY ".sql_col_mkr("felveteli_felev"));
    oci_define_by_name($avgs, "ATLAG", $total);
    oci_execute($avgs);
    while($felev = oci_fetch_assoc($avgs)){
        echo "<li>".$felev["felveteli_felev"].": ".$total."</li>";
    }
    oci_free_statement($avgs);
    echo "</ul>";
}
?>