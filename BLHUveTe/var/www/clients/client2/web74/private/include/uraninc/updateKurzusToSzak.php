<?php
$conn = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$szakkod=$_POST['szakkod'];
$kurzuskod=$_POST['kurzuskod'];

$compiled = oci_parse($conn, "INSERT INTO \"Szakokonvan\" (\"szakkod\", \"kurzuskod\") VALUES (:szakkod, :kurzuskod)");
oci_bind_by_name($compiled, ':szakkod', $szakkod);
oci_bind_by_name($compiled, ':kurzuskod', $kurzuskod);
$siker = oci_execute($compiled);
//oci_commit($conn);
oci_free_statement($compiled);
oci_close($conn);
if($siker){
    echo("<script>alert('Sikeresen hozza adtad a kurzust a szakhoz!')</script>");
    echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}else{
    echo("<script>alert('Hiba tortent a szakhoz valo hozzaadasa soran!')</script>");
    echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}
?>