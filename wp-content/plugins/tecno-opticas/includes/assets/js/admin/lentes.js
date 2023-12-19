jQuery( window ).load(function() {
    let body_t = jQuery('body');

    body_t.on("click", "#filtros_lentes_panel input.checkbox", function(){
        elemento = jQuery(this);
        wrap_referencia = elemento.attr("id");
        id_elemento = elemento.attr("class").replace("checkbox element_", "");
        contenedor_opciones = jQuery(".opciones_filtro_"+id_elemento);
        img_loader = '<img id="loader_optica" src="'+tecnooptica_lentes.ajaxLoaderImage+'" alt="Cargabdi">';
        contenedor_opciones.append(img_loader);
        if(jQuery(this).prop('checked') === true){
            jQuery.ajax({
                url : tecnooptica_lentes.ajaxUrl,
                type: 'post',
                data: {
                    action : "buscar_opciones_filtros",
                    id_elemento: id_elemento,
                    name: wrap_referencia,
                },
                async: true,
                success: function(resultado){
                    if(parseInt(resultado) !== 0){
                        contenedor_opciones.append(resultado);
                    }
                    jQuery("#loader_optica").remove();
                    jQuery(".precio_"+wrap_referencia+"_field").show();
                }
            });

        }
        else{
            jQuery(".precio_"+wrap_referencia+"_field").hide();
            contenedor_opciones.html("");
        }
    });
});