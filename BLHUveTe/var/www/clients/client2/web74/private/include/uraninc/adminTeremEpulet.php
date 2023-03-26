<?php
if($_SESSION["user"]["oktato"]>1){
    echo "<h3>Épületek/Termek kezelése</h3>";
    echo "<h4>Épület</h4>";
    echo "<form action='UranIndex.php' method='post'>";
    print_sql($adatb, "epulet", ["epulet_neve","epulet_cime"],"","<th>Törlés</th>",[["delEpulet","epulet_neve","TÖRLÉS"]]);
    echo "Új épület neve: <input type='text' name='epuletNeve' /><br/>";
    echo "Új épület címe: <input type='text' name='epuletCime' /><br/>";
    echo "<input type='submit' name='addEpulet' value='Új épület hozzáadása'/>";
    echo "</form><form action='UranIndex.php' method='post'>";
    echo "Épület neve: ";print_selectElement($adatb,"epulet","epulet_neve","epuletNeve_key");echo "<br/>";
    echo "Épület új neve: <input type='text' name='epuletNeve' /><br/>";
    echo "Épület új címe: <input type='text' name='epuletCime' /><br/>";
    echo "<input type='submit' name='editEpulet' value='Épület szerkesztése'/>";
    echo "</form>";
    echo "<h4>Terem</h4>";
    echo "<form action='UranIndex.php' method='post'>";
    print_sql($adatb, "terem", ["teremkod","epulet_neve","teremszam"],"","<th>Törlés</th>",[["delTerem","teremkod","TÖRLÉS"]]);
    echo "Új terem kódja: <input type='text' name='teremKod' /><br/>";
    echo "Új terem épülete: ";print_selectElement($adatb,"epulet","epulet_neve","teremEpulete");echo "<br/>";
    echo "Új terem száma: <input type='number' name='teremSzam' /><br/>";
    echo "<input type='submit' name='addTerem' value='Új terem hozzáadása'/>";
    echo "</form><form action='UranIndex.php' method='post'>";
    echo "Terem kódja: ";print_selectElement($adatb,"terem","teremkod","teremKod_key");echo "<br/>";
    echo "Terem új kódja: <input type='text' name='teremKod' /><br/>";
    echo "Terem új épülete: ";print_selectElement($adatb,"epulet","epulet_neve","teremEpulete",true);echo "<br/>";
    echo "Terem új száma: <input type='number' name='teremSzam' /><br/>";
    echo "<input type='submit' name='editTerem' value='Terem szerkesztése'/>";
    echo "</form>";
    if(isset($_POST["delEpulet"])){
        sql_delete($adatb,"epulet","WHERE ".sql_col_mkr("epulet_neve")."='".$_POST["delEpulet"]."'");
        header("Location: UranIndex.php");
    } elseif (isset($_POST["addEpulet"])){
        sql_insert($adatb,"epulet",["epulet_neve","epulet_cime"],"ss",[$_POST["epuletNeve"],$_POST["epuletCime"]]);
        header("Location: UranIndex.php");
    } elseif (isset($_POST["editEpulet"])){
        $keyVal=updateArrayHelper(["epulet_neve",$_POST["epuletNeve"],"epulet_cime",$_POST["epuletCime"]]);
        if(!empty($keyVal))sql_update($adatb,"epulet",$keyVal,"WHERE ".sql_col_of_table("epulet","epulet_neve")."='".$_POST["epuletNeve_key"]."'");
        header("Location: UranIndex.php");
    } elseif (isset($_POST["delTerem"])){
        sql_delete($adatb,"terem","WHERE ".sql_col_mkr("teremkod")."='".$_POST["delTerem"]."'");
        header("Location: UranIndex.php");
    } elseif (isset($_POST["addTerem"])){
        sql_insert($adatb,"terem",["teremkod","epulet_neve","teremszam"],"ssd",[$_POST["teremKod"],$_POST["teremEpulete"],$_POST["teremSzam"]]);
        header("Location: UranIndex.php");
    } elseif (isset($_POST["editTerem"])){
        $keyVal=updateArrayHelper(["teremkod",$_POST["teremKod"],"epulet_neve",$_POST["teremEpulete"],"teremszam",$_POST["teremSzam"]]);
        if(!empty($keyVal))sql_update($adatb,"terem",$keyVal,"WHERE ".sql_col_of_table("terem","teremkod")."='".$_POST["teremKod_key"]."'");
        header("Location: UranIndex.php");
    }
}
?>