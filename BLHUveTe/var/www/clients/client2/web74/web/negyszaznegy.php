<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BLHUveTe hiba</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <style>
        .noStyle{
            border: none;
            background-color: unset;
            color: inherit;
            cursor: inherit;
            width: 100%;
            padding: 0;
        }
        @keyframes purgi {
            from {
                transform: rotate(0deg) scale(100%);
            }
            to {
                transform: rotate(360deg) scale(1000%);
            }
        }
        .porog:hover{
            animation: purgi 500ms linear 1 normal;
        }
    </style>
</head>
<body>
<div id="headernav">
    <?php
    if(isset($_POST["page"])){
        $n=substr($_POST["page"],0,strpos($_POST["page"],"."));
        if(abs($n)==666||abs($n)==666666)header("Location: EhootKeziKonyv_ihadleroungisPrilogolusDexteriatum.html");
        echo "<header><h1>Blev Lote Hódmezővásárhelyi Ultravilágelméleti Tudományegyetem hivatalos ".$n.". oldala</h1></header>";
        echo '<form action="negyszaznegy.php" method="post"><nav>'.($n!=1?'<a class="porog" href="#"><input class="noStyle" type="submit" name="page" value="'.($n-1).'. oldal"/></a>':'').'<a class="porog" href="#"><input class="noStyle" type="submit" name="page" value="'.($n+1).'. oldal"/></a></nav></form>';
    } else {
        echo "<header><h1>Blev Lote Hódmezővásárhelyi Ultravilágelméleti Tudományegyetem hivatalos 404. oldala</h1></header>";
        echo '<form action="negyszaznegy.php" method="post"><nav><a class="porog" href="#"><input class="noStyle" type="submit" name="page" value="403. oldal"/></a><a class="porog" href="#"><input class="noStyle" type="submit" name="page" value="405. oldal"/></a></nav></form>';
    }
    ?>
</div>
<section>
    <h2>Az keresett oldal nem található</h2>
    <p></p>
</section>
<footer>Itt nincs semmi érdekes csak az oldal alja.</footer>
</body>
</html>