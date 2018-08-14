/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function(){
   $("#btn_projektSpeichern").click(function(){
        var projektname = $("#projektname").val();
        var projektbeschreibung = $("#projektbeschreibung").val();
        var projektid = $("#projektid").val();
        if(!projektname || !projektbeschreibung){
            amaranError("Fehler","Projektname/Projektbeschreibung dürfen nicht leer sein.");
        }else{
            $.ajax({
             type: "POST",
             data: {
               action:"saveAllgemeines",
               projektname:projektname,
               projektid:projektid,
               projektdesc:projektbeschreibung
             },
             dataType: "text",
             url: "./ajax/editProjekt.php",
             async: false,
             success: function() {
                    location.reload();
             },
             error: function(){
                  amaranError("Speichern Fehlgeschlagen",":(");
             }
         }); 
        }
   });
   
   $("#btn_projektdelete").click(function(){
        var projektid = $("#projektid").val();
        if(!confirm("Soll das Projekt wirklich gelöscht werden?")){
            return;
        }else{
            $.ajax({
             type: "POST",
             data: {
               action:"deleteProjekt",
               projektid:projektid
             },
             dataType: "text",
             url: "./ajax/editProjekt.php",
             async: false,
             success: function() {
                    window.location.href = "index.php?page=AddProjekt";
             },
             error: function(){
                  amaranError("Löschen Fehlgeschlagen",":(");
             }
         }); 
        }
   });
   
   $("#copyClipboard").click(function(){
       var input = $("#projektlink");
       input.select();
       document.execCommand("copy");
        amaranOk("Kopiert","Link wurde in die Zwischenablage kopiert.")
   });
   $("#copyLinkClipboard").click(function(){
       var input = $("#projektversionlink");
       input.select();
       document.execCommand("copy");
        amaranOk("Kopiert","Link wurde in die Zwischenablage kopiert.")
   });
   $(document).on("click", ".copyChangesLink", function(){
       var input = $(".changesLinkInput");
       input.select();
       document.execCommand("copy");
       amaranOk("Kopiert","Link wurde in die Zwischenablage kopiert.")
   });
});


function openVersionModal(versionID){
    $.ajax({
        type: "POST",
        data: {
          action:"getVersionModal",
          versionID:versionID
        },
        dataType: "text",
        url: "./ajax/editProjekt.php",
        async: false,
        success: function(data) {
            $("#modalPlaceholder").html("");
            $("#modalPlaceholder").html(data);
            $('#versionModal').modal('show');
        },
        error: function(){
            amaranError("Aktion Fehlgeschlagen",":(");
        }
    });
}

function setAsProjektFile(fileID){
    if(!confirm("Möchten Sie wirklich die Datei unter dem öffentlichen Downloadlink bereitstellen?")){
        return;
    }
    
    var projektid = $("#projektid").val();
    
    $.ajax({
        type: "POST",
        data: {
          action:"setAsProjektFile",
          projektid:projektid,
          fileid:fileID
        },
        dataType: "text",
        url: "./ajax/editProjekt.php",
        async: false,
        success: function() {
            location.reload();
        },
        error: function(){
             amaranError("Aktion Fehlgeschlagen",":(");
        }
    });
}

function removeAsProjektFile(fileID){
    if(!confirm("Möchten Sie wirklich die Datei vom öffentlichen Download entfernen?")){
        return;
    }
    
    var projektid = $("#projektid").val();
    
    $.ajax({
        type: "POST",
        data: {
          action:"removeAsProjektFile",
          projektid:projektid,
          fileid:fileID
        },
        dataType: "text",
        url: "./ajax/editProjekt.php",
        async: false,
        success: function() {
            location.reload();
        },
        error: function(){
             amaranError("Aktion Fehlgeschlagen",":(");
        }
    });
}


function removeFile(fileID){
    if(!confirm("Möchten Sie die Datei wirklich löschen?")){
        return;
    }
    
    var projektid = $("#projektid").val();
    
    $.ajax({
        type: "POST",
        data: {
          action:"removeFile",
          projektid:projektid,
          fileid:fileID
        },
        dataType: "text",
        url: "./ajax/editProjekt.php",
        async: false,
        success: function() {
            location.reload();
        },
        error: function(){
             amaranError("Aktion Fehlgeschlagen",":(");
        }
    });
}
