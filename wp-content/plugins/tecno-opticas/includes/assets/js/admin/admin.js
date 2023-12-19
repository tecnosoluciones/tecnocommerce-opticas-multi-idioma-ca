jQuery( window ).load(function() {
    let body_t = jQuery('body');

    let tipo_lente = jQuery("#_tipo_lente");

    let styles = {
        'outline' : "#F44336",
        'outline-style': "solid"
    };

    mostrar_descanso(tipo_lente.val());

    jQuery('.formulate_tab').hide();
    jQuery('.monturas_prices_tab').hide();
    jQuery('.lentes_contacto_prices_tab').hide();
    jQuery(".monturas_atributos_options").hide();
    jQuery(".formulate_options").hide();
    jQuery(".atributos_lentes_options").hide();
    jQuery(".filtros_lentes_options").hide();

    if(tecnooptica.validar_exlucir_form === "yes"){
        body_t.on("keyup", ".price_form", function(){
            elemento = jQuery(this);
            jQuery(".eco_price").val(elemento.val());
        })
    }

    body_t.on('woocommerce-product-type-change',function(){
        jQuery.showHideSubscriptionMeta();
    });

    if(jQuery('.options_group.pricing').length > 0) {
        jQuery.showHideSubscriptionsPanels();
    }

    // Move the subscription pricing section to the same location as the normal pricing section
    let a = jQuery('.options_group.optioptions_pricing');
    a.not('.variable_optioptions_pricing .options_group.optioptions_pricing').insertBefore(jQuery('.options_group.pricing:first'));
    jQuery('.show_if_optioptions.clear').insertAfter(a);

    jQuery('#general_product_data').on('change', '[name^="_tecnooptica_price"]', function() {
        jQuery('[name="_regular_price"]').val(jQuery(this).val());
    });

    jQuery("li.formulate_options").on("click", "a",function(){
        jQuery("div#formulate_panel").show();
    });

    jQuery("li.lentes_contacto_prices_options").on("click", "a",function(){
        jQuery("#lentes_contacto_panel").show();
    });

    jQuery("li.linked_product_options").on("click", "a",function(){
        switch(jQuery("select#product-type").val()){
            case"monturas":
            case"lentes":
            case"lentes-contacto":
                jQuery("#linked_product_data").children().each(function(){
                    if(!jQuery(this).hasClass("show_if_grouped")){
                        jQuery(this).children().show()
                    }
                });
            break;
        }

    });

    jQuery("li.monturas_atributos_options").on("click", "a",function(){
        jQuery("div#monturas_atributo_panel").show();
    });

    jQuery("li.atributos_lentes_options").on("click", "a",function(){
        jQuery("div#atributos_lentes_panel").show();
    });

    jQuery("li.filtros_lentes_options").on("click", "a",function(){
        jQuery("div#filtros_lentes_panel").show();
    });

    jQuery("li.monturas_prices_options").on("click", "a",function(){
        jQuery("div#monturas_prices_panel").show();
    });

    jQuery("#guardar-vision-sencilla").on("click", function(){
        let datos = validar_campos_rangos_formulas(this);
        if(parseInt(datos) !== 0){
            jQuery.ajax({
                url : tecnooptica.ajaxUrl,
                type: 'post',
                data: {
                    action : 'insert_rang_form_vision_sencilla',
                    datos: datos,
                },
                async: true,
                success: function(resultado){
                    if(parseInt(resultado) !== 0) {
                        mensaje_exitoso = '<div class="alert alert-success" role="alert">\n' +
                            '                        Rangos de la fórmula <strong>Visión sencilla</strong> guardados satisfactoriamente.\n' +
                            '                    </div>';
                        mostrar_mensaje(mensaje_exitoso);
                        setTimeout(function(){ location.reload() }, 3000);
                    }
                }
            });
        }
    });

    jQuery("#guardar-bifocales").on("click", function(){
        let datos = validar_campos_rangos_formulas_con_add(this);
        if(parseInt(datos) !== 0){
            jQuery.ajax({
                url : tecnooptica.ajaxUrl,
                type: 'post',
                data: {
                    action : 'insert_rang_form_bifocales',
                    datos: datos,
                },
                async: true,
                success: function(resultado){
                    if(parseInt(resultado) !== 0) {
                        mensaje_exitoso = '<div class="alert alert-success" role="alert">\n' +
                            '                        Rangos de la fórmula para lentes <strong>Bifocales</strong> guardados satisfactoriamente.\n' +
                            '                    </div>';
                        mostrar_mensaje(mensaje_exitoso);
                        setTimeout(function(){ location.reload() }, 3000);
                    }
                }
            });
        }
    });

    jQuery("#guardar-progresivos").on("click", function(){
        let datos = validar_campos_rangos_formulas_con_add(this);
        if(parseInt(datos) !== 0){
            jQuery.ajax({
                url : tecnooptica.ajaxUrl,
                type: 'post',
                data: {
                    action : 'insert_rang_form_progresivos',
                    datos: datos,
                },
                async: true,
                success: function(resultado){
                    if(parseInt(resultado) !== 0) {
                        mensaje_exitoso = '<div class="alert alert-success" role="alert">\n' +
                            '                        Rangos de la fórmula para lentes <strong>Progresivos</strong> guardados satisfactoriamente.\n' +
                            '                    </div>';
                        mostrar_mensaje(mensaje_exitoso);
                        setTimeout(function(){ location.reload() }, 3000);
                    }
                }
            });
        }
    });

    jQuery("#guardar-ocupacionales").on("click", function(){
        let datos = validar_campos_rangos_formulas_con_add(this);
        if(parseInt(datos) !== 0){
            jQuery.ajax({
                url : tecnooptica.ajaxUrl,
                type: 'post',
                data: {
                    action : 'insert_rang_form_ocupacionales',
                    datos: datos,
                },
                async: true,
                success: function(resultado){
                    if(parseInt(resultado) !== 0) {
                        mensaje_exitoso = '<div class="alert alert-success" role="alert">\n' +
                            '                        Rangos de la fórmula para lentes <strong>Ocupacionales</strong> guardados satisfactoriamente.\n' +
                            '                    </div>';
                        mostrar_mensaje(mensaje_exitoso);
                        setTimeout(function(){ location.reload() }, 3000);
                    }
                }
            });
        }
    });

    jQuery("[name^='rango-negativo']").on("keyup", function(){
        if(jQuery(this).val() !== "") {
            valor_alto_siguiente = jQuery(this).parent().siblings().children("input[name^='rango-positivo']").val()
            if(valor_alto_siguiente !== "" || jQuery(this).val() !== "") {
                if (parseFloat(valor_alto_siguiente) < parseFloat(jQuery(this).val())) {
                    if (is_negative_number(jQuery(this).val()) === false) {
                        jQuery(this).val("");
                        jQuery("#mensaje").html("");
                        mensaje_error = '<div class="alert alert-danger" role="alert">\n' +
                            '                        Disculpe pero el rango que intenta agregar es mayor al rango más alto, por favor coloque un número más bajo. Tambien son permitidos números negativos\n' +
                            '                    </div>';
                        mostrar_mensaje(mensaje_error);
                        jQuery(this).attr("class", "error_alert")
                    }
                }
                else {
                    if (jQuery(this).val() !== "-") {
                        if (is_negative_number(jQuery(this).val()) === false && is_positiv_number(jQuery(this).val()) === false) {
                            jQuery(this).val("")
                            jQuery("#mensaje").html("");
                            mensaje_error  = '<div class="alert alert-danger" role="alert">\n' +
                                '                        Solamente son permitidos valores <strong>numéricos incluyendo números negativos!</strong>\n' +
                                '                    </div>';
                            mostrar_mensaje(mensaje_error);
                            jQuery(this).attr("class","error_alert")
                        }
                        else{
                            jQuery(this).removeClass("error_alert");
                        }
                    }
                    else{
                        jQuery(this).removeClass("error_alert");
                    }
                }
            }
        }
    });

    jQuery("[name^='rango-positivo']").on("keyup", function(){
        if(jQuery(this).val() !== "") {
            valor_bajo_siguiente = jQuery(this).parent().siblings().children("input[name^='rango-negativo']").val();
            if(valor_bajo_siguiente !== "" || jQuery(this).val() !== "" ) {
                if (parseFloat(jQuery(this).val()) < parseFloat(valor_bajo_siguiente)) {
                    jQuery(this).val("");
                    jQuery("#mensaje").html("");
                    mensaje_error = '<div class="alert alert-danger" role="alert">\n' +
                        '                        Disculpe pero el rango que intenta agregar es menor al rango más bajo, por favor coloque un número más alto.\n' +
                        '                    </div>';
                    mostrar_mensaje(mensaje_error);
                    jQuery(this).attr("class", "error_alert");
                }
                else {
                    if (jQuery(this).val() !== "-") {
                        if (is_negative_number(jQuery(this).val()) === false && is_positiv_number(jQuery(this).val()) === false) {
                            jQuery(this).val("");
                            jQuery("#mensaje").html("");
                            mensaje_error  = '<div class="alert alert-danger" role="alert">\n' +
                                '                        Solamente son permitidos valores <strong>numéricos incluyendo números negativos!</strong>\n' +
                                '                    </div>';
                            mostrar_mensaje(mensaje_error);
                            jQuery(this).attr("class","error_alert");
                        }
                        else{
                            jQuery(this).removeClass("error_alert");
                        }
                    }
                    else {
                        jQuery(this).removeClass("error_alert");
                    }
                }
            }
        }
    });

    jQuery("[name^='step-']").on("keyup", function(){
        if(jQuery(this).val() !== "") {
            if (is_positiv_number(jQuery(this).val()) === false) {
                jQuery(this).val("");
                jQuery("#mensaje").html("");
                mensaje_error = '<div class="alert alert-danger" role="alert">\n' +
                    '                        Solamente son permitidos valores <strong>numéricos positivos!</strong>\n' +
                    '                    </div>';
                mostrar_mensaje(mensaje_error);
                jQuery(this).attr("class", "error_alert")
            }
            else{
                if(parseInt(jQuery(this).val().length) >= 5) {
                    mensaje_error = '<div class="alert alert-danger" role="alert">\n' +
                        '                        Solamente son permitidos <strong>4</strong> dígitos!\n' +
                        '                    </div>';
                    mostrar_mensaje(mensaje_error);
                    jQuery(this).attr("class", "error_alert");
                    jQuery(this).val("")
                }else{
                    jQuery(this).removeClass("error_alert");
                }
            }
        }
    });

    jQuery("[name='rango-positivo-bajo-eje']").on("focusout" , function(){
        if(jQuery(this).val() !== "") {
            let valor_rango_bajo = jQuery(this).val();
            let valor_rango_alto = jQuery("[name='rango-positivo-alto-eje']").val();

            if (parseFloat(valor_rango_bajo) > parseFloat(valor_rango_alto)) {
                mensaje_error = '<div class="alert alert-danger" role="alert">\n' +
                    '                        Discúlpelo pero el valor del campo <strong>rango positivo más alto del eje es menor</strong> al valor del campo rango positivo más bajo.\n' +
                    '                    </div>';
                mostrar_mensaje(mensaje_error);
                jQuery(this).val("");
                jQuery("[name='rango-positivo-alto-eje']").val("");
            }
            else{
                jQuery(this).removeClass("error_alert");
            }
        }
    });

    jQuery("[name='rango-positivo-alto-eje']").on("focusout" , function(){
        if(jQuery(this).val() !== "") {
            let valor_rango_bajo = jQuery("[name='rango-positivo-bajo-eje']").val();
            let valor_rango_alto = jQuery(this).val();

            if (parseFloat(valor_rango_bajo) > parseFloat(valor_rango_alto)) {
                mensaje_error = '<div class="alert alert-danger" role="alert">\n' +
                    '                        Discúlpelo pero el valor del campo <strong>rango positivo más alto del eje es menor</strong> al valor del campo rango positivo más bajo.\n' +
                    '                    </div>';
                mostrar_mensaje(mensaje_error);
                jQuery(this).val("");
                jQuery("[name='rango-positivo-alto-eje']").val("");
            }
            else{
                jQuery(this).removeClass("error_alert");
            }
        }
    });

    jQuery("nav#cam_vision").on("click","a", function(){
        jQuery("nav#cam_vision a").removeClass("nav-tab-active");
        jQuery(".content-form div").hide();
        jQuery(".content-form div#"+jQuery(this).attr("id")+"").show();
        jQuery(".content-form div#descripcion_"+jQuery(this).attr("id")+"").show();
        jQuery(this).addClass("nav-tab-active");
    });

    tipo_lente.on("change", function(){
        selec_tipo_lente = jQuery(this);
        mostrar_descanso(selec_tipo_lente.val());
    });

    body_t.on("focus","._camp_rang_one", function(){
        jQuery(this).attr("data-value", jQuery(this).val());
    });

    body_t.on("change", "._camp_rang_one",function(){
        jQuery(this).removeAttr("style");
        buscar_campos = jQuery(this).val();
        campo_primario = jQuery(this).val();
        jQuery(this).attr("name", jQuery(this).attr("name")+"["+campo_primario+"]");
        jQuery(this).parents("tr").attr("data-primario", campo_primario);
        respuesta = validar_primer_rang(this, buscar_campos);
        if(respuesta !== false) {
            tipo_lente = jQuery("#_tipo_lente").val();
            if (tipo_lente !== "descanso") {
                imprimir_campos(buscar_campos, tipo_lente,this,"",campo_primario);
                jQuery(this).parent().parent().siblings(".cam_price_one").show();
                jQuery(this).parent().parent().siblings(".cam_price_one").find("input").attr("name", "_rang_one[" + campo_primario + "][_price]");
            }
        }
        else{
            jQuery(this).val(jQuery(this).attr("data-value"));
            jQuery(this).parent().parent().siblings(".cam_price_one").hide();
            return 0
        }

        if(buscar_campos === ""){
            jQuery(this).parent().parent().siblings(".cam_price_one").hide();
        }
    });

    body_t.on("focus","._camp_rang_two", function(){
        jQuery(this).attr("data-value", jQuery(this).val());
    });

    body_t.on("change", "._camp_rang_two", function(){
        jQuery(this).removeAttr("style");
        buscar_campos = jQuery(this).val();
        tipo_lente = jQuery("#_tipo_lente").val();
        campo_primario = jQuery(this).attr("campo-primario");
        campo_secundario = jQuery(this).val();
        respuesta = validar_secund_rang(this, buscar_campos);
        if(respuesta !== false) {
            namecaso = "_rang_one[" + campo_primario + "][sub-rango][" + buscar_campos + "]";
            jQuery(this).attr("name", namecaso);
            if (tipo_lente !== "descanso") {
                imprimir_campos(buscar_campos, tipo_lente,this,"sub-campo",campo_primario,campo_secundario);
                jQuery(this).parent().parent().siblings(".cam_price_secc").show();
                jQuery(this).parent().parent().siblings(".cam_price_secc").find("input").attr("name", "_rang_one[" + campo_primario + "][sub-rango][" + buscar_campos + "][_price]");
                jQuery(this).parents("div.secc_two").find("a.new_row_camp_terc").attr("class","agregar_campo_terc");
            }
        }
        else{
            jQuery(this).val(jQuery(this).attr("data-value"));
            jQuery(this).parents(".content_secc_two").children("div.cam_price_secc").hide();
            return 0
        }
        if (buscar_campos === "") {
            jQuery(this).parent().parent().siblings(".cam_price_secc").hide();
        }
    });

    body_t.on("focus","._camp_rang_tree", function(){
        jQuery(this).attr("data-value", jQuery(this).val());
    });

    body_t.on("change", "._camp_rang_tree", function(){
        jQuery(this).removeAttr("style");
        buscar_campos = jQuery(this).val();
        tipo_lente = jQuery("#_tipo_lente").val();
        campo_primario = jQuery(this).attr("campo-primario");
        campo_secundario = jQuery(this).attr("campo-secundario");
        campo_terciario = jQuery(this).val();
        respuesta = validar_tercer_rang(this, buscar_campos);
        if(respuesta !== false) {
            jQuery(this).parents("tr").attr("data-secundario", campo_secundario);
            if (tipo_lente !== "descanso") {
                imprimir_campos(buscar_campos, tipo_lente, this, "sub-campo-2", campo_primario, campo_secundario, campo_terciario);
                if (tipo_lente === "bifocales" || tipo_lente === "progresivos") {
                    nuevo_name = "_rang_one[" + campo_primario + "][sub-rango][" + campo_secundario + "][sub-rango-2][" + buscar_campos + "]";
                    jQuery(this).attr("name", nuevo_name);
                    jQuery(this).parents(".secc_tree").siblings("div.cam_price_tree").children("p._regular_price_form").children("input").attr("name", nuevo_name + "[_price]");
                }
            }
            else{
                jQuery(this).val(jQuery(this).attr("data-value"));
                jQuery(this).parents(".content_secc_two").children("div.cam_price_secc").hide();
                return 0
            }
        }
    });

    body_t.on("click","a.agregar_campo",function(){
        error = "nonerror";
        jQuery(this).parents("div").siblings("div.camp_form").children().find("select").each(function(a,j){
            if(jQuery(j).hasClass("error_alert") === true){
                error = "error";
            }
        });

        if(error === "nonerror") {

            select_valor = jQuery(jQuery(this).siblings().children("select")).val();
            if (select_valor !== "") {
                insertar_tabla(select_valor, this);
                jQuery(this).hide();
                jQuery(this).siblings(".otro_row").show();
                jQuery(this).parent().siblings("div.cam_price_one").hide();
            }
            else {
                jQuery(jQuery(this).siblings().children("select")).css(styles);
                alert("Antes de agregar otro rango debes seleccionar el campo primero");
            }
            jQuery(this).parents("td").removeAttr("style");
        }
        else{
            mensaje_error = '<div class="alert alert-danger" role="alert">\n' +
                '                        Disculpe debe corregir primero los errores en los rangos de fórmulas para avanzar.\n' +
                '                    </div>';
            mensaje = jQuery("#tabla_formula_config");
            mensaje.show();
            mensaje.prepend(mensaje_error);
        }
    });

    body_t.on("click", "a.otro_row",function(){
        error = "nonerror";
        jQuery(this).parents("div").siblings("div.camp_form").children().find("select").each(function(a,j){
            console.log(jQuery(j).attr("class"));
            if(jQuery(j).hasClass("error_alert") === true){
                error = "error";
            }
        });

        if(error === "nonerror"){
            jQuery(this).parents("table.matr_form").find("a.eliminar_second").hide();
            rango_primario = jQuery(jQuery(this).siblings().children("select")).val();
            contador = jQuery(this).attr("data-count");
            insertar_tr_tabla(rango_primario, this,contador);
            jQuery(this).attr("data-count",contador);
            contador = contador_rowspan("data-primario",rango_primario, "", "");
            contador++;
            jQuery(this).parents("td.cont_form").attr("rowspan", contador);
        }
        else{
            mensaje_error = '<div class="alert alert-danger" role="alert">\n' +
                '                        Disculpe debe corregir primero los errores en los rangos de fórmulas para avanzar.\n' +
                '                    </div>';
            mensaje = jQuery("#tabla_formula_config");
            mensaje.show();
            mensaje.prepend(mensaje_error);
        }

    });

    body_t.on("click","a.agregar_campo_terc", function(){
        error = "nonerror";
        jQuery(this).parents("div").siblings("div.camp_form").children().find("select").each(function(a,j){
            if(jQuery(j).hasClass("error_alert") === true){
                error = "error";
            }
        });

        if(error === "nonerror") {
            campo_primario = jQuery(this).siblings().find("._camp_rang_two").attr("campo-primario");
            campo_secundario = jQuery(this).siblings().find("._camp_rang_two").val();
            if (campo_secundario !== "") {
                jQuery(this).parents("td.conte_seg_rang").siblings("td.conte_terc_rang").children().children(".cam_price_tree").children("a.eliminar_tercer").hide();
                insertar_tabla_tercer(campo_primario, campo_secundario, this);
                jQuery(this).parent().parent().children("div.cam_price_secc").hide();
            }
            else {
                jQuery(this).siblings().find("._camp_rang_two").css(styles);
                alert("Antes de agregar otro rango debes seleccionar el campo primero");
            }
        }else{
            mensaje_error = '<div class="alert alert-danger" role="alert">\n' +
                '                        Disculpe debe corregir primero los errores en los rangos de fórmulas para avanzar.\n' +
                '                    </div>';
            mensaje = jQuery("#tabla_formula_config");
            mensaje.show();
            mensaje.prepend(mensaje_error);
        }
    });

    body_t.on("click","a.agregar_campo_cuart", function(){
        error = "nonerror";
        jQuery(this).parents("div").siblings("div.camp_form").children().find("select").each(function(a,j){
            if(jQuery(j).hasClass("error_alert") === true){
                error = "error";
            }
        });

        if(error === "nonerror") {
            campo_primario = jQuery(this).siblings().find("._camp_rang_tree").attr("campo-primario");
            campo_secundario = jQuery(this).siblings().find("._camp_rang_tree").attr("campo-secundario");
            campo_terciario = jQuery(this).siblings().find("._camp_rang_tree").val();
            jQuery(this).parents("tr").find("a.eliminar_cuart").hide();
            jQuery(this).parents(".content_secc_tree").children("div.cam_price_tree").hide();
            if (campo_terciario !== "") {
                insertar_tabla_cuart(campo_primario, campo_secundario, campo_terciario, this)
            }
            else {
                jQuery(this).siblings().find("._camp_rang_tree").css(styles);
                alert("Antes de agregar otro rango debes seleccionar el campo primero");
            }
        }else{
            mensaje_error = '<div class="alert alert-danger" role="alert">\n' +
                '                        Disculpe debe corregir primero los errores en los rangos de fórmulas para avanzar.\n' +
                '                    </div>';
            mensaje = jQuery("#tabla_formula_config");
            mensaje.show();
            mensaje.prepend(mensaje_error);
        }
    });

    body_t.on("click", "a.eliminar_tercer", function(){
        if(parseInt(jQuery(this).attr("data-count")) === 1){
            jQuery(this).parents("td.conte_terc_rang").siblings("td.conte_seg_rang").children().children(".cam_price_secc").show();
            jQuery(this).parents("td").siblings("td.conte_seg_rang").children("div.content_secc_two").find("a.new_row_camp_terc").attr("class","agregar_campo_terc");
            jQuery(this).parents(".content_secc_tree").remove();
        }
        else{
            data_primario = jQuery(this).parents("tr").attr("data-primario");
            data_secundario = jQuery(this).parents("tr").attr("data-secundario");
            conteo_anterior = jQuery(this).parents("tr").siblings("tr[data-primario='"+data_primario+"'][data-secundario='"+data_secundario+"']").children().find('select._camp_rang_two option[value="'+data_secundario+'"]').parents("p").siblings("a").attr("data-child");
            conteo_nuevo = (parseInt(conteo_anterior) - 1);
            jQuery(this).parents("tr").siblings("tr[data-primario='"+data_primario+"'][data-secundario='"+data_secundario+"']").children().find('select._camp_rang_two option[value="'+data_secundario+'"]').parents("p").siblings("a").attr("data-child", conteo_nuevo);
            jQuery(this).parents("tr").siblings("tr[data-primario='"+data_primario+"'][data-secundario='"+data_secundario+"']").children().find("a.eliminar_tercer[data-count='"+conteo_nuevo+"']").show();
            jQuery(this).parents("tr").siblings("tr[data-primario='"+data_primario+"'][data-secundario='"+data_secundario+"']").find("td.conte_seg_rang[rowspan='"+conteo_anterior+"']").attr("rowspan", conteo_nuevo);
            jQuery(this).parents("tr").remove();
        }
    });

    body_t.on("click", "a.eliminar_second", function(){
        if(parseInt(jQuery(this).attr("data-count")) === 1){
            jQuery(this).parents("tr").children("td.cont_form").children("div.cam_price_one").show();
            jQuery(this).parents("tr").children("td.cont_form").children("div.cam_price_one").find(".wc_input_price").show();
            jQuery(this).parents("tr").children("td.cont_form").children("div.secc_one").children("a.agregar_campo").show();
            jQuery(this).parents("tr").children("td.cont_form").children("div.secc_one").children("a.otro_row").hide();
            jQuery(this).parents("tr").children("td.conte_seg_rang").children(".content_secc_two").remove();
        }
        else{
            jQuery(jQuery(this).parents("tr").siblings().get(parseInt(jQuery(this).parents("tr").siblings().length)-1)).find("a.eliminar_second").show();
            controlador = jQuery(this).parents("tr").siblings("tr.primer_rang").find("a.otro_row");
            cantid_viej = parseInt(controlador.attr("data-count")) - 1;
            controlador.attr("data-count",cantid_viej);

            jQuery(this).parents("tr").siblings("tr.primer_rang").find("td.cont_form").attr("rowspan",cantid_viej);
            if(parseInt(jQuery(this).parents("table.second_rang").length) !== 1){
                jQuery(this).parents("tr").remove();
            }
            else{
                if(typeof jQuery(this).parents("tr").attr("class") === "undefined"){
                    jQuery(this).parents("tr").remove();
                }
                else{
                    jQuery(this).parents("tr").children("td.cont_form").children("div.cam_price_one").show();
                    jQuery(this).parents("tr").children("td.cont_form").children("div.secc_one").children("a.agregar_campo").show();
                    jQuery(this).parents("tr").children("td.cont_form").children("div.secc_one").children("a.otro_row").hide();
                    jQuery(this).parents(".content_secc_two").remove();
                }
            }
        }
    });

    body_t.on("click", "a.eliminar_otro_rang", function(){
        d = jQuery("a.otro_rang");
        jQuery(this).parents("tr").remove();
        d.attr("data-count", parseInt(d.attr("data-count"))-1);

    });

    body_t.on("click", "a.otro_rang", function(){
        agregar_nuevo_rango(this);
    });

    body_t.on("click","a.new_row_camp_terc", function(){
        error = "nonerror";
        jQuery(this).parents("div").siblings("div.camp_form").children().find("select").each(function(a,j){
            if(jQuery(j).hasClass("error_alert") === true){
                error = "error";
            }
        });

        if(error === "nonerror") {
            jQuery(this).parents("tr").find("a.eliminar_tercer").hide();
            campo_primario = jQuery(this).siblings().find("._camp_rang_two").attr("campo-primario");
            campo_secundario = jQuery(this).siblings().find("._camp_rang_two").val();
            contador = jQuery(this).attr("data-child");
            jQuery(this).parents("tr").siblings("[data-primario='" + campo_primario + "'][data-secundario='" + campo_secundario + "']").find("a.eliminar_tercer").hide();
            insertar_tercer_campo_row(campo_primario, campo_secundario, contador, this);
        }else{
            mensaje_error = '<div class="alert alert-danger" role="alert">\n' +
                '                        Disculpe debe corregir primero los errores en los rangos de fórmulas para avanzar.\n' +
                '                    </div>';
            mensaje = jQuery("#tabla_formula_config");
            mensaje.show();
            mensaje.prepend(mensaje_error);
        }
    });

    body_t.on("change", "._camp_rang_cuart", function(){
        buscar_campos = jQuery(this).val();
        tipo_lente = jQuery("#_tipo_lente").val();
        campo_primario = jQuery(this).attr("campo-primario");
        campo_secundario = jQuery(this).attr("campo-secundario");
        campo_terciario = jQuery(this).attr("campo-terciario");
        campo_cuarteriano = jQuery(this).val();
        if(tipo_lente !== "descanso"){
            imprimir_campos(buscar_campos, tipo_lente,this,"sub-campo-3",campo_primario,campo_secundario, campo_terciario, campo_cuarteriano);
        }
    });

    body_t.on("click", "a.eliminar_cuart", function(){
        jQuery(jQuery(this).parents(".content_secc_cuart").siblings().get(parseInt(jQuery(this).parents(".content_secc_cuart").siblings().length)-1)).find("a.eliminar_cuart").show();
        if(parseInt(jQuery(this).attr("data-count")) === 1){
            jQuery(this).parents("td.conte_cuart_rang").siblings("td.conte_terc_rang").children().children(".cam_price_tree").show();
        }
        jQuery(this).parents(".content_secc_cuart").remove();

    });

    body_t.on("keyup",".eco_price", function(){
        jQuery("p._regular_price_field input#_regular_price").val(jQuery(this).val());
        jQuery("p._regular_price_field input#_regular_price").attr("value", jQuery(this).val());
    });

    body_t.on("keyup",".montura_price", function(){
        jQuery("p._regular_price_field input#_regular_price").val(jQuery(this).val());
        jQuery("p._regular_price_field input#_regular_price").attr("value", jQuery(this).val());
    });

    body_t.on("change", ".rang_formul_inicio", function(){
        valor_inicial = jQuery(this).val();
        valor_final = jQuery(this).parents("p").siblings().find(".rang_formul_final").val();
        desactivar_btn = jQuery("a.otro_rang");
        if (parseFloat(valor_inicial) < parseFloat(valor_final)) {
            desactivar_btn.hide();
            mensaje_error = '<div class="alert alert-danger" role="alert">\n' +
                '                        Disculpe pero el rango que intenta agregar es menor al rango final de la fórmula, por favor coloque un número más alto en el rango de inicio.\n' +
                '                    </div>';
            mensaje = jQuery("#tabla_formula_config");
            mensaje.show();
            mensaje.prepend(mensaje_error);
            jQuery(this).addClass("error_alert");
        }
        else{
            desactivar_btn.show();
            jQuery(".alert.alert-danger").remove();
            jQuery(this).removeClass("error_alert");
            jQuery(this).parents("p").siblings().find(".rang_formul_final").removeClass("error_alert");
        }
    });

    body_t.on("change", ".rang_formul_final", function(){
        valor_final = jQuery(this).val();
        valor_inicial = jQuery(this).parents("p").siblings().find(".rang_formul_inicio").val();
        desactivar_btn = jQuery("a.otro_rang");
        if (parseFloat(valor_inicial) < parseFloat(valor_final)) {
            desactivar_btn.hide();
            mensaje_error = '<div class="alert alert-danger" role="alert">\n' +
                '                        Disculpe pero el rango que intenta agregar es mayor al rango de inicio de la fórmula, por favor coloque un número más bajo en el rango final.\n' +
                '                    </div>';
            mensaje = jQuery("#tabla_formula_config");
            mensaje.show();
            mensaje.prepend(mensaje_error);
            jQuery(this).addClass("error_alert");
        }
        else{
            desactivar_btn.show();
            jQuery(".alert.alert-danger").remove();
            jQuery(this).removeClass("error_alert");
            jQuery(this).parents("p").siblings().find(".rang_formul_inicio").removeClass("error_alert");
        }
    });

});

