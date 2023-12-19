jQuery( window ).load(function() {
    jQuery("body").on("keyup","#precio_filtro",function() {
        valor = jQuery(this);
        if (parseInt(valor.val().length) !== 0) {
            contenedor_anch = valor;
            var offset = valor.position();
            respuesta = is_positiv_number(valor.val());
            contenedor_anch = jQuery("._regular_price_filtro");
            if (respuesta !== true) {
                mensaje_error = '<div class="wc_error_tip i18n_mon_decimal_error"">\n' +
                    '    Escribe en formato monetario decimal (.) sin separador de miles ni símbolos de moneda.\n' +
                    '</div>';
                contenedor_anch.append(mensaje_error);
                console.log(mensaje_error);
                valor.parent().find('.wc_error_tip')
                    .css('left', offset.left + valor.width() - (valor.width() / 2) - (jQuery('.wc_error_tip').width() / 2))
                    .css('top', offset.top + valor.height())
                    .fadeIn('100');
                valor.val("");
            }
            else {
                valor.parent().find('.wc_error_tip').remove();
            }
        }
    });

    jQuery('body').on("keyup", "input#tonalidad_filtro",function(){
        if(jQuery(this).val() > 85 || jQuery(this).val() < 5){
            if(jQuery(this).attr("name") === "tonalidad_filtro_rango_mayor"){
                alert("Disculpe pero la tonalidad maxima es 85");
            }
            else{
                alert("Disculpe pero la tonalidad minima es 5");
            }
            jQuery(this).val("");
        }
    });

    jQuery('body').on("change", "input#shade_option_no",function(){
        if(jQuery(this).is(':checked') ) {
            jQuery("._regular_tonalidad_filtro").show();
            jQuery("#ejemplo_tonalidad").show();
        }
        else{
            jQuery("._regular_tonalidad_filtro").hide();
            jQuery("#ejemplo_tonalidad").hide();
        }

    });
});

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