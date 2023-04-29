<?php
$condb = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');

$kurzuskod=$_POST['kurzuskod'];
$teremkod=$_POST['teremkod'];
$o_urancode=$_POST['o_urancode'];
$idopont=date('d-m-Y H:i', strtotime($_POST['idopont']));    
$tipus=$_POST['tipus'];
$max_letszam=$_POST['max_letszam'];

$compiled = oci_parse($condb, "INSERT INTO \"Vizsga\" (\"kurzuskod\", \"teremkod\", \"o_urancode\", \"idopont\", \"tipus\", \"max_letszam\") VALUES (:kurzuskod, :teremkod, :o_urancode, to_date(:idopont, 'DD-MM-YYYY HH24:MI'), :tipus, :max_letszam)");
oci_bind_by_name($compiled, ':kurzuskod', $kurzuskod);
oci_bind_by_name($compiled, ':teremkod', $teremkod);
oci_bind_by_name($compiled, ':o_urancode', $o_urancode);
oci_bind_by_name($compiled, ':idopont', $idopont);
oci_bind_by_name($compiled, ':tipus', $tipus);
oci_bind_by_name($compiled, ':max_letszam', $max_letszam);
$siker = oci_execute($compiled);
//oci_commit($conn);
oci_free_statement($compiled);
oci_close($condb);
if($siker){
    echo("<script>alert('Sikeresen letrehoztad a vizsgaidopontot!')</script>");
    echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}else{
    echo("<script>alert('Hiba tortent a vizsgaidopont letrehozasa soran!')</script>");
    echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}?>