jQuery.extend({
    showHideSubscriptionMeta: function(){
        let tipo = jQuery('select#product-type').val();
        let tab_formulas = jQuery('.formulate_tab');
        let tab_monturas = jQuery('.monturas_prices_tab');
        let tab_lentes_contacto = jQuery(".lentes_contacto_prices_tab");
        if (tipo === "monturas") {
            jQuery(".montura_price").attr("name", "_regular_price");
            jQuery(".montura_sale_price").attr("name", "_sale_price");
            jQuery("li.monturas_prices_options").addClass("active");
            jQuery("li.monturas_atributos_options").removeClass("active");
            jQuery("#monturas_prices_panel").show();
            jQuery("div#tagsdiv-materiales_montura").hide();
            jQuery( 'input#_manage_stock' ).trigger( 'change' );
            jQuery('.show_if_simple').show();
            jQuery("li.monturas_atributos_options").show();
            tab_monturas.show();
            jQuery("#shipping_product_data").hide();
            jQuery("div#formulate_panel").hide();
            tab_formulas.hide();
            tab_lentes_contacto.hide();
            jQuery('.hide_if_grouped').hide();
            jQuery("li.atributos_lentes_options").hide();
            jQuery('label.show_if_simple.tips').hide();
            jQuery('label.show_if_simple.tips').hide();
            jQuery("div#monturas_atributo_panel").hide();
            jQuery("li.filtros_lentes_options").hide();
            jQuery("#general_product_data").hide();
            jQuery('#lentes_contacto_panel').hide();
            jQuery(".lentes_contacto_price").attr("name", "_no_prices");
            jQuery(".lentes_contacto_sale_price").attr("name", "_no_prices");
            jQuery("#_sale_price").attr("name", "_no_prices");
            jQuery(".eco_price").attr("name", "_no_prices");
            jQuery("div.show_if_simple input[name='_regular_price']").attr("name", "_no_prices")
        }
        else if (tipo === "lentes") {
            jQuery("div#tagsdiv-materiales_montura").hide();
            jQuery(".eco_price").attr("name", "_regular_price");
            jQuery("li.formulate_options").addClass("active");
            jQuery("div#formulate_panel").show();
            tab_formulas.show();
            jQuery('.show_if_simple').show();
            jQuery("li.atributos_lentes_options").show();
            jQuery("li.filtros_lentes_options").show();
            jQuery( 'input#_manage_stock' ).trigger( 'change' );
            jQuery('.hide_if_grouped').hide();
            jQuery('label.show_if_simple.tips').hide();
            jQuery('label.show_if_simple.tips').hide();
            tab_monturas.hide();
            tab_lentes_contacto.hide();
            jQuery("#shipping_product_data").hide();
            jQuery("div#monturas_prices_panel").hide();
            jQuery("div#monturas_atributo_panel").hide();
            jQuery('#lentes_contacto_panel').hide();
            jQuery("#general_product_data").hide();
            jQuery(".monturas_atributos_options").hide();
            jQuery(".lentes_contacto_price").attr("name", "_no_prices");
            jQuery(".montura_price").attr("name", "_no_prices");
            jQuery("div.show_if_simple input[name='_regular_price']").attr("name", "_no_prices")
        }
        else if (tipo ==="lentes-contacto") {
            jQuery("div#tagsdiv-materiales_montura").hide();
            jQuery(".lentes_contacto_price").attr("name", "_regular_price");
            jQuery(".lentes_contacto_sale_price").attr("name", "_sale_price");
            jQuery("li.formulate_options").addClass("active");
            jQuery('.show_if_simple').show();
            jQuery('#lentes_contacto_panel').show();
            tab_lentes_contacto.show();
            jQuery( 'input#_manage_stock' ).trigger( 'change' );
            jQuery("div#formulate_panel").hide();
            jQuery("li.filtros_lentes_options").hide();
            tab_formulas.hide();
            jQuery('.hide_if_grouped').hide();
            jQuery("li.atributos_lentes_options").hide();
            jQuery('label.show_if_simple.tips').hide();
            jQuery('label.show_if_simple.tips').hide();
            jQuery("div#monturas_atributo_panel").hide();
            jQuery(".monturas_atributos_options").hide();
            tab_monturas.hide();
            jQuery("#shipping_product_data").hide();
            jQuery("div#monturas_prices_panel").hide();
            jQuery("#general_product_data").hide();
            jQuery(".eco_price").attr("name", "_no_prices");
            jQuery(".montura_sale_price").attr("name", "_no_prices");
            jQuery(".montura_price").attr("name", "_no_prices");
            jQuery("div.show_if_simple input[name='_regular_price']").attr("name", "_no_prices")
        }
        else{
            jQuery("div#tagsdiv-materiales_montura").hide();
            jQuery("div.show_if_simple input[name='_regular_price']").attr("name", "_regular_price");
            jQuery("#_sale_price").attr("name", "_sale_price");
            jQuery("div#monturas_atributo_panel").hide();
            jQuery(".lentes_contacto_price").attr("name", "_no_prices");
            jQuery(".eco_price").attr("name", "_no_prices");
            jQuery(".montura_price").attr("name", "_no_prices");
            jQuery(".montura_sale_price").attr("name", "_no_prices");
            jQuery(".lentes_contacto_sale_price").attr("name", "_no_prices");
            jQuery(".monturas_atributos_options").hide();
            jQuery("li.filtros_lentes_options").hide();
            jQuery("li.atributos_lentes_options").hide();
            tab_formulas.hide();
            tab_monturas.hide();
            tab_lentes_contacto.hide();
        }
    },
    showHideSubscriptionsPanels: function() {
        var tab = jQuery( 'div.panel-wrap' ).find( 'ul.wc-tabs li' ).eq( 0 ).find( 'a' );
        var panel = tab.attr( 'href' );
        var visible = jQuery( panel ).children( '.options_group' ).filter( function() {
            return 'none' != jQuery( this ).css( 'display' );
        });

        if ( 0 != visible.length ) {
            tab.trigger( 'click' ).parent().show();
        }
    },
});

