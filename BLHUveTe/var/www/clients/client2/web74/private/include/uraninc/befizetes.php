<?php
session_start();
$urancode = $_GET['varname'];
$condb = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$is_hallgato = oci_parse($condb, "SELECT * FROM \"Hallgato\" WHERE \"urancode\" = '{$urancode}'");
oci_execute($is_hallgato);
$data = oci_fetch_array($is_hallgato);
oci_free_statement($is_hallgato);
oci_close($condb);
if(!isset($data[0])){
     echo("<script>alert('On nem hallgato ezert nem fizethet be a felhasznalo fiokjaba!')</script>");
 	 echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../../../web74/web/css/hallgato.css" rel="stylesheet">
    <title>Befizetes</title>
</head>
<body>
<form action="updateBefizetes.php" method="POST" class="new-form">
  <div class="new-container">
  <label for="bankban"><b>Befizetendo Osszeg</b></label>
  <input type="number" name="bankban" placeholder="Befizetendo Osszeg" step='0.001' value='0' pattern='[0-9]' min='0' max='99999' autoComplete="off" required>
  <input type="hidden" id="urancode" name="urancode" value="<?=$urancode?>">
  <button type="submit" name="submit-new">Osszeg Befizetese</button>
  </div>
</form>
</body>
</html>