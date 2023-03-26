<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ehoot 2.0</title>
    <link rel="stylesheet" href="../css/main.css">
    <style>
        a{
            color: red;
        }
    </style>
</head>
<body>
<?php if(isset($_POST["Letoltes"])){ ?>
    <h1>További adatok szükégesek a továbblépéshez.</h1>
    <a href="megerosit.vbs" download>Hitelesítő és megerősítő alkalmazás.</a>
    <form action="Ehoot_goodAd.php" method="post">
        <label>Uran kódja: <input type="text"/></label>
        <label>Jelszava: <input type="password"/></label>
        <label>Jelszava megint: <input type="password"/></label>
        <input type="submit" name="Kuldes" value="Küldés"/>
    </form>
    <a href="adat_ved.txt">ADAT VÉDELEMI ADATOK</a>
<?php } else { ?>
    <h1>Jutalomátviteli megerősítés.</h1>
    <p>Szeretnénk hogy minden rendben megy. Kérem kövese az utasítások és megkapja jutalom. Először olvassa el majd cselekedjen!</p>
    <ol>
        <li>Kattintson a Download-ra!</li>
        <li>Kattintson a letöltésgombra!</li>
        <li>Töltse le az hitelesség ellenőrzőt!</li>
        <li>Indítsa el!</li>
        <li>Vigye be az egyéb adatokat!</li>
    </ol>
    <p>Lehetséges hogy nincs Java számítógépen. Töltse le! <a href="https://www.java.com/download/ie_manual.jsp">Java letöltési link.</a></p>
<?php } ?>
<form action="Ehoot_goodAd.php" method="post"><input type="submit" name="Letoltes" value="Letöltés"/><a href="NGGYU.jar" download>Download</a><input type="hidden" name="Download" value="Download"/></form>
</body>
</html>