function mostrar_descanso(Valor){
    img_loader = '<img id="loader_optica" src="'+tecnooptica.ajaxLoaderImage+'" alt="Cargabdi">';
    id_producto = jQuery("#post_ID").val();
    contenedor_imprimir = jQuery("div#config_form_camp");
    contenedor_imprimir.html("");
    contenedor_precio_eoc = jQuery("p._regular_price_eoc");

    if(Valor === "descanso"){
        contenedor_precio_eoc.show();
        contenedor_imprimir.html("");
    }
    else if(Valor === "bifocales" ){
        contenedor_imprimir.append(img_loader);
        contenedor_precio_eoc.show();
        jQuery.ajax({
            url : tecnooptica.ajaxUrl,
            type: 'post',
            data: {
                action : 'mostrar_bifocales',
                id_product : id_producto,
            },
            async: true,
            success: function(resultado){
                contenedor_imprimir.html("");
                contenedor_imprimir.append(resultado);
            }
        });
    }
    else if( Valor === "progresivos"){
        contenedor_imprimir.append(img_loader);
        contenedor_precio_eoc.show();

        jQuery.ajax({
            url : tecnooptica.ajaxUrl,
            type: 'post',
            data: {
                action : 'mostrar_progresivos',
                id_product : id_producto,
            },
            async: true,
            success: function(resultado){
                contenedor_imprimir.html("");
                contenedor_imprimir.append(resultado);
            }
        });
    }
    else if( Valor === "ocupacionales"){
        contenedor_imprimir.append(img_loader);
        contenedor_precio_eoc.show();

        jQuery.ajax({
            url : tecnooptica.ajaxUrl,
            type: 'post',
            data: {
                action : 'mostrar_ocupacionales',
                id_product : id_producto,
            },
            async: true,
            success: function(resultado){
                contenedor_imprimir.html("");
                contenedor_imprimir.append(resultado);
            }
        });
    }
    else if( Valor === "vision_sencilla"){
        contenedor_imprimir.append(img_loader);
        contenedor_precio_eoc.show();

        jQuery.ajax({
            url : tecnooptica.ajaxUrl,
            type: 'post',
            data: {
                action : 'mostrar_vision_sencilla',
                id_product : id_producto,
            },
            async: true,
            success: function(resultado){
                contenedor_imprimir.html("");
                contenedor_imprimir.append(resultado);
            }
        });
    }
}

