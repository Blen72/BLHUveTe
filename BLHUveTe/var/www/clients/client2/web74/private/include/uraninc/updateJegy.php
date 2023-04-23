<?php
$conn = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$urancode = $_POST['urancode'];
$erdemjegy = $_POST['erdemjegy'];
$kurzuskod = $_POST['kurzuskod'];
$zero = 0;//i know this is very dumb and im embarrassed
$compiled = oci_parse($conn, "UPDATE \"Hallgatoja\" SET \"erdemjegy\" = '{$erdemjegy}', \"felvett\" = '{$zero}' WHERE \"urancode\" = '{$urancode}' AND \"kurzuskod\" = '{$kurzuskod}'");
$siker = oci_execute($compiled);
//oci_commit($conn);
oci_free_statement($compiled);
oci_close($conn);
if($siker){
    echo("<script>alert('Sikeres jegybeiras!')</script>");
    echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}else{
    echo("<script>alert('Hiba tortent a jegybeiras soran!')</script>");
    echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}
?>