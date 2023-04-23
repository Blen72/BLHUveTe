<?php
$uzenet=$_POST['uzenet'];
$h_urancode=$_POST['h_urancode'];
$o_urancode=$_POST['o_urancode'];
$today=date('d-M-Y');

$final_uzenet = "uzenet---".$uzenet;

$conn = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$compiled = oci_parse($conn, "INSERT INTO \"Uzen\" (\"uzenet\", \"h_urancode\", \"o_urancode\", \"datum\") VALUES (:uzenet, :h_urancode, :o_urancode, to_date(:datum, 'DD-MM-YYYY'))");
oci_bind_by_name($compiled, ':uzenet', $final_uzenet);
oci_bind_by_name($compiled, ':h_urancode', $h_urancode);
oci_bind_by_name($compiled, ':o_urancode', $o_urancode);
oci_bind_by_name($compiled, ':datum', $today);
$siker = oci_execute($compiled);
//oci_commit($conn);
oci_free_statement($compiled);
oci_close($conn);
if($siker){
    echo("<script>alert('Sikeresen elkuldted az uzenetet!')</script>");
    echo("<script>window.location = 'EModuloIndex.php';</script>");
}else{
    echo("<script>alert('Hiba tortent az uzenet kuldese soran!')</script>");
    echo("<script>window.location = 'EModuloIndex.php';</script>");
}
?>