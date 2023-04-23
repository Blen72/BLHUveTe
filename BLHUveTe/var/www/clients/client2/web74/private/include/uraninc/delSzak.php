<?php
session_start();
$conn = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$code=$_GET['varname'];
$compiled = oci_parse($conn, "DELETE FROM \"Szak\" WHERE \"szakkod\" = '{$code}'");
$siker = oci_execute($compiled);
//oci_commit($conn);
oci_free_statement($compiled);
oci_close($conn);
if($siker){
    echo("<script>alert('Sikeresen torolte a szakot!')</script>");
    echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}else{
    echo("<script>alert('Hiba tortent a szak torlese soran!')</script>");
    echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}
?>