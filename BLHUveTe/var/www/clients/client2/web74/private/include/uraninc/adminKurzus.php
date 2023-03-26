<?php
if($_SESSION["user"]["oktato"]>1){
    echo "<h3>Kurzusok kezelése</h3>";
    echo "<h4>Kurzus</h4>";
    echo "<form action='UranIndex.php' method='post'>";
    print_sql($adatb, "kurzus", ["kurzuskod","nev","kepzesId","tipus","ajanlott_felev","kredit","hossz","kezdet","max_letszam","teremkod"],"","<th>Törlés</th>",[["delKurzus","kurzuskod","TÖRLÉS"]]);
    echo "Új kurzus kódja: <input type='text' name='kurzusKod' /><br/>";
    echo "Új kurzus neve: <input type='text' name='kurzusNev' /><br/>";
    echo "Új kurzus képzése: <input type='text' name='kurzusKepzes' /><br/>";
    echo "Új kurzus típusa: <input type='number' name='kurzusTipus' /><br/>";
    echo "Új kurzus ajánott féléve: <input type='number' name='kurzusAjanlottFelev' /><br/>";
    echo "Új kurzus kreditje: <input type='number' name='kurzusKredit' /><br/>";
    echo "Új kurzus hossza (perc): <input type='number' name='kurzusHossz' /><br/>";
    echo "Új kurzus kezdete: <input type='datetime-local' name='kurzusKezdet' /><br/>";
    echo "Új kurzus maximális létszáma: <input type='number' name='kurzusMaxLetszam' /><br/>";
    echo "Új kurzus teremkódja: ";print_selectElement($adatb,"terem","teremkod","kurzusTerem");echo "<br/>";
    echo "<input type='submit' name='addKurzus' value='Új kurzus hozzáadása'/>";
    echo "</form><form action='UranIndex.php' method='post'>";
    echo "Kurzus neve: ";print_selectElement($adatb,"kurzus","kurzuskod","kurzusKod_key");echo "<br/>";
    echo "Kurzus új kódja: <input type='text' name='kurzusKod' /><br/>";
    echo "Kurzus új neve: <input type='text' name='kurzusNev' /><br/>";
    echo "Kurzus új képzése: <input type='text' name='kurzusKepzes' /><br/>";
    echo "Kurzus új típusa: <input type='number' name='kurzusTipus' /><br/>";
    echo "Kurzus új ajánott féléve: <input type='number' name='kurzusAjanlottFelev' /><br/>";
    echo "Kurzus új kreditje: <input type='number' name='kurzusKredit' /><br/>";
    echo "Kurzus új hossza (perc): <input type='number' name='kurzusHossz' /><br/>";
    echo "Kurzus új kezdete: <input type='datetime-local' name='kurzusKezdet' /><br/>";
    echo "Kurzus új maximális létszáma: <input type='number' name='kurzusMaxLetszam' /><br/>";
    echo "Kurzus új teremkódja: ";print_selectElement($adatb,"terem","teremkod","kurzusTerem",true);echo "<br/>";
    echo "<input type='submit' name='editKurzus' value='Kurzus szerkesztése'/>";
    echo "</form>";
    if(isset($_POST["delKurzus"])){
        sql_delete($adatb,"kurzus","WHERE ".sql_col_mkr("kurzuskod")."='".$_POST["delKurzus"]."'");
        header("Location: UranIndex.php");
    } elseif (isset($_POST["addKurzus"])){
        sql_insert($adatb,"kurzus",["kurzuskod","nev","kepzesId","tipus","ajanlott_felev","kredit","hossz","kezdet","max_letszam","teremkod"],"sssddddids",[$_POST["kurzusKod"],$_POST["kurzusNev"],$_POST["kurzusKepzes"],$_POST["kurzusTipus"],$_POST["kurzusAjanlottFelev"],$_POST["kurzusKredit"],$_POST["kurzusHossz"],$_POST["kurzusKezdet"],$_POST["kurzusMaxLetszam"],$_POST["kurzusTerem"]]);
        header("Location: UranIndex.php");
    } elseif (isset($_POST["editKurzus"])){
        $keyVal=updateArrayHelper(["kurzuskod",$_POST["kurzusKod"],"nev",$_POST["kurzusNev"],"kepzesId",$_POST["kurzusKepzes"],"tipus",$_POST["kurzusTipus"],"ajanlott_felev",$_POST["kurzusAjanlottFelev"],"kredit",$_POST["kurzusKredit"],"hossz",$_POST["kurzusHossz"],"kezdet",$_POST["kurzusKezdet"],"max_letszam",$_POST["kurzusMaxLetszam"],"teremkod",$_POST["kurzusTerem"]]);
        if(!empty($keyVal))sql_update($adatb,"kurzus",$keyVal,"WHERE ".sql_col_of_table("kurzus","kurzuskod")."='".$_POST["kurzusKod_key"]."'");
        header("Location: UranIndex.php");
    }
    echo "<h4>Előfeltétele</h4>";
    echo "<form action='UranIndex.php' method='post'>";
    print_sql($adatb, "elofeltetele", ["kurzuskodnak","kurzuskod"],"","<th>Törlés</th>",[["delElofeltetel",["kurzuskodnak","kurzuskod"],"TÖRLÉS"]]);
    echo "Új előfeltétel kurzuskódnak: ";print_selectElement($adatb,"kurzus","kurzuskod","elofeltetelKorzuskodnak");echo "<br/>";
    echo "Új előfeltétel kurzuskód: ";print_selectElement($adatb,"kurzus","kurzuskod","elofeltetelKorzuskod");echo "<br/>";
    echo "<input type='submit' name='addElofeltetel' value='Új előfeltétel hozzáadása'/>";
    echo "</form>";
    //echo "A módodsításnak nincs értelme. Túl bonyolult. Egyszerűbb ha töröld majd hozzáadsz újat!";
    if(isset($_POST["delElofeltetel"])){
        $keys=explode(",", $_POST["delElofeltetel"]);
        sql_delete($adatb,"elofeltetele","WHERE ".sql_col_mkr("kurzuskodnak")."='".$keys[0]."' AND ".sql_col_mkr("kurzuskod")."='".$keys[1]."'");
        header("Location: UranIndex.php");
    } elseif (isset($_POST["addElofeltetel"])){
        sql_insert($adatb,"elofeltetele",["kurzuskodnak","kurzuskod"],"ss",[$_POST["elofeltetelKorzuskodnak"],$_POST["elofeltetelKorzuskod"]]);
        header("Location: UranIndex.php");
    }
}
?>