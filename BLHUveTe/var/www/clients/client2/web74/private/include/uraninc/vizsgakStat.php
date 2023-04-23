<?php
session_start();
$urancode = $_SESSION["uran_code"];
$conn = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$compiled = oci_parse($conn, "SELECT \"Vizsga\".\"vizsgaId\", \"Vizsga\".\"kurzuskod\", \"Vizsga\".\"teremkod\", \"Vizsga\".\"idopont\", \"Vizsga\".\"tipus\" FROM \"Vizsga\", \"Vizsgaja\" WHERE \"Vizsga\".\"vizsgaId\" = \"Vizsgaja\".\"vizsgaId\" AND \"Vizsgaja\".\"h_urancode\" = '{$urancode}'");
oci_execute($compiled);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../../../web74/web/css/hallgato.css" rel="stylesheet">
    <title>Vizsgak</title>
</head>
<body>
<br>
<table style="font-family: arial, sans-serif; border-collapse: collapse; width: 100%;">
<h1>Felvett Vizsgaim</h1>
<tr>
    <th style= "border: 3px solid black;text-align: left;">Kurzuskod</th>
    <th style= "border: 3px solid black;text-align: left;">Teremkod</th>
    <th style= "border: 3px solid black;text-align: left;">Idopont</th>
    <th style= "border: 3px solid black;text-align: left;">Tipus</th>
    <th style= "border: 3px solid black;text-align: left;">Vizsga Leadasa</th>
  </tr>
  <?php
while ($row = oci_fetch_array($compiled)) {
    if($row[4] == 1){
        $tipus = "Irasbeli";
      }
      if($row[4] == 2){
        $tipus = "Szobeli";
      }
      if($row[4] == 3){
        $tipus = "Irasbeli es Szobeli";
      }
    ?>
    <tr>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row[1]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row[2]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row[3]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $tipus?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><a href="../uraninc/leadVizsga.php?varname=<?php echo $row[0] ?>" onclick="return confirm('Biztosan leadja a vizsgaidopontot?')"><button>&#10134;</button></a></td>
    </tr>
    
    <?php

}
oci_free_statement($compiled);

$compiled = oci_parse($conn, "SELECT \"Vizsga\".\"vizsgaId\", \"Vizsga\".\"kurzuskod\", \"Vizsga\".\"teremkod\", \"Vizsga\".\"idopont\", \"Vizsga\".\"tipus\", \"Vizsga\".\"max_letszam\" FROM \"Vizsga\", \"Hallgatoja\" WHERE \"Vizsga\".\"kurzuskod\" = \"Hallgatoja\".\"kurzuskod\" AND \"Hallgatoja\".\"urancode\" = '{$urancode}' AND \"Hallgatoja\".\"felvett\" = 1 AND \"Hallgatoja\".\"erdemjegy\" < 2 AND \"vizsgaId\" NOT IN (SELECT \"vizsgaId\" FROM \"Vizsgaja\" WHERE \"h_urancode\" = '{$urancode}')");
oci_execute($compiled);
?>
<br>
<table style="font-family: arial, sans-serif; border-collapse: collapse; width: 100%;">
<h1>Felveheto Vizsgak</h1>
<tr>
    <th style= "border: 3px solid black;text-align: left;">Kurzuskod</th>
    <th style= "border: 3px solid black;text-align: left;">Teremkod</th>
    <th style= "border: 3px solid black;text-align: left;">Idopont</th>
    <th style= "border: 3px solid black;text-align: left;">Tipus</th>
    <th style= "border: 3px solid black;text-align: left;">Letszam/Max Letszam</th>
    <th style= "border: 3px solid black;text-align: left;">Vizsga Felvetele</th>
  </tr>
  <?php
while ($row = oci_fetch_array($compiled)) {
    $id = $row[0];
    $get_count = oci_parse($conn, "SELECT COUNT(*) FROM \"Vizsgaja\" WHERE \"vizsgaId\" = '{$id}'");
    oci_execute($get_count);
    $sor = oci_fetch_assoc($get_count);
    $count = $sor['COUNT(*)'];
    oci_free_statement($get_count);
    if($row[4] == 1){
        $tipus = "Irasbeli";
      }
      if($row[4] == 2){
        $tipus = "Szobeli";
      }
      if($row[4] == 3){
        $tipus = "Irasbeli es Szobeli";
      }
    ?>
    <tr>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row[1]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row[2]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row[3]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $tipus?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $count . "/" . $row[5]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><a href="../uraninc/felveszVizsga.php?varname=<?php echo $row[0] ?>" onclick="return confirm('Biztosan jelentkezik a vizsga idopontra?')"><button>&#10133;</button></a></td>
    </tr>
    
    <?php

}
oci_free_statement($compiled);
oci_close($conn);
?>

<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>

</body>
</html>