jQuery( window ).load(function() {

    let body_t = jQuery('body');
    setTimeout(habilitar_proceso,2000);

    body_t.on("click","a#confirmar_plantilla",function(){
        contenedor_boton = jQuery("h2#paso_two_boton button");
        if(parseInt(jQuery(".lista_formulas").length) !== 0){
            selector_plantilla = jQuery("select#selec_form");
            if(selector_plantilla.val()===""){
                r = confirm("Estimado cliente no ha seleccionado una de sus plantillas. ¿Seguro que desea continuar?");
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
        btnd = jQuery("div#botones_formulproce");
        tipo_vision = jQuery(this).val();
        div_impresion = jQuery("#imprimir_form");
        div_impresion.html("");
        div_impresion.hide();
        conten_descripcion = jQuery(".mostrar_descripcion_vision");
        conten_descripcion.hide();
        conten_descripcion.children().hide();
        btnd.hide();
        img_loader = '<img id="loader_optica" src="'+tecnooptica_proceso.ajaxLoaderImage+'" alt="Cargabdi">';

        div_contenedor = '<div id="contene_img"><div id="cont_s">Buscando datos para '+jQuery(this).siblings().text()+'... '+img_loader+'</div></div>';

        jQuery(this).parents(".accordion-body").append(div_contenedor);
        if(tipo_vision === "descanso") {
            jQuery("#contene_img").remove();
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
        if(parseFloat(control.val()) !== 0){
            control.removeAttr("style");
        }
        else{
            validar_formulas();
        }
    });

    body_t.on("click", "#confirmar_formula", function(){
        add_ojo_der = jQuery("select#add-ojo-der").val();
        add_ojo_izq = jQuery("select#add-ojo-izq").val();
        dp_campo = jQuery("input.dp-formulate").val();
        altura_campo = jQuery("input.altura-formulate").val();

        if(parseFloat(add_ojo_der) == 0 || parseFloat(add_ojo_izq) == 0){
            alert("El valor del campo ADD esta en 0, debe agregar su ADD para poder avanzar");
        }
        else if(dp_campo === "" || parseFloat(dp_campo) === 0){
            alert("El valor del campo DP esta vacio o es igual a 0 (cero), este campo es obligatorio");
        }
        else if(altura_campo === "" || parseFloat(altura_campo) === 0){
            alert("El valor del campo Altura esta vacio o es igual a 0 (cero), este campo es obligatorio");
        }
        else{
            control = 0;
            jQuery("div#imprimir_form select").each(function(){
                elemento = jQuery(this);
                if(parseFloat(elemento.val()) === 0){
                    control++;
                }
            });

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
                    r = confirm(menesaje);
                    if(r === true){
                        jQuery("div#imprimir_form select").removeAttr("style");
                        contenedor_boton = jQuery("h2#paso_three_boton button");
                        contenedor_boton.removeAttr("disabled");
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
                    break;
                default:
                    jQuery("div#imprimir_form select").removeAttr("style");
                    contenedor_boton = jQuery("h2#paso_three_boton button");
                    contenedor_boton.removeAttr("disabled");
                    contenedor_boton.click();
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
        jQuery("div#botones_oipcion_filtro").hide();
        jQuery("#botones_filtro").hide();
        jQuery(".descripcion_filtros p").hide();
        elemento = jQuery(this);
        id_taxono = elemento.attr("data-id");

        img_loader = '<img id="loader_optica" src="'+tecnooptica_proceso.ajaxLoaderImage+'" alt="Cargabdi">';
        div_contenedor = '<div id="contene_img"><div id="cont_s">Buscando datos para '+elemento.siblings(".filtro_proc_com").text()+'... '+img_loader+'</div></div>';
        jQuery(this).parents(".accordion-body").append(div_contenedor);
        jQuery("div.opciones_filtro_contenedor").hide();
        jQuery("input.opcio_filtro").prop('checked', false);
        jQuery("#opcion_filtro_"+id_taxono).show();
        jQuery("#contene_img").remove();
    });

    body_t.on("click","input.opcio_filtro", function () {
        jQuery("div#botones_oipcion_filtro").show();
    });

    body_t.on("click","#confirmar_filtro", function(){
        var datos_formula = new Object();
        opcion_filtro = "";

        jQuery("div#imprimir_form select").each(function(){
            datos_formula[jQuery(this).attr("name")] = jQuery(this).val();
        });

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

        div_impresion_list_lentes = jQuery("#imprimir_list_lentes");
        div_impresion_mensaje = jQuery("div#paso_three .accordion-body");
        img_loader = '<img id="loader_optica" src="'+tecnooptica_proceso.ajaxLoaderImage+'" alt="Cargabdi">';
        div_contenedor = '<div id="contene_img" style="padding: 20px 0px;"><div id="cont_s">Buscando lista de lentes ... '+img_loader+'</div></div>';
        div_impresion_mensaje.append(div_contenedor);

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
                jQuery("#contene_img").remove();
                div_impresion_list_lentes.append(resultado);
                contenedor_boton = jQuery("h2#paso_four_boton button");
                contenedor_boton.removeAttr("disabled");
                contenedor_boton.click();
            }
        });
        jQuery("div#botones_lista_lentes").hide();
    });

    body_t.on("click","#confirmar_lente", function(){
        opcion_filtro = 0;
        cantidad = jQuery(".list_lentes").find(".seleccionar").length;
        jQuery(".list_lentes").find(".seleccionar").each(function(){
            if(jQuery(this).prop("checked") !== true){
                opcion_filtro++;
            }
        });

        resultado = parseInt(cantidad)- parseInt(opcion_filtro);

        if(parseInt(resultado) === 1){
            contenedor_boton = jQuery("h2#paso_five_boton button");
            contenedor_boton.removeAttr("disabled");
            contenedor_boton.click();
        }
        else{
            alert("Debe seleccionar algun lente para continuar en el proceso de compra");
        }
    });

    body_t.on("click","a.cancel_proceso", function(){
        let llave = jQuery(this).attr("data-key");

        img_loader = '<img id="loader_optica" src="'+tecnooptica_proceso.ajaxLoaderImage+'" alt="Cargabdi">';
        jQuery(this).append(img_loader);
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

    body_t.on("click","#confirmar_comentario", function(){
        contenedor_boton = jQuery("h2#paso_six_boton button");
        contenedor_boton.removeAttr("disabled");
        contenedor_boton.click();
    });

    body_t.on("click","#confirmar_plantilla_nomre", function(){
        valor_plantilla = jQuery("input#dueno_form").val();

        if(parseInt(valor_plantilla.length) === 0){
            r = confirm("Estimado cliente no ha agregado un nombre a su plantilla, si no agrega un nombre no podra guardarse para futuras compras. " +
                "¿Seguro que desea continuar sin nombrar la plantilla?");
            if(r === true){
                vista_previa();
                contenedor_boton = jQuery("h2#paso_seven_boton button");
                contenedor_boton.removeAttr("disabled");
                contenedor_boton.click();
            }
        }
        else{
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
                    vista_previa();
                    contenedor_boton = jQuery("h2#paso_seven_boton button");
                    contenedor_boton.removeAttr("disabled");
                    contenedor_boton.click();
                }
            });
        }
    });

    body_t.on("click","a#completado", function(){
        jQuery("#procesar_lente").click();
    });

    body_t.on("click",".seleccionar", function(){
        jQuery("div#botones_lista_lentes").hide();
        jQuery("div#botones_lista_lentes").show();
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
                jQuery("div.opciones_filtro_contenedor").hide();
                jQuery("input.opcio_filtro").prop('checked', false);
                jQuery(".descripcion_filtros p").hide();
                jQuery("div#botones_oipcion_filtro").hide("");

                jQuery("div#imprimir_list_lentes").html("");
                jQuery("div#botones_lista_lentes").hide();

                jQuery("textarea#comentario_form").val("");

                jQuery("input#dueno_form").val("");

                jQuery(".pre_view").html("");
                break;
            case 'paso_two':
                paso_tres.attr("disabled","disabled");
                paso_cuatro.attr("disabled","disabled");
                paso_cinco.attr("disabled","disabled");
                paso_seis.attr("disabled","disabled");
                paso_siete.attr("disabled","disabled");

                jQuery(".filtro_proc_com").prop("checked", false);
                jQuery("div.opciones_filtro_contenedor").hide();
                jQuery("input.opcio_filtro").prop('checked', false);
                jQuery(".descripcion_filtros p").hide();
                jQuery("div#botones_oipcion_filtro").hide("");

                jQuery("div#imprimir_list_lentes").html("");
                jQuery("div#botones_lista_lentes").hide();

                jQuery("textarea#comentario_form").val("");

                jQuery("input#dueno_form").val("");

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

                jQuery("input#dueno_form").val("");

                jQuery(".pre_view").html("");
                break;
            case 'paso_four':
                paso_cinco.attr("disabled","disabled");
                paso_seis.attr("disabled","disabled");
                paso_siete.attr("disabled","disabled");

                jQuery("textarea#comentario_form").val("");

                jQuery("input#dueno_form").val("");

                jQuery(".pre_view").html("");
                break;
            case 'paso_five':
                paso_seis.attr("disabled","disabled");
                paso_siete.attr("disabled","disabled");

                jQuery("input#dueno_form").val("");

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

                    contenedor_boton_second = jQuery("h2#paso_three_boton button");
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
    var datos_formula = new Object();
    opcion_filtro = "";

    contenedor = jQuery(".pre_view");
    precio_montura = jQuery("h2#nombre_montura");
    montura_precio =precio_montura.attr("data-precio");
    contenedor.html("");

    var locale = 'co';
    var options = {style: 'currency', currency: 'cop', minimumFractionDigits: 2, maximumFractionDigits: 2};
    var formatter = new Intl.NumberFormat(locale, options);

    precio_montura_contenedor = '' +
        '<div class="montura">\n' +
        '<span>Precio Montura: </span>\n' +
        '<div class="contenedor_montura">'+formatter.format(montura_precio)+'</div>\n' +
        '</div>';

    jQuery("div#imprimir_form select").each(function(){
        datos_formula[jQuery(this).attr("name")] = jQuery(this).val();
    });

    jQuery(".tip_vision input").each(function(){
        if(jQuery(this).prop("checked") === true){
            tipo_vision = jQuery(this).val();
            tipo_vision_name = jQuery(this).parents(".contenedor").children("label").text();
        }
    });

    add = "";
    add_der = "";
    add_izq = "";
    comentarios = "";
    dp = "";

    if(tipo_vision === "bifocales" || tipo_vision === "progresivos"){
        add = "<th>ADD</th>\n";
        add_der = "<td>"+datos_formula['add-ojo-der']+"</td>\n";
        add_izq = "<td>"+datos_formula['add-ojo-der']+"</td>\n";
    }

    dp = jQuery("input.dp-formulate").val();

    tipo_vision_conten = '' +
        '<div class="tipo">\n' +
        '<span>Tipo: </span>\n' +
        '<div class="contenedor_tipo">'+tipo_vision_name+'</div>\n' +
        '</div>';

    if(parseInt(dp.length) !== 0){
        dp = "<div class='dp'>" +
            "<span>DP :</span>" +
            "<div class='dp_contenedor'>"
            +dp+
            "</div>" +
            "</div>";
    }

    if(jQuery("input.altura-formulate")) {
        altura = jQuery("input.altura-formulate").val();

        if (typeof altura !== "undefined") {
            if (parseInt(altura.length) !== 0) {
                altura = "<div class='altura'>" +
                    "<span>Altura :</span>" +
                    "<div class='altura_contenedor'>"
                    + altura +
                    "</div>" +
                    "</div>";
            }
        }
    }


    tabla = "<div class='formula'>" +
        "<span>Fórmula: </span>" +
        "<div class='contenedor_formula'>" +
        "<table>\n" +
        "    <tr>\n" +
        "        <th></th>\n" +
        "        <th>Esfera</th>\n" +
        "        <th>Cilindro</th>\n" +
        "        <th>Eje</th>\n" +
        add +
        "    </tr>\n" +
        "    <tr>\n" +
        "        <td>Ojo Derecho</td>\n" +
        "        <td>"+datos_formula['esfera-ojo-der']+"</td>\n" +
        "        <td>"+datos_formula['cilindro-ojo-der']+"</td>\n" +
        "        <td>"+datos_formula['eje-ojo-der']+"</td>\n" +
        add_der +
        "    </tr>\n" +
        "    <tr>\n" +
        "        <td>Ojo Izquierdo</td>\n" +
        "        <td>"+datos_formula['esfera-ojo-izq']+"</td>\n" +
        "        <td>"+datos_formula['cilindro-ojo-izq']+"</td>\n" +
        "        <td>"+datos_formula['eje-ojo-izq']+"</td>\n" +
        add_izq +
        "    </tr>\n" +
        "</table>"+
        "</div>" +
        "</div>";

    jQuery(".filtro_proc_com").each(function(){
        if(jQuery(this).prop("checked") === true){
            filtro = jQuery(this).parents(".contenedor").children().text();
            filtro_precio = jQuery(this).parents(".contenedor").children("#precio_filtro").attr("data-precio");
        }
    });

    if(parseInt(filtro_precio) !== 0) {

        precio_filtro_contenedor = '' +
            '<div class="filtro_precio">\n' +
            '<span>Precio Filtro: </span>\n' +
            '<div class="contenedor_filtro_precio">' + formatter.format(filtro_precio) + '</div>\n' +
            '</div>';
    }
    else{
        precio_filtro_contenedor = "";
    }

    if(parseInt(jQuery(".opcio_filtro").length) !== 0){
        jQuery(".opcio_filtro").each(function(){
            if(jQuery(this).prop("checked") === true){
                opcion_filtro = jQuery(this).val();
            }
        });

        opcion_filtro = '' +
            '<div class="opcion_filtro">\n' +
            '<span>Opciones del Filtro: </span>\n' +
            '<div class="contenedor_opcion_filtro">'+opcion_filtro+'</div>\n' +
            '</div>';
    }

    jQuery(".list_lentes").find(".seleccionar").each(function(){
        if(jQuery(this).prop("checked") === true){
            modelo = jQuery(this).attr("data-modelo");
            marca = jQuery(this).attr("data-marca");
            url_form = jQuery(this).attr("data-url");
            id_lente = jQuery(this).attr("data-id");
            precio_lente = jQuery(this).attr("data-precio");
        }
    });

    precio_lente_contenedor = '' +
        '<div class="lente_precio">\n' +
        '<span>Precio Lentes: </span>\n' +
        '<div class="contenedor_lente_precio">'+formatter.format(precio_lente)+'</div>\n' +
        '</div>';

    total_sin_iva = parseFloat(montura_precio) + parseFloat(filtro_precio) + parseFloat(precio_lente);

    if(tecnooptica_proceso.iva !== "no_aplica"){

        precio_tota_s_i_contenedor = '' +
            '<div class="total_s_i">\n' +
            '<span>Precio total sin IVA: </span>\n' +
            '<div class="contenedor_total_s_i">'+formatter.format(total_sin_iva)+'</div>\n' +
            '</div>';

        iva = (parseFloat(montura_precio)* parseFloat(tecnooptica_proceso.iva) / parseInt(100)) + (parseFloat(filtro_precio)* parseFloat(tecnooptica_proceso.iva) / parseInt(100)) + (parseFloat(precio_lente)* parseFloat(tecnooptica_proceso.iva) / parseInt(100));

        iva_contenedor = '' +
            '<div class="iva">\n' +
            '<span>IVA: </span>\n' +
            '<div class="contenedor_iva">'+formatter.format(iva)+'</div>\n' +
            '</div>';

        precio_tota_c_i_contenedor = '' +
            '<div class="total_c_i">\n' +
            '<span>Precio total con IVA: </span>\n' +
            '<div class="contenedor_total_c_i">'+formatter.format(parseFloat(total_sin_iva) + parseFloat(iva))+'</div>\n' +
            '</div>';
    }
    else{
        precio_tota_s_i_contenedor = '' +
            '<div class="total_s_i">\n' +
            '<span>Precio total: </span>\n' +
            '<div class="contenedor_total_s_i">'+formatter.format(total_sin_iva)+'</div>\n' +
            '</div>';

        iva_contenedor = "";
        precio_tota_c_i_contenedor = "";
    }



    comentarios = jQuery("#comentario_form").val();

    if(parseInt(comentarios.length) !== 0){
        comentarios = '' +
            '<div class="comentarios">\n' +
            '<span>Comentarios: </span>\n' +
            '<div class="contenedor_comentarios">'+comentarios+'</div>\n' +
            '</div>';
    }

    plantilla = jQuery("input#dueno_form").val();

    if(parseInt(plantilla.length) !== 0){
        plantilla = '' +
            '<div class="plantilla">\n' +
            '<span>Plantilla: </span>\n' +
            '<div class="contenedor_plantilla">'+plantilla+'</div>\n' +
            '</div>';
    }

    jQuery("#lente_caracteristica").val(filtro);

    filtro = '' +
        '<div class="filtro">\n' +
        '<span>Filtro: </span>\n' +
        '<div class="contenedor_filtro">'+filtro+'</div>\n' +
        '</div>';

    modelo = '' +
        '<div class="modelo">\n' +
        '<span>Modelo: </span>\n' +
        '<div class="contenedor_modelo">'+modelo+'</div>\n' +
        '</div>';

    marca = '' +
        '<div class="marca">\n' +
        '<span>Marca: </span>\n' +
        '<div class="contenedor_marca">'+marca+'</div>\n' +
        '</div>';


    contenedores = '' +
        '<div id="descripcion_contenedor">' +
        '<div class="caracteristicas">' +
        filtro +
        opcion_filtro +
        modelo +
        marca +
        comentarios +
        plantilla +
        '</div>' +
        '<div class="precios">' +
        precio_montura_contenedor +
        precio_filtro_contenedor +
        precio_lente_contenedor +
        precio_tota_s_i_contenedor +
        iva_contenedor +
        precio_tota_c_i_contenedor +
        '</div>' +
        '</div>';



    contenedor.append(tipo_vision_conten);
    contenedor.append(tabla);
    contenedor.append(dp);
    contenedor.append(altura);
    contenedor.append(contenedores);

    jQuery("form").attr("action", url_form);

    precio_lente = parseFloat(precio_lente)+parseFloat(filtro_precio);

    jQuery("#procesar_lente").val(id_lente);
    jQuery("#id_product").val(id_lente);
    jQuery("#prices").val(precio_lente);
    jQuery("#id_product").attr("value", id_lente);
    jQuery("#prices").attr("value", precio_lente);
    jQuery("#tipo_vision").val(tipo_vision_name);

}

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
    jQuery("#contene_img").remove();
    div_impresion.show();
    jQuery(".form_continuar").show();
    conten_descripcion.show();
    conten_descripcion.children("."+tipo_vision).show();
}

function habilitar_proceso(){
    jQuery('a#sig_ps').removeClass('inactivo');
}

function mostrar_mensaje_error(){
    menesaje = tecnooptica_proceso.mensajes['tecnooptica-setup_error_paso_2'];
    if(typeof menesaje == "undefined"){
        menesaje = "Observamos datos incoherentes en la formula, ¿Seguro que ingresaste los datos correctos? Si crees que todo está bien presiona el botón Aceptar, de lo contrario por favor corrige la fórmula.";
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

    if(parseFloat(add_ojo_der) == 0 || parseFloat(add_ojo_izq) == 0){
        alert("El valor del campo ADD esta en 0, debe agregar su ADD para poder avanzar");
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

