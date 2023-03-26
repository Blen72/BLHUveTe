<script>
    /*README!
    * FIXED!!!!! Előre legyenek kész a kérdések. Adjuk hozzá az öszzeset típussal együtt a megfelelő sorrendben. Új hozzáadásánál elveszik amit eddig csináltunk!
    * Technical stuff:
    * OLD: kerdes class: nth kérdés kiírása
    * DT class: DelThis tehát ezt törölni kell. Az adminoknak hasznos hogy tudják mit hova írjanak. :)
    * convContent class: Ne input legyen ott hanem annak a szövege*/
    var nthKerdes=1;
    var datx=[];
    function saveKerdesek(e){
        datx=[];
        var ins=e.getElementsByTagName("INPUT");
        for(let i=0; i<ins.length; i++){
            switch(ins[i].type){
                case "text": datx.push({"type":"text","value":ins[i].value});break;
                case "radio":
                case "checkbox":datx.push({"type":ins[i].type,"checked":ins[i].checked});break;
            }
        }
    }
    function loadKerdesek(e){
        var ins=e.getElementsByTagName("INPUT");
        for(let i=0; datx.length; i++){
            var dat=datx.shift();
            switch(dat.type){
                case "text": ins[i].value=dat.value;break;
                case "radio":
                case "checkbox":ins[i].checked=dat.checked;break;
            }
        }
    }
    function addRadio(e,n){
        saveKerdesek(e);
        e.innerHTML+="<label><input type='radio' name='radio"+n+"'/><input type='text' class='convContent'/></label><br>";
        loadKerdesek(e);
    }
    function addCheck(e,n){
        saveKerdesek(e);
        e.innerHTML+="<label><input type='checkbox' name='check"+n+"'/><input type='text' class='convContent'/></label><br>";
        loadKerdesek(e);
    }
    function addTest(kType){
        const tc = document.getElementById("testContent");
        var toadd="<div class='kerdes'><h2>"+nthKerdes+". kérdés</h2><span class='DT'>Utasítás:</span><input class='convContent' type='text'/><br>";
        switch(kType){
            case "szoveges":
                toadd+="Válasz: <input type='text'/><br>";
                break;
            case "radio":
                toadd+="<button class='DT' type='button' onclick='addRadio(this.parentElement,"+nthKerdes+")'>Add radio button</button><br>";
                break;
            case "check":
                toadd+="<button class='DT' type='button' onclick='addCheck(this.parentElement,"+nthKerdes+")'>Add checkbox</button><br>";
                break;
            default:alert("Elírás történt: "+kType);break;
        }
        saveKerdesek(document.getElementById("testContent"));
        tc.innerHTML+=toadd+"</div>";
        loadKerdesek(document.getElementById("testContent"));
        nthKerdes++;
    }
    function copyTest(from,to,ans){
        var anss=[];
        var radChGroup=false;
        var radChName="";//Minden radio "radio"+szám így ez biztos invalid! (annak is kell lennie) ++check
        for(var i=0;i<from.getElementsByTagName("INPUT").length;i++){
            var acte=from.getElementsByTagName("INPUT")[i];
            if(acte.classList.contains("DT")||acte.classList.contains("convContent"))continue;
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
        ans.value=anss.join("$EP$");//$EPARATOR$
        let finalRes="";
        while(from.getElementsByClassName("DT").length){
            from.getElementsByClassName("DT")[0].remove();
        }
        while(from.getElementsByClassName("convContent").length){
            from.getElementsByClassName("convContent")[0].replaceWith(from.getElementsByClassName("convContent")[0].value);
        }
        finalRes=from.innerHTML;
        to.value=finalRes;
    }
</script>
<div style="border: 2px solid aqua">
    <h1>Add new Test</h1>
    <label>Kérdés típusa:<select id="kType"><option value="szoveges">Sima szöveges</option><option value="radio">Rádiógombos</option><option value="check">Checkboxos</option></select></label><br>
    <button onclick="addTest(document.getElementById('kType').value);">Kérdés hozzáadása</button><br>
    <form action="ECoospaceIndex.php" method="post" onsubmit="copyTest(document.getElementById('testContent'),document.getElementById('testContentInput'),document.getElementById('testAns'));/*Ez lefut mielőtt action bekövetkezik!*/">
        <div id="testContent"></div>
        <label>Test name: <input type="text" name="tname"/></label><br>
        <label>Test kitöltési határidő: <input type="datetime-local" name="tdate"/></label><br>
        <label>Test kitöltési idő (másodpercben): <input type="number" name="ttime"/></label><br>
        <label>Hányszor tölthető ki: <input type="number" name="tmaxn"/></label><br>
        <label>Publikus-e: <input type="checkbox" name="tpublic"/></label><br>
        <input type="submit" name="addtest" value="Teszt hozzáadása"/><br>
        <input style="display: none" id="testContentInput" type="text" name="testContent"/>
        <input style="display: none" id="testAns" type="text" name="testAns"/>
        <input style="display: none" type="text" name="toshow" value="<?php echo $_POST["toshow"]; ?>"/>
    </form>
</div>