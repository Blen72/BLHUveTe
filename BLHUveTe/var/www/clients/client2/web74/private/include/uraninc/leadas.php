<?php
session_start();
$conn = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$code = $_SESSION["uran_code"];
$kurzus=$_GET['varname'];
$compiled = oci_parse($conn, "DELETE FROM \"Hallgatoja\" WHERE \"urancode\" = '{$code}' AND \"kurzuskod\" = '{$kurzus}'");
$siker = oci_execute($compiled);
//oci_commit($conn);
oci_free_statement($compiled);
oci_close($conn);
if($siker){
    echo("<script>alert('Sikeresen leadtad a targyat!')</script>");
    echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}else{
    echo("<script>alert('Hiba tortent a targyleadas soran!')</script>");
    echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}

?>