<?php
session_start();
$urancode=$_GET['varname'];
$condb = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$kurzusok = [];
$get_kurzus = oci_parse($condb, "SELECT \"kurzuskod\" FROM \"Kurzus\" WHERE \"kurzuskod\" NOT IN (SELECT \"kurzuskod\" FROM \"Oktatoja\")");
oci_execute($get_kurzus);
while ($row = oci_fetch_array($get_kurzus)){
    $kurzusok[] = $row[0];
}
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
    <title>Oktato Hozzadasa</title>
</head>
<body>
<form action="updateAddOktatoja.php" method="POST" class="new-form">
  <div class="new-container">
  <label for="kurzuskod"><b>Kurzuskod</b>
  <select name="kurzuskod">
    <?php foreach($kurzusok as $kurzus) {
    echo '<option value="' . $kurzus . '">' . $kurzus . '</option>';}?>
    </select>
    <br>
    <br>
    <input type="hidden" name="urancode" value=<?=$urancode?>>
  <button type="submit" name="submit-new">Oktato Hozzadasa</button>
  </div>
</form>
<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>
</body>
</html>