<?php
$conn = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$code = $_SESSION["uran_code"];
$compiled = oci_parse($conn, "SELECT \"Kurzus\".\"nev\", \"Kurzus\".\"kurzuskod\", \"epulet_neve\", \"Terem\".\"teremkod\", \"teremszam\", \"kredit\", \"kezdet\", \"hossz\" FROM \"Kurzus\", \"Hallgato\", \"Hallgatoja\", \"Terem\" WHERE \"Terem\".\"teremkod\" = \"Kurzus\".\"teremkod\" AND \"Hallgato\".\"urancode\" = \"Hallgatoja\".\"urancode\" AND \"Hallgatoja\".\"kurzuskod\" = \"Kurzus\".\"kurzuskod\" AND \"Hallgato\".\"urancode\" = '${code}' AND \"Hallgatoja\".\"felvett\" = 1 ORDER BY \"Kurzus\".\"kurzuskod\"");
oci_execute($compiled);
?>
<br>
<table style="font-family: arial, sans-serif; border-collapse: collapse; width: 100%;">
<h1>Felvett Targyak</h1>
<tr>
    <th style= "border: 3px solid black;text-align: left;">Targy Kodja</th>
    <th style= "border: 3px solid black;text-align: left;">Targy Neve</th>
    <th style= "border: 3px solid black;text-align: left;">Epulet Neve</th>
    <th style= "border: 3px solid black;text-align: left;">Teremkod</th>
    <th style= "border: 3px solid black;text-align: left;">Teremszam</th>
    <th style= "border: 3px solid black;text-align: left;">Kredit</th>
    <th style= "border: 3px solid black;text-align: left;">Kezdet</th>
    <th style= "border: 3px solid black;text-align: left;">Hossz</th>
    <th style= "border: 3px solid black;text-align: left;">Targy Leadasa</th>
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
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row[5]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row[6]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row[7]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><a href="../private/include/uraninc/leadas.php?varname=<?php echo $row[1] ?>" onclick="return confirm('Biztosan leadja a kovetkezo targyat: <?php echo $row[0] ?> ?')"><button>&#10134;</button></a></td>
    </tr>
    
    <?php

}
oci_free_statement($compiled);
$compiled = oci_parse($conn, "SELECT DISTINCT \"Kurzus\".\"nev\", \"kurzuskod\", \"kredit\", \"Kurzus\".\"kepzesId\", \"ajanlott_felev\", \"kezdet\", \"hossz\" FROM \"Kurzus\", \"Hallgato\" WHERE \"kurzuskod\" NOT IN (SELECT \"kurzuskod\" FROM \"Hallgatoja\" WHERE \"Hallgatoja\".\"urancode\" = '${code}')");
oci_execute($compiled);
?>
<br>
<table style="font-family: arial, sans-serif; border-collapse: collapse; width: 100%;">
<h1>Felveheto Targyak</h1>
<tr>
    <th style= "border: 3px solid black;text-align: left;">Targy Kodja</th>
    <th style= "border: 3px solid black;text-align: left;">Targy Neve</th>
    <th style= "border: 3px solid black;text-align: left;">Kredit</th>
    <th style= "border: 3px solid black;text-align: left;">Kurzus KepzesId</th>
    <th style= "border: 3px solid black;text-align: left;">Ajanlott Felev</th>
    <th style= "border: 3px solid black;text-align: left;">Kezdet</th>
    <th style= "border: 3px solid black;text-align: left;">Hossz</th>
    <th style= "border: 3px solid black;text-align: left;">Felvesz</th>
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
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row[5]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row[6]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><a href="../private/include/uraninc/felvetel.php?varname=<?php echo $row[1] ?>" onclick="return confirm('Biztosan fel szeretne venni a kovetkezo targyat: <?php echo $row[0] ?> ?')"><button>&#10133</button></a></td>
    </tr>
    
    <?php

}

oci_close($conn);
?>