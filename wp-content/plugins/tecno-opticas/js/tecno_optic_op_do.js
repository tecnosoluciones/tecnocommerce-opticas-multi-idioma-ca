jQuery( window ).load(function() {
    let body_t = jQuery('body');
    setTimeout(habilitar_proceso,2000);

    body_t.on("click","a#confirmar_plantilla",function(){
        contenedor_boton = jQuery("h2#paso_two_boton button");
        if(parseInt(jQuery(".lista_formulas").length) !== 0){
            selector_plantilla = jQuery("select#selec_form");
            if(selector_plantilla.val()===""){
                r = confirm(tecnooptica_proceso.mensajes_ajax['tecnooptica_ajax_1']);
                if(r === true){
                    contenedor_boton.removeAttr("disabled");
                    contenedor_boton.click();
                }
            }
        }
        else{
            contenedor_boton.removeAttr("disabled");
            contenedor_boton.click();
        }
    });

    body_t.on("click",".tipo_form", function(){
        jQuery(".form-mula_proceso_dos").css("margin-bottom", "160px");
        btnd = jQuery("div#botones_formulproce");
        tipo_vision = jQuery(this).val();
        div_impresion = jQuery("#imprimir_form");
        div_impresion.html("");
        div_impresion.hide();
        jQuery("#confirmar_formula").removeAttr("data-action");
        jQuery("select#add-ojo-der").removeAttr("data-control");
        jQuery("select#add-ojo-izq").removeAttr("data-control");
        jQuery("select#eje-ojo-der").removeAttr("data-control");
        jQuery("select#eje-ojo-izq").removeAttr("data-control");
        jQuery("select#cilindro-ojo-der").removeAttr("data-control");
        jQuery("select#cilindro-ojo-izq").removeAttr("data-control");
        jQuery("select#esfera-ojo-der").removeAttr("data-control");
        jQuery("select#esfera-ojo-izq").removeAttr("data-control");
        conten_descripcion = jQuery(".mostrar_descripcion_vision");
        conten_descripcion.hide();
        conten_descripcion.children().hide();
        btnd.hide();

        jQuery("#loader").removeAttr("style");
        if(tipo_vision === "descanso") {
            jQuery("#loader").css("display","none");
            btnd.show();
            conten_descripcion.show();
            conten_descripcion.children("."+tipo_vision).show();
        }
        else{
            consultar_ajax(tipo_vision, div_impresion, "form_proceso_compra");
        }
    });

    body_t.on("change", "div#imprimir_form select", function(){
        control = jQuery(this);
        jQuery("div#part_two").hide();
        jQuery("div#imprimir_list_lentes").html("");
        jQuery(".form-mula_proceso_dos").css("margin-bottom", "160px");
        jQuery(".filtro_proc_com").prop("checked", false);
        jQuery("div#mensajes").text("");
        jQuery("div#mensajes").removeAttr("style");
        jQuery("div#mensajes").text(tecnooptica_proceso.mensajes['tecnooptica-setup_mensaje_paso_2']);
        jQuery("a#confirmar_formula").show();
        jQuery("a#confirmar_filtro").hide();
        jQuery("a#confirmar_plantilla_nomre").hide();
        jQuery("div#confirmar_formula").show();
        if(parseFloat(control.val()) !== 0){
            control.removeAttr("style");
        }
        else{
            validar_formulas();
        }
    });

    body_t.on("click", "#confirmar_formula", function(){
        jQuery(".form-mula_proceso_dos").removeAttr("style");
        dp_campo = jQuery("input.dp-formulate").val();
        eje_ojo_der = jQuery("select#eje-ojo-der").val();
        eje_ojo_izq = jQuery("select#eje-ojo-izq").val();
        cilindro_ojo_der = jQuery("select#cilindro-ojo-der").val();
        cilindro_ojo_izq = jQuery("select#cilindro-ojo-izq").val();
        esfera_ojo_der = jQuery("select#esfera-ojo-der").val();
        esfera_ojo_izq = jQuery("select#esfera-ojo-izq").val();
        if(jQuery("select#add-ojo-izq").length !== 0){
            add_ojo_der = jQuery("select#add-ojo-der").val();
            add_ojo_izq = jQuery("select#add-ojo-izq").val();
            control_menor = obtener_menor("select#add-ojo-izq option");
            if(typeof jQuery("select#add-ojo-izq").attr("data-control") == "undefined") {
                if (parseFloat(add_ojo_izq.replace(",", ".")) == control_menor.replace(",", ".")) {
                    r = confirm(tecnooptica_proceso.mensajes_ajax['tecnooptica_ajax_2'].replace("%variable_cambio%", control_menor));
                    if (r === true) {
                        jQuery("select#add-ojo-izq").removeAttr("style");
                        jQuery("select#add-ojo-izq").attr("data-control","validado");
                        return 0;
                    }
                }
            }
            control_menor = obtener_menor("select#add-ojo-der option");
            if(typeof jQuery("select#add-ojo-der").attr("data-control") == "undefined"){
                if(parseFloat(add_ojo_der.replace(",",".")) == control_menor.replace(",",".")){
                    r = confirm(tecnooptica_proceso.mensajes_ajax['tecnooptica_ajax_3'].replace("%variable_cambio%", control_menor));
                    if(r === true){
                        jQuery("select#add-ojo-der").removeAttr("style");
                        jQuery("select#add-ojo-der").attr("data-control","validado");
                        return 0;
                    }
                }
            }

        }

        control_menor = obtener_menor("select#eje-ojo-izq option");
        if(typeof jQuery("select#eje-ojo-izq").attr("data-control") == "undefined") {
            if (parseFloat(eje_ojo_izq.replace(",", ".")) == control_menor.replace(",", ".")) {
                r = confirm(tecnooptica_proceso.mensajes_ajax['tecnooptica_ajax_4'].replace("%variable_cambio%", control_menor));
                if (r === true) {
                    jQuery("select#eje-ojo-izq").removeAttr("style");
                    jQuery("select#eje-ojo-izq").attr("data-control","validado");
                    return 0;
                }
            }
        }
        control_menor = obtener_menor("select#eje-ojo-der option");
        if(typeof jQuery("select#eje-ojo-der").attr("data-control") == "undefined"){
            if(parseFloat(eje_ojo_der.replace(",",".")) == control_menor.replace(",",".")){
                r = confirm(tecnooptica_proceso.mensajes_ajax['tecnooptica_ajax_5'].replace("%variable_cambio%", control_menor));
                if(r === true){
                    jQuery("select#eje-ojo-der").removeAttr("style");
                    jQuery("select#eje-ojo-der").attr("data-control","validado");
                    return 0;
                }
            }
        }
        control_menor = obtener_menor("select#cilindro-ojo-izq option");
        if(typeof jQuery("select#cilindro-ojo-izq").attr("data-control") == "undefined") {
            if (parseFloat(cilindro_ojo_izq.replace(",", ".")) == control_menor.replace(",", ".")) {
                r = confirm(tecnooptica_proceso.mensajes_ajax['tecnooptica_ajax_6'].replace("%variable_cambio%", control_menor));
                if (r === true) {
                    jQuery("select#cilindro-ojo-izq").removeAttr("style");
                    jQuery("select#cilindro-ojo-izq").attr("data-control","validado");
                    return 0;
                }
            }
        }
        control_menor = obtener_menor("select#cilindro-ojo-der option");
        if(typeof jQuery("select#cilindro-ojo-der").attr("data-control") == "undefined"){
            if(parseFloat(cilindro_ojo_der.replace(",",".")) == control_menor.replace(",",".")){
                r = confirm(tecnooptica_proceso.mensajes_ajax['tecnooptica_ajax_7'].replace("%variable_cambio%", control_menor));
                if(r === true){
                    jQuery("select#cilindro-ojo-der").removeAttr("style");
                    jQuery("select#cilindro-ojo-der").attr("data-control","validado");
                    return 0;
                }
            }
        }
        control_menor = obtener_menor("select#esfera-ojo-izq option");
        if(typeof jQuery("select#esfera-ojo-izq").attr("data-control") == "undefined") {
            if (parseFloat(esfera_ojo_izq.replace(",", ".")) == control_menor.replace(",", ".")) {
                texto =  tecnooptica_proceso.mensajes_ajax['tecnooptica_ajax_8'];
                r = confirm(tecnooptica_proceso.mensajes_ajax['tecnooptica_ajax_8'].replace("%variable_cambio%", control_menor));
                if (r === true) {
                    jQuery("select#esfera-ojo-izq").removeAttr("style");
                    jQuery("select#esfera-ojo-izq").attr("data-control","validado");
                    return 0;
                }
            }
        }
        control_menor = obtener_menor("select#esfera-ojo-der option");
        if(typeof jQuery("select#esfera-ojo-der").attr("data-control") == "undefined"){
            if(parseFloat(esfera_ojo_der.replace(",",".")) == control_menor.replace(",",".")){
                    r = confirm(tecnooptica_proceso.mensajes_ajax['tecnooptica_ajax_9'].replace("%variable_cambio%", control_menor));
                if(r === true){
                    jQuery("select#esfera-ojo-der").removeAttr("style");
                    jQuery("select#esfera-ojo-der").attr("data-control","validado");
                    return 0;
                }
            }
        }

        if(jQuery("input.altura-formulate").length !== 0){
            altura_campo = jQuery("input.altura-formulate").val();
            if(altura_campo === "" || parseFloat(altura_campo) === 0){
                alert(tecnooptica_proceso.mensajes_ajax['tecnooptica_ajax_10'].replace("%variable_cambio%", control_menor));
                return 0;
            }
        }

        if(dp_campo === "" || parseFloat(dp_campo) === 0){
            alert(tecnooptica_proceso.mensajes_ajax['tecnooptica_ajax_11'].replace("%variable_cambio%", control_menor));
            return 0;
        }
        else{
            control = 0;
            jQuery("div#imprimir_form select").each(function(){
                elemento = jQuery(this);
                if(elemento.attr("data-control") != "validado") {
                    if (parseFloat(elemento.val().replace(",", ".")) === 0) {
                        control++;
                    }
                }
            });

            if(typeof jQuery("#confirmar_formula").attr("data-action") != "undefined"){
                control = 0;
            }

            switch (control) {
                case  1:
                case  2:
                case  3:
                case  4:
                case  5:
                case  6:
                case  7:
                case  8:
                    menesaje = tecnooptica_proceso.mensajes['tecnooptica-setup_error_paso_2'];
                    if(typeof jQuery("#confirmar_formula").attr("data-action") == "undefined"){
                        if(typeof menesaje == "undefined"){
                            menesaje = tecnooptica_proceso.mensajes_ajax['tecnooptica_ajax_12'];
                        }
                        r = confirm(menesaje);
                        if(r === true){
                            jQuery("div#imprimir_form select").removeAttr("style");
                            contenedor_boton = jQuery("#confirmar_formula");
                            contenedor_boton.attr("data-action","validado");
                            contenedor_boton.click();
                        }
                        else{
                            var styles = {
                                'outline' : "#F44336",
                                'outline-style': "solid"
                            };
                            control = 0;
                            jQuery("div#imprimir_form select").each(function(){
                                elemento = jQuery(this);
                                if(parseFloat(elemento.val()) === 0){
                                    control++;
                                    elemento.css(styles);
                                }
                            });
                        }
                    }
                    break;
                default:
                    jQuery("div#imprimir_form select").removeAttr("style");
                    contenedor_boton = jQuery("#confirmar_formula");
                    contenedor_boton.removeAttr("disabled");
                    jQuery("div#part_two").show();
                    jQuery("div#mensajes").text("");
                    jQuery("div#mensajes").removeAttr("style");
                    jQuery("div#mensajes").text(tecnooptica_proceso.mensajes['tecnooptica-setup_mensaje_paso_3']);
                    jQuery("a#confirmar_filtro").show();
                    jQuery("a#confirmar_formula").hide();
                    jQuery("a#confirmar_plantilla_nomre").hide();
                    jQuery("a#completado").hide();
                    jQuery(".filtro_proceso_dos").get(0).scrollIntoView({behavior: "smooth"});
                    break;
            }

            jQuery("div#botones_oipcion_filtro").hide();
        }
    });

    body_t.on("keyup", "input.dp-formulate",function(){
        valor = jQuery(this);
        var styles = {
            'outline' : "#F44336",
            'outline-style': "solid"
        };
        if(valor.val() === "") {
            valor.css(styles);
        }
        else{
            valor.removeAttr("style");
        }
    });

    body_t.on("keyup", "input.altura-formulate",function(){
        valor = jQuery(this);
        var styles = {
            'outline' : "#F44336",
            'outline-style': "solid"
        };
        if(valor.val() === "") {
            valor.css(styles);
        }
        else{
            valor.removeAttr("style");
        }
    });

    body_t.on("click",".filtro_proc_com", function(){
        jQuery("input#tonalidad_definitiva").val("");
        div_impresion_list_lentes = jQuery("#imprimir_list_lentes");
        div_impresion_list_lentes.html("");
        jQuery("div#botones_oipcion_filtro").hide();
        jQuery("#botones_filtro").hide();
        jQuery(".descripcion_filtros p").hide();
        elemento = jQuery(this);
        id_taxono = elemento.attr("data-id");

        jQuery("#loader").removeAttr("style");

        jQuery("div#mensajes").text("");
        jQuery("div#mensajes").removeAttr("style");
        jQuery("div#mensajes").text(tecnooptica_proceso.mensajes['tecnooptica-setup_mensaje_paso_4']);
        jQuery("a#confirmar_filtro").show();
        jQuery("a#confirmar_formula").hide();
        jQuery("a#confirmar_plantilla_nomre").hide();
        jQuery("a#completado").hide();

        jQuery("#loader").css("display","none");
    });

    body_t.on("click","input.opcio_filtro", function () {
        jQuery("div#botones_oipcion_filtro").show();
        jQuery("div#mensajes").removeAttr("style");
        jQuery("div#mensajes").text("");
        jQuery("div#mensajes").text(tecnooptica_proceso.mensajes['tecnooptica-setup_mensaje_paso_6']);
    });

    body_t.on("click","#confirmar_filtro", function(){
        var datos_formula = new Object();
        opcion_filtro = "";
        filtro = "";
        jQuery(".filtro_proc_com").each(function(){
            if(jQuery(this).prop("checked") === true){
                filtro = jQuery(this).val();
            }
        });

        if(filtro === ""){
            alert("You must first select a feature.");
            return;
        }

        jQuery("div#imprimir_form select").each(function(){
            datos_formula[jQuery(this).attr("name")] = jQuery(this).val();
        });

        jQuery(".tip_vision input").each(function(){
            if(jQuery(this).prop("checked") === true){
                tipo_vision = jQuery(this).val();
            }
        });

        if(parseInt(jQuery(".opcio_filtro").length) !== 0){
            jQuery(".opcio_filtro").each(function(){
                if(jQuery(this).prop("checked") === true){
                    opcion_filtro = jQuery(this).attr("data-opcion");
                }
            });
        }

        div_impresion_list_lentes = jQuery("#imprimir_list_lentes");
        div_impresion_mensaje = jQuery("div#paso_three .accordion-body");
        jQuery("#loader").removeAttr("style");

        jQuery.ajax({
            url : tecnooptica_proceso.ajaxUrl,
            type: 'post',
            data: {
                action : "form_buscar_lentes",
                tipo_vision: tipo_vision,
                filtro: filtro,
                datos_formula: datos_formula,
                opcion_filtro: opcion_filtro,
            },
            async: true,
            success: function(resultado){
                div_impresion_list_lentes.html("");
                jQuery("#loader").css("display","none");
                div_impresion_list_lentes.append(resultado);
                if(resultado === "<h4>At the moment, there are no products.</h4>"){
                    jQuery("div#mensajes").text("");
                    jQuery("div#mensajes").removeAttr("style");
                    jQuery("div#mensajes").text(tecnooptica_proceso.mensajes['tecnooptica-setup_mensaje_paso_3']);
                    jQuery("a#confirmar_filtro").hide();
                    return 0;
                }
                jQuery("a#confirmar_filtro").hide();
                jQuery("a#confirmar_plantilla_nomre").show();
                jQuery("div#mensajes").text("");
                jQuery("div#mensajes").removeAttr("style");
                jQuery("div#mensajes").text(tecnooptica_proceso.mensajes['tecnooptica-setup_mensaje_paso_5']);
            }
        });
        jQuery("div#botones_lista_lentes").hide();
    });

    body_t.on("click","a.cancel_proceso", function(){
        let llave = jQuery(this).attr("data-key");

        jQuery("#loader").removeAttr("style");
        jQuery.ajax({
            url : tecnooptica_proceso.ajaxUrl,
            type: 'post',
            data: {
                action : "remover_product",
                key: llave,
            },
            async: true,
            success: function(resultado){
                window.location.href = tecnooptica_proceso.url_carrito
            }
        });

    });

    body_t.on("change","select#tonalidad_selector", function(){
        jQuery("input#tonalidad_definitiva").val("");
        if(jQuery(this).val() !== ""){
            jQuery("div#mensajes").removeAttr("style");
            jQuery("div#mensajes").text("");
            jQuery("div#mensajes").text(tecnooptica_proceso.mensajes['tecnooptica-setup_mensaje_paso_6']);
            jQuery("input#tonalidad_definitiva").val(jQuery(this).val());
            jQuery("input#tonalidad_definitiva").attr("value", jQuery(this).val());
        }
        else{
            jQuery("a#confirmar_filtro").hide();
            jQuery("a#confirmar_formula").hide();
            jQuery("a#confirmar_plantilla_nomre").show();
            jQuery("a#completado").hide();
            jQuery("div#mensajes").css({"color": "#a94442", "background-color": "#f2dede","border-color": "#e8c4c4"});
            jQuery("div#mensajes").text("");
            jQuery("div#mensajes").text(tecnooptica_proceso.mensajes['tecnooptica-setup_mensaje_error_tonalidad']);
        }

    });

    body_t.on("click","#confirmar_plantilla_nomre", function() {
        valor_plantilla = 0;
        jQuery("input.dueno_form").each(function(){
            if(parseInt(jQuery(this).val().length) !== 0){
                valor_plantilla = jQuery(this).val();
            }
        });

        if (parseInt(jQuery(".opciones_filtro_contenedor").length) !== 0){
            if (jQuery(".opcio_filtro")) {
                opcion_filtro = 0;
                jQuery(".opciones_filtro_contenedor").find(".opcio_filtro").each(function () {
                    if (jQuery(this).prop("checked") === true) {
                        opcion_filtro++;
                    }
                });

                if (parseInt(opcion_filtro) === 0) {
                    jQuery("div#mensajes").css({
                        "color": "#a94442",
                        "background-color": "#f2dede",
                        "border-color": "#e8c4c4"
                    });
                    jQuery("div#mensajes").text("");
                    jQuery("div#mensajes").text(tecnooptica_proceso.mensajes['tecnooptica-setup_mensaje_error_tintura']);
                    return;
                }
            }
        }

        id_lente = "";
        jQuery(".list_lentes").find(".seleccionar").each(function(){
            if(jQuery(this).prop("checked") === true){
                id_lente = jQuery(this).attr("data-id");
            }
        });

        if(id_lente === ""){
            alert(tecnooptica_proceso.mensajes_ajax['tecnooptica_ajax_13']);
            return
        }

        if(parseInt(jQuery("select#tonalidad_selector").length) !== 0){
            validar_selector_tonalidada = "";
            jQuery("select#tonalidad_selector").each(function(){
                if(jQuery(this).val() !== ""){
                    validar_selector_tonalidada = jQuery(this).val();
                }
            });

            if(validar_selector_tonalidada === ""){
                jQuery("div#mensajes").css({"color": "#a94442", "background-color": "#f2dede","border-color": "#e8c4c4"});
                jQuery("div#mensajes").text("");
                jQuery("div#mensajes").text(tecnooptica_proceso.mensajes['tecnooptica-setup_mensaje_error_tonalidad']);
                return;
            }
        }

        if(parseInt(valor_plantilla) === 0){
            r = confirm(tecnooptica_proceso.mensajes_ajax['tecnooptica_ajax_1']);
            if(r === true){
                vista_previa();
                contenedor_boton = jQuery("#confirmar_plantilla_nomre");
                contenedor_boton.removeAttr("disabled");
                jQuery("a#confirmar_plantilla_nomre").hide();
                jQuery("a#completado").show();

                jQuery("div#mensajes").text("");
                jQuery("div#mensajes").removeAttr("style");
                jQuery("div#mensajes").text(tecnooptica_proceso.mensajes['tecnooptica-setup_mensaje_proceso_listo']);
            }
        }
        else{
            jQuery("#loader").removeAttr("style");
            jQuery("a#confirmar_plantilla_nomre").hide();

            var datos_formula = new Object();

            jQuery("div#imprimir_form select").each(function(){
                datos_formula[jQuery(this).attr("name")] = jQuery(this).val();
            });

            dp = jQuery("input.dp-formulate").val();

            jQuery(".tip_vision input").each(function(){
                if(jQuery(this).prop("checked") === true){
                    tipo_vision = jQuery(this).val();
                }
            });

            jQuery(".filtro_proc_com").each(function(){
                if(jQuery(this).prop("checked") === true){
                    filtro = jQuery(this).val();
                }
            });

            if(parseInt(jQuery(".opcio_filtro").length) !== 0){
                jQuery(".opcio_filtro").each(function(){
                    if(jQuery(this).prop("checked") === true){
                        opcion_filtro = jQuery(this).attr("data-opcion");
                    }
                });
            }

            jQuery.ajax({
                url : tecnooptica_proceso.ajaxUrl,
                type: 'post',
                data: {
                    action : "guardar_plantilla",
                    tipo_vision: tipo_vision,
                    dp: dp,
                    datos_formula: datos_formula,
                    filtro: filtro,
                    opcion_filtro: opcion_filtro,
                    nombre_plantilla: valor_plantilla,
                },
                async: true,
                success: function(resultado){
                    jQuery("div#mensajes").text("");
                    jQuery("div#mensajes").removeAttr("style");
                    jQuery("div#mensajes").text(tecnooptica_proceso.mensajes['tecnooptica-setup_mensaje_proceso_listo']);
                    jQuery("#loader").css("display","none");
                    jQuery("a#completado").show();
                }
            });
        }

        jQuery("a#confirmar_filtro").hide();
        jQuery("a#confirmar_formula").hide();
    });

    body_t.on("click","a#completado", function(){
        jQuery("#procesar_lente").click();
    });

    body_t.on("click",".seleccionar", function(){
        jQuery(".opciones_filtro_contenedor").hide();
        jQuery(".tonalidad_selector_content").hide();
        jQuery(".camp_formula_nombre").hide();
        jQuery("input.opcio_filtro").prop('checked', false);
        jQuery('select#tonalidad_selector option[value=""]').prop('selected', true);
        jQuery("div#botones_lista_lentes").hide();
        jQuery("div#botones_lista_lentes").show();
        jQuery(this).parents("div.conten_text").children(".opciones_filtro_contenedor").show();
        jQuery(this).parents("div.conten_text").children(".tonalidad_selector_content").show();
        jQuery(this).parents("div.conten_text").children(".camp_formula_nombre").show();
        jQuery("div#mensajes").text("");
        jQuery("div#mensajes").removeAttr("style");
        jQuery("div#mensajes").text(tecnooptica_proceso.mensajes['tecnooptica-setup_mensaje_paso_6']);
        jQuery("a#confirmar_filtro").hide();
        jQuery("a#confirmar_formula").hide();
        jQuery("a#confirmar_plantilla_nomre").show();
        jQuery("a#completado").hide();
    });

    body_t.on("click",".accordion-button", function(){
        paso = jQuery(this).attr("aria-controls");
        paso_dos = jQuery("[aria-controls='paso_two']");
        paso_tres = jQuery("[aria-controls='paso_three']");
        paso_cuatro = jQuery("[aria-controls='paso_four']");
        paso_cinco = jQuery("[aria-controls='paso_five']");
        paso_seis = jQuery("[aria-controls='paso_six']");
        paso_siete = jQuery("[aria-controls='paso_seven']");

        switch (paso) {
            case 'paso_one':
                paso_dos.attr("disabled","disabled");
                paso_tres.attr("disabled","disabled");
                paso_cuatro.attr("disabled","disabled");
                paso_cinco.attr("disabled","disabled");
                paso_seis.attr("disabled","disabled");
                paso_siete.attr("disabled","disabled");

                jQuery('select#selec_form option[value=""]').prop('selected', true);

                jQuery("div#imprimir_form").html("");
                jQuery(".mostrar_descripcion_vision div").hide();
                jQuery(".tip_vision input").prop("checked", false);
                jQuery("div#botones_formulproce").hide();
                jQuery("div#imprimir_form").hide();
                jQuery(".filtro_proc_com").prop("checked", false);
                jQuery(".opciones_filtro").html("");
                jQuery(".descripcion_filtros p").hide();
                jQuery("div#botones_oipcion_filtro").hide("");

                jQuery("div#imprimir_list_lentes").html("");
                jQuery("div#botones_lista_lentes").hide();

                jQuery("textarea#comentario_form").val("");

                jQuery("input.dueno_form").val("");

                jQuery(".pre_view").html("");
                break;
            case 'paso_two':
                paso_tres.attr("disabled","disabled");
                paso_cuatro.attr("disabled","disabled");
                paso_cinco.attr("disabled","disabled");
                paso_seis.attr("disabled","disabled");
                paso_siete.attr("disabled","disabled");

                jQuery(".filtro_proc_com").prop("checked", false);
                jQuery(".opciones_filtro").html("");
                jQuery(".descripcion_filtros p").hide();
                jQuery("div#botones_oipcion_filtro").hide("");

                jQuery("div#imprimir_list_lentes").html("");
                jQuery("div#botones_lista_lentes").hide();

                jQuery("textarea#comentario_form").val("");

                jQuery("input.dueno_form").val("");

                jQuery(".pre_view").html("");
                break;
            case 'paso_three':
                paso_cuatro.attr("disabled","disabled");
                paso_cinco.attr("disabled","disabled");
                paso_seis.attr("disabled","disabled");
                paso_siete.attr("disabled","disabled");

                jQuery("div#imprimir_list_lentes").html("");
                jQuery("div#botones_lista_lentes").hide();

                jQuery("textarea#comentario_form").val("");

                jQuery("input.dueno_form").val("");

                jQuery(".pre_view").html("");
                break;
            case 'paso_four':
                paso_cinco.attr("disabled","disabled");
                paso_seis.attr("disabled","disabled");
                paso_siete.attr("disabled","disabled");

                jQuery("textarea#comentario_form").val("");

                jQuery("input.dueno_form").val("");

                jQuery(".pre_view").html("");
                break;
            case 'paso_five':
                paso_seis.attr("disabled","disabled");
                paso_siete.attr("disabled","disabled");

                jQuery("input.dueno_form").val("");

                jQuery(".pre_view").html("");
                break;
            case 'paso_six':
                paso_siete.attr("disabled","disabled");

                jQuery(".pre_view").html("");
                break;
        }
    });

    body_t.on("change", "select#selec_form", function(){
        contenedor = jQuery(this).val();
        if(parseInt(contenedor.length) !== 0){
            jQuery.ajax({
                url: tecnooptica_proceso.ajaxUrl,
                type: 'post',
                data: {
                    action: "buscar_plantilla",
                    nombre_plantilla: contenedor
                },
                async: true,
                success: function (resultado) {
                    let datos = JSON.parse(resultado);
                    contenedor_boton_prim = jQuery("h2#paso_two_boton button");
                    contenedor_boton_prim.removeAttr("disabled");
                    contenedor_boton_prim.click();

                    contenedor_boton_second = jQuery("#confirmar_formula");
                    contenedor_boton_second.removeAttr("disabled");
                    contenedor_boton_second.click();

                    jQuery("div#tipo_form_config_form").show();
                    jQuery(".tip_vision input.tipo_form").each(function(e,t){
                        if(jQuery(t).val() === datos.tipo_vision){
                            jQuery(t).prop("checked", true);
                            jQuery(t).click();
                        }
                    });

                    jQuery.each(datos.datos_formula, function(i, item) {
                        jQuery('select#'+i+' option[value="'+item+'"]').attr('selected',true);
                    });
                }
            });
        }
    });

    body_t.on("click", "#mostrar_guia", function(){
        jQuery(".modal-backdrop-opti").addClass("dark-on");
        jQuery(".modal-container").addClass("modal-activo");
        jQuery("#conenedor_medidas").addClass("contenedor_activo");
        jQuery("body").addClass("body_modal");
    });

    body_t.on("click", "button.close-modal", function(){
        jQuery(".modal-backdrop-opti").removeClass("dark-on");
        jQuery(".modal-container").removeClass("modal-activo");
        jQuery("#conenedor_medidas").removeClass("contenedor_activo");
        jQuery("body").removeClass("body_modal");
    });

    jQuery(window).click(function(event) {
        target = jQuery(event.target);
        if(jQuery(target).attr("class") === "contenedor_activo"){
            jQuery(".modal-backdrop-opti").removeClass("dark-on");
            jQuery(".modal-container").removeClass("modal-activo");
            jQuery("#conenedor_medidas").removeClass("contenedor_activo");
            jQuery("body").removeClass("body_modal");
        }
    });
});

