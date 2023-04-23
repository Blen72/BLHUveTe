<?php
$uzenet=$_POST['uzenet'];
$kurzuskod=$_POST['kurzuskod'];
$urancode=$_POST['urancode'];
$today=date('d-M-Y');

$final_uzenet = $kurzuskod."---".$uzenet;

$conn = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$compiled = oci_parse($conn, "INSERT INTO \"Uzen\" (\"uzenet\", \"h_urancode\", \"o_urancode\", \"datum\") VALUES (:uzenet, :h_urancode, :o_urancode, to_date(:datum, 'DD-MM-YYYY'))");
oci_bind_by_name($compiled, ':uzenet', $final_uzenet);
oci_bind_by_name($compiled, ':h_urancode', $urancode);
oci_bind_by_name($compiled, ':o_urancode', $urancode);
oci_bind_by_name($compiled, ':datum', $today);
$siker = oci_execute($compiled);
//oci_commit($conn);
oci_free_statement($compiled);
oci_close($conn);
if($siker){
    echo("<script>alert('Sikeresen hozzaszoltal a forumhoz!')</script>");
    echo("<script>window.location = 'ECoospaceIndex.php';</script>");
}else{
    echo("<script>alert('Hiba tortent a forum hozzaszolasa soran!')</script>");
    echo("<script>window.location = 'ECoospaceIndex.php';</script>");
}
?>