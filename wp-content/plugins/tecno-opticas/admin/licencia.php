<?php
/**
 * Created by PhpStorm.
 * User: DESAR01
 * Date: 5/11/2021
 * Time: 1:18 PM
 */

if (! current_user_can ('manage_options')) wp_die (__('No tienes suficientes permisos para acceder a esta página.', 'tecno-opticas'));

if(get_option('tecnooptica-verifi_licen')){
    $licencia = get_option('tecnooptica-verifi_licen');
}
else{
    $licencia = "";
}

if(TECNO_OPTICAS_LICENSE['estado'] == "error"){
    $mensaje = ' 
        <div class="alert alert-'.TECNO_OPTICAS_LICENSE['estado'].'" role="alert">
            '.TECNO_OPTICAS_LICENSE['mensaje'].'
        </div>
    ';
}
else{
    $mensaje = "";
}

?>
    <div class="wrap woocommerce">
        <div class="content-form">

            <div id="mensaje"><?php echo $mensaje; ?></div>

            <div id="licencia" class="content licencia_form">
                <h2><?php _e('Activación del módulo', 'tecno-opticas'); ?> <!-- para: --><?php /*echo $_SERVER['SERVER_NAME']; */?></h2>
                <div id="descripcion_licencia" class="licencia_form">
                    <p>
                        <?php _e('Ingrese el código de su licencia', 'tecno-opticas'); ?>                        
                    </p>
                </div>

                <table class="form-table">
                    <tr>
                        <th class="titledesc">
                            <label for=""><?php _e('License Key', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="forminp forminp-text">
                            <input id="licencia_key" type="text" value="<?php echo $licencia; ?>" name="license_key" title="License Key">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <button id="guardar-licencia" class="button-primary woocommerce-save-button" value="Guardar los cambios">
                                <?php _e('Activar', 'tecno-opticas'); ?>
                            </button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <script>
        jQuery( window ).load(function() {
            let body_t = jQuery('body');

            body_t.on("click", "#guardar-licencia",function(){
                img_loader = '<img id="loader_optica" src="'+tecnooptica.ajaxLoaderImage+'" alt="Cargabdi">';
                valor = jQuery("#licencia_key").val();

                if(parseInt(valor.length) != 0){

                    jQuery(this).text("Consultando");
                    jQuery(this).append(img_loader);
                    jQuery(this).attr("id","consultando");
                    jQuery.ajax({
                        url : tecnooptica.ajaxUrl,
                        type: 'post',
                        data: {
                            action : 'validar_licencia',
                            licencia: valor,
                        },
                        async: true,
                        success: function(resultado){
                            let datos = JSON.parse(resultado);
                            mostrar_mensaje(datos['mensaje']);
                            if(datos['estado'] === "success"){
                                jQuery("div#tecno-optica-noticia").remove();
                                window.location.href = location.protocol + '//' + window.location.host + '/wp-admin/admin.php?page=tecno-opticas%2Fadmin%2Fajustes_modulo.php';
                            }
                            else{
                                jQuery("#loader_optica").remove();
                                jQuery("button#consultando").text("Activar");
                                jQuery("button#consultando").attr("id","guardar-licencia");
                            }
                        }
                    });
                }
                else{
                    alert("<?php _e('Agrega algo en el campo licencia', 'tecno-opticas'); ?>");
                }
            });
        });
    </script>
<?php

?>