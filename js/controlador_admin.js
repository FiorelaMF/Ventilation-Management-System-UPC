

    /* ---- VENTILACION ---- */    

    $("#ver_aforo").click(function(){
        $("#bienvenida").hide();
        $("#ver_casos_fiebre").hide();
        // Este ultimo se muestra
        $("#ver_aforo_covid").fadeIn(2000);
    });
/*
    $("#ver_ventilacion").click(function(){
        $("#bienvenida").hide();
        $("#ver_aforo_covid").hide();
        

        $("#ver_vent_tabla").fadeIn(2000);
    }); */

    $("#ver_fiebre").click(function(){
        $("#bienvenida").hide();
        $("#ver_aforo_covid").hide();
        $("#ver_casos_fiebre").fadeIn(2000);
    });

    /* ---- CURSOS ---- */
    $("#ingresa_doc").click(function(){
        $("#bienvenida").hide();
        $("#ver_aforo_covid").hide();
        $("#ver_casos_fiebre").hide();
        $("#ingresa_doc_nuevo").fadeIn(2000);
    });

    $("#crea_secc").click(function(){
        $("#bienvenida").hide();
        $("#ver_aforo_covid").hide();
        $("#ver_casos_fiebre").hide();
        $("#ingresa_doc_nuevo").hide();
        $("#crea_seccion_nueva").show();
    });


