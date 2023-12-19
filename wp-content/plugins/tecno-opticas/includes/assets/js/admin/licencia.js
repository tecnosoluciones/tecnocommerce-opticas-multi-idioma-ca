jQuery( window ).ready(function() {
    if(licence_tecnooptica){
        jQuery("div#wpbody-content .wrap").prepend(licence_tecnooptica.licencia);
    }
});