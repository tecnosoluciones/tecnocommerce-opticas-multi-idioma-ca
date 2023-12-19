<?php
/**
 * Created by PhpStorm.
 * User: DESAR01
 * Date: 27/10/2021
 * Time: 4:21 PM
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

function configurar_descripcion(){

    update_option("tecnooptica-descripcion_descanso", $_POST['descripcion_descanso'], 'no');
    update_option("tecnooptica-descripcion_vision_sencilla", $_POST['descripcion_vision_sencilla'], 'no');
    update_option("tecnooptica-descripcion_progresivo", $_POST['descripcion_progresivo'], 'no');
    update_option("tecnooptica-descripcion_bifocales", $_POST['descripcion_bifocales'], 'no');
    update_option("tecnooptica-descripcion_ocupacionales", $_POST['descripcion_ocupacionales'], 'no');


    $mensaje = "
        <script type='text/javascript'>
            jQuery('.alert').fadeOut( 12000, function(){
                    jQuery('#mensaje').html('');
                } )
        </script>
    
    ";

    return '<div class="alert alert-success" role="alert"><strong>'.__("Descripciones guardadas exitosamente", "tecno-opticas").'</strong></div>'.$mensaje.'';

}


if(isset($_POST['option_page'])){
    $mensaje = configurar_descripcion();
}
else{
    $mensaje = "";
}
?>

<div class="wrap woocommerce">
    <nav class="nav-tab-wrapper woo-nav-tab-wrapper" id="cam_vision">
        <a href="admin.php?page=tecno-opticas%2Fadmin%2Fajustes_modulo.php" class="nav-tab" id="descripci_tipo_lente"><?php _e('Ajustes Generales', 'tecno-opticas'); ?></a>
        <a href="admin.php?page=tecno-opticas%2Fadmin%2Fdescripcion_tipos.php" class="nav-tab nav-tab-active" id="descripci_tipo_lente"><?php _e('Descripción Tipos de Visión', 'tecno-opticas'); ?></a>
        <a href="admin.php?page=tecno-opticas%2Fadmin%2Fajustes.php" class="nav-tab" id="mensaje_proces"><?php _e('Mensajes', 'tecno-opticas'); ?></a>
        <a href="admin.php?page=tecno-opticas%2Fadmin%2Fajustes_whatsapp.php" class="nav-tab" id="whatsapp"><?php _e('Configuración de WhatsApp', 'tecno-opticas'); ?></a>
    </nav>
    <div class="content-form">

        <div id="" class="content">
            <div id="descripci_ajustes" class="ajustes">
                <p>
                <?php _e('Aquí usted debe configurar la descripción para los tipos de visión.', 'tecno-opticas'); ?>
                </p>
            </div>
            <form id="guardar_ajustes" method="post" action="admin.php?page=tecno-opticas%2Fadmin%2Fdescripcion_tipos.php">
                <?php settings_fields('tecnooptica-setup'); ?>
                <?php do_settings_sections('tecnooptica-setup'); ?>
                <table class="table_ajustes">
                    <?php
                    if(get_option('tecnooptica-setupexclude_form_descanso') == "yes"){
                        ?>
                        <tr>
                            <th class="">
                                <label for=""><?php _e('Descanso', 'tecno-opticas'); ?></label>
                            </th>
                            <td class="editor_ajustes">
                                <p class="form-field mensaje_whatsapp_field ">
                                    <?php wp_editor(stripslashes(get_option('tecnooptica-descripcion_descanso')), "descripcion_descanso", $settings); ?>
                                </p>
                            </td>
                        </tr>
                        <?php
                    }
                    if(get_option('tecnooptica-setupexclude_form_vs') == "yes"){
                        ?>
                        <tr>
                            <th class="">
                                <label for=""><?php _e('Visión Sencilla', 'tecno-opticas'); ?></label>
                            </th>
                            <td class="editor_ajustes">
                                <p class="form-field numero_whatsapp_field num_whatsapp">
                                    <?php wp_editor(stripslashes(get_option('tecnooptica-descripcion_vision_sencilla')), "descripcion_vision_sencilla", $settings); ?>
                            </td>
                        </tr>
                        <?php
                    }
                    if(get_option('tecnooptica-setupexclude_form_progresivo') == "yes"){
                        ?>
                        <tr>
                            <th class="">
                                <label for=""><?php _e('Progresivos', 'tecno-opticas'); ?></label>
                            </th>
                            <td class="editor_ajustes">
                                <p class="form-field mensaje_whatsapp_field ">
                                    <?php wp_editor(stripslashes(get_option('tecnooptica-descripcion_progresivo')), "descripcion_progresivo", $settings); ?>
                                </p>
                            </td>
                        </tr>
                        <?php
                    }
                    if(get_option('tecnooptica-setupexclude_form_bifocales') == "yes"){
                        ?>
                        <tr>
                            <th class="">
                                <label for=""><?php _e('Bifocales', 'tecno-opticas'); ?></label>
                            </th>
                            <td class="editor_ajustes">
                                <p class="form-field mensaje_whatsapp_field ">
                                    <?php wp_editor(stripslashes(get_option('tecnooptica-descripcion_bifocales')), "descripcion_bifocales", $settings); ?>
                                </p>
                            </td>
                        </tr>
                        <?php
                    }
                    if(get_option('tecnooptica-setupexclude_form_ocupacionales') == "yes") {
                        ?>
                        <tr>
                            <th class="">
                                <label for=""><?php _e('Ocupacionales', 'tecno-opticas'); ?></label>
                            </th>
                            <td class="editor_ajustes">
                                <p class="form-field mensaje_whatsapp_field ">
                                    <?php wp_editor(stripslashes(get_option('tecnooptica-descripcion_ocupacionales')), "descripcion_ocupacionales", $settings); ?>
                                </p>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    <tr>
                        <td colspan="2">
                            <button type="submit" id="guardar_ajustes" class="button-primary woocommerce-save-button" value="Guardar whatsapp">
                            <?php _e('Guardar los cambios', 'tecno-opticas'); ?>
                            </button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>

    </div>
