<?php
$ishallgset=$_SESSION["user"]["hallgato"]||isset($_POST["hallgato"])||isset($_SESSION["viewAsHallgato"]);
if($ishallgset||$_SESSION["user"]["oktato"])include_once("../private/include/uraninc/viewAs.php");
if($ishallgset) {
    $teljesitetttargyak=sql_select($adatb,"kurzus,hallgatoja",["kurzus.nev","kurzus.kurzuskod","felveteli_felev","MAX(".sql_col_mkr("hanyadjara").") AS hany","kredit","erdemjegy"],"WHERE ".sql_col_of_table("kurzus","kurzuskod")."=".sql_col_of_table("hallgatoja","kurzuskod")." AND ".sql_col_of_table("hallgatoja","erdemjegy").">1 AND ".sql_col_of_table("hallgatoja","urancode")."='".$hallgato["urancode"]."' GROUP BY ".sql_col_of_table("hallgatoja","kurzuskod"));
    echo "Teljesített tárgyak:<table><thead><tr><th>Tárgy neve</th><th>Tárgy kódja</th><th>Teljesítés féléve</th><th>Hanyadjára</th><th>Kredit</th><th>Érdemjegy</th></tr></thead><tbody>";
    while(($targy = mysqli_fetch_assoc($teljesitetttargyak))!==null){
        echo "<tr><td>".$targy["nev"]."</td><td>".$targy["kurzuskod"]."</td><td>".$targy["felveteli_felev"]."</td><td>".$targy["hany"]."</td><td>".$targy["kredit"]."</td><td>".$targy["erdemjegy"]."</td></tr>";
    }
    mysqli_free_result($teljesitetttargyak);
    echo "</tbody></table>";
}

?>