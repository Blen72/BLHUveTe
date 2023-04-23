<?php
$conn = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');

$compiled = oci_parse($conn, "SELECT \"epulet_neve\", \"epulet_cime\" FROM \"Epulet\"");
oci_execute($compiled);

?>
<br>
<table style="font-family: arial, sans-serif; border-collapse: collapse; width: 100%;">
<h1>Epuletek <a href="../private/include/uraninc/newEpulet.php"><button style="margin: 5px; padding-top: 5px; padding-bottom: 5px">Uj Epulet Felvetele</button></a></h1>
<tr>
    <th style= "border: 3px solid black;text-align: left;">Epulet neve</th>
    <th style= "border: 3px solid black;text-align: left;">Epulet cime</th>
    <th style= "border: 3px solid black;text-align: left;">Torles</th>
  </tr>
  <?php
while ($row = oci_fetch_assoc($compiled)) {
    $epulet = $row["epulet_neve"];
    ?>
    <tr>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["epulet_neve"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["epulet_cime"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><a href="../private/include/uraninc/delEpulet.php?varname=<?php echo $epulet ?>" onclick="return confirm('Biztosan torli az epuletet az adatbazisbol: <?php echo $epulet ?> ?')"><Button>Del</button></a></td>
    </tr>
    
    <?php

}
oci_free_statement($compiled);
$compiled = oci_parse($conn, "SELECT \"teremkod\", \"epulet_neve\", \"teremszam\" FROM \"Terem\"");
oci_execute($compiled);
?>
<br>
<table style="font-family: arial, sans-serif; border-collapse: collapse; width: 100%;">
<h1>Termek <a href="../private/include/uraninc/newTerem.php"><button style="margin: 5px; padding-top: 5px; padding-bottom: 5px">Uj Terem Felvetele</button></a></h1>
<tr>
    <th style= "border: 3px solid black;text-align: left;">Teremkod</th>
    <th style= "border: 3px solid black;text-align: left;">Epulet neve</th>
    <th style= "border: 3px solid black;text-align: left;">Teremszam</th>
    <th style= "border: 3px solid black;text-align: left;">Torles</th>
  </tr>
  <?php
while ($row = oci_fetch_assoc($compiled)) {
    $teremkod = $row["teremkod"];
    ?>
    <tr>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["teremkod"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["epulet_neve"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["teremszam"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><a href="../private/include/uraninc/delTerem.php?varname=<?php echo $teremkod ?>" onclick="return confirm('Biztosan torli a kovetkezo teremkodu termet az adatbazisbol: <?php echo $teremkod ?> ?')"><Button>Del</button></a></td>
    </tr>
    
    <?php

}
oci_free_statement($compiled);
$compiled = oci_parse($conn, "SELECT \"urancode\", \"nev\", \"szakkod\", \"kepzesId\", \"felev\" FROM \"Hallgato\"");
oci_execute($compiled);
?>
<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>
<?php
oci_close($conn);
?>