<?php
session_start();
include_once("../private/include/func.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ehoot</title>
    <link rel="stylesheet" href="css/main.css">
    <style>
        #vavaFREE{
            animation: flashBack 1s linear 0s infinite normal;
        }

        @keyframes flashBack {
            from{color: purple}
            to{color: blue}
        }
    </style>
</head>
<body>
<div id="headernav">
    <header><h1>Ehoot</h1></header>
    <nav><a href="index.php">Elosztó</a><a href="EhootGYIK.html">GYIK</a></nav>
</div>
<p>Sajnos az Ehoot még nem működik! Túl veszélyesnek tartják.</p>
<form>
    <label onclick="if(parseInt(document.getElementById('code').value)===666666)document.getElementsByTagName('nav')[0].children[1].href='EhootKeziKonyv_ihadleroungisPrilogolusDexteriatum.html';">Írd be a táblán látható kódot!<input id="code" type="text"></label><input type="submit"><a href="goodies/ALG.xyz" download>Igazi küldés</a>
</form><br>
<footer><a href="goodies/Ehoot_goodAd.php"><div id="vavaFREE" style="font-size: 3em;">INGYEN<?php $t=[" SÖR! HÍVD MEG OKTATÓDAT IS ÉS KAPHAT!", "ES SZEMMMŰTÉT! NEM LÁTJA? CSAK KATTINT ÉS MEGVILÁGOSUL!", " JEGYEK! MINDEN TÁRGYBÓL GARANTÁLT A TOVÁBJUTÁS!", " DIPLOMA! BSC FELETT CSAK KEVESET FIZETNI! JÓ AJÁLAT", " EHOOT HACK! LEGYEN A LEGOKÓSABB OSZTÁLY!", " JÓSLÁS! TUDD MEG JÖVŐJÉT! HAGYD HÁTRA A MÚLTTAT!", " LÁB GOMBA EL TÜNTETÉS! FÁJ? ÉG? VISSZKET? TEGYEN EL LENE MOST!", " ELISMERÉSPONT! LEGYEN NEKED A LEGTÖBB PONT HOGY MENŐ AZ ISKOLÁD!"]; $i=0; try {$i=random_int(0, count($t)-1);} catch (Exception $e) {} echo $t[$i]; ?></div></a></footer>
<?php
if(false){
?>
Úgy érzed be tudsz jelentekzni?
<form action="EhootIndex.php" method="post">
    <label>Ehoot Elhasználónév:
        <input type="text" placeholder="Elhasználónév" name="fname">
    </label><br>
    <label>Jelszó:
        <input type="password" placeholder="je***ó" name="pwd">
    </label><br>
    <input type="submit" name="submit" placeholder="Menjél ki fingani!" value="Bejelentkezés">
</form>
<?php
}
?>
</body>
</html>