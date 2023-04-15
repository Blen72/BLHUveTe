<?php
$conn = oci_connect('JAROSLAV', '1111', 'localhost/XE');

$compiled = oci_parse($conn, "SELECT \"urancode\", \"nev\" FROM \"Felhasznalo\"");
oci_execute($compiled);

?>
<br>
<table style="font-family: arial, sans-serif; border-collapse: collapse; width: 100%;">
<h1>Felhasznalok <button style="margin: 5px; padding-top: 5px; padding-bottom: 5px">Uj Felhasznalo Felvetele</button></h1>
<tr>
    <th style= "border: 3px solid black;text-align: left;">Urancode</th>
    <th style= "border: 3px solid black;text-align: left;">Nev</th>
    <th style= "border: 3px solid black;text-align: left;">Torles</th>
  </tr>
  <?php
while ($row = oci_fetch_assoc($compiled)) {
    ?>
    <tr>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["urancode"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["nev"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><Button>Del</button></td>
    </tr>
    
    <?php

}
oci_free_statement($compiled);
$compiled = oci_parse($conn, "SELECT \"urancode\", \"nev\", \"szakkod\", \"kepzesId\", \"felev\" FROM \"Hallgato\"");
oci_execute($compiled);
?>
<br>
<table style="font-family: arial, sans-serif; border-collapse: collapse; width: 100%;">
<h1>Hallgatok</h1>
<tr>
    <th style= "border: 3px solid black;text-align: left;">Urancode</th>
    <th style= "border: 3px solid black;text-align: left;">Nev</th>
    <th style= "border: 3px solid black;text-align: left;">Szakkod</th>
    <th style= "border: 3px solid black;text-align: left;">KepzesID</th>
    <th style= "border: 3px solid black;text-align: left;">Felev</th>
    <th style= "border: 3px solid black;text-align: left;">Torles</th>
  </tr>
  <?php
while ($row = oci_fetch_assoc($compiled)) {
    ?>
    <tr>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["urancode"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["nev"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["szakkod"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["kepzesId"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["felev"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><Button>Del</button></td>
    </tr>
    
    <?php

}
oci_free_statement($compiled);
oci_close($conn);
?>