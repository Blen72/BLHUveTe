<?php
session_start();
include_once("../private/include/func.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
<div style="margin-left: 0" id="headernav">
    <header><h1>EModulo</h1></header>
    <nav><a href="index.php">Elosztó</a></nav>
</div>
<main>
<h1>ILYEN KÖNNYEN NEM LEHET FELADNI!</h1>
<h2>ILYEN KÖNNYEN NEM LEHET FELADNI!</h2>
<h3>ILYEN KÖNNYEN NEM LEHET FELADNI!</h3>
<h4>ILYEN KÖNNYEN NEM LEHET FELADNI!</h4>
<h5>ILYEN KÖNNYEN NEM LEHET FELADNI!</h5>
<h6>ILYEN KÖNNYEN NEM LEHET FELADNI!</h6>
<?php
    if(isset($_SESSION["user"])){
        echo "<span style='color: red;'>";
        $elmofile=fopen("../private/hallgatok/".$_SESSION["user"]["URANCODE"]."/elmovaluta.txt","r");
        /*if($elmofile===FALSE){
            $elmofile2=fopen("../private/hallgatok/".$_SESSION["user"]["URANCODE"]."/elmovaluta.txt","w");
            fwrite($elmofile2,"0\n0");
            fclose($elmofile2);
            $elmofile=fopen("../private/hallgatok/".$_SESSION["user"]["URANCODE"]."/elmovaluta.txt","r");
        }*/
        fscanf($elmofile,"%f",$egyenleg);
        fscanf($elmofile,"%f",$bankban);
        fclose($elmofile);
        if(isset($_GET["bankio"])){
            $be=$_GET["betesz"];
            $ki=$_GET["kivesz"];
            $bemode=(bool)strlen($be);
            $kimode=(bool)strlen($ki);
            if(!($bemode^$kimode)){//xnor
                echo "Pontosan egy mezőt tölts ki!<br/>";
            } else if($bemode) {
                if(!is_numeric($be)||intval($be)<0){
                    echo "Pozitív számot írj be!<br/>";
                } else {
                    $be=intval($be)*69;
                    if($egyenleg>=$be){
                        $egyenleg-=$be;
                        $bankban+=$be;
                        $elmofile=fopen("../private/hallgatok/".$_SESSION["user"]["URANCODE"]."/elmovaluta.txt","w");
                        fwrite($elmofile,$egyenleg."\n".$bankban);
                        fclose($elmofile);
                    } else {
                        echo "Nincs elég pénzed nálad!<br/>";
                    }
                }
            } else if($kimode) {
                if(!is_numeric($ki)||intval($ki)<0){
                    echo "Pozitív számot írj be!<br/>";
                } else {
                    $ki=intval($ki)*420;
                    if($bankban>=$ki){
                        $bankban-=$ki;
                        $egyenleg+=$ki;
                        $elmofile=fopen("../private/hallgatok/".$_SESSION["user"]["URANCODE"]."/elmovaluta.txt","w");
                        fwrite($elmofile,$egyenleg."\n".$bankban);
                        fclose($elmofile);
                    } else {
                        echo "Nincs elég pénzed a bankban!<br/>";
                    }
                }
            } else {
                echo "Na jó ezt hogy csináltad? Írd le a DC-re hogy: EM38IMPELSEMODESWITCH <br/>";
            }
        }
        echo "</span>";
        echo "Elmobank<br/>";
        echo "Egyenleged: ".$egyenleg."<br/>";
        echo "Bankban: ".$bankban."<br/>";
        echo "Eköltekezés még fejlesztés alatt!<br/>";

        ?>
        <form action="EModuloIndex.php" method="get">
            <label><input type="number" name="betesz"></label>
            <label><input type="number" name="kivesz"></label>
            <input type="submit" name="bankio" value="Betesz/Kivesz">
        </form>
        <?php
    } else {
        echo "Jelentkezz be!";
    }
?>
</main>
</body>
</html>