function is_negative_number(number=0){
    if( (is_numeric(number)) && (number<0) ){
        return true;
    }else{
        return false;
    }
}

function is_positiv_number(number=0){
    if( (is_numeric(number)) && (number>=0) ){
        return true;
    }else{
        return false;
    }
}

function is_numeric(value) {
    return !isNaN(parseFloat(value)) && isFinite(value);
}

function validar_campos_rangos_formulas(data) {
    let rang_positiv_esfera = jQuery(data).parent().parent().parent().find("input[name='rango-positivo-esfera']").val();
    let rang_negativ_esfera = jQuery(data).parent().parent().parent().find("input[name='rango-negativo-esfera']").val();
    let rang_step_esfera = jQuery(data).parent().parent().parent().find("input[name='step-esfera']").val();
    let rang_positiv_cilindro = jQuery(data).parent().parent().parent().find("input[name='rango-positivo-cilindro']").val();
    let rang_negativ_cilindro = jQuery(data).parent().parent().parent().find("input[name='rango-negativo-cilindro']").val();
    let rang_step_cilindro = jQuery(data).parent().parent().parent().find("input[name='step-cilindro']").val();
    let rang_alto_eje = jQuery(data).parent().parent().parent().find("input[name='rango-positivo-alto-eje']").val();
    let rang_bajo_eje = jQuery(data).parent().parent().parent().find("input[name='rango-positivo-bajo-eje']").val();
    let rang_step_eje = jQuery(data).parent().parent().parent().find("input[name='step-eje']").val();

    var datos = new Object();

    if(rang_positiv_esfera === ""){
        mensaje_error  = '<div class="alert alert-danger" role="alert">\n' +
            '                        El campo rango positivo de la esfera se encuentra <strong>vacío!</strong>. Debes agregar un valor positivo para el rango antes de guardar\n' +
            '                    </div>';
        mostrar_mensaje(mensaje_error);
        jQuery("[name='rango-positivo-esfera']").attr("class","error_alert");
        return 0;
    }
    else{
        jQuery("[name='rango-positivo-esfera']").removeClass("error_alert");
        datos.rang_positiv_esfera = rang_positiv_esfera;
    }

    if(rang_negativ_esfera === ""){
        mensaje_error  = '<div class="alert alert-danger" role="alert">\n' +
            '                        El campo rango negativo de la esfera se encuentra <strong>vacío!</strong>. Debes agregar un valor negativo para el rango antes de guardar\n' +
            '                    </div>';
        mostrar_mensaje(mensaje_error);
        jQuery("[name='rango-negativo-esfera']").attr("class","error_alert");
        return 0;
    }
    else{
        jQuery("[name='rango-negativo-esfera']").removeClass("error_alert");
        datos.rang_negativ_esfera = rang_negativ_esfera;
    }

    if(rang_step_esfera === ""){
        mensaje_error  = '<div class="alert alert-danger" role="alert">\n' +
            '                        El campo salto de la esfera se encuentra <strong>vacío!</strong>. Debes agregar un valor positivo para el salto antes de guardar\n' +
            '                    </div>';
        mostrar_mensaje(mensaje_error);
        jQuery("[name='step-esfera']").attr("class","error_alert");
        return 0;
    }
    else{
        jQuery("[name='step-esfera']").removeClass("error_alert");
        datos.rang_step_esfera = rang_step_esfera;
    }

    if(rang_positiv_cilindro === ""){
        mensaje_error  = '<div class="alert alert-danger" role="alert">\n' +
            '                        El campo rango positivo del cilindro se encuentra <strong>vacío!</strong>. Debes agregar un valor positivo para el rango antes de guardar\n' +
            '                    </div>';
        mostrar_mensaje(mensaje_error);
        jQuery("[name='rango-positivo-cilindro']").attr("class","error_alert");
        return 0
    }
    else{
        jQuery("[name='rango-positivo-cilindro']").removeClass("error_alert");
        datos.rang_positiv_cilindro = rang_positiv_cilindro;
    }

    if(rang_negativ_cilindro === ""){
        mensaje_error  = '<div class="alert alert-danger" role="alert">\n' +
            '                        El campo rango negativo del cilindro se encuentra <strong>vacío!</strong>. Debes agregar un valor negativo para el rango antes de guardar\n' +
            '                    </div>';
        mostrar_mensaje(mensaje_error);
        jQuery("[name='rango-negativo-cilindro']").attr("class","error_alert");
        return 0;
    }
    else{
        jQuery("[name='rango-negativo-cilindro']").removeClass("error_alert");
        datos.rang_negativ_cilindro = rang_negativ_cilindro;
    }

    if(rang_step_cilindro === ""){
        mensaje_error  = '<div class="alert alert-danger" role="alert">\n' +
            '                        El campo salto del cilindro se encuentra <strong>vacío!</strong>. Debes agregar un valor positivo para el salto antes de guardar\n' +
            '                    </div>';
        mostrar_mensaje(mensaje_error);
        jQuery("[name='step-cilindro']").attr("class","error_alert");
        return 0;
    }
    else{
        jQuery("[name='step-cilindro']").removeClass("error_alert");
        datos.rang_step_cilindro = rang_step_cilindro;
    }

    if(rang_alto_eje === ""){
        mensaje_error  = '<div class="alert alert-danger" role="alert">\n' +
            '                        El campo rango alto del eje se encuentra <strong>vacío!</strong>. Debes agregar un valor negativo para el rango antes de guardar\n' +
            '                    </div>';
        mostrar_mensaje(mensaje_error);
        jQuery("[name='rango-positivo-alto-eje']").attr("class","error_alert");
        return 0;
    }
    else{
        jQuery("[name='rango-positivo-alto-eje']").removeClass("error_alert");
        datos.rang_alto_eje = rang_alto_eje;
    }

    if(rang_bajo_eje === ""){
        mensaje_error  = '<div class="alert alert-danger" role="alert">\n' +
            '                        El campo rango bajo del eje se encuentra <strong>vacío!</strong>. Debes agregar un valor negativo para el rango antes de guardar\n' +
            '                    </div>';
        mostrar_mensaje(mensaje_error);
        jQuery("[name='rango-positivo-bajo-eje']").attr("class","error_alert");
        return 0;
    }
    else{
        jQuery("[name='rango-positivo-bajo-eje']").removeClass("error_alert");
        datos.rang_bajo_eje = rang_bajo_eje;
    }

    if(rang_step_eje === ""){
        mensaje_error  = '<div class="alert alert-danger" role="alert">\n' +
            '                        El campo salto del eje se encuentra <strong>vacío!</strong>. Debes agregar un valor positivo para el salto antes de guardar\n' +
            '                    </div>';
        mostrar_mensaje(mensaje_error);
        jQuery("[name='step-eje']").attr("class","error_alert");
        return 0;
    }
    else if(rang_step_eje === 0){
        mensaje_error  = '<div class="alert alert-danger" role="alert">\n' +
            '                        El campo salto del eje <strong>no puede ser 0!</strong>. Debes agregar un valor positivo mayor que 0 para el salto antes de guardar\n' +
            '                    </div>';
        mostrar_mensaje(mensaje_error);
        jQuery("[name='step-eje']").attr("class","error_alert");
        return 0;
    }
    else{
        jQuery("[name='step-eje']").removeClass("error_alert");
        datos.rang_step_eje = rang_step_eje;
    }

    return datos;
}

