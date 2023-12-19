<?php
/**
 * Created by PhpStorm.
 * User: DESAR01
 * Date: 29/10/2021
 * Time: 9:13 AM
 */
if (! current_user_can ('manage_options')) wp_die (__('No tienes suficientes permisos para acceder a esta página.', 'tecno-opticas'));
?>
<div class="wrap">
    <p><img src="<?php echo get_site_url(); ?>/wp-content/plugins/tecno-opticas/images/ts_logo.png" alt="Tecno-Soluciones" title="Tecno-Soluciones"></p>
    <h2><?php _e( 'Tecno Ópticas', 'tecno-opticas' ) ?></h2>
</div>
<?php

function  exclude_plugin_settings() {

    if(isset($_POST['tipo_proceso_compra'])){
        $proceso_compra = $_POST['tipo_proceso_compra'];
    }
    else{
        $proceso_compra = "opcion_1";
    }

    update_option("tecnooptica-tipo_proceso_compra", $proceso_compra, 'no');

    if(isset($_POST['habilitar_exclusion'])){
        $excluir = $_POST['habilitar_exclusion'];
    }
    else{
        $excluir = "no";
    }

    update_option("tecnooptica-setupexclude_form", $excluir, 'no');

    if(isset($_POST['habilitar_descanso'])){
        $habli_desca = $_POST['habilitar_descanso'];
    }
    else{
        $habli_desca = "no";
    }

    update_option("tecnooptica-setupexclude_form_descanso", $habli_desca, 'no');

    if(isset($_POST['habilitar_vs'])){
        $habli_vs = $_POST['habilitar_vs'];
    }
    else{
        $habli_vs = "no";
    }

    update_option("tecnooptica-setupexclude_form_vs", $habli_vs, 'no');

    if(isset($_POST['habilitar_bifocal'])){
        $habli_bifocales = $_POST['habilitar_bifocal'];
    }
    else{
        $habli_bifocales = "no";
    }

    update_option("tecnooptica-setupexclude_form_bifocales", $habli_bifocales, 'no');

    if(isset($_POST['habilitar_progresivo'])){
        $habli_progresivos = $_POST['habilitar_progresivo'];
    }
    else{
        $habli_progresivos = "no";
    }

    update_option("tecnooptica-setupexclude_form_progresivo", $habli_progresivos, 'no');

    if(isset($_POST['habilitar_ocupacionales'])){
        $habli_ocupacionales = $_POST['habilitar_ocupacionales'];
    }
    else{
        $habli_ocupacionales = "no";
    }

    update_option("tecnooptica-setupexclude_form_ocupacionales", $habli_ocupacionales, 'no');

    if(isset($_POST['habilitar_altura'])){
        $habli_altur = $_POST['habilitar_altura'];
    }
    else{
            $habli_altur = "no";
    }

    update_option("tecnooptica-setupexclude_form_habli_altur", $habli_altur, 'no');

    if(isset($_POST['habilitar_porcentaje_tonalidad'])){
        $habli_altur = $_POST['habilitar_porcentaje_tonalidad'];
    }
    else{
        $habli_altur = "no";
    }

    update_option("tecnooptica-setupexclude_form_habilitar_porcentaje_tonalidad", $habli_altur, 'no');

    $mensaje = "
        <script type='text/javascript'>
            jQuery('.alert').fadeOut( 12000, function(){
                    jQuery('#mensaje').html('');
                } )
        </script>
    
    ";

    return '<div class="alert alert-success" role="alert"><strong>'.__("Ajuste", "tecno-opticas").'</strong> '.__("para el proceso de compra guardado correctamente", "tecno-opticas").'</div>'.$mensaje.'';
}

if(isset($_POST['option_page'])){
    $mensaje = exclude_plugin_settings();
}
else{
    $mensaje = "";
}

if(get_option('tecnooptica-tipo_proceso_compra') == "opcion_1"){
    $opcion_1 = 'selected="selected"';
    $opcion_2 = '';
}
else{
    $opcion_1 = '';
    $opcion_2 = 'selected="selected"';
}

