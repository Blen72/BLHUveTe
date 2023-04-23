<?php
session_start();
$kurzuskod=$_GET['varname'];

$conect = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$get_elofeltetel = oci_parse($conect, "SELECT \"kurzuskod\" FROM \"Elofeltetele\" WHERE \"kurzuskodnak\" = '{$kurzuskod}'");
oci_execute($get_elofeltetel);
$sor = oci_fetch_array($get_elofeltetel);
$adat = @$sor[0];
oci_free_statement($get_elofeltetel);

$get_adat = oci_parse($conect, "SELECT * FROM \"Hallgatoja\" WHERE \"kurzuskod\" = '{$adat}' AND \"erdemjegy\" < 2");
oci_execute($get_adat);
$data = oci_fetch_array($get_adat);
oci_free_statement($get_adat);
oci_close($conect);
if(isset($data[0])){
     echo("<script>alert('Ezt a kurzust meg nem veheti fel mig a kovetkezo kurzust nem teljesiti : $adat!')</script>");
 	 echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
     return;
}

$one = 1;//i know this is very dumb and im embarrassed
$condb = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$get_count = oci_parse($condb, "SELECT COUNT(*) FROM \"Hallgatoja\" WHERE \"kurzuskod\" = '{$kurzuskod}' AND \"felvett\" = '{$one}'");
oci_execute($get_count);
$row = oci_fetch_assoc($get_count);
$count = $row['COUNT(*)'];
oci_free_statement($get_count);

$get_letszam = oci_parse($condb, "SELECT \"max_letszam\" FROM \"Kurzus\" WHERE \"kurzuskod\" = '{$kurzuskod}'");
oci_execute($get_letszam);
$row = oci_fetch_array($get_letszam);
$max_letszam = $row[0];
oci_free_statement($get_letszam);
oci_close($condb);

if($count >= $max_letszam){
    echo("<script>alert('A kurzus max letszama betelt!')</script>");
    echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
    return;
}

$conn = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$code = $_SESSION["uran_code"];
$get_felev = oci_parse($conn, "SELECT \"felev\" FROM \"Hallgato\" WHERE \"urancode\" = '{$code}'");
oci_execute($get_felev);
$row = oci_fetch_array($get_felev);
$felev = $row[0];
oci_free_statement($get_felev);
$kurzus=$_GET['varname'];
$compiled = oci_parse($conn, "INSERT INTO \"Hallgatoja\" (\"urancode\", \"kurzuskod\", \"hanyadjara\", \"felveteli_felev\", \"felvett\", \"erdemjegy\") VALUES (:urancode, :kurzuskod, 1, :felveteli_felev, 1, 0)");
oci_bind_by_name($compiled, ':urancode', $code);
oci_bind_by_name($compiled, ':kurzuskod', $kurzus);
oci_bind_by_name($compiled, ':felveteli_felev', $felev);
$siker = oci_execute($compiled);
//oci_commit($conn);
oci_free_statement($compiled);
oci_close($conn);
if($siker){
    echo("<script>alert('Sikeres targyfelvetel!')</script>");
    echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}else{
    echo("<script>alert('Hiba tortent a targyfelvetel soran!')</script>");
    echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}

?>