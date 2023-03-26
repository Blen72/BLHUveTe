<?php
$ishallgset=$_SESSION["user"]["hallgato"]||isset($_POST["hallgato"])||isset($_SESSION["viewAsHallgato"]);
if($ishallgset||$_SESSION["user"]["oktato"])include_once("../private/include/uraninc/viewAs.php");
if($ishallgset){
    echo "<form action='UranIndex.php' method='post'>";
    echo "Felvett tárgyak:<table><thead><tr><th>Tárgy neve</th><th>Tárgy kódja</th><th>Kredit</th><th>Óra helye</th><th>Óra kezdete</th><th>Óra hossza</th><th>Leadás</th>".($_SESSION["user"]["oktato"]?"<th>Jegy beírás</th>":"")."</tr></thead><tbody>";
    $felvetttargyak=sql_select($adatb,"hallgato,hallgatoja,kurzus,terem".($_SESSION["user"]["oktato"]==1&&!$self?",oktatoja":""),["kurzus.nev","kurzus.kurzuskod","epulet_neve","terem.teremkod","teremszam","kredit","kezdet","hossz"],"WHERE ".sql_col_of_table("terem","teremkod")."=".sql_col_of_table("kurzus","teremkod")." AND ".sql_col_of_table("hallgato","urancode")."=".sql_col_of_table("hallgatoja","urancode")." AND ".sql_col_of_table("hallgatoja","kurzuskod")."=".sql_col_of_table("kurzus","kurzuskod")." AND ".sql_col_of_table("hallgato","urancode")."='".$hallgato["urancode"]."' AND ".sql_col_mkr("felvett")."=true".($_SESSION["user"]["oktato"]==1&&!$self?" AND ".sql_col_of_table("oktatoja","kurzuskod")."=".sql_col_of_table("kurzus","kurzuskod")." AND ".sql_col_of_table("oktatoja","urancode")."='".$_SESSION["user"]["urancode"]."'":"")." ORDER BY ".sql_col_of_table("kurzus","kurzuskod"));
    while(($targy = mysqli_fetch_assoc($felvetttargyak))!==null){
        echo "<tr><td>".$targy["nev"]."</td><td>".$targy["kurzuskod"]."</td><td>".$targy["kredit"]."</td><td>".$targy["epulet_neve"]."/".$targy["teremkod"]."(".$targy["teremszam"].".)</td><td>".$targy["kezdet"]."</td><td>".$targy["hossz"].
            "</td><td><input type='checkbox' name='kkod_".$targy["kurzuskod"]."' value='".$targy["kurzuskod"]."'/></td>".
            ($_SESSION["user"]["oktato"]?"<td><input name='kkod_".$targy["kurzuskod"]." helper' type='hidden' value='".$targy["kurzuskod"]."' /><input type='text' name='kkod_".$targy["kurzuskod"]." jegy' /></td>":"")."</tr>";
    }
    echo "</tbody></table><input type='submit' name='sendLe' value='Leadás".($_SESSION["user"]["oktato"]?"/jegybeírás":"")."'/></form><form action='UranIndex.php' method='post'>";
    mysqli_free_result($felvetttargyak);

    if($_SESSION["user"]["oktato"]>1||$self){
        echo "Felvehető tárgyak:<table><thead><tr><th>Felvétel</th><th>Tárgy neve</th><th>Tárgy kódja</th><th>Ajánlott képzés</th><th>Ajánlott félév</th><th>Kredit</th><th>Óra kezdete</th><th>Óra hossza</th></tr></thead><tbody>";
        //NEM JÓ: ($_SESSION["user"]["oktato"]>1?" AND kurzus.max_letszam>(SELECT COUNT(*) FROM hallgatoja WHERE kurzus.kurzuskod=hallgatoja.kurzuskod AND hallgatoja.felvett=true GROUP BY hallgatoja.kurzuskod)":"")
        $felvehetotargyak=sql_select($adatb,"hallgato,kurzus",["kurzus.nev","kurzuskod","kredit","kurzus.kepzesId","ajanlott_felev","kezdet","hossz"],"WHERE ".sql_col_of_table("hallgato","urancode")."='".$hallgato["urancode"]."' AND ".sql_col_mkr("kurzuskod")." NOT IN (".sql_subselect_mkr("kurzus,hallgatoja",["kurzus.kurzuskod"],"WHERE ".sql_col_of_table("kurzus","kurzuskod")."=".sql_col_of_table("hallgatoja","kurzuskod")." AND ".sql_col_of_table("hallgatoja","urancode")."='".$hallgato["urancode"]."' AND (".sql_col_of_table("hallgatoja","erdemjegy").">1 OR ".sql_col_mkr("felvett")."=1)").") AND (".sql_subselect_mkr("elofeltetele",["COUNT(*)"],"WHERE ".sql_col_of_table("elofeltetele","kurzuskodnak")."=".sql_col_of_table("kurzus","kurzuskod")).")=(".sql_subselect_mkr("elofeltetele",["COUNT(*)"],"WHERE ".sql_col_mkr("kurzuskodnak")."=".sql_col_of_table("kurzus","kurzuskod")." AND ".sql_col_of_table("elofeltetele","kurzuskod")." IN (".sql_subselect_mkr("hallgatoja",["hallgatoja.kurzuskod"],"WHERE ".sql_col_of_table("hallgatoja","erdemjegy").">1 AND ".sql_col_of_table("hallgatoja","urancode")."='".$hallgato["urancode"]."'").")").") ORDER BY ".sql_col_mkr("ajanlott_felev").",".sql_col_mkr("kurzus.kurzuskod"));
        while(($targy = mysqli_fetch_assoc($felvehetotargyak))!==null){
            echo "<tr><td><input type='checkbox' name='kkod_".$targy["kurzuskod"]."' value='".$targy["kurzuskod"]."' /></td><td>".$targy["nev"]."</td><td>".$targy["kurzuskod"]."</td><td>".$targy["kepzesId"]."</td><td>".$targy["ajanlott_felev"]."</td><td>".$targy["kredit"]."</td><td>".$targy["kezdet"]."</td><td>".$targy["hossz"]."</td></tr>";
        }
        mysqli_free_result($felvehetotargyak);
        echo "</tbody></table>".($_SESSION["user"]["oktato"]?"<input name='hallgato' type='hidden' value='".$hallgato["urancode"]."' />":"")."<input type='submit' name='sendFel' value='Felvétel'/></form>";
    }

    if(isset($_POST["sendFel"])){
        $siker=true;
        foreach ($_POST as $kulcs=>$posta){
            if(startsWith($kulcs,"kkod_")/*$posta!=="Felvétel"&&$kulcs!=="hallgato"*/){
                $nedjere=sql_select($adatb,"hallgatoja",["MAX(".sql_col_mkr("hanyadjara").") AS hany"],"WHERE ".sql_col_mkr("kurzuskod")."='".$posta."' AND ".sql_col_mkr("urancode")."='".$hallgato["urancode"]."' GROUP BY ".sql_col_mkr("kurzuskod"));
                $nplusegyedjere = mysqli_fetch_assoc($nedjere)["hany"]+1;
                mysqli_free_result($nedjere);
                $siker&=sql_insert($adatb,"hallgatoja",["urancode","kurzuskod","hanyadjara","felveteli_felev","felvett"],"ssiii",[$hallgato["urancode"],$posta,$nplusegyedjere,$hallgato["felev"],1]);
            }
        }
        if($siker){
            header("Location: UranIndex.php");//reload
        } else {
            echo "Sikertelen tárgyfelvétel!";
        }
    } else if(isset($_POST["sendLe"])){
        $siker=true;
        $prev=null;
        //var_dump($_POST);
        foreach ($_POST as $kulcs=>$posta){
            if (endsWith($kulcs,"helper")){
                $prev=$posta;
            } else if(startsWith($kulcs,"kkod_")/*$kulcs!=="sendLe"&&$kulcs!=="hallgato"&&!endsWith($kulcs,"helper")*/){
                //echo("KUZKÓD:prev:".$prev.",kulcs:".$kulcs.",posta:".$posta."<br>");
                if(endsWith($kulcs,"jegy")){
                    if(!empty($posta)){
                        $kkod=$prev;
                        //TODO
                        $siker&=sql_update($adatb, "hallgatoja",["felvett"=>0,"erdemjegy"=>$posta],"WHERE urancode='".$hallgato["urancode"]."' AND kurzuskod='".$kkod."' AND hanyadjara=(SELECT MAX(hanyadjara) FROM hallgatoja WHERE kurzuskod='".$kkod."' AND urancode='".$hallgato["urancode"]."' GROUP BY kurzuskod)");
                    }
                } else {
                    //TODO
                    $siker&=sql_delete($adatb,"hallgatoja","WHERE urancode='".$hallgato["urancode"]."' AND kurzuskod='".$posta."' AND hanyadjara=(SELECT MAX(hanyadjara) FROM hallgatoja WHERE hallgatoja.urancode='".$hallgato["urancode"]."' AND kurzuskod='".$posta."' GROUP BY hallgatoja.kurzuskod)");
                }
            }
        }
        if($siker){
            header("Location: UranIndex.php");//reload
        } else {
            echo "Sikertelen tárgyleadás".($_SESSION["user"]["oktato"]?"/jegybeírás":"")."!";
        }
    }
}
?>