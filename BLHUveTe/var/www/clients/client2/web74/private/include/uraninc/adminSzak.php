<?php
$conn = oci_connect('JAROSLAV', '1111', 'localhost/XE');

$compiled = oci_parse($conn, "SELECT \"szakkod\", \"szaknev\" FROM \"Szak\"");
oci_execute($compiled);

?>
<br>
<table style="font-family: arial, sans-serif; border-collapse: collapse; width: 100%;">
<h1>Szakok <button style="margin: 5px; padding-top: 5px; padding-bottom: 5px">Uj Szak Felvetele</button></h1>
<tr>
    <th style= "border: 3px solid black;text-align: left;">Szakkod</th>
    <th style= "border: 3px solid black;text-align: left;">Szaknev</th>
    <th style= "border: 3px solid black;text-align: left;">Torles</th>
  </tr>
  <?php
while ($row = oci_fetch_assoc($compiled)) {
    ?>
    <tr>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["szakkod"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["szaknev"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><Button>Del</button></td>
    </tr>
    
    <?php

}
oci_free_statement($compiled);
$compiled = oci_parse($conn, "SELECT \"szakkod\", \"kurzuskod\" FROM \"Szakokonvan\"");
oci_execute($compiled);
?>
<br>
<table style="font-family: arial, sans-serif; border-collapse: collapse; width: 100%;">
<h1>Melyik Szakokon Van a Kurzus</h1>
<tr>
    <th style= "border: 3px solid black;text-align: left;">Szakkod</th>
    <th style= "border: 3px solid black;text-align: left;">Kurzuskod</th>
    <th style= "border: 3px solid black;text-align: left;">Torles</th>
  </tr>
  <?php
while ($row = oci_fetch_assoc($compiled)) {
    ?>
    <tr>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["szakkod"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["kurzuskod"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><Button>Del</button></td>
    </tr>
    
    <?php

}
oci_free_statement($compiled);
oci_close($conn);
?>