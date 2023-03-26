<?php
if($_SESSION["user"]["oktato"]>1){
    echo "<h3>Felhasználók kezelése</h3>";
    echo "<h4>Felhasználók</h4>";
    echo "<form action='UranIndex.php' method='post'>";
    print_sql($adatb, "felhasznalo", ["urancode","nev",/*"jelszo",*/"profilkep"],"WHERE ".sql_col_mkr("urancode")." NOT IN (".sql_subselect_mkr("hallgato",["urancode"]).") AND ".sql_col_mkr("urancode")." NOT IN (".sql_subselect_mkr("oktato",["urancode"]).")","<th>Törlés</th><th>Oktatóvá váltás</th><th>Hallgatóvá váltás</th>",[["delUser","urancode","TÖRLÉS"],["addO","urancode","OKTATÓVÁ"],["addH","urancode","HALLGATÓVÁ"]]);
    echo "</form>";
    echo "<h4>Hallgató</h4>";
    echo "<form action='UranIndex.php' method='post'>";
    print_sql($adatb, "hallgato", ["urancode","nev",/*"jelszo",*/"profilkep","szakkod","kepzesId","felev"],"WHERE ".sql_col_mkr("urancode")." NOT IN (".sql_subselect_mkr("oktato",["urancode"]).")","<th>Törlés</th><th>Oktatóvá váltás</th><th>Hallgatóból váltás</th>",[["delUser","urancode","TÖRLÉS"],["addO","urancode","OKTATÓVÁ"],["removeH","urancode","HALLGATÓBÓL"]]);
    echo "</form>";
    echo "<h4>Oktató</h4>";
    echo "<form action='UranIndex.php' method='post'>";
    print_sql($adatb, "oktato", ["urancode","nev",/*"jelszo",*/"profilkep","jogosultsag"],"WHERE ".sql_col_mkr("urancode")." NOT IN (".sql_subselect_mkr("hallgato",["urancode"]).")","<th>Törlés</th><th>Oktatóból váltás</th><th>Hallgatóvá váltás</th>",[["delUser","urancode","TÖRLÉS"],["removeO","urancode","OKTATÓBÓL"],["addH","urancode","HALLGATÓVÁ"]]);
    echo "</form>";
    echo "<h4>Oktató és Hallgató</h4>";
    echo "<form action='UranIndex.php' method='post'>";
    print_sql($adatb, "oktato,hallgato", ["hallgato.urancode","hallgato.nev",/*"hallgato.jelszo",*/"hallgato.profilkep","jogosultsag","szakkod","kepzesId","felev"],"WHERE ".sql_col_of_table("oktato","urancode")."=".sql_col_of_table("hallgato","urancode"),"<th>Törlés</th><th>Oktatóból váltás</th><th>Hallgatóvá váltás</th>",[["delUser","urancode","TÖRLÉS"],["removeO","urancode","OKTATÓBÓL"],["removeH","urancode","HALLGATÓBÓL"]]);
    echo "</form>";
    if(isset($_POST["delUser"])){
        sql_delete($adatb,"felhasznalo","WHERE ".sql_col_mkr("urancode")."='".$_POST["delUser"]."'");
        header("Location: UranIndex.php");
    } elseif(isset($_POST["addH"])) {
        $dat=sql_select($adatb,"felhasznalo",["urancode","nev","jelszo","profilkep"],"WHERE ".sql_col_mkr("urancode")."='".$_POST["addH"]."'");
        $adat=mysqli_fetch_assoc($dat);
        mysqli_free_result($dat);
        sql_insert($adatb,"hallgato",["urancode","nev","jelszo","profilkep","szakkod","kepzesId","felev"],"ssssssd",[$adat["urancode"],$adat["nev"],$adat["jelszo"],$adat["profilkep"],"EPTIT","BSc",1]);
        header("Location: UranIndex.php");
    } elseif(isset($_POST["addO"])) {
        $dat=sql_select($adatb,"felhasznalo",["urancode","nev","jelszo","profilkep"],"WHERE ".sql_col_mkr("urancode")."='".$_POST["addO"]."'");
        $adat=mysqli_fetch_assoc($dat);
        mysqli_free_result($dat);
        sql_insert($adatb,"oktato",["urancode","nev","jelszo","profilkep","jogosultsag"],"ssssd",[$adat["urancode"],$adat["nev"],$adat["jelszo"],$adat["profilkep"],1]);
        header("Location: UranIndex.php");
    } elseif(isset($_POST["removeH"])) {
        sql_delete($adatb,"hallgato","WHERE ".sql_col_mkr("urancode")."='".$_POST["removeH"]."'");
        header("Location: UranIndex.php");
    } elseif(isset($_POST["removeO"])) {
        sql_delete($adatb,"oktato","WHERE ".sql_col_mkr("urancode")."='".$_POST["removeO"]."'");
        header("Location: UranIndex.php");
    }
}
?>