<?php
session_start();
$urancode = $_SESSION["uran_code"];
$condb = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$termek = [];
$kurzusok = [];
$get_terem = oci_parse($condb, "SELECT \"teremkod\" FROM \"Terem\"");
oci_execute($get_terem);
while ($row = oci_fetch_array($get_terem)){
    $termek[] = $row[0];
}
$get_kurzus = oci_parse($condb, "SELECT \"kurzuskod\" FROM \"Oktatoja\" WHERE \"urancode\" = '{$urancode}'");
oci_execute($get_kurzus);
while ($row = oci_fetch_array($get_kurzus)){
    $kurzusok[] = $row[0];
}
oci_free_statement($get_terem);
oci_free_statement($get_kurzus);
oci_close($condb);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../../../web74/web/css/hallgato.css" rel="stylesheet">
    <title>Vizsgaidopont Meghirdetese</title>
</head>
<body>
<form action="updateNewVizsga.php" method="POST" class="new-form">
  <div class="new-container">
  <label for="kurzuskod"><b>Kurzuskod</b></label>
  <select name="kurzuskod">
    <?php foreach($kurzusok as $kurzus) {
    echo '<option value="' . $kurzus . '">' . $kurzus . '</option>';}?>
    </select>
  <br>
  <br>
  <label for="teremkod"><b>Teremkod</b></label>
  <select name="teremkod">
    <?php foreach($termek as $terem) {
    echo '<option value="' . $terem . '">' . $terem . '</option>';}?>
    </select>
  <br>
  <br>
  <input type="hidden" name="o_urancode" value="<?=$urancode?>">
  <label for="idopont"><b>Idopont</b></label>
  <input type="date" name="idopont" autoComplete="off" required>
  <label for="tipus"><b>Tipus</b></label>
  <select name="tipus">
    <option value="1">Irasbeli</option>
    <option value="2">Szobeli</option>
    <option value="3">Irasbeli es Szobeli</option>
    </select>
    <br>
  <br>
  <label for="max_letszam"><b>Max Letszam</b></label>
  <input type="number" name="max_letszam" placeholder="Max Letszam" value="0" pattern="[0-9]" min="0" max="999" autoComplete="off" required>
  <button type="submit" name="submit-new">Uj vizsgaidopont meghirdetese</button>
  </div>
</form>
</body>
</html>