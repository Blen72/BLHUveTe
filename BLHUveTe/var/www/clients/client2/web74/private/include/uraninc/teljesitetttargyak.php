<?php
$ishallgset=$_SESSION["user"]["hallgato"]||isset($_POST["hallgato"])||isset($_SESSION["viewAsHallgato"]);
if($ishallgset||$_SESSION["user"]["oktato"])include_once("../private/include/uraninc/viewAs.php");
if($ishallgset) {
    $teljesitetttargyak=sql_select($adatb,"kurzus,hallgatoja",["kurzus.nev","kurzus.kurzuskod","felveteli_felev","MAX(hanyadjara) AS hany","kredit","erdemjegy"],"WHERE kurzus.kurzuskod=hallgatoja.kurzuskod AND hallgatoja.erdemjegy>1 AND hallgatoja.urancode='".$hallgato["urancode"]."' GROUP BY hallgatoja.kurzuskod");
    echo "Teljesített tárgyak:<table><thead><tr><th>Tárgy neve</th><th>Tárgy kódja</th><th>Teljesítés féléve</th><th>Hanyadjára</th><th>Kredit</th><th>Érdemjegy</th></tr></thead><tbody>";
    while(($targy = mysqli_fetch_assoc($teljesitetttargyak))!==null){
        echo "<tr><td>".$targy["nev"]."</td><td>".$targy["kurzuskod"]."</td><td>".$targy["felveteli_felev"]."</td><td>".$targy["hany"]."</td><td>".$targy["kredit"]."</td><td>".$targy["erdemjegy"]."</td></tr>";
    }
    mysqli_free_result($teljesitetttargyak);
    echo "</tbody></table>";
}

?>