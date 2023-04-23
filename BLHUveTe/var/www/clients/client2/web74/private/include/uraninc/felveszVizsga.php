<?php
session_start();
$urancode = $_SESSION["uran_code"];
$vizsgaId = $_GET['varname'];

$condb= oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$get_count = oci_parse($condb, "SELECT COUNT(\"vizsgaId\") FROM \"Vizsgaja\"");
oci_execute($get_count);
$sor = oci_fetch_array($get_count);
$count = $sor[0];
oci_free_statement($get_count);

$get_letszam = oci_parse($condb, "SELECT \"max_letszam\" FROM \"Vizsga\" WHERE \"vizsgaId\" = '{$vizsgaId}'");
oci_execute($get_letszam);
$row = oci_fetch_array($get_letszam);
$max_letszam = $row[0];
oci_free_statement($get_letszam);
oci_close($condb);

if($count >= $max_letszam){
    echo("<script>alert('A vizsga max letszama betelt!')</script>");
    echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
    return;
}

$conn = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$compiled = oci_parse($conn, "INSERT INTO \"Vizsgaja\" (\"vizsgaId\", \"h_urancode\") VALUES (:vizsgaId, :h_urancode)");
oci_bind_by_name($compiled, ':vizsgaId', $vizsgaId);
oci_bind_by_name($compiled, ':h_urancode', $urancode);
$siker = oci_execute($compiled);
//oci_commit($conn);
oci_free_statement($compiled);
oci_close($conn);
if($siker){
    echo("<script>alert('Sikeres vizsgafelvetel!')</script>");
    echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}else{
    echo("<script>alert('Hiba tortent a vizsgafelvetel soran!')</script>");
    echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}

?>