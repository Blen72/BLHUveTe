<?php
session_start();
$conn = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$urancode= $_GET['varname'];
$kurzuskod=$_GET['kurzus'];
$compiled = oci_parse($conn, "DELETE FROM \"Hallgatoja\" WHERE \"urancode\" = '{$urancode}' AND \"kurzuskod\" = '{$kurzuskod}'");
$siker = oci_execute($compiled);
//oci_commit($conn);
oci_free_statement($compiled);
oci_close($conn);
if($siker){
    echo("<script>alert('Sikeresen ledobta a targyrol!')</script>");
    echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}else{
    echo("<script>alert('Hiba tortent a targyledobas soran!')</script>");
    echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}

?>