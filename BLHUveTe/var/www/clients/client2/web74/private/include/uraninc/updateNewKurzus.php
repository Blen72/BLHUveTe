<?php
$condb = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$kurzuskod=$_POST['kurzuskod'];
$nev=$_POST['nev'];
$kepzesId=$_POST['kepzesId'];
$tipus=$_POST['tipus'];
$ajanlott_felev=$_POST['ajanlott_felev'];
$kredit=$_POST['kredit'];
$hossz=$_POST['hossz'];
$kezdet=date('d-m-Y H:i', strtotime($_POST['kezdet']));    
$max_letszam=$_POST['max_letszam'];
$teremkod=$_POST['teremkod'];
$get_kurzus = oci_parse($condb, "SELECT * FROM \"Kurzus\" WHERE \"kurzuskod\" = '{$kurzuskod}'");
oci_execute($get_kurzus);
$data = oci_fetch_array($get_kurzus);
oci_free_statement($get_kurzus);
oci_close($condb);
if(isset($data[0])){
     echo("<script>alert('A kurzus mar letezik az adatbazisban!')</script>");
 	 echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}else{
$conn = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$compiled = oci_parse($conn, "INSERT INTO \"Kurzus\" (\"kurzuskod\", \"nev\", \"kepzesId\", \"tipus\", \"ajanlott_felev\", \"kredit\", \"hossz\", \"kezdet\", \"max_letszam\", \"teremkod\") VALUES (:kurzuskod, :nev, :kepzesId, :tipus, :ajanlott_felev, :kredit, :hossz, to_date(:kezdet, 'DD-MM-YYYY HH24:MI'), :max_letszam, :teremkod)");
oci_bind_by_name($compiled, ':kurzuskod', $kurzuskod);
oci_bind_by_name($compiled, ':nev', $nev);
oci_bind_by_name($compiled, ':kepzesId', $kepzesId);
oci_bind_by_name($compiled, ':tipus', $tipus);
oci_bind_by_name($compiled, ':ajanlott_felev', $ajanlott_felev);
oci_bind_by_name($compiled, ':kredit', $kredit);
oci_bind_by_name($compiled, ':hossz', $hossz);
oci_bind_by_name($compiled, ':kezdet', $kezdet);
oci_bind_by_name($compiled, ':max_letszam', $max_letszam);
oci_bind_by_name($compiled, ':teremkod', $teremkod);
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