<?php
session_start();
$condb = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$epuletek = [];
$get_epulet = oci_parse($condb, "SELECT \"epulet_neve\" FROM \"Epulet\"");
oci_execute($get_epulet);
while ($row = oci_fetch_array($get_epulet)){
    $epuletek[] = $row[0];
}
oci_free_statement($get_epulet);
oci_close($condb);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../../../web74/web/css/hallgato.css" rel="stylesheet">
    <title>Terem Felvetele</title>
</head>
<body>
<form action="updateNewTerem.php" method="POST" class="new-form">
  <div class="new-container">
  <label for="teremkod"><b>Teremkod</b></label>
  <input type="text" name="teremkod" placeholder="Teremkod" autoComplete="off" maxlength="20" required>
  <label for="epulet_neve"><b>Epulet neve</b></label>
  <select name="epulet_neve" id="epulet_neve">
    <?php foreach($epuletek as $epulet) {
    echo '<option value="' . $epulet . '">' . $epulet . '</option>';}?>
    </select>
  <br>
  <br>
  <label for="teremszam"><b>Teremszam</b></label>
  <input type="number" name="teremszam" placeholder="Teremszam" value="0" pattern="[0-9]" min="-99999" max="99999" autoComplete="off" required>
  <button type="submit" name="submit-new">Uj terem hozzadasa</button>
  </div>
</form>
</body>
</html>