<?php
$conn = oci_connect('JAROSLAV', '1111', 'localhost/XE');

$compiled = oci_parse($conn, "SELECT \"epulet_neve\", \"epulet_cime\" FROM \"Epulet\"");
oci_execute($compiled);

?>
<br>
<table style="font-family: arial, sans-serif; border-collapse: collapse; width: 100%;">
<h1>Epuletek <button style="margin: 5px; padding-top: 5px; padding-bottom: 5px">Uj Epulet Felvetele</button></h1>
<tr>
    <th style= "border: 3px solid black;text-align: left;">Epulet neve</th>
    <th style= "border: 3px solid black;text-align: left;">Epulet cime</th>
    <th style= "border: 3px solid black;text-align: left;">Torles</th>
  </tr>
  <?php
while ($row = oci_fetch_assoc($compiled)) {
    ?>
    <tr>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["epulet_neve"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["epulet_cime"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><Button>Del</button></td>
    </tr>
    
    <?php

}
oci_free_statement($compiled);
$compiled = oci_parse($conn, "SELECT \"teremkod\", \"epulet_neve\", \"teremszam\" FROM \"Terem\"");
oci_execute($compiled);
?>
<br>
<table style="font-family: arial, sans-serif; border-collapse: collapse; width: 100%;">
<h1>Termek <button style="margin: 5px; padding-top: 5px; padding-bottom: 5px">Uj Terem Felvetele</button></h1>
<tr>
    <th style= "border: 3px solid black;text-align: left;">Teremkod</th>
    <th style= "border: 3px solid black;text-align: left;">Epulet neve</th>
    <th style= "border: 3px solid black;text-align: left;">teremszam</th>
    <th style= "border: 3px solid black;text-align: left;">Torles</th>
  </tr>
  <?php
while ($row = oci_fetch_assoc($compiled)) {
    ?>
    <tr>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["teremkod"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["epulet_neve"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["teremszam"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><Button>Del</button></td>
    </tr>
    
    <?php

}
oci_free_statement($compiled);
$compiled = oci_parse($conn, "SELECT \"urancode\", \"nev\", \"szakkod\", \"kepzesId\", \"felev\" FROM \"Hallgato\"");
oci_execute($compiled);
?>
<?php
oci_close($conn);
?>