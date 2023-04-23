<?php
session_start();
if(!$_SESSION["uran_code"])  
{  
  
    header("Location: login.php");  
} 

$urancode = $_SESSION["uran_code"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Elméleti Modulo</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
<div style="margin-left: 0" id="headernav">
    <header><h1>EModulo</h1></header>
    <nav><a href="index.php">Elosztó</a></nav>

    <form action="EModuloIndex.php" method="POST">
    <button type="submit" name="submit-search">Uzenetek mutatasa</button>
    </form>
    </div>

    <?php
    if(isset($_POST['submit-search'])){?>

<table style="font-family: arial, sans-serif; border-collapse: collapse; width: 100%;">
<h1>Uzenetek</h1><a href="ujUzenet.php?varname=<?php echo $urancode ?>"><button>Uj Uzenet</button></a><br><br>
<tr>
    <th style= "border: 3px solid black;text-align: left;">Kuldte</th>
    <th style= "border: 3px solid black;text-align: left;">Uzenet</th>
    <th style= "border: 3px solid black;text-align: left;">Idopont</th>
  </tr>
  <?php

  $condb = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
  $get_uzenet = oci_parse($condb, "SELECT \"uzenet\", \"datum\", \"o_urancode\" FROM \"Uzen\" WHERE \"h_urancode\" = '{$urancode}'");
  oci_execute($get_uzenet);
  
while ($row = oci_fetch_array($get_uzenet)) {
    //itt levagni a stringet else pedig csak continue ha nem azonos
    $escaped_uzenet = explode("---", $row[0]);
    if($escaped_uzenet[0] !== "uzenet"){
        continue;
    }
    $user = $row[2];
    $get_name = oci_parse($condb, "SELECT \"nev\" FROM \"Felhasznalo\" WHERE \"urancode\" = '{$user}'");
    oci_execute($get_name);
    $sor = oci_fetch_array($get_name);
    $nev = $sor[0];
    oci_free_statement($get_name);
    ?>

    <tr>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $nev?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $escaped_uzenet[1]?></td>
        <td style= "border: 2px solid black;text-align: left;padding: 8px;"><?php echo $row[1]?></td>
    </tr>

<?php }
}
?>
<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>
</body>
</html>