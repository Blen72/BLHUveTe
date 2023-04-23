<?php
$conn = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$compiled = oci_parse($conn,"BEGIN proc_targyfelvetel; END;");
oci_execute($compiled);
oci_free_statement($compiled);
oci_close($conn);
echo("<script>alert('Sikeres Valtozas!')</script>");
echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
?>