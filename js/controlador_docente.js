// Arreglar el ready por default

// --------- PRIMERA CARGA DE PAGINA -----------
/*
        console.log("if vez = 0");
        $("#bienvenida").show();
        $("#ver_mis_asist").hide();
        $("#ver_asist_curs").hide();
        $("#ver_vent_doc").hide();
*/

        $("#ver_misasist").click(function(){
            $("#bienvenida").hide();
            $("#ver_asist_curs").hide();
            $("#ver_vent_doc").hide();
            // Este ultimo se muestra
            $("#ver_mis_asist").fadeIn(2000);
        });
        


        $("#ver_asistcursos").click(function(){
            $("#bienvenida").hide();
            $("#ver_mis_asist").hide();
            $("#ver_vent_doc").hide();
            // Este ultimo se muestra
            $("#ver_asist_curs").fadeIn(2000);
        });
        
        $("#ver_ventilacion").click(function(){
            $("#bienvenida").hide();
            $("#ver_mis_asist").hide();
            $("#ver_asist_curs").hide();
            // Este ultimo se muestra
            $("#ver_vent_doc").fadeIn(1000);
        });

    

/*
if($("form-group").submit()){
    console.log("Form submitted!");
    $("#bienvenida").hide();
    $("#ver_mis_asist").show(2000);

} else{
    console.log("llega al else");


//$(document).one('ready', function () {
    $(document).ready(function(){
    //$( window ).on( "load", function(){
        
        $(document).on('submit', 'form-group', function(e) {
            e.preventDefault();
            console.log('Submitted');
        });
    
        
        $("#bienvenida").show();
        $("#ver_mis_asist").hide();
        $("#ver_asist_curs").hide();
        $("#ver_vent_doc").hide();
        /* ---- CURSOS ---- 


    });  */

//}

