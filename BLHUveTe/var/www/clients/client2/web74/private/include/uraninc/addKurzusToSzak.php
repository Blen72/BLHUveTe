<?php
session_start();
$condb = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$szakok = [];
$kurzuskod = $_GET['varname'];
$get_szakok = oci_parse($condb, "SELECT \"szakkod\" FROM \"Szak\"");
oci_execute($get_szakok);
while ($row = oci_fetch_array($get_szakok)){
    $szakok[] = $row[0];
}
oci_free_statement($get_szakok);

$get_szakokonvan = oci_parse($condb, "SELECT DISTINCT \"szakkod\" FROM \"Szakokonvan\" WHERE \"kurzuskod\" = '{$kurzuskod}'");
oci_execute($get_szakokonvan);

while ($row = oci_fetch_array($get_szakokonvan)){
    if (($key = array_search($row[0], $szakok)) !== false) {
        unset($szakok[$key]);
    }
}
oci_free_statement($get_szakokonvan);

if(count($szakok) === 0){
     echo("<script>alert('Nincs olyan szak ahol a kurzust nem lenne elerheto!')</script>");
 	 echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}
oci_close($condb);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../../../web74/web/css/hallgato.css" rel="stylesheet">
    <title>Kurzus szakhoz valo hozzaadasa</title>
</head>
<body>
<form action="updateKurzusToSzak.php" method="POST" class="new-form">
  <div class="new-container">
  <label for="szakkod"><b>Szakkod</b></label>
  <select name="szakkod">
    <?php foreach($szakok as $szak) {
    echo '<option value="' . $szak . '">' . $szak . '</option>';}?>
    </select>
    <br>
    <br>
    <label for="kurzuskod"><b>Kurzuskod</b></label>
  <input type="text" name="kurzuskod" value="<?=$kurzuskod?>" readonly>
  <button type="submit" name="submit-new">Kurzus hozzaadasa</button>
  </div>
</form>
<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>
</body>
</html>