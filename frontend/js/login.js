/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){
   $("#btn_login").click(function(){
       Login();
   });
   
   $("#password").keydown(function(e){
        if (e.which == 13 || e.keyCode == 13) {
             Login();
        }
   })
   
});

function Login(){
    var username = $("#username").val();
    var password = $("#password").val();
    var stay = $("#stay").is(":checked");
    if(!username || !password){
        amaranError("Fehler","Bitte füllen Sie alle Felder aus!");
    }else{
        $.ajax({
         type: "POST",
         data: {
           username:username,
           password:password,
           stay:stay
         },
         url: "ajax/login.php",
         dataType: "html",
         async: false,
         success: function(data) {
             location.reload();
         },
         error: function(data){
              amaranError("Login Fehlgeschlagen",":(");
         }
     }); 
    }
}

    
