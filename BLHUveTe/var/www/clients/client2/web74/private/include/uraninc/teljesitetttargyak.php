<?php
$conn = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$code = $_SESSION["uran_code"];
$sql = "SELECT \"Kurzus\".\"nev\",\"Kurzus\".\"kurzuskod\" ,\"felveteli_felev\", \"kredit\", \"erdemjegy\" FROM \"Kurzus\", \"Hallgatoja\" WHERE \"Kurzus\".\"kurzuskod\" = \"Hallgatoja\".\"kurzuskod\" AND \"Hallgatoja\".\"urancode\" = '${code}' AND \"Hallgatoja\".\"erdemjegy\" > 1";
$compiled = oci_parse($conn, $sql);
oci_execute($compiled);
?>
<br>
<table style="font-family: arial, sans-serif; border-collapse: collapse; width: 100%;">
<tr>
    <th style= "border: 3px solid black;text-align: left;">Targy Kodja</th>
    <th style= "border: 3px solid black;text-align: left;">Targy Neve</th>
    <th style= "border: 3px solid black;text-align: left;">Teljesites Feleve</th>
    <th style= "border: 3px solid black;text-align: left;">Kredit</th>
    <th style= "border: 3px solid black;text-align: left;">Erdemjegy</th>
  </tr>
  <?php
while ($row = oci_fetch_array($compiled)) {
    ?>
    <tr>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row[1]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row[0]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row[2]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row[3]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row[4]?></td>
    </tr>
    
    <?php

}
oci_free_statement($compiled);

oci_close($conn);
?>