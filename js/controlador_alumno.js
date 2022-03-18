$("#ver_asist").click(function(){
    $("#bienvenida").hide();
    $("#ver_vent_alum").hide();
    // Este ultimo se muestra
    $("#ver_asist_alum").fadeIn(2000);
    console.log("ver asist");
});

$("#ver_ventilacion").click(function(){
    $("#bienvenida").hide();
    $("#ver_asist_alum").hide();
    $("#ver_vent_alum").fadeIn(2000);
    // Este ultimo se muestra
    console.log("ver vent controlador");
});

