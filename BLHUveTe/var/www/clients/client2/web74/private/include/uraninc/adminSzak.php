<?php
session_start();
$conn = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');

$compiled = oci_parse($conn, "SELECT \"szakkod\", \"szaknev\" FROM \"Szak\"");
oci_execute($compiled);

?>
<br>
<table style="font-family: arial, sans-serif; border-collapse: collapse; width: 100%;">
<h1>Szakok <a href="../private/include/uraninc/newSzak.php"><button style="margin: 5px; padding-top: 5px; padding-bottom: 5px">Uj Szak Felvetele</button></a></h1>
<tr>
    <th style= "border: 3px solid black;text-align: left;">Szakkod</th>
    <th style= "border: 3px solid black;text-align: left;">Szaknev</th>
    <th style= "border: 3px solid black;text-align: left;">Torles</th>
  </tr>
  <?php
while ($row = oci_fetch_assoc($compiled)) {
    $code = $row["szakkod"];
    $nev = $row["szaknev"];
    ?>
    <tr>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["szakkod"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["szaknev"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><a href="../private/include/uraninc/delSzak.php?varname=<?php echo $code ?>" onclick="return confirm('Biztosan torolni szeretne a kovetkezo szakot: <?php echo $nev ?> ?')"><Button>Del</button></a></td>
    </tr>
    
    <?php

}
oci_free_statement($compiled);
$compiled = oci_parse($conn, "SELECT \"Szakokonvan\".\"szakkod\", \"Kurzus\".\"kurzuskod\", \"Kurzus\".\"nev\" FROM \"Szakokonvan\", \"Kurzus\" WHERE \"Kurzus\".\"kurzuskod\" = \"Szakokonvan\".\"kurzuskod\" ORDER BY \"Szakokonvan\".\"szakkod\"");
oci_execute($compiled);
?>
<br>
<table style="font-family: arial, sans-serif; border-collapse: collapse; width: 100%;">
<h1>Melyik Szakokon Van a Kurzus</h1>
<tr>
    <th style= "border: 3px solid black;text-align: left;">Szakkod</th>
    <th style= "border: 3px solid black;text-align: left;">Kurzuskod</th>
    <th style= "border: 3px solid black;text-align: left;">Kurzus neve</th>
  </tr>
  <?php
while ($row = oci_fetch_array($compiled)) {
    ?>
    <tr>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row[0]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row[1]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row[2]?></td>
    </tr>
    
    <?php

}
?>
<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>
<?php
oci_free_statement($compiled);
oci_close($conn);
?>