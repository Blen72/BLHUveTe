<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BLHUveTe infók</title>
    <link rel="stylesheet" href="../css/main.css">
    <style>
        p a{
            color: aqua;
        }
    </style>
</head>
<body>
<div id="headernav">
    <header><h1>Blev Lote Hódmezővásárhelyi Ultravilágelméleti Tudományegyetem elméleti idő átváltása</h1></header>
    <nav><a href="../index.php">Elosztó</a><a href="../EInf.php">Inf elosztó</a></nav>
</div>
<main>
    <p>FIGYELEM! 1 év = 365 nappal számol! Szökőévért adj hozzá egy napot!</p>
    <p>Egy másodperc = egy elméleti másodperc</p>
    <form action="atvalt.php" method="get" autocomplete="off">
        <label>Másodperc/Emásodperc<input type="text" name="esec"/></label><br/>
        <label>Perc/Eperc<input type="text" name="emin"/></label><br/>
        <label>Óra/Eóra<input type="text" name="ehour"/></label><br/>
        <label>Nap/Ehold<input type="text" name="emoon"/></label><br/>
        <label><!--Hét-->Év/Ehatvankilenc<input type="text" name="e69"/></label><br/>
        <label>-/Ehónap<input type="text" name="emonth"/></label><br/>
        <label>-/Eév<input type="text" name="eyear"/></label><br/>
        <input type="submit" name="atvalt_edtod" value="Edate to date">
        <input type="submit" name="atvalt_dtoed" value="Date to edate">
    </form>
    <div>
        <?php
        $NNN=[[60,"mp"],[60,"p"],[24,"h"],[365,"nap"],/*[52,"hét"],*/[1000,"év"],[1000,"zév"],[1000000,"mév"]];
        $NNE=[[420,"emp"],[420,"ep"],[69,"eh"],[70,"ehold"],[420,"ehatvankilenc"],[69,"ehónap"],[1000000,"eév"]];
        function getI(){
            $ret=[$_GET["esec"],$_GET["emin"],$_GET["ehour"],$_GET["emoon"],$_GET["e69"],$_GET["emonth"],$_GET["eyear"]];
            return array_map(function($v){return intval($v);},$ret);
        }
        function MPtoString($meSys,$mp){
            $ret="";
            for($i=0;$i<count($meSys);$i++){
                $rem=$mp%$meSys[$i][0];
                $ret=$rem.$meSys[$i][1]." ".$ret;
                $mp=($mp-$rem)/$meSys[$i][0];
            }
            return $ret;
        }
        if(isset($_GET["atvalt_edtod"])){
            $ins=getI();
            echo MPtoString($NNN,((((($ins[6]*69+$ins[5])*420+$ins[4])*70+$ins[3])*69+$ins[2])*420+$ins[1])*420+$ins[0]);
        } else if(isset($_GET["atvalt_dtoed"])){
            $ins=getI();
            echo MPtoString($NNE,(((/*(*/$ins[/*5*/4]*365/*+$ins[4])*7*/+$ins[3])*24+$ins[2])*60+$ins[1])*60+$ins[0]);
        }
        ?>
    </div>
</main>
</body>
</html>