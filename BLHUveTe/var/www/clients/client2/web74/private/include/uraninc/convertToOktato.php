<?php
session_start();
$condb = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$code_oktato=$_GET['varname'];
$get_oktato = oci_parse($condb, "SELECT * FROM \"Oktato\" WHERE \"urancode\" = '{$code_oktato}'");
oci_execute($get_oktato);
$data = oci_fetch_array($get_oktato);
oci_free_statement($get_oktato);
oci_close($condb);
if(isset($data[0])){
     echo("<script>alert('A felhasznalo mar oktato!')</script>");
 	 echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}else{

$conn = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$code=$_GET['varname'];
$get_felhasznalo = oci_parse($conn, "SELECT * FROM \"Felhasznalo\" WHERE \"urancode\" = '{$code}'");
oci_execute($get_felhasznalo);
$row = oci_fetch_assoc($get_felhasznalo);
$urancode = $row["urancode"];
$nev = $row["nev"];
$jelszo = $row["jelszo"];
$profilkep = $row["profilkep"];
oci_free_statement($get_felhasznalo);
$compiled = oci_parse($conn, "INSERT INTO \"Oktato\" (\"urancode\", \"nev\", \"jelszo\", \"profilkep\", \"jogosultsag\") VALUES (:urancode, :nev, :jelszo, :profilkep, 2)");
oci_bind_by_name($compiled, ':urancode', $urancode);
oci_bind_by_name($compiled, ':nev', $nev);
oci_bind_by_name($compiled, ':jelszo', $jelszo);
oci_bind_by_name($compiled, ':profilkep', $profilkep);
$siker = oci_execute($compiled);
//oci_commit($conn);
oci_free_statement($compiled);
oci_close($conn);
if($siker){
    echo("<script>alert('Sikeres oktato konvertalas!')</script>");
    echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}else{
    echo("<script>alert('Hiba az oktato konvertalas soran!')</script>");
    echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}

}?>