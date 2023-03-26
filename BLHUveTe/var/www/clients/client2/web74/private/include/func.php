<?php
//README! NE INLUDEOLD MÁSHOL MINT A /var/www/clients/client2/web74/web!
//const FULLPTH = "/xampp/htdocs/BLHUveTe"."/var/www/clients/client2/web74/";
//const FULLPRIVATE = FULLPTH."private/";
const KEPZESEK = ["BSc", "MSc", "JSc", "HCSc", "UHCSc", "KFCSc", "KFSCSc", "UFCSc", "NERDSc"];//BSc, MSc, J(obb)Sc, HCSc, UHCSc, K(inetic)F(orce)C(lass)Sc/K(entucky)F(ried)C(hicken)Sc, KFS(treet)CSc, U(ltra)FCSc, N(ever)E(ending)R(elease)D(isease)Sc

function makeUran($username){
    return substr(strtr(base64_encode(md5($username,true)),"+/","-_"),0,22);
}





function getUsers($path){
    $users=[];
    $file=fopen($path, "r");
    if ($file === FALSE){
        die("A fájlbeolvasás nem sikerült!");
    }

    while (($line=fgets($file)) !== FALSE){
        $user = unserialize($line);
        $users[] = $user;
    }

    fclose($file);
    return $users;
}

function getUser($urancode){
    $users=getUsers("../private/res/users.txt");
    $user=null;
    foreach ($users as $profile){
        if($profile["URANCODE"] === $urancode){
            return $profile;
        }
    }
    return $user;
}

function putUsers($path, $users){
    $file=fopen($path, "w");
    if ($file === FALSE){
        die("A fájlbeolvasás nem sikerült!");
    }

    foreach ($users as $user){
        if(!is_null($user)) {
            $serialized = serialize($user);
            fwrite($file, $serialized . "\n");
        }
    }

    fclose($file);
}

function createUsersFolder($fname){
    $urancode=$fname;
    $fname="../private/hallgatok/$fname";
    mkdir($fname,0777,true);
    $file=fopen("$fname/felveheti.txt","w");
    $file2=fopen("$fname/teljesitett.txt","w");
    $file3=fopen("$fname/felvett.txt","w");
    $file4=fopen("$fname/elmovaluta.txt","w");
    if($file===FALSE||$file2===FALSE||$file3===FALSE||$file4===FALSE){
        die("Probléma a fájl létrehozásakor!");
    } else {
        fclose($file);
        fclose($file2);
        fclose($file3);
        fwrite($file4,"0\n0");
        fclose($file4);
    }
    refreshUserTargyak($urancode);
}

/*function isTeljesitettek($urancode,$targyak){
    $teljesitett=0;
    $file2=fopen("hallgatok/$urancode/teljesitett.txt","r");
    while (($line=fgets($file2)) !== FALSE){
        if(in_array(trim($line),$targyak))$teljesitett++;
    }
    echo count($targyak)." ".$teljesitett." teljesítettek?:".($targyak[0]===""||count($targyak)==$teljesitett?"true":"false")." ";
    fclose($file2);
    return $targyak[0]===""||count($targyak)==$teljesitett;
}*/

function getTargy($name){
    $fileTargyak=fopen("../private/targyak/targyak.txt","r");
    while(($line=fgets($fileTargyak)) !== FALSE){
        $line=trim($line);
        if($line==="")continue;
        if(substr($line,0,strpos($line,";")/*targyakHELP: ameddig a kód az első!*/)==$name)return explode(";", $line);
    }
    return null;
}

function isElofeltetelekOk($teljesitettek,$elofeltetelek){
    if($elofeltetelek[0]==="")return true;
    $teljesitettdb=0;
    for($i=0;$i<count($teljesitettek);$i++)if(in_array($teljesitettek[$i],$elofeltetelek))$teljesitettdb++;
    return count($elofeltetelek)==$teljesitettdb;
}

