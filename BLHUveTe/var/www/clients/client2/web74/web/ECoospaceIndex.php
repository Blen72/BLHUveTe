<?php
session_start();
ob_start();
include_once("../private/include/func.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Elméleti Coospace</title>
    <link rel="stylesheet" href="css/main.css">
    <style>
        .noStyle{
            border: none;
            background-color: unset;
            color: inherit;
            cursor: inherit;
            width: 100%;
            padding: 0;
        }
        .kerdes h2{
            font-size: medium;
            margin: 0;
        }
        .test{
            margin: 0 0 0 8px;
            border: 2px solid crimson;
            padding: 0 4px;
        }
        .test form button{
            background-color: white;
            border: 2px solid lime;
        }
        .test form button:hover{
            background-color: wheat;
            border: 2px solid darkred;
        }
        .kerdes{
            margin-bottom: 10px;
            background-color: rgba(0,0,0,0.2);
            border: 2px solid #f00;
            padding: 4px;
        }
        .hirdetmenyDiv{
            border: 2px solid crimson;
            margin: 4px 0 0 8px;
            background-color: rgba(128,0,255,0.25);
        }
        .hirdetmenyDiv h2{
            margin: 4px 0 0 4px;
        }
        .hirdetmenyDiv p{
            margin: 8px;
        }
        .hirdetmenyDiv a{
            color: aqua;
        }
    </style>
</head>
<body>
<div id="headernav">
    <header><h1>Elméleti Coospace</h1></header>
    <form action="ECoospaceIndex.php" method="post" style="overflow-y: hidden;overflow-x: auto;scrollbar-color: crimson cyan;scrollbar-width: thin;"><nav><a href="index.php">Elosztó</a><?php
        if(isset($_SESSION["user"])){
            $fileFelvett=fopen("../private/hallgatok/".$_SESSION["user"]["URANCODE"]."/felvett.txt","r");
            while (($line=fgets($fileFelvett)) !== FALSE){
                echo "<a href='#'><input class='noStyle' type='submit' name='toshow' value='".trim($line)."'></a>";
            }
        } else {
            echo "Jelentkezz be!";
        }
        ?></nav></form>
</div>
<?php
if(isset($_SESSION["user"])&&isset($_POST["toshow"])/*&&$_SESSION["user"]["admin"]*/){
    if($_SESSION["user"]["admin"]){
        $szinterdir="../private/szinterek/".$_POST["toshow"];
        if(isset($_POST["addtest"])){
            if(!file_exists($szinterdir."/tesztek")) {
                mkdir($szinterdir."/tesztek", 0777, true);
            }
            $file=fopen($szinterdir."/tesztek/".$_POST["tname"].".php","w");
            $file2=fopen($szinterdir."/tesztek/".$_POST["tname"]."_ans.php","w");
            fwrite($file,(isset($_POST["tpublic"])?"on":"off")."\n".$_POST["tdate"]."\n".$_POST["tmaxn"]."\n".$_POST["ttime"]."\n"/*."<summary>".$_POST["tname"]."</summary>"*/.$_POST["testContent"]);
            fwrite($file2,implode("\n",explode('$EP$',$_POST["testAns"])));
            fclose($file);fclose($file2);
        } else if(isset($_POST["addhirdetmeny"])){
            if(!file_exists($szinterdir."/hirdetmenyek")) {
                mkdir($szinterdir."/hirdetmenyek", 0777, true);
            }
            $file=fopen($szinterdir."/hirdetmenyek/".$_POST["hname"].".html","w");
            fwrite($file, "<div class='hirdetmenyDiv'><h2>".$_POST["hname"]."</h2><p>".implode("<br/>", explode("\n",$_POST["hirdetmenyContent"]))."</p></div>");
            fclose($file);
        }
    }
    include("../private/szinterek/lib/main.php");//benne van az ob_flush
} else {ob_flush();}
?>
</body>
</html>