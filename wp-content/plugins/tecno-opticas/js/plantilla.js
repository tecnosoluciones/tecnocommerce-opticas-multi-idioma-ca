jQuery( window ).load(function() {
    let body_t = jQuery('body');
    body_t.on("click", "a.editar", function(){
        jQuery(".conten_formula_plantilla").hide();
        plantilla = jQuery(this).attr("data-name");
        jQuery(".conten_formula_plantilla[data-name='"+plantilla+"']").show();
        body_t.append('<div class="oscuridad" style="height: '+jQuery("body").height()+'px"><img id="loader_optica" src="'+tecnooptica_plantilla.ajaxLoaderImage+'" alt=""></div>');


        jQuery.ajax({
            url : tecnooptica_plantilla.ajaxUrl,
            type: 'post',
            data: {
                action : "consultar_plantilla",
                key: plantilla,
                ancho: jQuery(window).width(),
            },
            async: true,
            success: function(resultado){
                jQuery("#loader_optica").remove();
                jQuery(".oscuridad").append(resultado);
            }
        });
    });

    body_t.on("click", "button.cancelar_plantilla", function(){
        jQuery(".oscuridad").remove();
        jQuery(this).parents(".conten_formula_plantilla").hide();
    });

    body_t.on("click", "a.eliminar", function(){
        plantilla = jQuery(this).attr("data-name");
        mensaje = "<div class=\"alert alert-success\" role=\"alert\">\n" +
            "            Plantilla <strong>"+plantilla+"</strong> eliminada.\n" +
            "        </div>";
        jQuery.ajax({
            url : tecnooptica_plantilla.ajaxUrl,
            type: 'post',
            data: {
                action : "remover_plantilla",
                key: plantilla,
            },
            async: true,
            success: function(resultado){
                if(parseInt(resultado) === 1){
                    mostrar_mensaje(mensaje);
                    setTimeout(function(){ location.reload() }, 2000);
                }
            }
        });
    });

    body_t.on("change", "select#select_tip_vision", function(){
        tipo_vision = jQuery(this).val();
        plantilla = jQuery(".conten_formula_plantilla").attr("data-name");

        if(parseInt(jQuery(window).width()) < 768){
            contenedor_formula = jQuery(".form_movil .formula");
            contenedor_formula.html("");
            contenedor_formula.append('<img id="loader_optica" src="'+tecnooptica_plantilla.ajaxLoaderImage+'" alt="">');
        }
        else{
            contenedor_formula = jQuery("td#contenedor_formula");
            contenedor_formula.html("");
            contenedor_formula.append('<img id="loader_optica" src="'+tecnooptica_plantilla.ajaxLoaderImage+'" alt="">');
        }

        jQuery.ajax({
            url : tecnooptica_plantilla.ajaxUrl,
            type: 'post',
            data: {
                action : "consultar_tipo_vision_plantilla",
                tipo_vision: tipo_vision,
                plantilla: plantilla,
                ancho: jQuery(window).width(),
            },
            async: true,
            success: function(resultado){
                jQuery("#loader_optica").remove();
                contenedor_formula.append(resultado);
            }
        });
    });

    body_t.on("click", ".guardar_plantilla", function(){
        tipo_vision = jQuery("select#select_tip_vision").val();
        dp = jQuery("#dp").val();
        plantilla = jQuery(".conten_formula_plantilla").attr("data-name");

        var datos_formula = new Object();

        jQuery("table#formulas select").each(function(a,e){
            datos_formula[jQuery(e).attr("name")] = jQuery(e).val();
        });

        mensaje = "<div class=\"alert alert-success\" role=\"alert\">\n" +
            "            Plantilla <strong>"+plantilla+"</strong> Actualizada correctamente.\n" +
            "        </div>";

        jQuery.ajax({
            url : tecnooptica_plantilla.ajaxUrl,
            type: 'post',
            data: {
                action : "actualizar_plantilla",
                tipo_vision: tipo_vision,
                dp: dp,
                plantilla: plantilla,
                datos_formula: datos_formula,
            },
            async: true,
            success: function(resultado){
                if(parseInt(resultado) === 1){
                    jQuery(".oscuridad").remove();
                    mostrar_mensaje(mensaje);
                    setTimeout(function(){ jQuery("div.mensaje").html("") }, 2000);
                }
            }
        });
    });

    body_t.on("click","button#añadir_nueva_formula", function(){
        body_t.append('<div class="oscuridad" style="height: '+jQuery("body").height()+'px"><img id="loader_optica" src="'+tecnooptica_plantilla.ajaxLoaderImage+'" alt=""></div>');

        jQuery.ajax({
            url : tecnooptica_plantilla.ajaxUrl,
            type: 'post',
            data: {
                action : "nueva_plantilla",
                ancho: jQuery(window).width(),

            },
            async: true,
            success: function(resultado){
                jQuery("#loader_optica").remove();
                jQuery(".oscuridad").append(resultado);
            }
        });
    });

    body_t.on("click","button.agregar_plantilla", function(){
        tipo_vision = jQuery("select#select_tip_vision").val();
        dp = jQuery("#dp").val();
        plantilla = jQuery(".nombre_plantilla").val();

        var datos_formula = new Object();

        jQuery("table#formulas select").each(function(a,e){
            datos_formula[jQuery(e).attr("name")] = jQuery(e).val();
        });

        mensaje = "<div class=\"alert alert-success\" role=\"alert\">\n" +
            "            Plantilla <strong>"+plantilla+"</strong> agregada correctamente.\n" +
            "        </div>";

        jQuery.ajax({
            url : tecnooptica_plantilla.ajaxUrl,
            type: 'post',
            data: {
                action : "actualizar_plantilla",
                tipo_vision: tipo_vision,
                dp: dp,
                plantilla: plantilla,
                datos_formula: datos_formula,
            },
            async: true,
            success: function(resultado){
                if(parseInt(resultado) === 1){
                    jQuery(".oscuridad").remove();
                    mostrar_mensaje_plantilla(mensaje);
                    setTimeout(function(){ jQuery("div.mensaje").html("") }, 2000);
                    setTimeout(function(){ location.reload() }, 3000);
                }
            }
        });
    });

    body_t.on("change", "select.caja_ojo_der", function(){
        Valor_caja_redercha = jQuery(this).val();
        input_cantidad = jQuery("input.qty");
        Valor_caja_izquierda = jQuery("select.caja_ojo_izq").val();
        canti_cajas = parseInt(Valor_caja_redercha) + parseInt(Valor_caja_izquierda);

        input_cantidad.val(canti_cajas);
        input_cantidad.keyup();
    });

    body_t.on("change", "select.caja_ojo_izq", function(){
        Valor_caja_izquierda = jQuery(this).val();
        input_cantidad = jQuery("input.qty");
        Valor_caja_redercha = jQuery("select.caja_ojo_der").val();
        canti_cajas = parseInt(Valor_caja_redercha) + parseInt(Valor_caja_izquierda);

        input_cantidad.val(canti_cajas);
        input_cantidad.keyup();
    });

});

function mostrar_mensaje_plantilla(mensaje){
    contenedor = jQuery("div.mensaje");
    contenedor.append(mensaje);
}