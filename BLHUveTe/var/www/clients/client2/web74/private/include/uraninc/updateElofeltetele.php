<?php
$conn = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$kurzuskodnak=$_POST['kurzuskodnak'];
$kurzuskod=$_POST['kurzuskod'];
if($kurzuskod === $kurzuskodnak){
    echo("<script>alert('Nem lehet a kurzusnak onmaga az elofeltetele!')</script>");
    echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
    return;
}

$compiled = oci_parse($conn, "INSERT INTO \"Elofeltetele\" (\"kurzuskodnak\", \"kurzuskod\") VALUES (:kurzuskodnak, :kurzuskod)");
oci_bind_by_name($compiled, ':kurzuskodnak', $kurzuskodnak);
oci_bind_by_name($compiled, ':kurzuskod', $kurzuskod);
$siker = oci_execute($compiled);
//oci_commit($conn);
oci_free_statement($compiled);
oci_close($conn);
if($siker){
    echo("<script>alert('Sikeresen hozza adtad az elofeltetelt a kurzushoz!')</script>");
    echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}else{
    echo("<script>alert('Hiba tortent a kurzushoz valo elofeltetel hozzaadasa soran!')</script>");
    echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}
?>