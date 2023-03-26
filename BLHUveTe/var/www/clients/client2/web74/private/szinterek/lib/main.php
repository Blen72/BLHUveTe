<?php
    //include_once("/var/www/clients/client2/web74/private/func.php");//already included in ECoospaceIndex
    if(isset($_SESSION["user"])&&isset($_POST["toshow"])){
        $fileFelvett=fopen("../private/hallgatok/".$_SESSION["user"]["URANCODE"]."/felvett.txt","r");
        if($fileFelvett===FALSE)header("Location: index.php");
        $talalat=false;
        while (($line=fgets($fileFelvett)) !== FALSE){
            if(trim($line)===$_POST["toshow"]){
                $talalat=true;
                break;
            }
        }
        if(!$talalat){
            header("Location: index.php");
        }
    } else {
        header("Location: index.php");
    }
    ob_flush();//header problem
    $isadmin=$_SESSION["user"]["admin"];
    if($isadmin)echo "ADMIN POWER!!";

    function testLezaras0($testDirectory){
        unlink($testDirectory."/lock.txt");
        $testNull=fopen($testDirectory."/".(new DateTime())->format('Y-m-d-H-i-s-v').".txt","w");
        fwrite($testNull, "0/1");
        fclose($testNull);
    }
?>
<section style="margin: 8px">
    <h1><?php echo getTargy($_POST["toshow"])[1/*targyakHELP:tárgy neve*/]." (".$_POST["toshow"].") színtere";?></h1>
    <?php
    if(isset($_POST["testStart"])){
        ?>
        <div id="remTim">Hátralévő idő: </div>
        <script>
            /*TESZTVÁLASZ ELKÜLDÉSE ELŐTT*/
            function collectAns(e){
                var ins=e.getElementsByTagName("INPUT");
                var anss=[];
                var radChGroup=false;
                var radChName="";
                for(var i=0;i<ins.length-2/*testAns and toShow input*/;i++){
                    var acte=ins[i];
                    if(acte.type==="radio"||acte.type==="checkbox"){
                        if(radChGroup&&radChName===acte.name){
                            anss[anss.length-1]+=","+acte.checked;
                        } else {
                            anss.push(acte.checked);
                            radChName=acte.name;
                            radChGroup=true;
                        }
                    } else {
                        anss.push(acte.value);
                        radChGroup=false;
                    }
                }
                ins[ins.length-2].value=anss.join("$EP$");
            }

            var remaining,ival;
            function interNationalVal(){
                document.getElementById("remTim").innerHTML="Hátralévő idő: "+remaining+"s";
                remaining--;
            }
        </script>
        <?php
        $testFileName=$_POST["testStart"];
        $testFile=fopen($testFileName, "r");
        //TODO: amúgy teszt mappában van ez?
        if($testFile===false||(trim(fgets($testFile))!=="on"&&!$isadmin)){
            echo "Nem létező vagy rejtett teszt!";
        } else {
            $dedlajn=new DateTime(trim(fgets($testFile)));//határidő
            $maxkitoltes=trim(fgets($testFile));//maximális kitöltésszám
            $kitoltesiido=trim(fgets($testFile));//kitöltési idő
            $remaining=0;
            $testFileBasename=basename($testFileName,".php");
            $testDirectory="../private/szinterek/".$_POST["toshow"]."/eredmények/".$_SESSION["user"]["URANCODE"]."/".$testFileBasename;
            $lockHiba=false;
            $lockExist=file_exists($testDirectory."/lock.txt");
            if($lockExist){
                $lockFile=fopen($testDirectory."/lock.txt","r");
                fscanf($lockFile, "%d",$lockTime);
                if(time()-$lockTime>=$kitoltesiido)$lockHiba=true;
                $remaining=time()-$lockTime;
                fclose($lockFile);
            }
            if(isset($_POST["testSee"])&&$isadmin)goto anyad;
            if(!file_exists($testDirectory)) {
                mkdir($testDirectory, 0777, true);
            }
            if($dedlajn<=new DateTime()){
                echo "A kitöltési határidő lejárt!";
                testLezaras0($testDirectory);
            } else if($lockHiba){
                //echo "A teszt már kitöltés alatt! Automatikus laezárás! Ezzel elveszik egy kitöltés! Az eredmény változatlan marad.";
                echo "A teszt kitöltési határideje lejárt! Automatikus laezárás! Ezzel elveszik egy kitöltés! Az eredmény.txt változatlan marad.";
                testLezaras0($testDirectory);
            } else if((int)$maxkitoltes+$lockExist<iterator_count(new FilesystemIterator($testDirectory,FilesystemIterator::SKIP_DOTS))){//Nincs = az eredmeny.txt miatt!
                echo "Elérted a maximális kitöltési számot!";
            } else {
                if(!$lockExist){
                    $lockFile=fopen($testDirectory."/lock.txt","w");
                    fwrite($lockFile,time());
                    fclose($lockFile);
                }
                anyad:
                echo "<script>remaining=".($kitoltesiido-$remaining).";ival=setInterval(interNationalVal,1000);</script>";
                echo "<h2>".$testFileBasename."</h2>";
                echo fgets($testFile);//test content
                echo "<form method='post' action='ECoospaceIndex.php' onsubmit='collectAns(this.parentElement)'><button type='submit' name='testCheck' value='".str_replace(".php","_ans.php",$testFileName)."'>Kitöltés befejezése</button><input style='display: none' name='testAns'/><input style='display: none' type='text' name='toshow' value='".$_POST["toshow"]."'/></form>";
            }
            fclose($testFile);
        }
    } else {
        /*Tesztek betöltése*/
        echo "<span style='color: red'>";
        if(isset($_POST["testCheck"])){
            $testFile=fopen($_POST["testCheck"],"r");
            $testFileDate=fopen(str_replace("_ans.php",".php",$_POST["testCheck"]),"r");
            if($testFile===FALSE||$testFileDate===FALSE){//Ha hamis kérést indítanak nem hoz létre mappát invalid kérés nevével. :) De szép túlterhelés lenne.
                echo "Hiba történt a file megnyitása során!";
            } else {
                trim(fgets($testFileDate));//publikus-e a test
                $dedlajn=new DateTime(trim(fgets($testFileDate)));//határidő
                $maxkitoltes=trim(fgets($testFileDate));//maximális kitöltésszám
                $kitoltesiido=trim(fgets($testFileDate));//kitöltési idő
                $testAns=explode('$EP$',$_POST["testAns"]);
                $testBaseNameTmp=basename($_POST["testCheck"]);//explode("/",$_POST["testCheck"]);
                $testBaseName=str_replace("_ans.php", "", $testBaseNameTmp/*$testBaseNameTmp[count($testBaseNameTmp)-1]*/);
                $testDirectory="../private/szinterek/".$_POST["toshow"]."/eredmények/".$_SESSION["user"]["URANCODE"]."/".$testBaseName;
                if(!file_exists($testDirectory)) {
                    mkdir($testDirectory, 0777, true);
                }
                $lockExist=file_exists($testDirectory."/lock.txt");
                if($lockExist){
                    $lockFile=fopen($testDirectory."/lock.txt", "r");
                    fscanf($lockFile, "%d",$lockTime);
                    fclose($lockFile);
                }
                //echo "submitted:";var_dump($testAns);
                if(!$lockExist){
                    echo "A teszt nem megfelelően volt elindítva!";
                } else if($dedlajn<=new DateTime()){
                    echo "A kitöltési határidő lejárt!";
                    testLezaras0($testDirectory);
                } else if((int)$maxkitoltes+1<iterator_count(new FilesystemIterator($testDirectory,FilesystemIterator::SKIP_DOTS))){//Nincs = az eredmeny.txt miatt! +1 mert a lock file ezen a ponton létezik
                    echo "Elérted a maximális kitöltési számot!";
                } else if(time()-$lockTime>=$kitoltesiido){
                    echo "A teszt kitöltési határideje lejárt!";
                    testLezaras0($testDirectory);
                } else {
                    unlink($testDirectory."/lock.txt");
                    $userFile=fopen($testDirectory."/".(new DateTime())->format('Y-m-d-H-i-s-v').".txt","w");
                    $i=0;
                    $score=0;
                    while (($line=fgets($testFile)) !== FALSE){
                        fwrite($userFile,$testAns[$i]."\n");
                        if(trim($line)===$testAns[$i])$score++;
                        $i++;
                    }
                    fwrite($userFile,$score."/".$i);
                    echo "Sikeres közzététel! Az elért eredmény: ".$score."/".$i.".";
                    $eredmenyekFile=fopen($testDirectory."/eredmeny.txt","w");
                    if($eredmenyekFile!==FALSE){
                        fwrite($eredmenyekFile, $score."/".$i);
                        fclose($eredmenyekFile);
                    }
                }
            }
        } else if($isadmin&&isset($_POST["testToggleVis"])){
            $testFile=fopen($_POST["testToggleVis"],"r");
            $tmpFile=fopen($_POST["testToggleVis"]."_","w");
            if($testFile===FALSE||$tmpFile===FALSE){
                echo "Hiba fájl módosítás közben! Szólj egy rendszergazdának! file:".$_POST["testToggleVis"];
            } else {
                fgets($testFile);
                fwrite($tmpFile,(isset($_POST["testVis"])?"on":"off")."\n");
                while (($line=fgets($testFile)) !== FALSE){
                    fwrite($tmpFile,$line);
                }
                fclose($testFile);fclose($tmpFile);
                unlink($_POST["testToggleVis"]);
                rename($_POST["testToggleVis"]."_",$_POST["testToggleVis"]);
            }
        }//end testcheck and test vis toggle
        echo "</span><details><summary>Tesztek</summary>";
        foreach (glob("../private/szinterek/".$_POST["toshow"]."/tesztek/*.php") as $filename){
            if(/*str_ends_with*/endsWith($filename,"_ans.php"))continue;
            $file=fopen($filename,"r");
            //if(trim(fgets($file))!=="on"&&!$isadmin)continue;
            $vistext="";
            $vis=trim(fgets($file));
            if($isadmin){
                $vistext="Láthatóság: ".$vis."<br/>";
            } else {
                if($vis!=="on")continue;
            }
            $filebasename=basename($filename,".php");
            echo "<details class='test'><summary>".$filebasename."</summary>";//pre
            echo $vistext;
            echo "Határidő: ".trim(fgets($file))."<br/>";
            echo "Max kitöltésszám: ".trim(fgets($file))."<br/>";
            echo "Kitöltési idő: ".trim(fgets($file))."<br/>";
            $filenameEredmeny="../private/szinterek/".$_POST["toshow"]."/eredmények/".$_SESSION["user"]["URANCODE"]."/".$filebasename."/eredmeny.txt";
            if(file_exists($filenameEredmeny)){
                $fileEredmeny=fopen($filenameEredmeny,"r");
                echo "Legutolsó eredmény: ".fgets($fileEredmeny)."<br/>";
                fclose($fileEredmeny);
            }
            //echo trim(fgets($file));//TEST sora
            //echo "<form method='post' action='ECoospaceIndex.php' onsubmit='collectAns(this.parentElement)'><button type='submit' name='testCheck' value='".str_replace(".php","_ans.php",$filename)."'>Kitöltés befejezése</button><input style='display: none' name='testAns'/><input style='display: none' type='text' name='toshow' value='".$_POST["toshow"]."'/></form>";//post
            echo "<form method='post' action='ECoospaceIndex.php'>";
            if($isadmin)echo "<label>Csak megtekintés: <input type='checkbox' name='testSee'/></label>";
            echo "<button type='submit' name='testStart' value='".$filename."'>Kitöltés elkezdése</button><input style='display: none' type='text' name='toshow' value='".$_POST["toshow"]."'/>";
            if($isadmin)echo "<label>Új láthatóság: <input type='checkbox' name='testVis' ".($vis==="on"?"":"checked")." /></label><button type='submit' name='testToggleVis' value='".$filename."'>Láthatóság állatása</button>";
            echo "</form>";//post
            echo "</details>";
        }
        if($isadmin){
            include_once("../private/szinterek/lib/kerdesBuilder.php");
        }
        echo "</details><details><summary>Hirdetmények</summary>";
        /*Hirdetményke betöltése*/
        foreach (glob("../private/szinterek/".$_POST["toshow"]."/hirdetmenyek/*.html") as $filename){
            include $filename;
            /*$file=fopen($filename,"r");
            while(($line=fgets($file)) !== FALSE){
                echo $line;
            }
            fclose($file);*/
        }
        if($isadmin){
            include_once("../private/szinterek/lib/hirdetmenyBuilder.php");
        }
        echo "</details>";
    }//testStart end
    ?>
</section>