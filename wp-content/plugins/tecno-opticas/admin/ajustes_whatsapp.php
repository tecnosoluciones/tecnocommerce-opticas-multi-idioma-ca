<?php
/**
 * Created by PhpStorm.
 * User: DESAR01
 * Date: 27/10/2021
 * Time: 4:12 PM
 */

if (! current_user_can ('manage_options')) wp_die (__('No tienes suficientes permisos para acceder a esta página.', 'tecno-opticas'));
?>
<div class="wrap">
    <p><img src="<?php echo get_site_url(); ?>/wp-content/plugins/tecno-opticas/images/ts_logo.png" alt="Tecno-Soluciones" title="Tecno-Soluciones"></p>
    <h2><?php _e( 'Tecno Ópticas', 'tecno-opticas' ) ?></h2>
</div>
<?php

$settings = array(
    'quicktags' => true,
    'tinymce' => true,
    'media_buttons' => false,
    'textarea_rows' => 10,
    'editor_css' => '',
    'editor_class' => '',
    'teeny' => true,
    'dfw' => false,
);

function configurar_whatsapp(){
    if(!get_option("tecnooptica-num-whatsapp")){
        add_option("tecnooptica-num-whatsapp", $_POST['numero_whatsapp'], "", 'no');
    }else{
        update_option("tecnooptica-num-whatsapp", $_POST['numero_whatsapp'], 'no');
    }

    $text_whatsapp = str_replace(" ","%20",$_POST['mensaje_whatsapp']);

    if(!get_option("tecnooptica-text-whatsapp")){
        add_option("tecnooptica-text-whatsapp", $text_whatsapp, "", 'no');
    }else{
        update_option("tecnooptica-text-whatsapp", $text_whatsapp, 'no');
    }

    $mensaje = "
        <script type='text/javascript'>
            jQuery('.alert').fadeOut( 12000, function(){
                    jQuery('#mensaje').html('');
                } )
        </script>
    
    ";

    return '<div class="alert alert-success" role="alert"><strong>'.__("Configuración de Whatsapp guardados exitosamente", "tecno-opticas").'</strong> </div>'.$mensaje.'';

}


if(isset($_POST['option_page'])){
    $mensaje = configurar_whatsapp();
}
else{
    $mensaje = "";
}
?>

<div class="wrap woocommerce">
    <nav class="nav-tab-wrapper woo-nav-tab-wrapper" id="cam_vision">
        <a href="admin.php?page=tecno-opticas%2Fadmin%2Fajustes_modulo.php" class="nav-tab" id="descripci_tipo_lente"><?php _e('Ajustes Generales', 'tecno-opticas'); ?></a>
        <a href="admin.php?page=tecno-opticas%2Fadmin%2Fdescripcion_tipos.php" class="nav-tab" id="descripci_tipo_lente"><?php _e('Descripción Tipos de Visión', 'tecno-opticas'); ?></a>
        <a href="admin.php?page=tecno-opticas%2Fadmin%2Fajustes.php" class="nav-tab" id="mensaje_proces"><?php _e('Mensajes', 'tecno-opticas'); ?></a>
        <a href="admin.php?page=tecno-opticas%2Fadmin%2Fajustes_whatsapp.php" class="nav-tab nav-tab-active" id="whatsapp"><?php _e('Configuración de WhatsApp', 'tecno-opticas'); ?></a>
    </nav>
    <div class="content-form">

        <div id="" class="content">
            <h2><?php  _e('Configuración de Whatsapp', 'tecno-opticas'); ?></h2>
            <div id="descripci_ajustes" class="ajustes">
                <p>
                    <?php  _e('Aquí usted debe configurar el número de whatsapp y el mensaje que se va a mostrar.', 'tecno-opticas'); ?>
                </p>
            </div>
            <form id="guardar_ajustes" method="post" action="admin.php?page=tecno-opticas%2Fadmin%2Fajustes_whatsapp.php">
                <?php settings_fields('tecnooptica-setup'); ?>
                <?php do_settings_sections('tecnooptica-setup'); ?>
                <table class="table_ajustes">
                    <tr>
                        <th class="">
                            <label for="">
                            <?php  _e('Número de Whatsapp', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="editor_ajustes">
                            <p class="form-field numero_whatsapp_field num_whatsapp">
                                <label for="numero_whatsapp"></label><input type="text" class="num_whatsapp" style="" name="numero_whatsapp" id="numero_whatsapp" value="<?php echo get_option('tecnooptica-num-whatsapp'); ?>" placeholder=""> </p>
                        </td>
                    </tr>
                    <tr>
                        <th class="">
                           <label for=""><?php  _e('Mensaje de WhatsApp', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="editor_ajustes">
                            <p class="form-field mensaje_whatsapp_field ">
                                <textarea class="short" style="" name="mensaje_whatsapp" id="mensaje_whatsapp" placeholder="" rows="2" cols="20"><?php echo str_replace("%20"," ",get_option('tecnooptica-text-whatsapp'));?></textarea>
                            </p>
                            <input type="hidden" class="" name="whatsapp" id="whatsapp" value="whatsapp">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button type="submit" id="guardar_ajustes" class="button-primary woocommerce-save-button" value="Guardar whatsapp"><?php  _e('Guardar los cambios', 'tecno-opticas'); ?></button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>

    </div>
