<?php
/**
 * Created by PhpStorm.
 * User: DESAR01
 * Date: 13/09/2021
 * Time: 3:21 PM
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

function  register_th_plugin_settings() {

    if(get_option('tecnooptica-tipo_proceso_compra') == "opcion_1") {
        update_option("tecnooptica-setup_mensaje_0", $_POST['mensaje_0'], 'no');
        update_option("tecnooptica-setup_paso_1", $_POST['paso_1'], 'no');
        update_option("tecnooptica-setup_descripcion_paso_1", $_POST['descripcion_paso_1'], 'no');
        update_option("tecnooptica-setup_paso_2", $_POST['paso_2'], 'no');
        update_option("tecnooptica-setup_descripcion_paso_2", $_POST['descripcion_paso_2'], 'no');
        update_option("tecnooptica-setup_paso_3", $_POST['paso_3'], 'no');
        update_option("tecnooptica-setup_descripcion_paso_3", $_POST['descripcion_paso_3'], 'no');
        update_option("tecnooptica-setup_paso_4", $_POST['paso_4'], 'no');
        update_option("tecnooptica-setup_descripcion_paso_4", $_POST['descripcion_paso_4'], 'no');
        update_option("tecnooptica-setup_paso_5", $_POST['paso_5'], 'no');
        update_option("tecnooptica-setup_descripcion_paso_5", $_POST['descripcion_paso_5'], 'no');
        update_option("tecnooptica-setup_paso_6", $_POST['paso_6'], 'no');
        update_option("tecnooptica-setup_descripcion_paso_6", $_POST['descripcion_paso_6'], 'no');
        update_option("tecnooptica-setup_paso_7", $_POST['paso_7'], 'no');
        update_option("tecnooptica-setup_descripcion_paso_7", $_POST['descripcion_paso_7'], 'no');
        update_option("tecnooptica-setup_error_paso_2", $_POST['error_paso_3'], 'no');
    }
    else {
        update_option("tecnooptica-setup_mensaje_0", $_POST['mensaje_0'], 'no');
        update_option("tecnooptica-setup_mensaje_paso_inicio", $_POST['mensaje_inicial'], 'no');
        update_option("tecnooptica-setup_mensaje_paso_1", $_POST['mensaje_1'], 'no');
        update_option("tecnooptica-setup_mensaje_paso_2", $_POST['mensaje_2'], 'no');
        update_option("tecnooptica-setup_mensaje_paso_3", $_POST['mensaje_3'], 'no');
        update_option("tecnooptica-setup_mensaje_paso_4", $_POST['mensaje_4'], 'no');
        update_option("tecnooptica-setup_mensaje_paso_5", $_POST['mensaje_5'], 'no');
        update_option("tecnooptica-setup_mensaje_paso_6", $_POST['mensaje_6'], 'no');
        update_option("tecnooptica-setup_mensaje_error_tintura", $_POST['mensaje_error_tintura'], 'no');
        update_option("tecnooptica-setup_mensaje_error_tonalidad", $_POST['mensaje_error_tonalidad'], 'no');
        update_option("tecnooptica-setup_mensaje_error_plantilla", $_POST['mensaje_error_plantilla'], 'no');
        update_option("tecnooptica-setup_mensaje_proceso_listo", $_POST['mensaje_proceso_listo'], 'no');
    }

    $mensaje = "
        <script type='text/javascript'>
            jQuery('.alert').fadeOut( 12000, function(){
                    jQuery('#mensaje').html('');
                } )
        </script>
    
    ";

    return '<div class="alert alert-success" role="alert"><strong>'.__("Mensajes", "tecno-opticas").'</strong> '.__("para el proceso de compra almacenados correctamente", "tecno-opticas").'</div>'.$mensaje.'';

}

if(isset($_POST['option_page'])){
    $mensaje = register_th_plugin_settings();
}
else{
    $mensaje = "";
}



if(get_option("tecnooptica-tipo_proceso_compra")){
    $opcion_proceso_compra = get_option('tecnooptica-tipo_proceso_compra');
}
else {
    $opcion_proceso_compra = "opcion_1";
}

if(get_option('tecnooptica-tipo_proceso_compra') == "opcion_2"){
    $setup_mensaje_paso_inicio = __("Por favor lee el proceso indicado arriba para que conozcas cómo vamos a configurar tu montura formulada. Luego haz clic en el botón Continuar.", 'tecno-opticas');
    $setup_mensaje_paso_1= __("1. Ahora debes seleccionar uno de nuestros tipos de lentes para pasar al siguiente paso.", 'tecno-opticas');
    $setup_mensaje_paso_2= __("2. Gracias por tu elección. Para avanzar al siguiente paso haz clic en el botón Continuar.", 'tecno-opticas');
    $setup_mensaje_paso_3= __("3. Bien, ahora debes llenar TODOS los campos de tu fórmula para poder seguir adelante. Por favor nota que también debes cargar la imagen de la prescripción de la fórmula. Una vez que hayas llenado todo, haz clic en el botón continuar.", 'tecno-opticas');
    $setup_mensaje_paso_4= __("4. Bien avancemos al siguiente paso, haz clic en el botón Continuar.", 'tecno-opticas');
    $setup_mensaje_paso_5= __("5. Selecciona las características de lentes que prefieras para seguir avanzando.", 'tecno-opticas');
    $setup_mensaje_paso_6= __("6. Bien ya tienes la característica de los lentes que quieres, haz clic en el botón Continuar.", 'tecno-opticas');
    $setup_mensaje_error_plantilla= __("Oye, te faltó la plantilla de la fórmula, pero tranquilo está en rojo para señalártelo, recuerda hacer clic en el botón confirmar fórmula.", 'tecno-opticas');
    $setup_mensaje_proceso_listo= __("Ya estás listo para realizar la compra de tus gafas formuladas. Ahora solo debes hacer clic en Comprar para agregarlas a tu carrito.", 'tecno-opticas');

    if(!get_option("tecnooptica-setup_mensaje_paso_inicio")){
        add_option("tecnooptica-setup_mensaje_paso_inicio", $setup_mensaje_paso_inicio, "", 'no');
    }

    if(!get_option("tecnooptica-setup_mensaje_paso_1")){
        add_option("tecnooptica-setup_mensaje_paso_1", $setup_mensaje_paso_1, "", 'no');
    }
    if(!get_option("tecnooptica-setup_mensaje_paso_2")){
        add_option("tecnooptica-setup_mensaje_paso_2", $setup_mensaje_paso_2, "", 'no');
    }
    if(!get_option("tecnooptica-setup_mensaje_paso_3")){
        add_option("tecnooptica-setup_mensaje_paso_3", $setup_mensaje_paso_3, "", 'no');
    }
    if(!get_option("tecnooptica-setup_mensaje_paso_4")){
        add_option("tecnooptica-setup_mensaje_paso_4", $setup_mensaje_paso_4, "", 'no');
    }
    if(!get_option("tecnooptica-setup_mensaje_paso_5")){
        add_option("tecnooptica-setup_mensaje_paso_5", $setup_mensaje_paso_5, "", 'no');
    }
    if(!get_option("tecnooptica-setup_mensaje_paso_6")){
        add_option("tecnooptica-setup_mensaje_paso_6", $setup_mensaje_paso_6, "", 'no');
    }
    if(!get_option("tecnooptica-setup_mensaje_error_tintura")){
        add_option("tecnooptica-setup_mensaje_error_tintura", $setup_mensaje_paso_7, "", 'no');
    }
    if(!get_option("tecnooptica-setup_mensaje_error_tonalidad")){
        add_option("tecnooptica-setup_mensaje_error_tonalidad", $setup_mensaje_paso_8, "", 'no');
    }
    if(!get_option("tecnooptica-setup_mensaje_error_plantilla")){
        add_option("tecnooptica-setup_mensaje_error_plantilla", $setup_mensaje_error_plantilla, "", 'no');
    }
    if(!get_option("tecnooptica-setup_mensaje_proceso_listo")){
        add_option("tecnooptica-setup_mensaje_proceso_listo", $setup_mensaje_proceso_listo, "", 'no');
    }
}
?>

<div class="wrap woocommerce">
    <nav class="nav-tab-wrapper woo-nav-tab-wrapper" id="cam_vision">
        <a href="admin.php?page=tecno-opticas%2Fadmin%2Fajustes_modulo.php" class="nav-tab" id="descripci_tipo_lente"><?php _e('Ajustes Generales', 'tecno-opticas'); ?></a>
        <a href="admin.php?page=tecno-opticas%2Fadmin%2Fdescripcion_tipos.php" class="nav-tab" id="descripci_tipo_lente"><?php _e('Descripción Tipos de Visión', 'tecno-opticas'); ?></a>
        <a href="admin.php?page=tecno-opticas%2Fadmin%2Fajustes.php" class="nav-tab nav-tab-active" id="mensaje_proces"><?php _e('Mensajes', 'tecno-opticas'); ?></a>
        <a href="admin.php?page=tecno-opticas%2Fadmin%2Fajustes_whatsapp.php" class="nav-tab" id="whatsapp"><?php _e('Configuración de WhatsApp', 'tecno-opticas'); ?></a>
    </nav>
    <div class="content-form">

    <div class="config_mensajes">

        <div id="mensaje"><?php echo $mensaje; ?></div>

        <div id="" class="content">
            <h2><?php _e('Configuración de mensajes para el proceso de compra', 'tecno-opticas'); ?></h2>
            <div id="descripci_ajustes" class="ajustes">
                <p>
                    <?php _e('Aquí usted debe configurar los mensajes que guiarán a los clientes a través del proceso de compra de las gafas con lentes formulados.', 'tecno-opticas'); ?>
                </p>
            </div>
            <form id="guardar_ajustes" method="post" action="admin.php?page=tecno-opticas%2Fadmin%2Fajustes.php">
                <?php settings_fields('tecnooptica-setup'); ?>
                <?php do_settings_sections('tecnooptica-setup'); ?>
                <table class="table_ajustes">
                    <tr>
                        <th class="">
                            <label for=""><?php _e('BIENVENIDA', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="editor_ajustes">
                            <?php wp_editor(stripslashes(get_option('tecnooptica-setup_mensaje_0')), "mensaje_0", $settings ); ?>
                        </td>
                    </tr>
                    <?php
                    if($opcion_proceso_compra == "opcion_1"){ ?>
                    <tr>
                        <th class="">
                            <label for=""><?php _e('PASO 1', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="editor_ajustes">
                            <?php wp_editor(stripslashes(get_option('tecnooptica-setup_paso_1')), "paso_1", $settings ); ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="">
                            <label for=""><?php _e('Descripción para el PASO 1', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="editor_ajustes">
                            <?php wp_editor(stripslashes(get_option('tecnooptica-setup_descripcion_paso_1')), "descripcion_paso_1", $settings ); ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="">
                            <label for=""><?php _e('PASO 2', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="editor_ajustes">
                            <?php wp_editor(stripslashes(get_option('tecnooptica-setup_paso_2')), "paso_2", $settings ); ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="">
                            <label for=""><?php _e('Descripción para el PASO 2', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="editor_ajustes">
                            <?php wp_editor(stripslashes(get_option('tecnooptica-setup_descripcion_paso_2')), "descripcion_paso_2", $settings ); ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="">
                            <label for=""><?php _e('PASO 3', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="editor_ajustes">
                            <?php wp_editor(stripslashes(get_option('tecnooptica-setup_paso_3')), "paso_3", $settings ); ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="">
                            <label for=""><?php _e('Descripción para el PASO 3', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="editor_ajustes">
                            <?php wp_editor(stripslashes(get_option('tecnooptica-setup_descripcion_paso_3')), "descripcion_paso_3", $settings ); ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="">
                            <label for=""><?php _e('PASO 4', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="editor_ajustes">
                            <?php wp_editor(stripslashes(get_option('tecnooptica-setup_paso_4')), "paso_4", $settings ); ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="">
                            <label for=""><?php _e('Descripción para el PASO 4', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="editor_ajustes">
                            <?php wp_editor(stripslashes(get_option('tecnooptica-setup_descripcion_paso_4')), "descripcion_paso_4", $settings ); ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="">
                            <label for=""><?php _e('PASO 5', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="editor_ajustes">
                            <?php wp_editor(stripslashes(get_option('tecnooptica-setup_paso_5')), "paso_5", $settings ); ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="">
                            <label for=""><?php _e('Descripción para el PASO 5', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="editor_ajustes">
                            <?php wp_editor(stripslashes(get_option('tecnooptica-setup_descripcion_paso_5')), "descripcion_paso_5", $settings ); ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="">
                            <label for=""><?php _e('PASO 6', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="editor_ajustes">
                            <?php wp_editor(stripslashes(get_option('tecnooptica-setup_paso_6')), "paso_6", $settings ); ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="">
                            <label for=""><?php _e('Descripción para el PASO 6', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="editor_ajustes">
                            <?php wp_editor(stripslashes(get_option('tecnooptica-setup_descripcion_paso_6')), "descripcion_paso_6", $settings ); ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="">
                            <label for=""><?php _e('PASO 7', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="editor_ajustes">
                            <?php wp_editor(stripslashes(get_option('tecnooptica-setup_paso_7')), "paso_7", $settings ); ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="">
                            <label for=""><?php _e('Descripción para el PASO 7', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="editor_ajustes">
                            <?php wp_editor(stripslashes(get_option('tecnooptica-setup_descripcion_paso_7')), "descripcion_paso_7", $settings ); ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="">
                            <label for=""><?php _e('Mensaje de error en el PASO 2', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="editor_ajustes">
                            <?php wp_editor(stripslashes(get_option('tecnooptica-setup_error_paso_2')), "error_paso_3", $settings ); ?>
                        </td>
                    </tr>
                    <?php }
                    else { ?>
                        <tr>
                            <th class="">
                                <label for=""><?php _e('Mensaje inicial', 'tecno-opticas'); ?></label>
                            </th>
                            <td class="editor_ajustes">
                                <?php wp_editor(stripslashes(get_option('tecnooptica-setup_mensaje_paso_inicio')), "mensaje_inicial", $settings ); ?>
                            </td>
                        </tr>
                        <tr>
                            <th class="">
                                <label for=""><?php _e('Mensaje 1', 'tecno-opticas'); ?></label>
                            </th>
                            <td class="editor_ajustes">
                                <?php wp_editor(stripslashes(get_option('tecnooptica-setup_mensaje_paso_1')), "mensaje_1", $settings ); ?>
                            </td>
                        </tr>
                        <tr>
                            <th class="">
                                <label for=""><?php _e('Mensaje 2', 'tecno-opticas'); ?></label>
                            </th>
                            <td class="editor_ajustes">
                                <?php wp_editor(stripslashes(get_option('tecnooptica-setup_mensaje_paso_2')), "mensaje_2", $settings ); ?>
                            </td>
                        </tr>
                        <tr>
                            <th class="">
                                <label for=""><?php _e('Mensaje 3', 'tecno-opticas'); ?></label>
                            </th>
                            <td class="editor_ajustes">
                                <?php wp_editor(stripslashes(get_option('tecnooptica-setup_mensaje_paso_3')), "mensaje_3", $settings ); ?>
                            </td>
                        </tr>
                        <tr>
                            <th class="">
                                <label for=""><?php _e('Mensaje 4', 'tecno-opticas'); ?></label>
                            </th>
                            <td class="editor_ajustes">
                                <?php wp_editor(stripslashes(get_option('tecnooptica-setup_mensaje_paso_4')), "mensaje_4", $settings ); ?>
                            </td>
                        </tr>
                        <tr>
                            <th class="">
                                <label for=""><?php _e('Mensaje 5', 'tecno-opticas'); ?></label>
                            </th>
                            <td class="editor_ajustes">
                                <?php wp_editor(stripslashes(get_option('tecnooptica-setup_mensaje_paso_5')), "mensaje_5", $settings ); ?>
                            </td>
                        </tr>
                        <tr>
                            <th class="">
                                <label for=""><?php _e('Mensaje 6', 'tecno-opticas'); ?></label>
                            </th>
                            <td class="editor_ajustes">
                                <?php wp_editor(stripslashes(get_option('tecnooptica-setup_mensaje_paso_6')), "mensaje_6", $settings ); ?>
                            </td>
                        </tr>
                        <tr>
                            <th class="">
                                <label for=""><?php _e('Mensaje error tintura', 'tecno-opticas'); ?></label>
                            </th>
                            <td class="editor_ajustes">
                                <?php wp_editor(stripslashes(get_option('tecnooptica-setup_mensaje_error_tintura')), "mensaje_error_tintura", $settings ); ?>
                            </td>
                        </tr>
                        <tr>
                            <th class="">
                                <label for=""><?php _e('Mensaje error tonalidad', 'tecno-opticas'); ?></label>
                            </th>
                            <td class="editor_ajustes">
                                <?php wp_editor(stripslashes(get_option('tecnooptica-setup_mensaje_error_tonalidad')), "mensaje_error_tonalidad", $settings ); ?>
                            </td>
                        </tr>
                        <tr>
                            <th class="">
                                <label for=""><?php _e('Mensaje error plantilla', 'tecno-opticas'); ?></label>
                            </th>
                            <td class="editor_ajustes">
                                <?php wp_editor(stripslashes(get_option('tecnooptica-setup_mensaje_error_plantilla')), "mensaje_error_plantilla", $settings ); ?>
                            </td>
                        </tr>
                        <tr>
                            <th class="">
                                <label for=""><?php _e('Mensaje proceso listo', 'tecno-opticas'); ?></label>
                            </th>
                            <td class="editor_ajustes">
                                <?php wp_editor(stripslashes(get_option('tecnooptica-setup_mensaje_proceso_listo')), "mensaje_proceso_listo", $settings ); ?>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="2">
                            <button id="guardar_ajustes" class="button-primary woocommerce-save-button" value="Guardar los cambios">
                            <?php _e('Guardar los cambios', 'tecno-opticas'); ?></button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>


    </div>
</div>
