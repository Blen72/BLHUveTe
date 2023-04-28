<?php
session_start();
$conn = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');

$compiled = oci_parse($conn, "SELECT \"urancode\", \"nev\" FROM \"Felhasznalo\"");
oci_execute($compiled);
$urancode=$_SESSION["user"]["urancode"];

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
        <?php if($code!==$urancode) { ?>      
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><a href="../private/include/uraninc/addJegy.php?varname=<?php echo $code ?>" onclick="return confirm('Biztosan jegyet szeretne beirni a kovetkezo hallgatonak: <?php echo $nev ?> ?')"><Button>Jegybeiras</button></a></td>
        <?php } else {
            ?>
             <td></td>
            <?php
        }?>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><a href="../private/include/uraninc/deleteFelhasznalo.php?varname=<?php echo $code ?>" onclick="return confirm('Biztosan torolni szeretne a kovetkezo felhasznalot: <?php echo $nev ?> ?')"><Button>Del</button></a></td>
    </tr>
    
    <?php

}
$hallgatok = oci_parse($conn, "SELECT \"Kurzus\".\"nev\" AS \"kurzus\", \"Hallgato\".\"nev\" AS \"hallgato\", \"Hallgato\".\"urancode\" AS \"code\", \"Kurzus\".\"kurzuskod\" AS \"kod\" FROM \"Oktatoja\",\"Hallgato\", \"Hallgatoja\", \"Kurzus\" WHERE \"Oktatoja\".\"kurzuskod\"=\"Kurzus\".\"kurzuskod\" AND \"Hallgatoja\".\"kurzuskod\"=\"Kurzus\".\"kurzuskod\" AND \"Hallgatoja\".\"urancode\"=\"Hallgato\".\"urancode\" AND \"Oktatoja\".\"urancode\"='{$urancode}' AND \"Hallgatoja\".\"erdemjegy\"=0");
oci_execute($hallgatok); ?>
</table>
<h1>Hallgatók ledobása a kurzusról</h1>
<table style="font-family: arial, sans-serif; border-collapse: collapse; width: 100%;">
    <tr>
        <th style= "border: 3px solid black;text-align: left;">Hallgato</th>
        <th style= "border: 3px solid black;text-align: left;">Kurzus</th>
        <th style= "border: 3px solid black;text-align: left;">Ledob</th>
    </tr>
    <?php
    while ($row = oci_fetch_assoc($hallgatok)) {
        $nev=$row["hallgato"];
        $code=$row["code"];
        $kurzus=$row["kod"];
    ?>
    <tr>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["hallgato"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["kurzus"]?></td>    
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><a href="../private/include/uraninc/ledob.php?varname=<?php echo $code ?>&kurzus=<?php echo $kurzus ?>" onclick="return confirm('Biztosan le szeretne dobni a kovetkezo hallgatot: <?php echo $nev ?> ?')"><Button>Ledobas</button></a></td>
     </tr>
    <?php

}
?>
</table>
<?php
if(isset($_POST["valami"])) {
    $ev=(int)$_POST["ev"];
}
  $nincs_diploma = oci_parse($conn, "SELECT \"nev\", \"urancode\" FROM \"Hallgato\" WHERE \"kepzesId\"=0");
  $van_diploma = oci_parse($conn, "SELECT \"nev\", \"urancode\" FROM \"Hallgato\" WHERE \"kepzesId\">0");
  $ev_diploma = oci_parse($conn, "SELECT \"nev\", \"urancode\" FROM \"Hallgato\" WHERE \"kepzesId\">0 AND EXTRACT(YEAR FROM SYSDATE)-trunc(\"felev\"/3)={$ev}");
?>
<h1>Itt tudod megnézni, hogy kik diplomáztak az adott évben</h1>
<p>Ha 0-át írsz be, akkor azokat listázza ki, akik még nem diplomáztak</p>
<p>Ha 1-et írsz be, akkor a diplomásokat listázza ki</p>
<p>Ha pedig évet írsz be, akkor pedig az abban az évben diplomázottakat listázza ki</p>
<table style="font-family: arial, sans-serif; border-collapse: collapse; width: 100%; margin-bottom:20px">
    <tr>
    <th style= "border: 3px solid black;text-align: left;">
    <form method="post">
        <input type="number" value="<?php echo $ev?>" name="ev" min="0" max="2023" />
        <button name="valami" type="submit">Lista</button>
    </form>
</th>
<?php if($ev>=1) {?>
<th style= "border: 3px solid black;text-align: left;">kepzes</th>
<th style= "border: 3px solid black;text-align: left;">szakkod</th>
<th style= "border: 3px solid black;text-align: left;">atlag</th>
<?php } ?>
</tr>
    <?php
    $szamlalo=0;
    $szoveg='';
    if($ev===0) {
        $szoveg=' diploma nelkuli hallgato van.';
        oci_execute($nincs_diploma);
        while ($row = oci_fetch_assoc($nincs_diploma)) {
            $szamlalo=$szamlalo+1;
        ?>
        <tr>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row["nev"]?></td>
    </tr>
        <?php
        }
    }else if($ev===1){
        $szoveg=' diplomas hallgato van.';
        oci_execute($van_diploma);
        while ($row = oci_fetch_assoc($van_diploma)) {
            $szamlalo=$szamlalo+1;
            $code=$row["urancode"];
            $seged=oci_parse($conn, "SELECT \"osszeg\"/(\"felevek_szama\"*30) AS \"atlag\",\"h_nev\", \"Kepzes\".\"nev\" AS \"kepzes\", \"szakkod\" FROM \"Kepzesideje\", \"Kepzes\", (SELECT \"Kurzus\".\"kepzesId\" AS \"id\", SUM(\"Kurzus\".\"kredit\" * \"Hallgatoja\".\"erdemjegy\") AS \"osszeg\", \"Hallgato\".\"nev\" AS \"h_nev\" FROM \"Hallgato\", \"Hallgatoja\", \"Kurzus\"
            WHERE \"Hallgato\".\"urancode\"='{$code}' AND \"Hallgatoja\".\"urancode\"='{$code}' AND \"Kurzus\".\"kurzuskod\"=\"Hallgatoja\".\"kurzuskod\" AND \"Kurzus\".\"kepzesId\"=\"Hallgato\".\"kepzesId\"-1
            GROUP BY \"Hallgato\".\"nev\", \"Kurzus\".\"kepzesId\") WHERE \"Kepzesideje\".\"kepzesId\"=\"id\" AND \"Kepzes\".\"kepzesId\"=\"id\"");
            oci_execute($seged);
            while ($row0 = oci_fetch_assoc($seged)) {

        ?>
        <tr>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row0["h_nev"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row0["kepzes"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row0["szakkod"]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row0["atlag"]?></td>
        </tr>
        <?php
        }}
    }else if($ev>1){
        $szoveg=' hallgato van, aki '.$ev.'-ban/ben szerzett diplomat.';
        oci_execute($ev_diploma);
        while ($row = oci_fetch_assoc($ev_diploma)) {
            $szamlalo=$szamlalo+1;
            $code=$row["urancode"];
            $seged=oci_parse($conn, "SELECT \"osszeg\"/(\"felevek_szama\"*30) AS \"atlag\",\"h_nev\", \"Kepzes\".\"nev\" AS \"kepzes\", \"szakkod\" FROM \"Kepzesideje\", \"Kepzes\", (SELECT \"Kurzus\".\"kepzesId\" AS \"id\", SUM(\"Kurzus\".\"kredit\" * \"Hallgatoja\".\"erdemjegy\") AS \"osszeg\", \"Hallgato\".\"nev\" AS \"h_nev\" FROM \"Hallgato\", \"Hallgatoja\", \"Kurzus\"
            WHERE \"Hallgato\".\"urancode\"='{$code}' AND \"Hallgatoja\".\"urancode\"='{$code}' AND \"Kurzus\".\"kurzuskod\"=\"Hallgatoja\".\"kurzuskod\" AND \"Kurzus\".\"kepzesId\"=\"Hallgato\".\"kepzesId\"-1
            GROUP BY \"Hallgato\".\"nev\", \"Kurzus\".\"kepzesId\") WHERE \"Kepzesideje\".\"kepzesId\"=\"id\" AND \"Kepzes\".\"kepzesId\"=\"id\"");
         oci_execute($seged);
         while ($row0 = oci_fetch_assoc($seged)) {

     ?>
     <tr>
     <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row0["h_nev"]?></td>
     <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row0["kepzes"]?></td>
     <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row0["szakkod"]?></td>
     <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row0["atlag"]?></td>
     </tr>
        <?php }}}
    
?>
</table>
<h3>
<?php
if(isset($_POST["valami"])) {
    echo $szamlalo.$szoveg;
}
?>
</h3>
<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>
<?php
oci_free_statement($compiled);
oci_close($conn);
?>