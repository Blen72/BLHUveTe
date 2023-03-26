<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BLHUveTe elosztó</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <script>
        function Load(){
            var ps=document.getElementsByTagName("P");
            var cols={"UranText":["Blue","CornflowerBlue","DarkBlue","DarkSlateBlue","DeepSkyBlue","DodgerBlue","LightBlue","LightSkyBlue","MediumBlue","MidnightBlue","RoyalBlue","SkyBlue","SteelBlue"],"EhootText":["BlueViolet","DarkMagenta","DarkOrchid","DarkViolet","Indigo","MediumPurple","Purple","RebeccaPurple"],"ECoospaceText":["DarkKhaki","Gold","GoldenRod","Khaki","LemonChiffon","LightGoldenRodYellow","PeachPuff","SandyBrown","Yellow"],"EModuloText":["Chartreuse","DarkSeaGreen","ForestGreen","Green","GreenYellow","LawnGreen","LightGreen","Lime","LimeGreen","MediumSeaGreen","MediumSpringGreen","PaleGreen","SeaGreen","SpringGreen"]};
            for(var i=0;i<ps.length;i++){
                var old=ps[i].innerText,uj="";
                var col=cols[ps[i].id];
                for(var j=0;j<old.length;j++){
                    uj+="<span style=\"color:"+col[Math.floor(Math.random()*col.length)]+";\">"+old.charAt(j)+"</span>";
                }
                ps[i].innerHTML=uj;
            }
        }
    </script>
</head>
<body onload="Load();">
<div id="headernav">
<header><h1>Blev Lote Hódmezővásárhelyi Ultravilágelméleti Tudományegyetem hivatalos elosztó oldala</h1></header>
<nav><a href="UranIndex.php">Uran</a><a href="EhootIndex.php">Ehoot</a><a href="ECoospaceIndex.php">Elméleti Coospace</a><a href="EModuloIndex.php">EModulo</a><a href="EInf.php">Elméleti információk</a><?php if(isset($_SESSION["user"])){ ?><a href="logout.php">Kijelentkezés</a><?php } else {?><a href="login.php">Bejelentkezés</a><?php }?></nav>
</div>
<section>
    <h2 style="color: dodgerblue">Uran</h2>
    <p id="UranText">A hivatalos egyetemi rendszer. Itt lehet a tárgyakat felvenni illetve leadni.</p>
</section>
<section>
    <h2 style="color: purple">Ehoot</h2>
    <p id="EhootText">Itt főleg időre menő 2-4 válasz közül lehet egyet válasznak adni az egyes kérdésekre.</p>
</section>
<section>
    <h2 style="color: yellow">Elméleti Coospace</h2>
    <p id="ECoospaceText">Az oktatók ezt a rendszert használják tesztekre és egyéb anyaggal kapcsolatos dolgok megosztására. Itt lehet kérdezni az oktatótól amennyiben engedélyezett.</p>
</section>
<section>
    <h2 style="color: greenyellow">EModulo</h2>
    <p id="EModuloText">Néhány űrlapot lehet kitölteni. Aki feladná a küzdelmet annak erősen ajánlott ez az oldal!</p>
</section>
<footer>Az oldal nem felel meg a követelményeknek, ahogy a hallgató sem.</footer>
</body>
</html>