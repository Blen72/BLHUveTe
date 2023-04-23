<?php
session_start();
$condb = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$kepzesek = [];
$get_kepzes = oci_parse($condb, "SELECT \"kepzesId\" FROM \"Kepzes\"");
oci_execute($get_kepzes);
while ($row = oci_fetch_array($get_kepzes)){
    $kepzesek[] = $row[0];
}
oci_free_statement($get_kepzes);

$termek = [];
$get_terem = oci_parse($condb, "SELECT \"teremkod\" FROM \"Terem\"");
oci_execute($get_terem);
while ($row = oci_fetch_array($get_terem)){
    $termek[] = $row[0];
}
oci_free_statement($get_terem);
oci_close($condb);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../../../web74/web/css/hallgato.css" rel="stylesheet">
    <title>Kurzus Felvetele</title>
</head>
<body>
<form action="updateNewKurzus.php" method="POST" class="new-form">
  <div class="new-container">
  <label for="kurzuskod"><b>Kurzuskod</b></label>
  <input type="text" name="kurzuskod" placeholder="Kurzuskod" autoComplete="off" maxlength="20" required>
  <label for="nev"><b>Kurzusnev</b></label>
  <input type="text" name="nev" placeholder="Kurzusnev" autoComplete="off" maxlength="200" required>
  <label for="kepzesId"><b>KepzesId</b></label>
  <select name="kepzesId" id="kepzesId">
    <?php foreach($kepzesek as $kepzes) {
    echo '<option value="' . $kepzes . '">' . $kepzes . '</option>';}?>
    </select>
    <br>
    <br>

    <label for="tipus"><b>Tipus</b></label>
  <input type="number" name="tipus" placeholder="Tipus" value="0" pattern="[0-9]" min="0" max="9" autoComplete="off" required>
  <label for="ajanlott_felev"><b>Ajanlott Felev</b></label>
  <input type="number" name="ajanlott_felev" placeholder="Ajanlott Felev" value="0" pattern="[0-9]" min="-999" max="999" autoComplete="off" required>
  <label for="kredit"><b>Kredit</b></label>
  <input type="number" name="kredit" placeholder="Kredit" value="0" pattern="[0-9]" min="0" max="99" autoComplete="off" required>
  <label for="hossz"><b>Hossz</b></label>
  <input type="number" name="hossz" placeholder="Hossz" value="0" pattern="[0-9]" min="0" max="9999" autoComplete="off" required>
  <label for="kezdet"><b>Kezdet</b></label>
  <input type="date" name="kezdet" placeholder="Max Letszam" autoComplete="off" required>
  <label for="max_letszam"><b>Max Letszam</b></label>
  <input type="number" name="max_letszam" placeholder="Max Letszam" value="0" pattern="[0-9]" min="0" max="9999" autoComplete="off" required>
  <label for="teremkod"><b>Teremkod</b></label>
  <select name="teremkod" id="teremkod">
    <?php foreach($termek as $terem) {
    echo '<option value="' . $terem . '">' . $terem . '</option>';}?>
    </select>
    <br>
    <br>
  <button type="submit" name="submit-new">Uj Kurzus hozzadasa</button>
  </div>
</form>
</body>
</html>