<?php
session_start();
$one = 1;//i know this is very dumb and im embarrassed
$zero = 0;//i know this is very dumb and im embarrassed
$oktato = $_SESSION["uran_code"];
$condb = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$kurzusok = [];
$hallgato=$_GET['varname'];
$get_oktatoja = oci_parse($condb, "SELECT \"Oktatoja\".\"kurzuskod\" FROM \"Hallgatoja\", \"Oktatoja\" WHERE \"Hallgatoja\".\"kurzuskod\" = \"Oktatoja\".\"kurzuskod\" AND \"Hallgatoja\".\"urancode\" = '{$hallgato}' AND \"Oktatoja\".\"urancode\" = '{$oktato}'AND \"felvett\" = '{$one}' AND \"erdemjegy\" = '{$zero}'");
oci_execute($get_oktatoja);
$data = oci_fetch_array($get_oktatoja);
oci_free_statement($get_oktatoja);
oci_close($condb);
if(!isset($data[0])){
    oci_free_statement($get_oktatoja);
    oci_close($condb);
     echo("<script>alert('On nem oktatoja a hallgatonak!')</script>");
 	 echo("<script>window.location = '../../../../web74/web/UranIndex.php';</script>");
}
$con = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$get_kurzus = oci_parse($con, "SELECT \"Oktatoja\".\"kurzuskod\" FROM \"Hallgatoja\", \"Oktatoja\" WHERE \"Hallgatoja\".\"kurzuskod\" = \"Oktatoja\".\"kurzuskod\" AND \"Hallgatoja\".\"urancode\" = '{$hallgato}' AND \"Oktatoja\".\"urancode\" = '{$oktato}'AND \"felvett\" = '{$one}' AND \"erdemjegy\" = '{$zero}'");
oci_execute($get_kurzus);
while ($row = oci_fetch_array($get_kurzus)){
    $kurzusok[] = $row[0];
}
oci_free_statement($get_kurzus);
oci_close($con);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../../../web74/web/css/hallgato.css" rel="stylesheet">
    <title>Jegybeiras</title>
</head>
<body>
<form action="updateJegy.php" method="POST" class="new-form">
  <div class="new-container">
  <label for="kurzuskod"><b>Kurzuskod</b></label>
  <select name="kurzuskod" id="kurzuskod">
    <?php foreach($kurzusok as $kurzus) {
    echo '<option value="' . $kurzus . '">' . $kurzus . '</option>';}?>
    </select>
    <br>
    <br>
    <label for="erdemjegy"><b>Erdemjegy</b></label>
  <input type="number" name="erdemjegy" placeholder="Erdemjegy" value="1" pattern="[0-9]" min="1" max="5" autoComplete="off" required>
  <input type="hidden" name="urancode" value=<?=$hallgato?>>
  <button type="submit" name="submit-new">Jegybeiras</button>
  </div>
</form>
<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>
</body>
</html>