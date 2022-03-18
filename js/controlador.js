$(document).ready(function(){
    $("#bienvenida").show();
    $("#ver_aforo_covid").hide();
    console.log("LLega aca");

    /* ---- VENTILACION ---- */    

    $("#ver_aforo").click(function(){
        $("#bienvenida").hide();
        // Este ultimo se muestra
        $("#ver_aforo_covid").fadeIn(2000);
    });

    $("#ver_ventilacion").click(function(){
        $("#bienvenida").hide();
        

        $("#ver_aforo_covid").fadeIn(2000);
    });

    $("#ver_fiebre").click(function(){
        $("#bienvenida").hide();
        $("#ver_aforo_covid").fadeIn(2000);
    });

    /* ---- CURSOS ---- */


});
