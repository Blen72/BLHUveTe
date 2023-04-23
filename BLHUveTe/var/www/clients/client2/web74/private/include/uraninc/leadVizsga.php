<?php
session_start();
$urancode = $_SESSION["uran_code"];
$vizsgaId = $_GET['varname'];
$conn = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$compiled = oci_parse($conn, "DELETE FROM \"Vizsgaja\" WHERE \"vizsgaId\" = '{$vizsgaId}' AND \"h_urancode\" = '{$urancode}'");
$siker = oci_execute($compiled);
//oci_commit($conn);
oci_free_statement($compiled);
oci_close($conn);
if($siker){
    echo("<script>alert('Sikeres leadata a vizsgaidopontot!')</script>");
    echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}else{
    echo("<script>alert('Hiba tortent a vizsgaidopont leadasa soran!')</script>");
    echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}

?>