function validar_campos_rangos_formulas_con_add(data) {
    let rang_positiv_esfera = jQuery(data).parent().parent().parent().find("input[name='rango-positivo-esfera']").val();
    let rang_negativ_esfera = jQuery(data).parent().parent().parent().find("input[name='rango-negativo-esfera']").val();
    let rang_step_esfera = jQuery(data).parent().parent().parent().find("input[name='step-esfera']").val();
    let rang_positiv_cilindro = jQuery(data).parent().parent().parent().find("input[name='rango-positivo-cilindro']").val();
    let rang_negativ_cilindro = jQuery(data).parent().parent().parent().find("input[name='rango-negativo-cilindro']").val();
    let rang_step_cilindro = jQuery(data).parent().parent().parent().find("input[name='step-cilindro']").val();
    let rang_positiv_add = jQuery(data).parent().parent().parent().find("input[name='rango-positivo-add']").val();
    let rang_negativ_add = jQuery(data).parent().parent().parent().find("input[name='rango-negativo-add']").val();
    let rang_step_add = jQuery(data).parent().parent().parent().find("input[name='step-add']").val();
    let rang_alto_eje = jQuery(data).parent().parent().parent().find("input[name='rango-positivo-alto-eje']").val();
    let rang_bajo_eje = jQuery(data).parent().parent().parent().find("input[name='rango-positivo-bajo-eje']").val();
    let rang_step_eje = jQuery(data).parent().parent().parent().find("input[name='step-eje']").val();

    var datos = new Object();

    if(rang_positiv_esfera===""){
        mensaje_error  = '<div class="alert alert-danger" role="alert">\n' +
            '                        El campo rango positivo de la esfera se encuentra <strong>vacío!</strong>. Debes agregar un valor positivo para el rango antes de guardar\n' +
            '                    </div>';
        mostrar_mensaje(mensaje_error);
        jQuery("[name='rango-positivo-esfera']").attr("class","error_alert");
        return 0;
    }
    else{
        jQuery("[name='rango-positivo-esfera']").removeClass("error_alert");
        datos.rang_positiv_esfera = rang_positiv_esfera;
    }

    if(rang_negativ_esfera===""){
        mensaje_error  = '<div class="alert alert-danger" role="alert">\n' +
            '                        El campo rango negativo de la esfera se encuentra <strong>vacío!</strong>. Debes agregar un valor negativo para el rango antes de guardar\n' +
            '                    </div>';
        mostrar_mensaje(mensaje_error);
        jQuery("[name='rango-negativo-esfera']").attr("class","error_alert");
        return 0;
    }
    else{
        jQuery("[name='rango-negativo-esfera']").removeClass("error_alert");
        datos.rang_negativ_esfera = rang_negativ_esfera;
    }

    if(rang_step_esfera===""){
        mensaje_error  = '<div class="alert alert-danger" role="alert">\n' +
            '                        El campo salto de la esfera se encuentra <strong>vacío!</strong>. Debes agregar un valor positivo para el salto antes de guardar\n' +
            '                    </div>';
        mostrar_mensaje(mensaje_error);
        jQuery("[name='step-esfera']").attr("class","error_alert");
        return 0;
    }
    else{
        jQuery("[name='step-esfera']").removeClass("error_alert");
        datos.rang_step_esfera = rang_step_esfera;
    }

    if(rang_positiv_cilindro===""){
        mensaje_error  = '<div class="alert alert-danger" role="alert">\n' +
            '                        El campo rango positivo del cilindro se encuentra <strong>vacío!</strong>. Debes agregar un valor positivo para el rango antes de guardar\n' +
            '                    </div>';
        mostrar_mensaje(mensaje_error);
        jQuery("[name='rango-positivo-cilindro']").attr("class","error_alert");
        return 0;
    }
    else{
        jQuery("[name='rango-positivo-cilindro']").removeClass("error_alert");
        datos.rang_positiv_cilindro = rang_positiv_cilindro;
    }

    if(rang_negativ_cilindro===""){
        mensaje_error  = '<div class="alert alert-danger" role="alert">\n' +
            '                        El campo rango negativo del cilindro se encuentra <strong>vacío!</strong>. Debes agregar un valor negativo para el rango antes de guardar\n' +
            '                    </div>';
        mostrar_mensaje(mensaje_error);
        jQuery("[name='rango-negativo-cilindro']").attr("class","error_alert");
        return 0;
    }
    else{
        jQuery("[name='rango-negativo-cilindro']").removeClass("error_alert");
        datos.rang_negativ_cilindro = rang_negativ_cilindro;
    }

    if(rang_step_cilindro===""){
        mensaje_error  = '<div class="alert alert-danger" role="alert">\n' +
            '                        El campo salto del cilindro se encuentra <strong>vacío!</strong>. Debes agregar un valor positivo para el salto antes de guardar\n' +
            '                    </div>';
        mostrar_mensaje(mensaje_error);
        jQuery("[name='step-cilindro']").attr("class","error_alert");
        return 0;
    }
    else{
        jQuery("[name='step-cilindro']").removeClass("error_alert");
        datos.rang_step_cilindro = rang_step_cilindro;
    }

    if(rang_positiv_add===""){
        mensaje_error  = '<div class="alert alert-danger" role="alert">\n' +
            '                        El campo rango positivo de ADD se encuentra <strong>vacío!</strong>. Debes agregar un valor positivo para el rango antes de guardar\n' +
            '                    </div>';
        mostrar_mensaje(mensaje_error);
        jQuery("[name='rango-positivo-cilindro']").attr("class","error_alert");
        return 0;
    }
    else{
        jQuery("[name='rango-positivo-cilindro']").removeClass("error_alert");
        datos.rang_positiv_add = rang_positiv_add;
    }

    if(rang_negativ_add===""){
        mensaje_error  = '<div class="alert alert-danger" role="alert">\n' +
            '                        El campo rango negativo de ADD se encuentra <strong>vacío!</strong>. Debes agregar un valor negativo para el rango antes de guardar\n' +
            '                    </div>';
        mostrar_mensaje(mensaje_error);
        jQuery("[name='rango-negativo-cilindro']").attr("class","error_alert");
        return 0;
    }
    else{
        jQuery("[name='rango-negativo-cilindro']").removeClass("error_alert");
        datos.rang_negativ_add = rang_negativ_add;
    }

    if(rang_step_add===""){
        mensaje_error  = '<div class="alert alert-danger" role="alert">\n' +
            '                        El campo salto de ADD se encuentra <strong>vacío!</strong>. Debes agregar un valor positivo para el salto antes de guardar\n' +
            '                    </div>';
        mostrar_mensaje(mensaje_error);
        jQuery("[name='step-cilindro']").attr("class","error_alert");
        return 0;
    }
    else{
        jQuery("[name='step-cilindro']").removeClass("error_alert");
        datos.rang_step_add = rang_step_add;
    }

    if(rang_alto_eje===""){
        mensaje_error  = '<div class="alert alert-danger" role="alert">\n' +
            '                        El campo rango alto del eje se encuentra <strong>vacío!</strong>. Debes agregar un valor negativo para el rango antes de guardar\n' +
            '                    </div>';
        mostrar_mensaje(mensaje_error);
        jQuery("[name='rango-positivo-alto-eje']").attr("class","error_alert")
        return 0;
    }
    else{
        jQuery("[name='rango-positivo-alto-eje']").removeClass("error_alert");
        datos.rang_alto_eje = rang_alto_eje;
    }

    if(rang_bajo_eje===""){
        mensaje_error  = '<div class="alert alert-danger" role="alert">\n' +
            '                        El campo rango bajo del eje se encuentra <strong>vacío!</strong>. Debes agregar un valor negativo para el rango antes de guardar\n' +
            '                    </div>';
        mostrar_mensaje(mensaje_error);
        jQuery("[name='rango-positivo-bajo-eje']").attr("class","error_alert");
        return 0;
    }
    else{
        jQuery("[name='rango-positivo-bajo-eje']").removeClass("error_alert");
        datos.rang_bajo_eje = rang_bajo_eje;
    }

    if(rang_step_eje===""){
        mensaje_error  = '<div class="alert alert-danger" role="alert">\n' +
            '                        El campo salto del eje se encuentra <strong>vacío!</strong>. Debes agregar un valor positivo para el salto antes de guardar\n' +
            '                    </div>';
        mostrar_mensaje(mensaje_error);
        jQuery("[name='step-eje']").attr("class","error_alert");
        return 0;
    }
    else if(rang_step_eje===0){
        mensaje_error  = '<div class="alert alert-danger" role="alert">\n' +
            '                        El campo salto del eje <strong>no puede ser 0!</strong>. Debes agregar un valor positivo mayor que 0 para el salto antes de guardar\n' +
            '                    </div>';
        mostrar_mensaje(mensaje_error);
        jQuery("[name='step-eje']").attr("class","error_alert");
        return 0;
    }
    else{
        jQuery("[name='step-eje']").removeClass("error_alert");
        datos.rang_step_eje = rang_step_eje;
    }

    return datos;
}

