<?php
$conn = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$compiled = oci_parse($conn, "SELECT \"kurzuskod\", AVG(\"erdemjegy\") FROM \"Hallgatoja\" GROUP BY \"kurzuskod\"");
oci_execute($compiled);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../../../web74/web/css/hallgato.css" rel="stylesheet">
    <title>Evfolyami-statiszika</title>
</head>
<body>
<table style="font-family: arial, sans-serif; border-collapse: collapse; width: 100%;">
<h1>Evfolyami-statiszika</h1>
<tr>
    <th style= "border: 3px solid black;text-align: left;">Targy Kodja</th>
    <th style= "border: 3px solid black;text-align: left;">Atlag</th>
  </tr>
  <?php
while ($row = oci_fetch_array($compiled)) {
    ?>
    <tr>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row[0]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row[1]?></td>
    </tr>
<?php
} 
oci_free_statement($compiled);
oci_close($conn);
?>
</body>
</html>