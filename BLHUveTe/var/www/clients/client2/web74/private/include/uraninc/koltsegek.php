<?php
session_start();
$zero = 0;//i know this is very dumb and im embarrassed
$urancode = $_GET['varname'];
$condb = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$is_hallgato = oci_parse($condb, "SELECT * FROM \"Hallgato\" WHERE \"urancode\" = '{$urancode}'");
oci_execute($is_hallgato);
$data = oci_fetch_array($is_hallgato);
oci_free_statement($is_hallgato);
oci_close($condb);
if(!isset($data[0])){
     echo("<script>alert('On nem hallgato ezert nincsennek befizetendo koltsegei!')</script>");
 	 echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}
$con = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$can_user_pay = oci_parse($con, "SELECT * FROM \"Hallgato\" WHERE \"urancode\" = '{$urancode}'");
oci_execute($can_user_pay);
$data = oci_fetch_assoc($can_user_pay);
$osszeg = $data["osszeg"];
oci_free_statement($can_user_pay);
oci_close($con);
if($data["osszeg"] > $data["bankban"]){
    echo("<script>alert('Nincs elegendo penze a koltsegek kifizetesere!')</script>");
    echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}else{
    $conn = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
    $user_pay = oci_parse($conn, "UPDATE \"Hallgato\" SET \"bankban\" = \"bankban\" - '{$osszeg}' , \"osszeg\" = '{$zero}' WHERE \"urancode\" = '{$urancode}'");
    oci_execute($user_pay);
    oci_free_statement($user_pay);
    oci_close($conn);
    echo("<script>alert('Sikeressen kifizette a koltsegeit!')</script>");
    echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}
?>