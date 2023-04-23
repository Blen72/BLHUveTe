<?php
session_start();
$conn = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');

$compiled = oci_parse($conn, "SELECT \"urancode\", \"nev\" FROM \"Felhasznalo\"");
oci_execute($compiled);

?>
<br>
<table style="font-family: arial, sans-serif; border-collapse: collapse; width: 100%;">
<h1>Felhasznalok</h1>
<tr>
    <th style= "border: 3px solid black;text-align: left;">Urancode</th>
    <th style= "border: 3px solid black;text-align: left;">Nev</th>
    <th style= "border: 3px solid black;text-align: left;">Torles</th>
    <th style= "border: 3px solid black;text-align: left;">Hallgato</th>
    <th style= "border: 3px solid black;text-align: left;">Oktato</th>
  </tr>
  <?php
while ($row = oci_fetch_assoc($compiled)) {
        $code = $row["urancode"];
        $nev = $row["nev"];
    ?>
    <tr>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["urancode"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["nev"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><a href="../private/include/uraninc/deleteFelhasznalo.php?varname=<?php echo $code ?>" onclick="return confirm('Biztosan torolni szeretne a kovetkezo felhasznalot: <?php echo $nev ?> ?')"><Button>Del</button></a></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><a href="../private/include/uraninc/convertToHallgato.php?varname=<?php echo $code ?>" onclick="return confirm('Biztosan hallgatova szeretne alakitani a kovetkezo felhasznalot: <?php echo $nev ?> ?')"><Button>To Hallgato</button></a></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><a href="../private/include/uraninc/convertToOktato.php?varname=<?php echo $code ?>" onclick="return confirm('Biztosan oktatova szeretne alakitani a kovetkezo felhasznalot: <?php echo $nev ?> ?')"><Button>To Oktato</button></a></td>
    </tr>
    
    <?php

}
oci_free_statement($compiled);
$compiled = oci_parse($conn, "SELECT \"urancode\", \"nev\", \"szakkod\", \"kepzesId\", \"felev\" FROM \"Hallgato\"");
oci_execute($compiled);
?>
<br>
<table style="font-family: arial, sans-serif; border-collapse: collapse; width: 100%;">
<h1>Hallgatok</h1>
<tr>
    <th style= "border: 3px solid black;text-align: left;">Urancode</th>
    <th style= "border: 3px solid black;text-align: left;">Nev</th>
    <th style= "border: 3px solid black;text-align: left;">Szakkod</th>
    <th style= "border: 3px solid black;text-align: left;">KepzesID</th>
    <th style= "border: 3px solid black;text-align: left;">Felev</th>
    <th style= "border: 3px solid black;text-align: left;">Jegybeiras</th>
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
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["szakkod"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["kepzesId"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["felev"]?></td>       
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><a href="../private/include/uraninc/addJegy.php?varname=<?php echo $code ?>" onclick="return confirm('Biztosan jegyet szeretne beirni a kovetkezo hallgatonak: <?php echo $nev ?> ?')"><Button>Jegybeiras</button></a></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><a href="../private/include/uraninc/deleteFelhasznalo.php?varname=<?php echo $code ?>" onclick="return confirm('Biztosan torolni szeretne a kovetkezo felhasznalot: <?php echo $nev ?> ?')"><Button>Del</button></a></td>
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