function vista_previa(){

    jQuery(".tip_vision input").each(function(){
        if(jQuery(this).prop("checked") === true){
            tipo_vision_name = jQuery(this).parents(".contenedor").children("label").text();
        }
    });

    jQuery(".filtro_proc_com").each(function(){
        if(jQuery(this).prop("checked") === true){
            filtro_precio = jQuery(this).parents(".contenedor").children("#precio_filtro").attr("data-precio");
        }
    });

    jQuery(".list_lentes").find(".seleccionar").each(function(){
        if(jQuery(this).prop("checked") === true){
            url_form = jQuery(this).attr("data-url");
            id_lente = jQuery(this).attr("data-id");
            precio_lente = jQuery(this).attr("data-precio");
        }
    });

    jQuery("form").attr("action", url_form);

    precio_lente = parseFloat(precio_lente)+parseFloat(filtro_precio);

    jQuery("#procesar_lente").val(id_lente);
    jQuery("#id_product").val(id_lente);
    jQuery("#prices").val(precio_lente);
    jQuery("#id_product").attr("value", id_lente);
    jQuery("#prices").attr("value", precio_lente);
    jQuery("#tipo_vision").val(tipo_vision_name);
}

/*revisar este punto*/
function consultar_ajax(tipo_vision, div_impresion,funcion){
    conten_descripcion = jQuery(".mostrar_descripcion_vision");

    if(jQuery(window).width() < 768){
        div_impresion.append(tecnooptica_proceso.fomulas[tipo_vision].mobile);
    }
    else{
        div_impresion.append(tecnooptica_proceso.fomulas[tipo_vision].full);
    }

    plantilla = jQuery("select#selec_form");
    if(parseInt(plantilla.length) !== 0){
        if(parseInt(plantilla.val().length) !== 0) {
            jQuery.ajax({
                url: tecnooptica_proceso.ajaxUrl,
                type: 'post',
                data: {
                    action: "buscar_plantilla",
                    nombre_plantilla: plantilla.val()
                },
                async: true,
                success: function (resultado) {
                    let datos = JSON.parse(resultado);
                    jQuery.each(datos.datos_formula, function (i, item) {
                        jQuery('select#' + i + ' option[value="' + item + '"]').attr('selected', true);
                    });
                    jQuery("input.dp-formulate").val(datos.dp);
                }
            });
        }
    }
    jQuery("#loader").css("display","none");
    div_impresion.show();
    jQuery(".form_continuar").show();
    jQuery("div#part_two").hide();
    jQuery("div#mensajes").text("");
    jQuery("div#mensajes").removeAttr("style");
    jQuery("div#mensajes").text(tecnooptica_proceso.mensajes['tecnooptica-setup_mensaje_paso_2']);
    jQuery("a#confirmar_formula").show();
    jQuery("a#confirmar_filtro").hide();
    jQuery("a#confirmar_plantilla_nomre").hide();
    jQuery("div#confirmar_formula").show();
    conten_descripcion.show();
    conten_descripcion.children("."+tipo_vision).show();
}

