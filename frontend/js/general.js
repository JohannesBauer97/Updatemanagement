/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {
    $('.tooltipster').tooltipster({
        theme: 'tooltipster-light'
    });
});


function amaranOk(title,message){
    $.amaran({
        'theme'     :'awesome ok',
        'content'   :{
            title: title,
            message:message,
            info:'',
            icon:'fa fa-check-square-o'
        },
        'position'  :'top right',
        'outEffect' :'slideRight'
    });
}

function amaranError(title,message){
    $.amaran({
        'theme'     :'awesome error',
        'content'   :{
            title:title,
            message:message,
            info:'',
            icon:'fa fa-exclamation-circle'
        },
        'position'  :'top right',
        'outEffect' :'slideRight'
    });
}