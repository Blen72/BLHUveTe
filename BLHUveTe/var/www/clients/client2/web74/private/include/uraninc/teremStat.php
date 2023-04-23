<?php
$one = 1; //i know this is very dumb and im embarrassed
$conn = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$compiled = oci_parse($conn, "SELECT \"kurzuskod\", \"teremkod\", SUM(\"max_letszam\") FROM \"Kurzus\" GROUP BY \"teremkod\", \"kurzuskod\"");
oci_execute($compiled);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../../../web74/web/css/hallgato.css" rel="stylesheet">
    <title>Teremkihasznaltsagi statisztika</title>
</head>
<body>
<table style="font-family: arial, sans-serif; border-collapse: collapse; width: 100%;">
<h1>Teremkihasznaltsagi statisztika</h1>
<tr>
    <th style= "border: 3px solid black;text-align: left;">Kurzuskod</th>
    <th style= "border: 3px solid black;text-align: left;">Teremkod</th>
    <th style= "border: 3px solid black;text-align: left;">Kihasznaltsag (%)</th>
  </tr>
  <?php
while ($row = oci_fetch_array($compiled)) {
    $kurzuskod = $row[0];
    $get_count = oci_parse($conn, "SELECT COUNT(*) FROM \"Hallgatoja\" WHERE \"kurzuskod\" = '{$kurzuskod}' AND \"felvett\" = '{$one}'");
    oci_execute($get_count);
    $sor = oci_fetch_assoc($get_count);
    $count = $sor['COUNT(*)'];
    oci_free_statement($get_count);
    $szazalek = ($count/$row[2]) * 100;
    ?>
    <tr>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row[0]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row[1]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $szazalek?></td>
    </tr>
<?php 
} 
oci_free_statement($compiled);
oci_close($conn);
?>
</body>
</html>