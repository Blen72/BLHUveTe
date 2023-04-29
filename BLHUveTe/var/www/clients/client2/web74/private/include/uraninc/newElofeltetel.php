<?php
session_start();
$condb = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$kurzuskodnak = [];
$get_kurzuskodnak = oci_parse($condb, "SELECT \"kurzuskod\" FROM \"Kurzus\" WHERE \"kurzuskod\" NOT IN (SELECT \"kurzuskodnak\" FROM \"Elofeltetele\")");
oci_execute($get_kurzuskodnak);
while ($row = oci_fetch_array($get_kurzuskodnak)){
    $kurzuskodnak[] = $row[0];
}
oci_free_statement($get_kurzuskodnak);

$kurzuskodok = [];
$get_kurzuskod = oci_parse($condb, "SELECT \"kurzuskod\" FROM \"Kurzus\"");
oci_execute($get_kurzuskod);
while ($row = oci_fetch_array($get_kurzuskod)){
    $kurzuskodok[] = $row[0];
}
oci_free_statement($get_kurzuskod);

oci_close($condb);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../../../web74/web/css/hallgato.css" rel="stylesheet">
    <title>Elofeltetel hozzaadasa</title>
</head>
<body>
<form action="updateElofeltetele.php" method="POST" class="new-form">
  <div class="new-container">
  <label for="kurzuskodnak"><b>Kurzuskod</b></label>
  <select name="kurzuskodnak">
    <?php foreach($kurzuskodnak as $k) {
    echo '<option value="' . $k . '">' . $k . '</option>';}?>
    </select>
  <br>
  <br>
  <label for="kurzuskod"><b>Elofeltetele</b></label>
  <select name="kurzuskod">
    <?php foreach($kurzuskodok as $kurzuskod) {
    echo '<option value="' . $kurzuskod . '">' . $kurzuskod . '</option>';}?>
    </select>
  <br>
  <br>
  <button type="submit" name="submit-new">Uj elofeltetel</button>
  </div>
</form>
</body>
</html>