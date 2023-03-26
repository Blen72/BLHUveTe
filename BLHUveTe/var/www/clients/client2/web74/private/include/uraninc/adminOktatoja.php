<?php
if($_SESSION["user"]["oktato"]>1){
    echo "<h4>Oktatója</h4>";
    echo "<form action='UranIndex.php' method='post'>";
    print_sql($adatb, "oktatoja,oktato", ["oktatoja.urancode","nev","kurzuskod"],"WHERE oktato.urancode=oktatoja.urancode","<th>Törlés</th>",[["delOktatoja",["urancode","kurzuskod"],"TÖRLÉS"]]);
    echo "Új oktatója Urankódja: ";print_selectElement($adatb,"oktato","urancode","oktatojaKod");echo "<br/>";
    echo "Új oktatója kurzuskódja: ";print_selectElement($adatb,"kurzus","kurzuskod","oktatojaKurzuskod");echo "<br/>";
    echo "<input type='submit' name='addOktatoja' value='Új oktatója hozzáadása'/>";
    echo "</form>";
    //echo "A módodsításnak nincs értelme. Túl bonyolult. Egyszerűbb ha töröld majd hozzáadsz újat!";
    if(isset($_POST["delOktatoja"])){
        $keys=explode(",", $_POST["delOktatoja"]);
        sql_delete($adatb,"oktatoja","WHERE ".sql_col_mkr("urancode")."='".$keys[0]."' AND ".sql_col_mkr("kurzuskod")."='".$keys[1]."'");
        header("Location: UranIndex.php");
    } elseif (isset($_POST["addOktatoja"])){
        sql_insert($adatb,"oktatoja",["urancode","kurzuskod"],"ss",[$_POST["oktatojaKod"],$_POST["oktatojaKurzuskod"]]);
        header("Location: UranIndex.php");
    }
}
?>