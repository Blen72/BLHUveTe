<?php
$condb = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$teremkod=$_POST['teremkod'];
$epulet_neve=$_POST['epulet_neve'];
$teremszam=$_POST['teremszam'];
$get_terem = oci_parse($condb, "SELECT * FROM \"Terem\" WHERE \"teremkod\" = '{$teremkod}'");
oci_execute($get_terem);
$data = oci_fetch_array($get_terem);
oci_free_statement($get_terem);
oci_close($condb);
if(isset($data[0])){
     echo("<script>alert('A terem mar letezik az adatbazisban!')</script>");
 	 echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}else{
$conn = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$compiled = oci_parse($conn, "INSERT INTO \"Terem\" (\"teremkod\", \"epulet_neve\", \"teremszam\") VALUES (:teremkod, :epulet_neve, :teremszam)");
oci_bind_by_name($compiled, ':teremkod', $teremkod);
oci_bind_by_name($compiled, ':epulet_neve', $epulet_neve);
oci_bind_by_name($compiled, ':teremszam', $teremszam);
$siker = oci_execute($compiled);
//oci_commit($conn);
oci_free_statement($compiled);
oci_close($conn);
if($siker){
    echo("<script>alert('Sikeresen hozza adtad az epuletet az adatbazishoz!')</script>");
    echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}else{
    echo("<script>alert('Hiba tortent a terem letrehozasa soran!')</script>");
    echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}
}?>