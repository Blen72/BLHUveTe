<?php
$condb = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$targyfelvetel = "targyfelvetel";
$get_info = oci_parse($condb, "SELECT \"ertek\" FROM \"AdminBeallitasok\" WHERE \"id\" = '{$targyfelvetel}'");
oci_execute($get_info);
$is_it_targyfelvetel;
while ($row = oci_fetch_array($get_info)) {
        $is_it_targyfelvetel = $row[0];
}
oci_free_statement($get_info);
oci_close($condb);

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
$compiled = oci_parse($conn, "SELECT DISTINCT \"Kurzus\".\"nev\", \"kurzuskod\", \"kredit\", \"Kurzus\".\"kepzesId\", \"ajanlott_felev\", \"kezdet\", \"hossz\", \"max_letszam\" FROM \"Kurzus\", \"Hallgato\" WHERE \"kurzuskod\" NOT IN (SELECT \"kurzuskod\" FROM \"Hallgatoja\" WHERE \"Hallgatoja\".\"urancode\" = '${code}')");
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
    <th style= "border: 3px solid black;text-align: left;">Letszam/Max_Letszam</th>
    <?php if($is_it_targyfelvetel == 1){?>
        <th style= "border: 3px solid black;text-align: left;">Felvesz</th>
    <?php }?>
  </tr>
  <?php
while ($row = oci_fetch_array($compiled)) {
    $one = 1; //i know this is very dumb and im embarrassed
    $kurzuskod = $row[1];
    $get_count = oci_parse($conn, "SELECT COUNT(*) FROM \"Hallgatoja\" WHERE \"kurzuskod\" = '{$kurzuskod}' AND \"felvett\" = '{$one}'");
    oci_execute($get_count);
    $sor = oci_fetch_assoc($get_count);
    $count = $sor['COUNT(*)'];
    oci_free_statement($get_count);
    ?>
    <tr>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row[1]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row[0]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row[2]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row[3]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row[4]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row[5]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row[6]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $count . "/" . $row[7]?></td>
        <?php if($is_it_targyfelvetel == 1){?>
            <td style= "border: 2px solid black;text-align: left;padding: 8px;"><a href="../private/include/uraninc/felvetel.php?varname=<?php echo $row[1] ?>" onclick="return confirm('Biztosan fel szeretne venni a kovetkezo targyat: <?php echo $row[0] ?> ?')"><button>&#10133</button></a></td>
        <?php }?>
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