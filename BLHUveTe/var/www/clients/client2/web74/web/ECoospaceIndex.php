<?php
session_start();
if(!$_SESSION["uran_code"])  
{  
  
    header("Location: login.php");  
} 

$conn = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
$kurzusok = [];
$compiled = oci_parse($conn, "SELECT \"kurzuskod\" FROM \"Kurzus\"");
oci_execute($compiled);
while ($row = oci_fetch_array($compiled)){
    $kurzusok[] = $row[0];
}
oci_free_statement($compiled);
oci_close($conn);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Elméleti Coospace</title>
    <link rel="stylesheet" href="css/main.css">

</head>
<body>
<div id="headernav">
    <header><h1>Elméleti Coospace</h1></header>
    <nav><a href="index.php">Elosztó</a>
    </nav>
</div>

<form action="ECoospaceIndex.php" method="POST">
<label for="kurzusForum"><b>Kurzus Forumok</b></label>
  <select name="kurzusForum" id="kurzusForum">
    <?php foreach($kurzusok as $kurzus) {
    echo '<option value="' . $kurzus . '">' . $kurzus . '</option>';}?>
    </select>
    <button type="submit" name="submit-search">Kurzus Forum mutatasa</button>
</form>

<?php
    if(isset($_POST['submit-search'])){
        $kurzuskod = $_POST["kurzusForum"];
        ?>
        
<table style="font-family: arial, sans-serif; border-collapse: collapse; width: 100%;">
<h1><?php echo $kurzuskod . " Forum" ?></h1><a href="forumUzenet.php?varname=<?php echo $kurzuskod ?>"><button>Uj Forum Uzenet</button></a><br><br>
<tr>
    <th style= "border: 3px solid black;text-align: left;">Posztolta</th>
    <th style= "border: 3px solid black;text-align: left;">Uzenet</th>
    <th style= "border: 3px solid black;text-align: left;">Idopont</th>
  </tr>
  <?php

  $condb = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
  $get_forum = oci_parse($condb, "SELECT \"uzenet\", \"datum\", \"h_urancode\" FROM \"Uzen\"");
  oci_execute($get_forum);
  
while ($row = oci_fetch_array($get_forum)) {
    //itt levagni a stringet else pedig csak continue ha nem azonos
    $escaped_uzenet = explode("---", $row[0]);
    if($escaped_uzenet[0] !== $kurzuskod){
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
    <?php 
    }
    ?>
    </table>
    <?php
    oci_free_statement($get_forum);
    oci_close($condb);
    }
?>
<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>
</body>
</html>