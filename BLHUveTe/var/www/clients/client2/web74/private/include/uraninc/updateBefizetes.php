<?php
$condb = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$bankban=$_POST['bankban'];
$urancode=$_POST['urancode'];
$conn = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$compiled = oci_parse($conn, "UPDATE \"Hallgato\" SET \"bankban\" = \"bankban\" + '{$bankban}' WHERE \"urancode\" = '{$urancode}'");
$siker = oci_execute($compiled);
//oci_commit($conn);
oci_free_statement($compiled);
oci_close($conn);
if($siker){
    echo("<script>alert('Sikeresen befizettel!')</script>");
    echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}else{
    echo("<script>alert('Hiba tortent a befizetes soran!')</script>");
    echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}
?>