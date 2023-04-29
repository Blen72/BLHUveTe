<?php
session_start();
$conn = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$szakkod=$_GET['szakkod'];
$kurzuskod=$_GET['kurzuskod'];
$compiled = oci_parse($conn, "DELETE FROM \"Szakokonvan\" WHERE \"szakkod\" = '{$szakkod}' AND \"kurzuskod\" = '{$kurzuskod}'");
$siker = oci_execute($compiled);
//oci_commit($conn);
oci_free_statement($compiled);
oci_close($conn);
if($siker){
    echo("<script>alert('Sikeresen torolte a szakrol a kurzust!')</script>");
    echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}else{
    echo("<script>alert('Hiba tortent az kurzus szakrol valo torlese soran!')</script>");
    echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}
?>