function mostrar_mensaje(mensaje_error){
    mensaje = jQuery("#mensaje");
    mensaje.show();
    mensaje.append(mensaje_error);
    jQuery(".alert").fadeOut( 12000, function(){
        mensaje.html("");
    } )
}

function imprimir_campos(buscar_campos, tipo_lente,elemento,tip_element_campo,campo_primario,campo_secundario, campo_terciario, campo_cuarteriano){
    jQuery.ajax({
        url : tecnooptica.ajaxUrl,
        type: 'post',
        data: {
            action : 'consultar_rangos',
            buscar_campos: buscar_campos,
            tipo_lente: tipo_lente,
            tip_element_campo: tip_element_campo,
            campo_primario: campo_primario,
            campo_secundario: campo_secundario,
            campo_terciario: campo_terciario,
            campo_cuarteriano: campo_cuarteriano,
        },
        async: true,
        success: function(resultado){
            jQuery(elemento).parent().parent().siblings(".camp_form");
            jQuery(elemento).parent().parent().siblings(".camp_form").html("");
            jQuery(elemento).parent().parent().siblings(".camp_form").append(resultado);
        }
    });
}

function insertar_tabla(select_valor,elemento){
    valores = [];
    conteo_primario = jQuery(elemento).attr("data-count");
    jQuery(elemento).siblings().children("select").find("option").each(function(a,d)
    {
        if(jQuery(d).val() !== ""){
            valores.push(jQuery(d).val());
        }
    });

    var $valores = valores.filter(function($valores) {
        return $valores !== select_valor;
    });

    jQuery.ajax({
        url : tecnooptica.ajaxUrl,
        type: 'post',
        data: {
            action : 'segundo_campo',
            select_valores: $valores,
            valor_selected: select_valor,
            contador: conteo_primario,
        },
        async: true,
        success: function(resultado){
            jQuery("td#conte_seg_rang").show();
            jQuery(elemento).parents("td.cont_form").siblings("td.conte_seg_rang").show();
            jQuery(elemento).parents("td.cont_form").siblings("td.conte_seg_rang").append(resultado);
        }
    });
}

