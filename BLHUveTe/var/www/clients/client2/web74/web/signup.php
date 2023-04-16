<?php
session_start();
include_once "../private/include/sqlhelper.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Disznóvágási Ferenc">
    <title>Regisztráció</title>
    <!--link href="img/icon.png" rel="icon"-->
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
<header>
    <div id="headernav">
        <header><h1>Blev Lote Hódmezővásárhelyi Ultravilágelméleti Tudományegyetem hivatalos regisztrációs oldala</h1></header>
        <nav><a href="UranIndex.php">Uran</a><a href="EhootIndex.php">Ehoot</a><a href="ECoospaceIndex.php">Elméleti Coospace</a><a href="EModuloIndex.php">EModulo</a></nav>
    </div>

    <?php
    include_once("../private/include/func.php");
    //getUsers("../private/res/users.txt");
    $errors = [];

    if (isset($_POST["send"])){
        if (!isset($_POST["username"]) || trim($_POST["username"]) === ""){
            $errors[] = "A felhasználónév megadása szükséges!";
        }

        if (!isset($_POST["password"]) || trim($_POST["password"]) === "" || !isset($_POST["passwordagain"]) || trim($_POST["passwordagain"]) === ""){
            $errors[] = "A jelszó és az ellenőrző jelszó megadása is szükséges!";
        }

        $username = $_POST["username"];
        $urancode=makeUran(str_shuffle($username));
        $password = $_POST["password"];
        $passwordagain = $_POST["passwordagain"];
        $profilepic="";//TODO: profil;

        if($password !== $passwordagain){
            $errors[] = "A két jelszónak meg kell egyeznie!";
        }

        /*sql_insert("szak",["szakkod","szaknev"],"ss",["epti2","teszikezett"]);*/

        //$errors[]="Nincs regisztrációs időszak! ezen a DC szerveren lehet tájékozódni: https://discord.gg/HEjFwC9yE8";//TODO: Reg időszak egy config fileba amit admin szerkeszthet!

        if(count($errors) === 0){
            $conn = oci_connect('JAROSLAV', '1111', 'localhost/XE', 'AL32UTF8');
            $password=password_hash($password, PASSWORD_DEFAULT);
            $compiled = oci_parse($conn, "INSERT INTO \"Felhasznalo\" (\"urancode\", \"nev\", \"jelszo\", \"profilkep\") VALUES (:urancode, :nev, :jelszo, :profilkep)");
            oci_bind_by_name($compiled, ':urancode', $urancode);
            oci_bind_by_name($compiled, ':nev', $username);
            oci_bind_by_name($compiled, ':jelszo', $password);
            oci_bind_by_name($compiled, ':profilkep', $profilepic);
            oci_execute($compiled);
            //oci_commit($conn);
            oci_free_statement($compiled);
            oci_close($conn);

            /*$profiles[] = ["username" => $username, "URANCODE" => $urancode, "felev" => 1, "szak"=>"EPTIT", "password" => $password, "admin" => false];

            putUsers("../private/res/users.txt", $profiles);
            createUsersFolder($urancode);*/
            header("Location: login.php");
        }
    }

    ?>
</header>
<main>
    <h1>Regisztráció</h1>
    <form method="POST" action="signup.php" enctype="multipart/form-data">
        <fieldset>
            <input type="text" name="username" placeholder="Teljes név" required/><br/>
            <input type="password" name="password" placeholder="Jelszó" required/><br/>
            <input type="password" name="passwordagain" placeholder="Jelszó megerősítése" required/> <br/>

            <input type="submit" name="send" value="Regisztráció"/>
            <input type="reset" name="reset-btn" value="Adatok törlése"/>
        </fieldset>
        <?php
        if (count($errors) !== 0) {
            echo "Sikertelen regisztráció!<br>";
            foreach ($errors as $error) {
                echo "<strong>" . $error . "</strong><br>";
            }
        }
        ?>
    </form>
</main>
</body>
</html>