function habilitar_proceso(){
    jQuery('a#sig_ps').removeClass('inactivo');
}

function mostrar_mensaje_error(){
    menesaje = tecnooptica_proceso.mensajes['tecnooptica-setup_error_paso_2'];
    if(typeof menesaje == "undefined"){
        menesaje = tecnooptica_proceso.mensajes_ajax['tecnooptica_ajax_13'];
    }
    r = confirm(menesaje);
    if(r === true){
        jQuery("div#imprimir_form select").removeAttr("style");
    }
    else{
        var styles = {
            'outline' : "#F44336",
            'outline-style': "solid"
        };
        control = 0;
        jQuery("div#imprimir_form select").each(function(){
            elemento = jQuery(this);
            if(parseFloat(elemento.val()) === 0){
                control++;
                elemento.css(styles);
            }
        });
    }
}

function validar_formulas(){
    var styles = {
        'outline' : "#F44336",
        'outline-style': "solid"
    };
    add_ojo_der = jQuery("select#add-ojo-der").val();
    add_ojo_izq = jQuery("select#add-ojo-izq").val();

    if(parseFloat(add_ojo_der.replace(",",".")) == 0 || parseFloat(add_ojo_izq.replace(",",".")) == 0){
        alert(tecnooptica_proceso.mensajes_ajax['tecnooptica_ajax_14']);
    }
    else {
        control = 0;
        jQuery("div#imprimir_form select").each(function () {
            elemento = jQuery(this);
            if (parseFloat(elemento.val()) === 0) {
                control++;
                elemento.css(styles);
            }
        });

        switch (control) {
            case  3:
            case  4:
            case  5:
            case  6:
            case  7:
            case  8:
                mostrar_mensaje_error();
                break;
        }
    }
}

function obtener_menor(elemento){
    control_menor = "0.00";
    jQuery(elemento).each(function(e,s){
        if(e == 0){
            control_menor = jQuery(s).val();
        }

        if(parseFloat(jQuery(s).val().replace(",", ".")) == 0){
            control_menor = "0";
            return false;
        }

        if(parseFloat(jQuery(s).val().replace(",", ".")) < 0) {
            if (parseFloat(control_menor.replace(",", ".")) < parseFloat(jQuery(s).val().replace(",", "."))) {
                control_menor = jQuery(this).val();
            }
        }
        else{
            if (parseFloat(control_menor.replace(",", ".")) > parseFloat(jQuery(s).val().replace(",", "."))) {
                control_menor = jQuery(this).val();
            }
        }

    });
    return control_menor;
}