if(get_option('tecnooptica-setupexclude_form') == "yes"){
    $cheked = 'checked="checked"';
}
else{
    $cheked = '';
}

if(get_option('tecnooptica-setupexclude_form_descanso') == "yes"){
    $habli_desca = 'checked="checked"';
}
else{
    $habli_desca = '';
}

if(get_option('tecnooptica-setupexclude_form_vs') == "yes"){
    $habli_vs = 'checked="checked"';
}
else{
    $habli_vs = '';
}

if(get_option('tecnooptica-setupexclude_form_vs') == "yes"){
    $habli_vs = 'checked="checked"';
}
else{
    $habli_vs = '';
}

if(get_option('tecnooptica-setupexclude_form_bifocales') == "yes"){
    $habli_bifocales = 'checked="checked"';
}
else{
    $habli_bifocales = '';
}

if(get_option('tecnooptica-setupexclude_form_progresivo') == "yes"){
    $habli_progresivos = 'checked="checked"';
}
else{
    $habli_progresivos = '';
}

if(get_option('tecnooptica-setupexclude_form_ocupacionales') == "yes"){
    $habli_ocupacionales = 'checked="checked"';
}
else{
    $habli_ocupacionales = '';
}

if(get_option('tecnooptica-setupexclude_form_habli_altur') == "yes"){
    $habli_altur = 'checked="checked"';
}
else{
    $habli_altur = '';
}

if(get_option('tecnooptica-setupexclude_form_habilitar_porcentaje_tonalidad') == "yes"){
    $habli_porcent = 'checked="checked"';
}
else{
    $habli_porcent = '';
}

?>

