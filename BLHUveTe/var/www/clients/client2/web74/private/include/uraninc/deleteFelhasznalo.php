<?php
session_start();
$code_felhasznalo=$_GET['varname'];
$code = $_SESSION["uran_code"];
if($code === $code_felhasznalo){
     echo("<script>alert('Nem tudod onmagad torolni!')</script>");
 	 echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}else{
$conn = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$code=$_GET['varname'];
$compiled = oci_parse($conn, "DELETE FROM \"Felhasznalo\" WHERE \"urancode\" = '{$code}'");
$siker = oci_execute($compiled);
//oci_commit($conn);
oci_free_statement($compiled);
oci_close($conn);
if($siker){
    echo("<script>alert('Sikeresen torolte a felhasznalot!')</script>");
    echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}else{
    echo("<script>alert('Hiba tortent a felhasznalo torlese soran!')</script>");
    echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}

}?>