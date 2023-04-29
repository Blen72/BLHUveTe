<?php
session_start();
$urancode = $_SESSION["uran_code"];
$conn = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');

  $sql = oci_parse($conn, "alter session set nls_date_format='DD-MM-YYYY HH24:MI'");
oci_execute($sql);
oci_free_statement($sql);

$compiled = oci_parse($conn, "SELECT \"urancode\", \"nev\", \"jogosultsag\" FROM \"Oktato\"");
oci_execute($compiled);

?>
<br>
<table style="font-family: arial, sans-serif; border-collapse: collapse; width: 100%;">
<h1>Oktatok <a href="../private/include/uraninc/newVizsga.php"><button style="margin: 5px; padding-top: 5px; padding-bottom: 5px">Uj Vizsga Meghirdetese</button></a></h1>
<tr>
    <th style= "border: 3px solid black;text-align: left;">Urancode</th>
    <th style= "border: 3px solid black;text-align: left;">Nev</th>
    <th style= "border: 3px solid black;text-align: left;">Jogosultsag</th>
    <th style= "border: 3px solid black;text-align: left;">Oktato hozzadasa egy kurzushoz</th>
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
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><a href="../private/include/uraninc/addOktatoja.php?varname=<?php echo $code ?>" onclick="return confirm('Biztosan szeretne a kovetkezo oktatot hozzarendelni egy kurzushoz: <?php echo $nev ?> ?')"><Button>Hozzadas</button></a></td>
    </tr>
    
    <?php

}
$sql = oci_parse($conn, "SELECT \"vizsgaId\", \"kurzuskod\", \"teremkod\", \"idopont\", \"tipus\", \"max_letszam\" FROM \"Vizsga\" WHERE \"o_urancode\" = '{$urancode}'");
oci_execute($sql);
?>
<br>
<table style="font-family: arial, sans-serif; border-collapse: collapse; width: 100%;">
<h1>Meghirdetett vizsgaim</h1>
<tr>
    <th style= "border: 3px solid black;text-align: left;">Kurzuskod</th>
    <th style= "border: 3px solid black;text-align: left;">Teremkod</th>
    <th style= "border: 3px solid black;text-align: left;">Idopont</th>
    <th style= "border: 3px solid black;text-align: left;">Tipus</th>
    <th style= "border: 3px solid black;text-align: left;">Max Letszam</th>
    <th style= "border: 3px solid black;text-align: left;">Vizsgaidopont torlese</th>
  </tr>
  <?php
while ($row = oci_fetch_array($sql)) {
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
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row[5]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><a href="../private/include/uraninc/delVizsga.php?varname=<?php echo $row[0] ?>" onclick="return confirm('Biztosan szeretne a vizsgaidopontot torolni?')"><Button>Del</button></a></td>
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
oci_free_statement($sql);
oci_close($conn);
?>