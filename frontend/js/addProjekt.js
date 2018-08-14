/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function(){
   $("#btn_projektAnlegen").click(function(){
        var projektname = $("#projektname").val();
        var projektbeschreibung = $("#projektbeschreibung").val();
        if(!projektname){
            amaranError("Fehler","Es muss ein Projektname angegeben werden!");
        }else{
            $.ajax({
             type: "POST",
             data: {
               projektname:projektname,
               projektbeschreibung:projektbeschreibung
             },
             url: "ajax/addProjekt.php",
             dataType: "html",
             async: false,
             success: function(data) {
                    amaranOk("Angelegt!","Das Projekt kann nun bearbeitet werden.")
                    $("#projektname").val("");
                    $("#projektbeschreibung").val("");
                    location.reload();
             },
             error: function(data){
                  amaranError("Login Fehlgeschlagen",":(");
             }
         }); 
        }
   });
   
});