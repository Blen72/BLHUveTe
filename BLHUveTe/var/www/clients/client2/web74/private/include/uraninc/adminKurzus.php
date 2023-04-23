<?php
$conn = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');

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
    <th style= "border: 3px solid black;text-align: left;">Torles</th>
  </tr>
  <?php
while ($row = oci_fetch_assoc($compiled)) {
    $kod = $row["kurzuskod"];
    $nev = $row["nev"];
    ?>
    <tr>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["kurzuskod"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["nev"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["kepzesId"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["tipus"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["ajanlott_felev"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["kredit"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["hossz"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["kezdet"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["max_letszam"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["teremkod"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><a href="../private/include/uraninc/delKurzus.php?varname=<?php echo $kod ?>" onclick="return confirm('Biztosan torli a kurzust az adatbazisbol: <?php echo $nev ?> ?')"><Button>Del</button></a></td>
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
oci_free_statement($compiled);
oci_close($conn);
?>