function insertar_tabla_tercer(select_valor, select_valor_secundario,elemento){
    valores = [];
    conteo_primario = jQuery(elemento).siblings().children("select").attr("data-count");
    jQuery(elemento).siblings().children("select").find("option").each(function(a,d) {
        if(jQuery(d).val() !== ""){
            valores.push(jQuery(d).val());
        }
    });

    var valores = valores.filter(function(valores) {
        return valores !== select_valor;
    });

    var valores = valores.filter(function(valores) {
        return valores !== select_valor_secundario;
    });

    conteo_hermanos = validar_hermanos(elemento);
    control = jQuery(this).parents("tr").siblings().find("a.otro_row").attr("data-count");
    conteo_primario = parseInt(conteo_primario) - parseInt(conteo_primario);
    if(parseInt(conteo_hermanos) > parseInt(conteo_primario)){
        conteo_primario = conteo_hermanos;
    }

    jQuery.ajax({
        url : tecnooptica.ajaxUrl,
        type: 'post',
        data: {
            action : 'insertar_tabla_terc',
            select_valores: valores,
            select_valor: select_valor,
            select_valor_secundario: select_valor_secundario,
            contador: conteo_primario,
            tipo_lente: jQuery("select#_tipo_lente").val(),
        },
        async: true,
        success: function(resultado){
            jQuery(elemento).parents("tr").children("td.conte_terc_rang").append(resultado);
            jQuery(elemento).parents("tr").children("td.conte_terc_rang").show();
            if(jQuery("select#_tipo_lente").val() === "bifocales" || jQuery("select#_tipo_lente").val() === "progresivos"){
                jQuery(elemento).attr("data-child","1");
                jQuery(elemento).attr("class","new_row_camp_terc");
            }
        }
    });
}

