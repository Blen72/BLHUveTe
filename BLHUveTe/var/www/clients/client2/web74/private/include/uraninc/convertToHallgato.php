<?php
session_start();
$condb = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$code_hallgato=$_GET['varname'];
$get_hallgato = oci_parse($condb, "SELECT * FROM \"Hallgato\" WHERE \"urancode\" = '{$code_hallgato}'");
oci_execute($get_hallgato);
$data = oci_fetch_array($get_hallgato);
oci_free_statement($get_hallgato);
if(isset($data[0])){
     echo("<script>alert('A felhasznalo mar hallgato!')</script>");
 	 echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}

$szakok = [];
$kepzesek = [];
$get_szak = oci_parse($condb, "SELECT \"szakkod\" FROM \"Szak\"");
oci_execute($get_szak);
while ($row = oci_fetch_array($get_szak)){
    $szakok[] = $row[0];
}
oci_free_statement($get_szak);
$get_kepzes = oci_parse($condb, "SELECT \"kepzesId\" FROM \"Kepzes\"");
oci_execute($get_kepzes);
while ($row = oci_fetch_array($get_kepzes)){
    $kepzesek[] = $row[0];
}
oci_free_statement($get_kepzes);
oci_close($condb);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../../../web74/web/css/hallgato.css" rel="stylesheet">
    <title>Hallgato konvertalas</title>
</head>
<body>
<form action="updateHallgato.php" method="POST" class="new-form">
  <div class="new-container">
  <label for="szakkod"><b>Szakkod</b></label>
  <select name="szakkod" id="szakkod">
    <?php foreach($szakok as $szak) {
    echo '<option value="' . $szak . '">' . $szak . '</option>';}?>
    </select>
  <br>
  <label for="kepzesId"><b>KepzesID</b></label>
  <select name="kepzesId" id="kepzesId">
    <?php foreach($kepzesek as $kepzes) {
    echo '<option value="' . $kepzes . '">' . $kepzes . '</option>';}?>
  </select>
  <input type="hidden" id="urancode" name="urancode" value="<?=$code_hallgato?>">
  <button type="submit" name="submit-new">Konvertalas</button>
  </div>
</form>
</body>
</html>