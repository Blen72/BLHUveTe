<?php
$urancode=$_POST['urancode'];
$kurzuskod=$_POST['kurzuskod'];
$conn = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$compiled = oci_parse($conn, "INSERT INTO \"Oktatoja\" (\"urancode\", \"kurzuskod\") VALUES (:urancode, :kurzuskod)");
oci_bind_by_name($compiled, ':urancode', $urancode);
oci_bind_by_name($compiled, ':kurzuskod', $kurzuskod);
$siker = oci_execute($compiled);
//oci_commit($conn);
oci_free_statement($compiled);
oci_close($conn);
if($siker){
    echo("<script>alert('Sikeresen hozzaadtad az oktatot a kurzushoz!')</script>");
    echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}else{
    echo("<script>alert('Hiba tortent az oktato kurzushoz valo hozzadasa soran!')</script>");
    echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}
?>