<?php
session_start();
if(isset($_SESSION["user"]))header("Location: index.php");
include_once "../private/include/sqlhelper.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Disznóvágási Ferenc">
    <title>Uran Bejelentkezés</title>
    <!--link href="img/icon.png" rel="icon"-->
    <link href="css/main.css" rel="stylesheet">
</head>
<body>
<div id="headernav">
    <header><h1>Login</h1></header>
    <nav><a href="index.php">Elosztó</a><a href="signup.php">Regisztráció</a></nav>
</div>
    <?php
    include_once("../private/include/func.php");
    //getUsers("../private/res/users.txt");
    $ret = "";

    if (isset($_POST["send"])) {
        if (!isset($_POST["username"]) || trim($_POST["username"]) === "" || !isset($_POST["password"]) || trim($_POST["password"]) === "") {
            $ret = "<strong>Adj meg minden adatot!</strong>";
        } else {
            $uname = $_POST["username"];
            $pwd = $_POST["password"];//Psszt! Béla(admin) jelszava: 🐱Béla
            $adatb=db_open();
            $profiles = sql_select($adatb,"felhasznalo",["*"]);
            $mennyirevagyreszeg = false;
            while(($profile = mysqli_fetch_assoc($profiles))!==null){
                if ($profile["nev"] === $uname && password_verify($pwd, $profile["jelszo"])) {
                    //$hallgato=sql_select($adatb,"felhasznalo,hallgato",["*"],"WHERE felhasznalo.urancode=hallgato.urancode AND hallgato.urancode=?","s",[$profile["urancode"]]);
                    $hallgato=sql_select($adatb,"felhasznalo,hallgato,szak",["*"],"WHERE ".sql_col_of_table("felhasznalo","urancode")."=".sql_col_of_table("hallgato","urancode")." AND ".sql_col_of_table("hallgato","urancode")."='".$profile["urancode"]."' AND ".sql_col_of_table("szak","szakkod")."=".sql_col_of_table("hallgato","szakkod"));
                    $hallgatodat=mysqli_fetch_assoc($hallgato);
                    mysqli_free_result($hallgato);
                    $oktato=sql_select($adatb,"felhasznalo,oktato",["*"],"WHERE ".sql_col_of_table("felhasznalo","urancode")."=".sql_col_of_table("oktato","urancode")." AND ".sql_col_of_table("oktato","urancode")."='".$profile["urancode"]."'");
                    $oktatodat=mysqli_fetch_assoc($oktato);
                    mysqli_free_result($oktato);
                    $_SESSION["user"] = $profile+($hallgatodat===null?["hallgato"=>false]:$hallgatodat+["hallgato"=>true])+($oktatodat===null?["oktato"=>false]:$oktatodat+["oktato"=>(int)$oktatodat["jogosultsag"]]);
                    header("Location: index.php");
                    $mennyirevagyreszeg = true;
                    break;
                }
            }
            mysqli_free_result($profiles);
            db_close($adatb);
            if(!$mennyirevagyreszeg){
                $ret = "<strong>Sikertelen belépés! Az adatok nem megfelelőek!</strong>";
            }
        }
    }


    ?>

<main>
    <h1>Bejelentkezés</h1>
    <form action="login.php" method="POST">
        <fieldset>
            <input type="text" name="username" placeholder="Felhasználónév" required/> <br/><br/>
            <input type="password" name="password" placeholder="Jelszó" required/> <br/><br/>
            <input type="submit" value="Bejelentkezés" name="send"/>
        </fieldset>
    </form>
    <?php
    echo $ret;
    ?>
</main>

<footer>
    Szeretem a nagymacskákat
</footer>
</body>
</html>