<div class="wrap woocommerce">
    <nav class="nav-tab-wrapper woo-nav-tab-wrapper" id="cam_vision">
        <a href="admin.php?page=tecno-opticas%2Fadmin%2Fajustes_modulo.php" class="nav-tab nav-tab-active" id="descripci_tipo_lente"><?php _e('Ajustes Generales', 'tecno-opticas'); ?></a>
        <a href="admin.php?page=tecno-opticas%2Fadmin%2Fdescripcion_tipos.php" class="nav-tab" id="descripci_tipo_lente"><?php _e('Descripción Tipos de Visión', 'tecno-opticas'); ?></a>
        <a href="admin.php?page=tecno-opticas%2Fadmin%2Fajustes.php" class="nav-tab" id="mensaje_proces"><?php _e('Mensajes', 'tecno-opticas'); ?></a>
        <a href="admin.php?page=tecno-opticas%2Fadmin%2Fajustes_whatsapp.php" class="nav-tab" id="whatsapp"><?php _e('Configuración de WhatsApp', 'tecno-opticas'); ?></a>
    </nav>
    <div class="content-form">

        <div class="config_mensajes">

            <div id="mensaje"><?php echo $mensaje; ?></div>

            <div id="" class="content">
                <h2><?php echo __('Configuración del módulo', 'tecno-opticas'); ?></h2>
                <div id="descripci_ajustes" class="ajustes">
                    <p>
                        <?php _e('Aquí usted debe configurar los ajustes del módulo.', 'tecno-opticas'); ?>
                    </p>
                </div>
                <form id="guardar_ajustes" method="post" action="admin.php?page=tecno-opticas%2Fadmin%2Fajustes_modulo.php">
                    <?php settings_fields('tecnooptica-setup'); ?>
                    <?php do_settings_sections('tecnooptica-setup'); ?>
                    <table class="table_ajustes">
                        <tr>
                            <th class="">
                                <label for="exclusion_form"><?php _e('Excluir los productos que estén fuera de rango por la fórmula', 'tecno-opticas'); ?></label>
                            </th>
                            <td class="editor_ajustes">
                                <p class="form-field exclusion_form_field exclusion_form">
                                    <input type="checkbox" class="checkbox element_410" style="" name="habilitar_exclusion" id="exclusion_form" value="yes" <?php echo $cheked; ?>>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <hr>
                            </td>
                        </tr>
                    </table>

                    <p>
                    <?php _e('Por favor marque abajo los tipos de visión que desea habilitar en el módulo:', 'tecno-opticas'); ?>
                    </p>
                    <table  class="table_ajustes">
                        <tr>
                            <th class="">
                                <label for="exclusion_form">
                                    <?php _e('Descanso', 'tecno-opticas'); ?></label>
                            </th>
                            <td class="editor_ajustes">
                                <p class="form-field exclusion_form_field exclusion_form">
                                    <input type="checkbox" class="checkbox element_410" style="" name="habilitar_descanso" id="habilitar_descanso" value="yes" <?php echo $habli_desca; ?>>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th class="">
                                <label for="exclusion_form">
                                    <?php _e('Visión', 'tecno-opticas'); ?> sencilla</label>
                            </th>
                            <td class="editor_ajustes">
                                <p class="form-field exclusion_form_field exclusion_form">
                                    <input type="checkbox" class="checkbox element_410" style="" name="habilitar_vs" id="habilitar_vs" value="yes" <?php echo $habli_vs; ?>>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th class="">
                                <label for="exclusion_form">
                                    <?php _e('Bifocal', 'tecno-opticas'); ?></label>
                            </th>
                            <td class="editor_ajustes">
                                <p class="form-field exclusion_form_field exclusion_form">
                                    <input type="checkbox" class="checkbox element_410" style="" name="habilitar_bifocal" id="habilitar_bifocal" value="yes" <?php echo $habli_bifocales; ?>>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th class="">
                                <label for="exclusion_form">
                                    <?php _e('Progresivo', 'tecno-opticas'); ?></label>
                            </th>
                            <td class="editor_ajustes">
                                <p class="form-field exclusion_form_field exclusion_form">
                                    <input type="checkbox" class="checkbox element_410" style="" name="habilitar_progresivo" id="habilitar_progresivo" value="yes" <?php echo $habli_progresivos; ?>>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th class="">
                                <label for="exclusion_form">
                                    <?php _e('Ocupacionales', 'tecno-opticas'); ?></label>
                            </th>
                            <td class="editor_ajustes">
                                <p class="form-field exclusion_form_field exclusion_form">
                                    <input type="checkbox" class="checkbox element_410" style="" name="habilitar_ocupacionales" id="habilitar_ocupacionales" value="yes" <?php echo $habli_ocupacionales; ?>>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <hr>
                            </td>
                        </tr>
                    </table>

                    <p>                       
                        <?php _e(' Por favor seleccione el tipo de proceso de compra:', 'tecno-opticas'); ?>
                    </p>
                    <table  class="table_ajustes">
                        <tr>
                            <td class="editor_ajustes">
                                <p class="form-field exclusion_form_field exclusion_form">
                                    <select name="tipo_proceso_compra" id="tip_proces_compra">
                                        <option value="opcion_1" <?php echo $opcion_1; ?>><?php _e('Opción 1', 'tecno-opticas'); ?></option>
                                        <option value="opcion_2" <?php echo $opcion_2; ?>><?php _e('Opción 2', 'tecno-opticas'); ?></option>
                                    </select>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <hr>
                            </td>
                        </tr>
                        <tr>
                            <th class="">
                                <label for="exclusion_form">
                                <?php _e('Habilitar Campo del altura en el proceso de compra', 'tecno-opticas'); ?></label>
                            </th>
                            <td class="editor_ajustes">
                                <p class="form-field exclusion_form_field exclusion_form">
                                    <input type="checkbox" class="checkbox element_410" style="" name="habilitar_altura" id="habilitar_altura" value="yes" <?php echo $habli_altur; ?>>
                                </p>
                            </td>
                        </tr>
                        <tr>
                        <tr>
                            <th class="">
                                <label for="exclusion_form">
                                    <?php _e('Habilitar Campo de porcentaje para la tonalidad en el proceso de compra', 'tecno-opticas'); ?></label>
                            </th>
                            <td class="editor_ajustes">
                                <p class="form-field exclusion_form_field exclusion_form">
                                    <input type="checkbox" class="checkbox element_410" style="" name="habilitar_porcentaje_tonalidad" id="habilitar_porcentaje_tonalidad" value="yes" <?php echo $habli_porcent; ?>>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <hr>
                            </td>
                        </tr>
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
