<?php
$conn = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$sql = oci_parse($conn, "alter session set nls_date_format='DD-MM-YYYY HH24:MI'");
oci_execute($sql);
oci_free_statement($sql);
$compiled = oci_parse($conn, "SELECT * FROM \"Kurzus\"");
oci_execute($compiled);

?>
<br>
<table style="font-family: arial, sans-serif; border-collapse: collapse; width: 100%;">
<h1>Kurzusok <a href="../private/include/uraninc/newKurzus.php"><button style="margin: 5px; padding-top: 5px; padding-bottom: 5px">Uj Kurzus Felvetele</button></a></h1>
<tr>
    <th style= "border: 3px solid black;text-align: left;">Kurzuskod</th>
    <th style= "border: 3px solid black;text-align: left;">Nev</th>
    <th style= "border: 3px solid black;text-align: left;">KepzesId</th>
    <th style= "border: 3px solid black;text-align: left;">Tipus</th>
    <th style= "border: 3px solid black;text-align: left;">Ajanlott felev</th>
    <th style= "border: 3px solid black;text-align: left;">Kredit</th>
    <th style= "border: 3px solid black;text-align: left;">Hossz</th>
    <th style= "border: 3px solid black;text-align: left;">Kezdet</th>
    <th style= "border: 3px solid black;text-align: left;">Max letszam</th>
    <th style= "border: 3px solid black;text-align: left;">Teremkod</th>
    <th style= "border: 3px solid black;text-align: left;">Kurzus hozzaadasa szakhoz</th>
    <th style= "border: 3px solid black;text-align: left;">Torles</th>
  </tr>
  <?php
while ($row = oci_fetch_assoc($compiled)) {
    $kod = $row["kurzuskod"];
    $nev = $row["nev"];
    $ido = $row["kezdet"];
    ?>
    <tr>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["kurzuskod"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["nev"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["kepzesId"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["tipus"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["ajanlott_felev"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["kredit"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["hossz"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $ido?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["max_letszam"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["teremkod"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><a href="../private/include/uraninc/addKurzusToSzak.php?varname=<?php echo $kod ?>" onclick="return confirm('Biztosan hozza szeretni adni a kovetkezo kurzust egy szakhoz: <?php echo $nev ?> ?')"><Button>Hozzaad</button></a></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><a href="../private/include/uraninc/delKurzus.php?varname=<?php echo $kod ?>" onclick="return confirm('Biztosan torli a kurzust az adatbazisbol: <?php echo $nev ?> ?')"><Button>Del</button></a></td>
    </tr>
    
    <?php

}
$elofeltel = oci_parse($conn, "SELECT * FROM \"Elofeltetele\"");
oci_execute($elofeltel);
?>
<table style="font-family: arial, sans-serif; border-collapse: collapse; width: 100%;">
<h1>Kurzusok Elofeltetelei <a href="../private/include/uraninc/newElofeltetel.php"><button style="margin: 5px; padding-top: 5px; padding-bottom: 5px">Uj Kurzus Elofeltetel Hozzaadasa</button></a></h1>
<tr>
    <th style= "border: 3px solid black;text-align: left;">Kurzuskod</th>
    <th style= "border: 3px solid black;text-align: left;">Elofeltetele</th>
    <th style= "border: 3px solid black;text-align: left;">Elofeltetel Torlese</th>
  </tr>
  <?php
while ($row = oci_fetch_assoc($elofeltel)) {
  $torlendo = $row["kurzuskodnak"];
    ?>
    <tr>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["kurzuskodnak"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["kurzuskod"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><a href="../private/include/uraninc/delElofeltetele.php?varname=<?php echo $torlendo ?>" onclick="return confirm('Biztosan torli az elofeltetelt?')"><button>Del</button></a></td>
    </tr>
    
    <?php

}
?>
<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>
<?php
oci_free_statement($elofeltel);
oci_free_statement($compiled);
oci_close($conn);
?>