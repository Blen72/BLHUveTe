<?php
$condb = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$neve=$_POST['epulet_neve'];
$cime=$_POST['epulet_cime'];
$get_epulet = oci_parse($condb, "SELECT * FROM \"Epulet\" WHERE \"epulet_neve\" = '{$neve}'");
oci_execute($get_epulet);
$data = oci_fetch_array($get_epulet);
oci_free_statement($get_epulet);
oci_close($condb);
if(isset($data[0])){
     echo("<script>alert('Az epulet mar letezik az adatbazisban!')</script>");
 	 echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}else{
$conn = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$compiled = oci_parse($conn, "INSERT INTO \"Epulet\" (\"epulet_neve\", \"epulet_cime\") VALUES (:epulet_neve, :epulet_cime)");
oci_bind_by_name($compiled, ':epulet_neve', $neve);
oci_bind_by_name($compiled, ':epulet_cime', $cime);
$siker = oci_execute($compiled);
//oci_commit($conn);
oci_free_statement($compiled);
oci_close($conn);
if($siker){
    echo("<script>alert('Sikeresen hozza adtad az epuletet az adatbazishoz!')</script>");
    echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}else{
    echo("<script>alert('Hiba tortent az epulet letrehozasa soran!')</script>");
    echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}
}?>