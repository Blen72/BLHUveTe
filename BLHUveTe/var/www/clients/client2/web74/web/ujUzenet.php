<?php
session_start();
$urancode = $_GET['varname'];
$condb = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$felhasznalok = [];
$get_felhasznalo = oci_parse($condb, "SELECT \"nev\", \"urancode\" FROM \"Felhasznalo\"");
oci_execute($get_felhasznalo);
while ($row = oci_fetch_array($get_felhasznalo)){
    $felhasznalok[$row[1]] = $row[0];
}
oci_free_statement($get_felhasznalo);
oci_close($condb);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/hallgato.css" rel="stylesheet">
    <title>Uj Uzenet</title>
</head>
<body>
<form action="updateUjUzenet.php" method="POST" class="new-form">
  <div class="new-container">
  <label for="h_urancode"><b>Cimzett</b></label>
  <select name="h_urancode">
    <?php foreach($felhasznalok as $key => $value) {
    echo '<option value="' . $key . '">' . $value . '</option>';
    }?>
    </select>
    <br>
    <br>
  <label for="uzenet"><b>Uzenet</b></label>
  <textarea rows="5" cols="50" name="uzenet" placeholder="Uzenet" maxlength="450" required></textarea>
  <input type="hidden" name="o_urancode" value="<?=$urancode?>">
  <button type="submit" name="submit-new">Uzenet kuldese</button>
  </div>
</form>
</body>
</html>