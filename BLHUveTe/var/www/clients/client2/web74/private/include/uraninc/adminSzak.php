<?php
if($_SESSION["user"]["oktato"]>1){
    echo "<h3>Szakok kezelése</h3>";
    echo "<h4>Szak</h4>";
    echo "<form action='UranIndex.php' method='post'>";
    print_sql($adatb, "szak", ["szakkod","szaknev"],"","<th>Törlés</th>",[["delSzak","szakkod","TÖRLÉS"]]);
    echo "Új szak kódja: <input type='text' name='szakKod' /><br/>";
    echo "Új szak neve: <input type='text' name='szakNev' /><br/>";
    echo "<input type='submit' name='addSzak' value='Új szak hozzáadása'/>";
    echo "</form><form action='UranIndex.php' method='post'>";
    echo "Szak kódja: ";print_selectElement($adatb,"szak","szakkod","szakKod_key");echo "<br/>";
    echo "Szak új kódja: <input type='text' name='szakKod' /><br/>";
    echo "Szak új neve: <input type='text' name='szakNev' /><br/>";
    echo "<input type='submit' name='editSzak' value='Szak szerkesztése'/>";
    echo "</form>";
    echo "<h4>Szakokon van</h4>";
    echo "<form action='UranIndex.php' method='post'>";
    print_sql($adatb, "szakokonvan", ["szakkod","kurzuskod"],"","<th>Törlés</th>",[["delSzakokonvan",["szakkod","kurzuskod"],"TÖRLÉS"]]);
    echo "Új szakhoz hozzáadás: ";print_selectElement($adatb,"szak","szakkod","szakokonvanSzak");echo "<br/>";
    echo "Új kurzus hozzáadása a szakhoz: ";print_selectElement($adatb,"kurzus","kurzuskod","szakokonvanKurzus");echo "<br/>";
    echo "<input type='submit' name='addSzakokonvan' value='Új kurzus hozzáadása szakhoz hozzáadása'/>";
    echo "</form>";
    //echo "A módodsításnak nincs értelme. Túl bonyolult. Egyszerűbb ha töröld majd hozzáadsz újat!";
    if(isset($_POST["delSzak"])){
        sql_delete($adatb,"szak","WHERE ".sql_col_mkr("szakkod")."='".$_POST["delSzak"]."'");
        header("Location: UranIndex.php");
    } elseif (isset($_POST["addSzak"])){
        sql_insert($adatb,"szak",["szakkod","szaknev"],"ss",[$_POST["szakKod"],$_POST["szakNev"]]);
        header("Location: UranIndex.php");
    } elseif (isset($_POST["editSzak"])){
        $keyVal=updateArrayHelper(["szakkod",$_POST["szakKod"],"szaknev",$_POST["szakNev"]]);
        if(!empty($keyVal))sql_update($adatb,"szak",$keyVal,"WHERE ".sql_col_of_table("szak","szakkod")."='".$_POST["szakKod_key"]."'");
        header("Location: UranIndex.php");
    } elseif(isset($_POST["delSzakokonvan"])){
        $keys=explode(",", $_POST["delSzakokonvan"]);
        sql_delete($adatb,"szakokonvan","WHERE ".sql_col_mkr("szakkod")."='".$keys[0]."' AND ".sql_col_mkr("kurzuskod")."='".$keys[1]."'");
        header("Location: UranIndex.php");
    } elseif (isset($_POST["addSzakokonvan"])){
        sql_insert($adatb,"szakokonvan",["szakkod","kurzuskod"],"ss",[$_POST["szakokonvanSzak"],$_POST["szakokonvanKurzus"]]);
        header("Location: UranIndex.php");
    }
}
?>