function refreshUserTargyak($urancode){
    $felvehetotargyak=[];
    $teljesitetttargyak=[];
    //$felvetttargyak=[];
    $user=getUser($urancode);
    $fileTargyak=fopen("../private/targyak/targyak.txt","r");
    $file=fopen("../private/hallgatok/$urancode/felveheti.txt","w");
    $fileTeljesitett=fopen("../private/hallgatok/$urancode/teljesitett.txt","r");
    while (($line=fgets($fileTeljesitett)) !== FALSE){
        $teljesitetttargyak[]=trim($line);
    }
    fclose($fileTeljesitett);

    while (($line=fgets($fileTargyak)) !== FALSE){
        $line=trim($line);
        if($line==="")continue;
        $line=explode(";",$line);
        $elofelts=explode(",",$line[9/*targyakHELP:előfeltételek*/]);
        if($user["szak"]===$line[2/*targyakHELP:szak*/]/*later: több szak support*/ && (isElofeltetelekOk($teljesitetttargyak,$elofelts)&&!in_array($line[0],$teljesitetttargyak))){
            $felvehetotargyak[]=$line[0];
        }
        //echo var_dump($line)."<br/>";
    }
    foreach($felvehetotargyak as $str){
        fwrite($file, $str."\n");
    }
    fclose($fileTargyak);
    fclose($file);
}

function printUserTargyak($urancode){
    $file=fopen("../private/hallgatok/$urancode/felveheti.txt","r");
    $file2=fopen("../private/hallgatok/$urancode/teljesitett.txt","r");
    $fileFelvett=fopen("../private/hallgatok/$urancode/felvett.txt","r");
    $fileTargyak=fopen("../private/targyak/targyak.txt","r");
    if($file===FALSE||$file2===FALSE||$fileFelvett===FALSE||$fileTargyak===FALSE){
        die("Probléma a fájl beolvasásakor!");
    }
    $targyak=[];
    $targynevek=[];
    while(($line=fgets($fileTargyak)) !== FALSE){
        $line=trim($line);
        if($line==="")continue;
        $targynevek[]=substr($line,0,strpos($line,";"));
        $targyak[]=substr($line,strpos($line,";")+1);
    }
    fclose($fileTargyak);
    $felvetttargyak=[];
    echo "Felvett tárgyak:<ul>";
    while (($line=fgets($fileFelvett)) !== FALSE){
        $line=trim($line);
        $felvetttargyak[]=$line;
        echo "<li>".$line."</li>";
    }
    echo "</ul>Felvehető tárgyak (képzés,ajánlott félév):<table><thead><tr><th>Felvétel</th><th>Tárgy neve</th><th>Tárgy kódja</th><th>Ajánlott képzés</th><th>Ajánlott félév</th><th>Kredit(ea+gyak)</th><th>Óraszám(ea+gyak)</th></tr></thead><tbody>";
    while (($line=fgets($file)) !== FALSE){
        $line=trim($line);
        $da=explode(";",$targyak[array_search($line,$targynevek)]);
        echo "<tr>";
        //INDEX + 1 = tHELP !!
        echo "<td><input type='checkbox' name='".$line."' value='".$line."' ".(in_array($line,$felvetttargyak)?"checked":"")."/></td><td>".$line."</td>"."<td>".$da[0]."</td>"."<td>".KEPZESEK[$da[2]]."</td>"."<td>".$da[3]."</td>"."<td>".$da[4]."+".$da[5]."</td>"."<td>".$da[6]."+".$da[7]."</td></tr>";
        //echo "<tr>".$line." <sub>(".KEPZESEK[$da[1]].",".$da[2].")</sub><input type='checkbox' name='".$line."' value='".$line."' ".(in_array($line,$felvetttargyak)?"checked":"")."/></tr>";
    }
    echo "</tbody></table>Teljesített tárgyak:<ul>";
    while (($line=fgets($file2)) !== FALSE){
        echo "<li>$line</li>";
    }
    echo "</ul>";
    fclose($file);
    fclose($file2);
}

function userTargyfelvetel($urancode,$felvennikivanttargyak){
    $file=fopen("../private/hallgatok/$urancode/felveheti.txt","r");
    $fileFelvett=fopen("../private/hallgatok/$urancode/felvett.txt","w");
    //var_dump($felvennikivanttargyak);
    while (($line=fgets($file)) !== FALSE){
        if(in_array(trim($line),$felvennikivanttargyak))fwrite($fileFelvett,$line);
    }
}
/*BELOW 8.0*/
function startsWith( $haystack, $needle ) {
    $length = strlen( $needle );
    return substr( $haystack, 0, $length ) === $needle;
}

function endsWith( $haystack, $needle ) {
    $length = strlen( $needle );
    if( !$length ) {
        return true;
    }
    return substr( $haystack, -$length ) === $needle;
}