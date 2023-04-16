<?php
session_start();
$conn = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');

$compiled = oci_parse($conn, "SELECT \"urancode\", \"nev\", \"jogosultsag\" FROM \"Oktato\"");
oci_execute($compiled);

?>
<br>
<table style="font-family: arial, sans-serif; border-collapse: collapse; width: 100%;">
<h1>Oktatok</h1>
<tr>
    <th style= "border: 3px solid black;text-align: left;">Urancode</th>
    <th style= "border: 3px solid black;text-align: left;">Nev</th>
    <th style= "border: 3px solid black;text-align: left;">Jogosultsag</th>
    <th style= "border: 3px solid black;text-align: left;">Torles</th>
  </tr>
  <?php
while ($row = oci_fetch_assoc($compiled)) {
    $code = $row["urancode"];
    $nev = $row["nev"];
    ?>
    <tr>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["urancode"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["nev"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["jogosultsag"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><a href="../private/include/uraninc/deleteFelhasznalo.php?varname=<?php echo $code ?>" onclick="return confirm('Biztosan torolni szeretne a kovetkezo felhasznalot: <?php echo $nev ?> ?')"><Button>Del</button></a></td>
    </tr>
    
    <?php

}
oci_free_statement($compiled);
oci_close($conn);
?>