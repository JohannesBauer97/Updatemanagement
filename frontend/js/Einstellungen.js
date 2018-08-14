/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function(){
   $("#btn_pwAendern").click(function(){
        var oldpw = $("#oldpw").val();
        var newpw = $("#newpw").val();
        var newpw2 = $("#newpw2").val();
        if(!oldpw || !newpw || !newpw2){
            amaranError("Fehler","Bitte alle Felder ausfüllen!");
        }else{
            $.ajax({
             type: "POST",
             data: {
               oldpw:oldpw,
               newpw:newpw,
               newpw2:newpw2
             },
             url: "ajax/changePasswort.php",
             dataType: "html",
             async: false,
             success: function(data) {
                    amaranOk("Geändert!","Sie können sich nun mit Ihrem neuen Passwort anmelden.")
             },
             error: function(data){
                  amaranError("Ändern Fehlgeschlagen","Bitte überprüfen Sie Ihre Eingabe.");
             }
         }); 
        }
   });
   
});