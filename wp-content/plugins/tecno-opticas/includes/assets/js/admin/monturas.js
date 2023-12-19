jQuery( window ).load(function() {
    jQuery("#_ancho_montura").on("keyup",function(){
        valor = jQuery(this);
        contenedor_anch = jQuery("._ancho_montura_montura");
        var offset = valor.position();
        mensaje_error = '<div class="wc_error_tip i18n_mon_decimal_error"">\n' +
            '    Escribe en formato númerico decimal (.), este campo no permite letras.\n' +
            '</div>';
        if(valor.val()) {
            if(is_positiv_number(valor.val()) !== false){
                valor.parent().find( '.wc_error_tip' ).remove()
            }
            else{
                valor.val("");
                contenedor_anch.append(mensaje_error);
                valor.parent().find( '.wc_error_tip' )
                    .css( 'left', offset.left + valor.width() - ( valor.width() / 2 ) - ( jQuery( '.wc_error_tip' ).width() / 2 ) )
                    .css( 'top', offset.top + valor.height() )
                    .fadeIn( '100' );
            }
        }
    });

    jQuery("#_ancho_puente").on("keyup",function(){
        valor = jQuery(this);
        contenedor_anch = jQuery("._puente_montura");
        var offset = valor.position();
        mensaje_error = '<div class="wc_error_tip i18n_mon_decimal_error"">\n' +
            '    Escribe en formato númerico decimal (.), este campo no permite letras.\n' +
            '</div>';
        if(valor.val()) {
            if(is_positiv_number(valor.val()) !== false){
                valor.parent().find( '.wc_error_tip' ).remove()
            }
            else{
                valor.val("");
                contenedor_anch.append(mensaje_error);
                valor.parent().find( '.wc_error_tip' )
                    .css( 'left', offset.left + valor.width() - ( valor.width() / 2 ) - ( jQuery( '.wc_error_tip' ).width() / 2 ) )
                    .css( 'top', offset.top + valor.height() )
                    .fadeIn( '100' );
            }
        }
    });

    jQuery("#_ancho_mica").on("keyup",function(){
        valor = jQuery(this);
        contenedor_anch = jQuery("._ancho_mica_montura");
        var offset = valor.position();
        mensaje_error = '<div class="wc_error_tip i18n_mon_decimal_error"">\n' +
            '    Escribe en formato númerico decimal (.), este campo no permite letras.\n' +
            '</div>';
        if(valor.val()) {
            if(is_positiv_number(valor.val()) !== false){
                valor.parent().find( '.wc_error_tip' ).remove()
            }
            else{
                valor.val("");
                contenedor_anch.append(mensaje_error);
                valor.parent().find( '.wc_error_tip' )
                    .css( 'left', offset.left + valor.width() - ( valor.width() / 2 ) - ( jQuery( '.wc_error_tip' ).width() / 2 ) )
                    .css( 'top', offset.top + valor.height() )
                    .fadeIn( '100' );
            }
        }
    });

    jQuery("#_alto_mica").on("keyup",function(){
        valor = jQuery(this);
        contenedor_anch = jQuery("._alto_mica_montura");
        var offset = valor.position();
        mensaje_error = '<div class="wc_error_tip i18n_mon_decimal_error"">\n' +
            '    Escribe en formato númerico decimal (.), este campo no permite letras.\n' +
            '</div>';
        if(valor.val()) {
            if(is_positiv_number(valor.val()) !== false){
                valor.parent().find( '.wc_error_tip' ).remove()
            }
            else{
                valor.val("");
                contenedor_anch.append(mensaje_error);
                valor.parent().find( '.wc_error_tip' )
                    .css( 'left', offset.left + valor.width() - ( valor.width() / 2 ) - ( jQuery( '.wc_error_tip' ).width() / 2 ) )
                    .css( 'top', offset.top + valor.height() )
                    .fadeIn( '100' );
            }
        }
    });

    jQuery("#_brazo").on("keyup",function(){
        valor = jQuery(this);
        contenedor_anch = jQuery("._brazo_montura");
        var offset = valor.position();
        mensaje_error = '<div class="wc_error_tip i18n_mon_decimal_error"">\n' +
            '    Escribe en formato númerico decimal (.), este campo no permite letras.\n' +
            '</div>';
        if(valor.val()) {
            if(is_positiv_number(valor.val()) !== false){
                valor.parent().find( '.wc_error_tip' ).remove()
            }
            else{
                valor.val("");
                contenedor_anch.append(mensaje_error);
                valor.parent().find( '.wc_error_tip' )
                    .css( 'left', offset.left + valor.width() - ( valor.width() / 2 ) - ( jQuery( '.wc_error_tip' ).width() / 2 ) )
                    .css( 'top', offset.top + valor.height() )
                    .fadeIn( '100' );
            }
        }
    });

    jQuery("#_peso").on("keyup",function(){
        valor = jQuery(this);
        contenedor_anch = jQuery("._peso_montura");
        var offset = valor.position();
        mensaje_error = '<div class="wc_error_tip i18n_mon_decimal_error"">\n' +
            '    Escribe en formato númerico decimal (.), este campo no permite letras.\n' +
            '</div>';
        if(valor.val()) {
            if(is_positiv_number(valor.val()) !== false){
                valor.parent().find( '.wc_error_tip' ).remove()
            }
            else{
                valor.val("");
                contenedor_anch.append(mensaje_error);
                valor.parent().find( '.wc_error_tip' )
                    .css( 'left', offset.left + valor.width() - ( valor.width() / 2 ) - ( jQuery( '.wc_error_tip' ).width() / 2 ) )
                    .css( 'top', offset.top + valor.height() )
                    .fadeIn( '100' );
            }
        }
    });
});