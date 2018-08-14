/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function fileChange()
{
    //FileList Objekt aus dem Input Element mit der ID "fileA"
    var fileList = document.getElementById("fileA").files;
 
    //File Objekt (erstes Element der FileList)
    var file = fileList[0];
 
    //File Objekt nicht vorhanden = keine Datei ausgewählt oder vom Browser nicht unterstützt
    if(!file){
        //$('btnUpload').attr('disabled', true);
        //$('btnAbort').attr('disabled', true);
        return;
    }
       
 
    //$('btnUpload').removeAttr('disabled');
    //$('btnAbort').removeAttr('disabled');
    document.getElementById("fileName").innerHTML = 'Dateiname: ' + file.name;
    document.getElementById("fileSize").innerHTML = 'Dateigröße: ' + file.size + ' B';
    document.getElementById("fileType").innerHTML = 'Dateitype: ' + file.type;
    document.getElementById("progress").value = 0;
    document.getElementById("prozent").innerHTML = "0%";
}

var client = null;
 
function uploadFile()
{
    //Wieder unser File Objekt
    var file = document.getElementById("fileA").files[0];
    //FormData Objekt erzeugen
    var formData = new FormData();
    //XMLHttpRequest Objekt erzeugen
    client = new XMLHttpRequest();
 
    var prog = document.getElementById("progress");
 
    if(!file)
        return;
    
    if($("#version").val() === $("#projektversion").val()){
        alert("Die Version darf nicht der aktuellen oder einer früheren entsprechen.");
        return;
    }
 
    prog.value = 0;
    prog.max = 100;
 
    //Fügt dem formData Objekt unser File Objekt hinzu
    formData.append("datei", file);
    formData.append("pid", $("#pid").val());
    formData.append("changes", $("#changes").val());
    formData.append("version", $("#version").val());
    
    $("#uploading-status").fadeIn();
 
    client.onerror = function(e) {
        alert("onError");
    };
 
    client.onload = function(e) {
        document.getElementById("prozent").innerHTML = "Upload abgeschlossen.";
        prog.value = prog.max;
        location.reload();
    };
 
    client.upload.onprogress = function(e) {
        var p = Math.round(100 / e.total * e.loaded);
        document.getElementById("progress").value = p;            
        document.getElementById("prozent").innerHTML = p + "%";
    };
 
    client.onabort = function(e) {
        alert("Upload abgebrochen");
    };
 
    client.open("POST", "./ajax/upload.php");
    client.send(formData);
}

function uploadAbort() {
    if(client instanceof XMLHttpRequest)
        //Briecht die aktuelle Übertragung ab
        client.abort();
}