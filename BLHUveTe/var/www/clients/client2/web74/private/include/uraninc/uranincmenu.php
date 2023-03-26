<?php

if(isset($_SESSION["user"])){
    echo "<a href='#'><button class='noStyle' type='submit' name='toshow' value='profil.php'>Profil</button></a>";
    echo "<a href='#'><button class='noStyle' type='submit' name='toshow' value='targyfelvetel.php'>Tárgyfelvétel</button></a>";
    echo "<a href='#'><button class='noStyle' type='submit' name='toshow' value='teljesitetttargyak.php'>Teljesített tárgyak</button></a>";
    if($_SESSION["user"]["oktato"]>1){
        echo "<a href='#'><button class='noStyle' type='submit' name='toshow' value='adminFelhasznalo.php'>Felhasználók kezelése</button></a>";
        echo "<a href='#'><button class='noStyle' type='submit' name='toshow' value='adminTeremEpulet.php'>Épületek/termek kezelése</button></a>";
        echo "<a href='#'><button class='noStyle' type='submit' name='toshow' value='adminKurzus.php'>Kurzusok kezelése</button></a>";
        echo "<a href='#'><button class='noStyle' type='submit' name='toshow' value='adminOktatoja.php'>Oktatók kezelése</button></a>";
        echo "<a href='#'><button class='noStyle' type='submit' name='toshow' value='adminSzak.php'>Szakok kezelése</button></a>";
        echo "<a href='#'><button class='noStyle' type='submit' name='toshow' value='adminRendszergazda.php'>Rendszergazdasági ügyek</button></a>";
    }
} else {
    echo "Jelentkezz be!";
}

?>