<?php
$conn = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$code=$_POST['urancode'];
$szakkod=$_POST['szakkod'];
$kepzesId=$_POST['kepzesId'];
$get_felhasznalo = oci_parse($conn, "SELECT * FROM \"Felhasznalo\" WHERE \"urancode\" = '{$code}'");
oci_execute($get_felhasznalo);
$row = oci_fetch_assoc($get_felhasznalo);
$urancode = $row["urancode"];
$nev = $row["nev"];
$jelszo = $row["jelszo"];
$profilkep = $row["profilkep"];
oci_free_statement($get_felhasznalo);
$compiled = oci_parse($conn, "INSERT INTO \"Hallgato\" (\"urancode\", \"nev\", \"jelszo\", \"profilkep\", \"szakkod\", \"kepzesId\", \"felev\", \"osszeg\", \"bankban\") VALUES (:urancode, :nev, :jelszo, :profilkep, :szakkod, :kepzesId, 1, 0, 0)");
oci_bind_by_name($compiled, ':urancode', $urancode);
oci_bind_by_name($compiled, ':nev', $nev);
oci_bind_by_name($compiled, ':jelszo', $jelszo);
oci_bind_by_name($compiled, ':profilkep', $profilkep);
oci_bind_by_name($compiled, ':szakkod', $szakkod);
oci_bind_by_name($compiled, ':kepzesId', $kepzesId);
$siker = oci_execute($compiled);
//oci_commit($conn);
oci_free_statement($compiled);
oci_close($conn);
if($siker){
    echo("<script>alert('Sikeres hallgato konvertalas!')</script>");
    echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}else{
    echo("<script>alert('Hiba a hallgato konvertalas soran!')</script>");
    echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}
?>