jQuery( window ).load(function() {
    let body_t = jQuery('body');

    jQuery("#guardar-miopia_o_hipermetropia").on("click", function(){
        let datos = validar_campos_rangos_formulas(this);
        if(parseInt(datos) != 0){
            jQuery.ajax({
                url : tecnooptica_lentes_contacto.ajaxUrl,
                type: 'post',
                data: {
                    action : 'insert_rang_form_miopia',
                    datos: datos,
                },
                async: true,
                success: function(resultado){
                    if(parseInt(resultado) !== 0) {
                        mensaje_exitoso = '<div class="alert alert-success" role="alert">\n' +
                            '                        Rangos de la fórmula <strong>Miopia e Hipermetropía</strong> guardados satisfactoriamente.\n' +
                            '                    </div>';
                        mostrar_mensaje(mensaje_exitoso);
                        setTimeout(function(){ location.reload() }, 3000);
                    }
                }
            });
        }
    });

    jQuery("#guardar-astigmatismo").on("click", function(){
        let datos = validar_campos_rangos_formulas(this);

        if(parseInt(datos) != 0){
            jQuery.ajax({
                url : tecnooptica_lentes_contacto.ajaxUrl,
                type: 'post',
                data: {
                    action : 'insert_rang_form_astigmatismo',
                    datos: datos,
                },
                async: true,
                success: function(resultado){
                    if(parseInt(resultado) !== 0) {
                        mensaje_exitoso = '<div class="alert alert-success" role="alert">\n' +
                            '                        Rangos de la fórmula <strong>Astigmatismo</strong> guardados satisfactoriamente.\n' +
                            '                    </div>';
                        mostrar_mensaje(mensaje_exitoso);
                        setTimeout(function(){ location.reload() }, 3000);
                    }
                }
            });
        }
    });

    jQuery("nav#cam_vision").on("click","a", function(){
        jQuery("nav#cam_vision a").removeClass("nav-tab-active");
        jQuery(".content-form div").hide();
        jQuery(".content-form div#"+jQuery(this).attr("id")+"").show();
        jQuery(".content-form div#descripcion_"+jQuery(this).attr("id")+"").show();
        jQuery(this).addClass("nav-tab-active");
    });

    jQuery("[name^='rango-bajo']").on("keyup", function(){
        if(jQuery(this).val() !== "") {
            valor_alto_siguiente = jQuery(this).parent().siblings().children("input[name^='rango-alto']").val()
            if(valor_alto_siguiente !== "" || jQuery(this).val() !== "") {
                if (parseInt(valor_alto_siguiente) < parseInt(jQuery(this).val())) {
                    if (is_negative_number(jQuery(this).val()) === false) {
                        jQuery(this).val("")
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

    jQuery("[name^='rango-alto']").on("keyup", function(){
        if(jQuery(this).val() !== "") {
            valor_bajo_siguiente = jQuery(this).parent().siblings().children("input[name^='rango-bajo']").val();
            if(valor_bajo_siguiente !== "" || jQuery(this).val() !== "" ) {
                if (parseInt(jQuery(this).val()) < parseInt(valor_bajo_siguiente)) {
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

});

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

function mostrar_mensaje(mensaje_error){
    mensaje = jQuery("#mensaje");
    mensaje.show();
    mensaje.append(mensaje_error);
    jQuery(".alert").fadeOut( 12000, function(){
        mensaje.html("");
    } )
}

function validar_campos_rangos_formulas(data) {
    var datos = new Object();
    jQuery(data).parents("tbody").find("input").each(function(e,d){
        if(parseInt(jQuery(d).val().length) === 0){
            mensaje_error  = '<div class="alert alert-danger" role="alert">\n' +
                '                        El campo '+jQuery(d).attr("data-name")+' se encuentra <strong>vacío!</strong>. Debes agregar un valor positivo para el rango antes de guardar\n' +
                '                    </div>';
            mostrar_mensaje(mensaje_error);
            jQuery(d).attr("class","error_alert");
            return 0;
        }
        else{
            jQuery(d).removeClass("error_alert");
            datos[jQuery(d).attr("name")] = jQuery(d).val();
        }
    });

    return datos;
}