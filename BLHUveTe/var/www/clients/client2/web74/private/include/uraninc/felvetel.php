<?php
session_start();
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