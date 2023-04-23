<?php
session_start();
$condb = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$vizsgaidoszak = "vizsgaidoszak";
$get_info = oci_parse($condb, "SELECT \"ertek\" FROM \"AdminBeallitasok\" WHERE \"id\" = '{$vizsgaidoszak}'");
oci_execute($get_info);
$is_it_vizsgaidoszak;
while ($row = oci_fetch_array($get_info)) {
    $is_it_vizsgaidoszak = $row[0];
}
oci_free_statement($get_info);
oci_close($condb);
$ishallgset=$_SESSION["user"]["hallgato"]||isset($_POST["hallgato"])||isset($_SESSION["viewAsHallgato"]);
if($ishallgset||$_SESSION["user"]["oktato"])include_once("../private/include/uraninc/viewAs.php");
if($ishallgset){
    $code = $_SESSION["uran_code"];
    $sql = "SELECT \"Szak\".\"szaknev\", \"Kepzes\".\"nev\", \"felev\", \"osszeg\", \"bankban\" FROM \"Szak\", \"Kepzes\", \"Hallgato\" WHERE \"Szak\".\"szakkod\" = \"Hallgato\".\"szakkod\" AND \"Kepzes\".\"kepzesId\" = \"Hallgato\".\"kepzesId\" AND \"Hallgato\".\"urancode\" = '{$code}'";
    $stid = oci_parse($adatb, $sql);
    oci_execute($stid);
    $row = oci_fetch_array($stid);
    echo "Szak: ".$row[0]."<br/>";
    echo "Képzés: ".$row[1]."<br/>";
    echo "Jelenlegi félév: ".$row[2]."<br/>";
    echo "Befizetendo koltsegek: ".$row[3]."<br/>";
    echo "Befizettet osszege: ".$row[4]."<br/>";
    echo "Kreditindex félévenként: <ul>";
    $avgs=sql_select($adatb,"Hallgatoja,Kurzus",["felveteli_felev","SUM(".sql_col_mkr("erdemjegy")."*".sql_col_mkr("kredit").")/30 AS atlag"],"WHERE ".sql_col_of_table("Hallgatoja","kurzuskod")."=".sql_col_of_table("Kurzus","kurzuskod")." AND ".sql_col_of_table("Hallgatoja","urancode")."='".$hallgato["urancode"]."' AND ".sql_col_of_table("Hallgatoja","erdemjegy").">1 GROUP BY ".sql_col_mkr("felveteli_felev"));
    oci_define_by_name($avgs, "ATLAG", $total);
    oci_execute($avgs);
    while($felev = oci_fetch_assoc($avgs)){
        echo "<li>".$felev["felveteli_felev"].": ".$total."</li>";
    }
    oci_free_statement($avgs);
    echo "</ul>";
    ?>
    <a href="../private/include/uraninc/befizetes.php?varname=<?php echo $code ?>" onclick="return confirm('Biztosan szeretne befizetni az iskolai szamlajara?')"><button>Befizetes</button></a>
    <a href="../private/include/uraninc/koltsegek.php?varname=<?php echo $code ?>" onclick="return confirm('Biztosan szeretne kifizetni koltsegeit?')"><button>Koltsegek fizetese</button></a>
    <a href="../private/include/uraninc/evfolyamStat.php?"><button>Evfolyam-statisztika</button></a>
    <a href="../private/include/uraninc/teremStat.php?"><button>Teremkihasznaltsagi statisztika</button></a>
    <?php if($is_it_vizsgaidoszak == 1){?>
        <a href="../private/include/uraninc/vizsgakStat.php?"><button>Vizsgak</button></a>
    <?php } ?>
    <script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>
    <?php
}
?>