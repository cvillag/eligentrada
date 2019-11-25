$(document).ready(function(){

    // Oculta y muestra la descripcion de los eventos cuando el raton para por encima de su imgaen

    $("#c1").mouseenter(function(){
        $("#d1").animate({top: '-64px'}, "fast");
    });
    $("#c1").mouseleave(function(){
        $("#d1").animate({top: '0px'}, "fast");
    });

    $("#c2").mouseenter(function(){
        $("#d2").animate({top: '-64px'}, "fast");
    });
    $("#c2").mouseleave(function(){
        $("#d2").animate({top: '0px'}, "fast");
    });

    $("#c3").mouseenter(function(){
        $("#d3").animate({top: '-64px'}, "fast");
    });
    $("#c3").mouseleave(function(){
        $("#d3").animate({top: '0px'}, "fast");
    });
});