function insertar_tabla_cuart(select_valor, select_valor_secundario, select_valor_terciario,elemento){
    valores = [];
    conteo_primario = jQuery(elemento).parents("td").siblings("td.conte_cuart_rang").children().length;
    jQuery(elemento).siblings().children("select").find("option").each(function(a,d) {
        if(jQuery(d).val() !== ""){
            valores.push(jQuery(d).val());
        }
    });

    var valores = valores.filter(function(valores) {
        return valores !== select_valor;
    });

    var valores = valores.filter(function(valores) {
        return valores !== select_valor_secundario;
    });

    var valores = valores.filter(function(valores) {
        return valores !== select_valor_terciario;
    });


    jQuery.ajax({
        url : tecnooptica.ajaxUrl,
        type: 'post',
        data: {
            action : 'insertar_tabla_cuarta',
            select_valores: valores,
            select_valor: select_valor,
            select_valor_secundario: select_valor_secundario,
            select_valor_terciario: select_valor_terciario,
            contador: conteo_primario,
        },
        async: true,
        success: function(resultado){
            jQuery(elemento).parents("tr").children("td.conte_cuart_rang").append(resultado);
            jQuery(elemento).parents("tr").children("td.conte_cuart_rang").show();
        }
    });

}

function insertar_tr_tabla(select_valor,elemento,contador){
    valores = [];
    conteo_ = jQuery(elemento).siblings().children("select").attr("data-count");
    jQuery(elemento).siblings().children("select").find("option").each(function(a,d) {
        if(jQuery(d).val() !== ""){
            valores.push(jQuery(d).val());
        }
    });

    var valores = valores.filter(function(valores) {
        return valores !== select_valor;
    });

    jQuery.ajax({
        url : tecnooptica.ajaxUrl,
        type: 'post',
        data: {
            action : 'insertar_nuevo_row',
            select_valores: valores,
            select_valor: select_valor,
            contador: contador,
            tipo_vision: jQuery("select#_tipo_lente").val(),
        },
        async: true,
        success: function(resultado){
            jQuery("td.conte_seg_rang").show();
            jQuery(resultado).insertAfter(jQuery(elemento).parents("tbody").children("tr[data-primario='"+select_valor+"']").last())
        }
    });
}

function insertar_tercer_campo_row(valor_primario, valor_secundario, contador, elemento){
    valores = [];
    jQuery(elemento).siblings().children("select").find("option").each(function(a,d) {
        if(jQuery(d).val() !== ""){
            valores.push(jQuery(d).val())
        }
    });

    var valores = valores.filter(function(valores) {
        return valores !== valor_primario;
    });

    var valores = valores.filter(function(valores) {
        return valores !== valor_secundario;
    });

    jQuery.ajax({
        url : tecnooptica.ajaxUrl,
        type: 'post',
        data: {
            action : 'insertar_tabla_terc_row',
            select_valores: valores,
            select_valor: valor_primario,
            select_valor_secundario: valor_secundario,
            contador: contador,
        },
        async: true,
        success: function(resultado){
            jQuery(resultado).insertAfter(jQuery("tr[data-primario='"+valor_primario+"'][data-secundario='"+valor_secundario+"']").last());
            contador = contador_rowspan("data-primario",valor_primario, "data-secundario", valor_secundario);
            jQuery(elemento).parents("td").attr("rowspan", contador);
            jQuery(elemento).attr("data-child", contador);
            valor_busqueda = jQuery(elemento).parents("div.secc_two").find("._camp_rang_two").attr("campo-primario")
            jQuery(elemento).parents("tbody").find("._camp_rang_one").each(function(e,a){
                if(jQuery(a).val() === valor_busqueda){
                    contador = contador_rowspan("data-primario",valor_primario, "", "");
                    jQuery(a).parents("td").attr("rowspan", contador);
                }
            })
        }
    });
}

function validar_hermanos(elemeto){
    contador = 0;
    jQuery(elemeto).parent().parent().parent().siblings("td.conte_terc_rang").children().each(function(a,d) {
        if(parseInt(jQuery(d).children("div.secc_tree").find("select").attr("data-count")) > 0){
            contador = jQuery(d).children("div.secc_tree").find("select").attr("data-count");
        }
    });
    contador++;
    return contador;
}

function limpiar_hijos (elemento, elemento_anterior){
    jQuery(elemento).parents("td").siblings("td.conte_seg_rang").children().remove();
    jQuery(elemento).parents("td").siblings("td.conte_terc_rang").children().remove();
    jQuery(elemento).parents("td").siblings("td.conte_cuart_rang").children().remove();
    jQuery(elemento).parents("td").attr("rowspan", 1);
    console.log(jQuery(elemento).parents("td").siblings("td.conte_cuart_rang"));
    jQuery("table.matr_form tr[data-primario='"+elemento_anterior+"']").each(function(e,d){
        jQuery(d).remove();
    })
}

function validar_primer_rang(elemento, buscar_campos){
        hermanos = jQuery(elemento).parents("tr").children("td.conte_seg_rang").children().length;
        if(parseInt(hermanos) > 0 ){
            r = confirm("Si cambia el valor del campo se limpiara automaticamente todos los campos dependientes de este campo. Desea seguir adelante?");
            if(r === true){
                elemento_anterior = jQuery(elemento).attr("data-value");
                jQuery(elemento).parent().siblings("a.agregar_campo").show();
                jQuery(elemento).parent().siblings("a.otro_row").hide();
                limpiar_hijos(elemento ,elemento_anterior);
            }
            else{
                jQuery(elemento).val(buscar_campos);
                return r;
            }
        }
        else{
            return true;
        }
}

function validar_secund_rang(elemento, buscar_campos){
    hermanos = jQuery(elemento).parents("td").siblings("td.conte_terc_rang").children();
    elemento_anterior = jQuery(elemento).attr("data-value");
    if(parseInt(hermanos.length) > 0 ){
        r = confirm("Si cambia el valor del campo se limpiara automaticamente todos los campos dependientes de este campo. Desea seguir adelante?");
        if(r === true){
            jQuery(elemento).parents("td").attr("rowspan", 1);
            jQuery(elemento).parents("tr").siblings().each(function(k,w){
                if(jQuery(w).attr("data-secundario") === elemento_anterior){
                    if(jQuery(w).attr("class") !== "primer_rang rango_impar"){
                        jQuery(w).remove()
                    }
                }
            });
            hermanos.remove();
        }
        else{
            jQuery(elemento).val(buscar_campos);
            return r;
        }
    }
    else{
        return true;
    }
}

function validar_tercer_rang(elemento, buscar_campos){
    hermanos = jQuery(elemento).parents("td").siblings("td.conte_cuart_rang").children();
    if(parseInt(hermanos.length) > 0 ){
        r = confirm("Si cambia el valor del campo se limpiara automaticamente todos los campos dependientes de este campo. Desea seguir adelante?");
        if(r === true){

            hermanos.remove();
        }
        else{
            jQuery(elemento).val(buscar_campos);
            return r;
        }
    }
    else{
        return true;
    }
}

function agregar_nuevo_rango(elemento){
    conteo = jQuery(elemento).attr("data-count");
    tipo_vision = jQuery("select#_tipo_lente").val();
    jQuery.ajax({
        url : tecnooptica.ajaxUrl,
        type: 'post',
        data: {
            action : 'insertar_nuevo_rango',
            contador: conteo,
            tipo_vision: tipo_vision,
        },
        async: true,
        success: function(resultado){
            jQuery("table.matr_form tbody").append(resultado);
            jQuery(elemento).attr("data-count", parseInt(conteo)+1);
        }
    });
}

function contador_rowspan(campo_primario, valor_primario, campo_secundario, valor_secundario){

    if(campo_secundario !== ""){
        contador = jQuery('tr['+campo_primario+'="'+valor_primario+'"]['+campo_secundario+'="'+valor_secundario+'"]').length
    }
    else{
        contador = jQuery('tr['+campo_primario+'="'+valor_primario+'"]').length
    }

    return contador;
}