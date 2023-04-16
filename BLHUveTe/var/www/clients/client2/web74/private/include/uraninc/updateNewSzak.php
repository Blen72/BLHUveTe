<?php
$condb = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$code=$_POST['szakkod'];
$nev=$_POST['szaknev'];
$get_szak = oci_parse($condb, "SELECT * FROM \"Szak\" WHERE \"szakkod\" = '{$code}'");
oci_execute($get_szak);
$data = oci_fetch_array($get_szak);
oci_free_statement($get_szak);
oci_close($condb);
if(isset($data[0])){
     echo("<script>alert('A szak mar letezik az adatbazisban!')</script>");
 	 echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}else{
$conn = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$compiled = oci_parse($conn, "INSERT INTO \"Szak\" (\"szakkod\", \"szaknev\") VALUES (:szakkod, :szaknev)");
oci_bind_by_name($compiled, ':szakkod', $code);
oci_bind_by_name($compiled, ':szaknev', $nev);
$siker = oci_execute($compiled);
//oci_commit($conn);
oci_free_statement($compiled);
oci_close($conn);
if($siker){
    echo("<script>alert('Sikeresen hozza adtad a szakot az adatbazishoz!')</script>");
    echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}else{
    echo("<script>alert('Hiba tortent a szak letrehozasa soran!')</script>");
    echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}
}?>