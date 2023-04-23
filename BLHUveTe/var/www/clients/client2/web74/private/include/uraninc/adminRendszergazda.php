<?php
session_start();
$conn = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');

$compiled = oci_parse($conn, "SELECT * FROM \"AdminBeallitasok\"");
oci_execute($compiled);
$is_it_targyfelvetel;
$is_it_vizsgaidoszak;
while ($row = oci_fetch_assoc($compiled)) {
    if($row["id"] === "targyfelvetel"){
        $is_it_targyfelvetel = $row["ertek"];
    }
    if($row["id"] === "vizsgaidoszak"){
        $is_it_vizsgaidoszak = $row["ertek"];
    }
}
oci_free_statement($compiled);
oci_close($conn);
if($is_it_targyfelvetel == 1){
$ertektargy = "kikapcsolasa";
}else{
    $ertektargy = "bekapcsolasa";
}
if($is_it_vizsgaidoszak == 1){
    $ertekvizsga = "kikapcsolasa";
    }else{
        $ertekvizsga = "bekapcsolasa";
    }
?>
    <a href="../private/include/uraninc/changeTargyfelvetel.php?"><button>Targyfelveteli idoszak <?php echo $ertektargy?></button></a>
    <a href="../private/include/uraninc/changeVizsgaidoszak.php?"><button>Vizsgaidoszak <?php echo $ertekvizsga?></button></a>
    <a href="../private/include/uraninc/changeFelev.php?"><button>Felevek Frissitese</button></a>
<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>