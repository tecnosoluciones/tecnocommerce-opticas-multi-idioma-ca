<?php
/**
 * Created by PhpStorm.
 * User: DESAR01
 * Date: 3/10/2022
 * Time: 3:21 PM
 */
if (! current_user_can ('manage_options')) wp_die (__('No tienes suficientes permisos para acceder a esta página.', 'tecno-opticas'));

$args = array(
    'post_type' => 'vision_sencilla',
);
$loop = new WP_Query($args);
$id_vision_sencilla = $loop->post->ID;

$args = array(
    'post_type' => 'bifocales',
);
$loop = new WP_Query($args);
$id_bifocales = $loop->post->ID;

$args = array(
    'post_type' => 'progresivos',
);
$loop = new WP_Query($args);
$id_progresivos = $loop->post->ID;

$args = array(
    'post_type' => 'ocupacionales',
);
$loop = new WP_Query($args);
$id_ocupacionales = $loop->post->ID;

$class_mostrar = "none";
$class_mostrar_bifocales = "none";
$class_mostrar_progresivos = "none";
$class_mostrar_ocupacionales = "none";

$opciones_esfera = "";
$opciones_cilindro = "";
$opciones_eje = "";
$opciones_add_progresivos = "";
$opciones_esfera_bifocales = "";
$opciones_cilindro_bifocales = "";
$opciones_add_bifocales = "";
$opciones_eje_bifocales = "";
$opciones_esfera_progresivos = "";
$opciones_cilindro_progresivos = "";
$opciones_eje_progresivos = "";
$opciones_esfera_ocupacionales = "";
$opciones_cilindro_ocupacionales = "";
$opciones_eje_ocupacionales = "";
$opciones_add_ocupacionales = "";

if(get_option('tecnooptica-setupexclude_form_vs') == "yes") {
    if ($id_vision_sencilla != 0) {
        $rang_positiv_esfera = get_post_meta($id_vision_sencilla, "rang_positiv_esfera", true);
        $rang_negativ_esfera = get_post_meta($id_vision_sencilla, "rang_negativ_esfera", true);
        $rang_step_esfera = get_post_meta($id_vision_sencilla, "rang_step_esfera", true);
        $rang_positiv_cilindro = get_post_meta($id_vision_sencilla, "rang_positiv_cilindro", true);
        $rang_negativ_cilindro = get_post_meta($id_vision_sencilla, "rang_negativ_cilindro", true);
        $rang_step_cilindro = get_post_meta($id_vision_sencilla, "rang_step_cilindro", true);
        $rang_alto_eje = get_post_meta($id_vision_sencilla, "rang_alto_eje", true);
        $rang_bajo_eje = get_post_meta($id_vision_sencilla, "rang_bajo_eje", true);
        $rang_step_eje = get_post_meta($id_vision_sencilla, "rang_step_eje", true);

        $opciones_esfera = procesar_formul($id_vision_sencilla, "esfera");
        $opciones_cilindro = procesar_formul($id_vision_sencilla, "cilindro");
        $opciones_eje = procesar_formul($id_vision_sencilla, "eje");
        $class_mostrar = "block";
    }
}

if(get_option('tecnooptica-setupexclude_form_bifocales') == "yes") {
    if ($id_bifocales != 0) {
        $rang_positiv_esfera_bifocales = get_post_meta($id_bifocales, "rang_positiv_esfera", true);
        $rang_negativ_esfera_bifocales = get_post_meta($id_bifocales, "rang_negativ_esfera", true);
        $rang_step_esfera_bifocales = get_post_meta($id_bifocales, "rang_step_esfera", true);
        $rang_positiv_cilindro_bifocales = get_post_meta($id_bifocales, "rang_positiv_cilindro", true);
        $rang_negativ_cilindro_bifocales = get_post_meta($id_bifocales, "rang_negativ_cilindro", true);
        $rang_step_cilindro_bifocales = get_post_meta($id_bifocales, "rang_step_cilindro", true);
        $rang_positiv_add_bifocales = get_post_meta($id_bifocales, "rang_positiv_add", true);
        $rang_negativ_add_bifocales = get_post_meta($id_bifocales, "rang_negativ_add", true);
        $rang_step_add_bifocales = get_post_meta($id_bifocales, "rang_step_add", true);
        $rang_alto_eje_bifocales = get_post_meta($id_bifocales, "rang_alto_eje", true);
        $rang_bajo_eje_bifocales = get_post_meta($id_bifocales, "rang_bajo_eje", true);
        $rang_step_eje_bifocales = get_post_meta($id_bifocales, "rang_step_eje", true);
        $opciones_esfera_bifocales = procesar_formul($id_bifocales, "esfera");
        $opciones_cilindro_bifocales = procesar_formul($id_bifocales, "cilindro");
        $opciones_add_bifocales = procesar_formul($id_bifocales, "cilindro");
        $opciones_eje_bifocales = procesar_formul($id_bifocales, "eje");
        $class_mostrar_bifocales = "block";
    }
}

if(get_option('tecnooptica-setupexclude_form_progresivo') == "yes") {
    if ($id_progresivos != 0) {
        $rang_positiv_esfera_progresivos = get_post_meta($id_progresivos, "rang_positiv_esfera", true);
        $rang_negativ_esfera_progresivos = get_post_meta($id_progresivos, "rang_negativ_esfera", true);
        $rang_step_esfera_progresivos = get_post_meta($id_progresivos, "rang_step_esfera", true);
        $rang_positiv_cilindro_progresivos = get_post_meta($id_progresivos, "rang_positiv_cilindro", true);
        $rang_negativ_cilindro_progresivos = get_post_meta($id_progresivos, "rang_negativ_cilindro", true);
        $rang_step_cilindro_progresivos = get_post_meta($id_progresivos, "rang_step_cilindro", true);
        $rang_positiv_add_progresivos = get_post_meta($id_progresivos, "rang_positiv_add", true);
        $rang_negativ_add_progresivos = get_post_meta($id_progresivos, "rang_negativ_add", true);
        $rang_step_add_progresivos = get_post_meta($id_progresivos, "rang_step_add", true);
        $rang_alto_eje_progresivos = get_post_meta($id_progresivos, "rang_alto_eje", true);
        $rang_bajo_eje_progresivos = get_post_meta($id_progresivos, "rang_bajo_eje", true);
        $rang_step_eje_progresivos = get_post_meta($id_progresivos, "rang_step_eje", true);

        $opciones_esfera_progresivos = procesar_formul($id_progresivos, "esfera");
        $opciones_cilindro_progresivos = procesar_formul($id_progresivos, "cilindro");
        $opciones_add_progresivos = procesar_formul($id_progresivos, "cilindro");
        $opciones_eje_progresivos = procesar_formul($id_progresivos, "eje");
        $class_mostrar_progresivos = "block";
    }
}

if(get_option('tecnooptica-setupexclude_form_ocupacionales') == "yes") {
    if ($id_ocupacionales != 0) {
        $rang_positiv_esfera_ocupacionales = get_post_meta($id_ocupacionales, "rang_positiv_esfera", true);
        $rang_negativ_esfera_ocupacionales = get_post_meta($id_ocupacionales, "rang_negativ_esfera", true);
        $rang_step_esfera_ocupacionales = get_post_meta($id_ocupacionales, "rang_step_esfera", true);
        $rang_positiv_cilindro_ocupacionales = get_post_meta($id_ocupacionales, "rang_positiv_cilindro", true);
        $rang_negativ_cilindro_ocupacionales = get_post_meta($id_ocupacionales, "rang_negativ_cilindro", true);
        $rang_step_cilindro_ocupacionales = get_post_meta($id_ocupacionales, "rang_step_cilindro", true);
        $rang_positiv_add_ocupacionales = get_post_meta($id_ocupacionales, "rang_positiv_add", true);
        $rang_negativ_add_ocupacionales = get_post_meta($id_ocupacionales, "rang_negativ_add", true);
        $rang_step_add_ocupacionales = get_post_meta($id_ocupacionales, "rang_step_add", true);
        $rang_alto_eje_ocupacionales = get_post_meta($id_ocupacionales, "rang_alto_eje", true);
        $rang_bajo_eje_ocupacionales = get_post_meta($id_ocupacionales, "rang_bajo_eje", true);
        $rang_step_eje_ocupacionales = get_post_meta($id_ocupacionales, "rang_step_eje", true);

        $opciones_esfera_ocupacionales = procesar_formul($id_ocupacionales, "esfera");
        $opciones_cilindro_ocupacionales = procesar_formul($id_ocupacionales, "cilindro");
        $opciones_add_ocupacionales = procesar_formul($id_ocupacionales, "cilindro");
        $opciones_eje_ocupacionales = procesar_formul($id_ocupacionales, "eje");
        $class_mostrar_ocupacionales = "block";
    }
}

?>
    <div class="wrap woocommerce">
        <nav class="nav-tab-wrapper woo-nav-tab-wrapper" id="cam_vision">
            <?php
            if(get_option('tecnooptica-setupexclude_form_vs') == "yes"){
                echo '<a class="nav-tab nav-tab-active" id="vision-sencilla">'.__("Visión Sencilla", "tecno-opticas").'</a>';
            }
            if(get_option('tecnooptica-setupexclude_form_bifocales') == "yes"){
                echo '<a class="nav-tab" id="bifocales">'.__("Bifocal", "tecno-opticas").'</a>';
            }
            if(get_option('tecnooptica-setupexclude_form_progresivo') == "yes"){
                echo '<a class="nav-tab" id="progresivos">'.__("Progresivo", "tecno-opticas").'</a>';
            }
            if(get_option('tecnooptica-setupexclude_form_ocupacionales') == "yes") {
                echo '<a class="nav-tab" id="ocupacionales">'.__("Ocupacionales", "tecno-opticas").'</a>';
            }
            ?>
        </nav>
        <div class="content-form">

            <div id="mensaje"></div>

            <div id="vision-sencilla" class="content formula">
                <h2><?php _e('Rango de fórmulas para lentes de Visión Sencilla', 'tecno-opticas'); ?></h2>
                <div id="descripcion_vision-sencilla" class="descripcionform">
                    <p>
                    <?php _e('Aquí usted debe configurar los rangos correspondientes a los campos Esfera, Cilindro y Eje para los lentes de Visión Sencilla.', 'tecno-opticas'); ?>
                    </p>
                </div>

                <table class="form-table">
                    <tr>
                        <th></th>
                        <th><?php _e('Rango más alto', 'tecno-opticas'); ?></th>
                        <th><?php _e('Rango más bajo', 'tecno-opticas'); ?></th>
                        <th><?php _e('Salto del rango', 'tecno-opticas'); ?></th>
                    </tr>
                    <tr>
                        <th class="titledesc">
                            <label for=""><?php _e('Esfera', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_positiv_esfera; ?>" pattern="^[0-9]+" name="rango-positivo-esfera" title="<?php _e('Valor del rango positivo más alto', 'tecno-opticas'); ?>">
                        </td>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_negativ_esfera; ?>" name="rango-negativo-esfera" pattern="^[0-9]-" title="<?php _e('Valor del rango negativo más bajo', 'tecno-opticas'); ?>">
                        </td>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_step_esfera; ?>" pattern="^[0-9]+" name="step-esfera" title="<?php _e('salto de los valores', 'tecno-opticas'); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th class="titledesc">
                            <label for=""><?php _e('Cilindro', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_positiv_cilindro; ?>" pattern="^[0-9]+" name="rango-positivo-cilindro" title="<?php _e('Valor del rango positivo más alto', 'tecno-opticas'); ?>">
                        </td>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_negativ_cilindro; ?>" pattern="^[0-9]-" name="rango-negativo-cilindro" title="<?php _e('Valor del rango negativo más bajo', 'tecno-opticas'); ?>">
                        </td>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_step_cilindro; ?>" pattern="^[0-9]+" name="step-cilindro" title="<?php _e('salto de los valores', 'tecno-opticas'); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th class="titledesc">
                            <label for=""><?php _e('Eje', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_alto_eje; ?>" pattern="^[0-9]+" name="rango-positivo-alto-eje" title="<?php _e('Valor del rango positivo más alto', 'tecno-opticas'); ?>">
                        </td>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_bajo_eje; ?>" pattern="^[0-9]+" name="rango-positivo-bajo-eje" title="<?php _e('Valor del rango positivo más bajo', 'tecno-opticas'); ?>">
                        </td>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_step_eje; ?>" pattern="^[0-9]+" name="step-eje" title="<?php _e('salto de los valores', 'tecno-opticas'); ?>">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <button id="guardar-vision-sencilla" class="button-primary woocommerce-save-button" value="Guardar los cambios">
                                <?php _e('Guardar los cambios', 'tecno-opticas'); ?>
                            </button>
                        </td>
                    </tr>
                </table>

                <hr>

                <p style="display: <?php echo $class_mostrar; ?>"> Así se verán los campos de la fórmula para lentes de Visión Sencilla con los rangos que usted ha configurado:</p>

                <table class="form-table vista_previa" style="display: <?php echo $class_mostrar; ?>">
                    <tr>
                        <th class="titledesc">
                            <label for=""><?php _e('Esfera', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="forminp forminp-text">
                            <select name="" id="esfera">
                                <?php echo $opciones_esfera; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th class="titledesc">
                            <label for=""><?php _e('Cilindro', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="forminp forminp-text">
                            <select name="" id="cilindro">
                                <?php echo $opciones_cilindro; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th class="titledesc">
                            <label for=""><?php _e('Eje', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="forminp forminp-text">
                            <select name="" id="eje">
                                <?php echo $opciones_eje; ?>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
            <div id="bifocales" class="content formula" style="display: none;">
                <h2><?php _e('Rango de fórmulas para lentes Bifocales', 'tecno-opticas'); ?></h2>
                <div id="descripcion_bifocales" class="descripcionform">
                    <p>
                        <?php _e('Aquí usted debe configurar los rangos correspondientes a los campos Esfera, Cilindro, ADD y Eje para los lentes Bifocales.', 'tecno-opticas'); ?>
                    </p>
                </div>

                <table class="form-table">
                    <tr>
                        <th></th>
                        <th><?php _e('Rango más alto', 'tecno-opticas'); ?></th>
                        <th><?php _e('Rango más bajo', 'tecno-opticas'); ?></th>
                        <th><?php _e('Salto del rango', 'tecno-opticas'); ?></th>
                    </tr>
                    <tr>
                        <th class="titledesc">
                            <label for=""><?php _e('Esfera', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_positiv_esfera_bifocales; ?>" pattern="^[0-9]+" name="rango-positivo-esfera" title="<?php _e('Valor del rango positivo más alto', 'tecno-opticas'); ?>">
                        </td>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_negativ_esfera_bifocales; ?>" name="rango-negativo-esfera" pattern="^[0-9]-" title="<?php _e('Valor del rango negativo más bajo', 'tecno-opticas'); ?>">
                        </td>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_step_esfera_bifocales; ?>" pattern="^[0-9]+" name="step-esfera" title="<?php _e('salto de los valores', 'tecno-opticas'); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th class="titledesc">
                            <label for=""><?php _e('Cilindro', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_positiv_cilindro_bifocales; ?>" pattern="^[0-9]+" name="rango-positivo-cilindro" title="<?php _e('Valor del rango positivo más alto', 'tecno-opticas'); ?>">
                        </td>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_negativ_cilindro_bifocales; ?>" pattern="^[0-9]-" name="rango-negativo-cilindro" title="<?php _e('Valor del rango negativo más bajo', 'tecno-opticas'); ?>">
                        </td>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_step_cilindro_bifocales; ?>" pattern="^[0-9]+" name="step-cilindro" title="<?php _e('salto de los valores', 'tecno-opticas'); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th class="titledesc">
                            <label for=""><?php _e('ADD', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_positiv_add_bifocales; ?>" pattern="^[0-9]+" name="rango-positivo-add" title="<?php _e('Valor del rango positivo más alto', 'tecno-opticas'); ?>">
                        </td>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_negativ_add_bifocales; ?>" pattern="^[0-9]-" name="rango-negativo-add" title="<?php _e('Valor del rango negativo más bajo', 'tecno-opticas'); ?>">
                        </td>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_step_add_bifocales; ?>" pattern="^[0-9]+" name="step-add" title="<?php _e('salto de los valores', 'tecno-opticas'); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th class="titledesc">
                            <label for=""><?php _e('Eje', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_alto_eje_bifocales; ?>" pattern="^[0-9]+" name="rango-positivo-alto-eje" title="<?php _e('Valor del rango positivo más alto', 'tecno-opticas'); ?>">
                        </td>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_bajo_eje_bifocales; ?>" pattern="^[0-9]+" name="rango-positivo-bajo-eje" title="<?php _e('Valor del rango positivo más bajo', 'tecno-opticas'); ?>">
                        </td>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_step_eje_bifocales; ?>" pattern="^[0-9]+" name="step-eje" title="<?php _e('salto de los valores', 'tecno-opticas'); ?>">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <button id="guardar-bifocales" class="button-primary woocommerce-save-button" value="Guardar los cambios">
                                <?php _e('Guardar los cambios', 'tecno-opticas'); ?>
                            </button>
                        </td>
                    </tr>
                </table>

                <hr>

                <p style="display: <?php echo $class_mostrar_bifocales; ?>">Así se verán los campos de la fórmula para lentes Bifocales con los rangos que usted ha configurado:</p>

                <table class="form-table vista_previa" style="display: <?php echo $class_mostrar_bifocales; ?>">
                    <tr>
                        <th class="titledesc">
                            <label for=""><?php _e('Esfera', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="forminp forminp-text">
                            <select name="" id="esfera">
                                <?php echo $opciones_esfera_bifocales; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th class="titledesc">
                            <label for=""><?php _e('Cilindro', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="forminp forminp-text">
                            <select name="" id="cilindro">
                                <?php echo $opciones_cilindro_bifocales; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th class="titledesc">
                            <label for=""><?php _e('ADD', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="forminp forminp-text">
                            <select name="" id="add">
                                <?php echo $opciones_add_bifocales; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th class="titledesc">
                            <label for=""><?php _e('Eje', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="forminp forminp-text">
                            <select name="" id="eje">
                                <?php echo $opciones_eje_bifocales; ?>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
            <div id="progresivos" class="content formula" style="display: none;">
                <h2><?php _e('Rango de fórmulas para lentes Progresivos', 'tecno-opticas'); ?></h2>
                <div id="descripcion_progresivos" class="descripcionform">
                    <p>
                        <?php _e('Aquí usted debe configurar los rangos correspondientes a los campos Esfera, Cilindro, ADD y Eje para los lentes Progresivos.', 'tecno-opticas'); ?>
                    </p>
                </div>

                <table class="form-table">
                    <tr>
                        <th></th>
                        <th><?php _e('Rango más alto', 'tecno-opticas'); ?></th>
                        <th><?php _e('Rango más bajo', 'tecno-opticas'); ?></th>
                        <th><?php _e('Salto del rango', 'tecno-opticas'); ?></th>
                    </tr>
                    <tr>
                        <th class="titledesc">
                            <label for=""><?php _e('Esfera', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_positiv_esfera_progresivos; ?>" pattern="^[0-9]+" name="rango-positivo-esfera" title="<?php _e('Valor del rango positivo más alto', 'tecno-opticas'); ?>">
                        </td>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_negativ_esfera_progresivos; ?>" name="rango-negativo-esfera" pattern="^[0-9]-" title="<?php _e('Valor del rango negativo más bajo', 'tecno-opticas'); ?>">
                        </td>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_step_esfera_progresivos; ?>" pattern="^[0-9]+" name="step-esfera" title="<?php _e('salto de los valores', 'tecno-opticas'); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th class="titledesc">
                            <label for=""><?php _e('Cilindro', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_positiv_cilindro_progresivos; ?>" pattern="^[0-9]+" name="rango-positivo-cilindro" title="<?php _e('Valor del rango positivo más alto', 'tecno-opticas'); ?>">
                        </td>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_negativ_cilindro_progresivos; ?>" pattern="^[0-9]-" name="rango-negativo-cilindro" title="<?php _e('Valor del rango negativo más bajo', 'tecno-opticas'); ?>">
                        </td>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_step_cilindro_progresivos; ?>" pattern="^[0-9]+" name="step-cilindro" title="<?php _e('salto de los valores', 'tecno-opticas'); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th class="titledesc">
                            <label for=""><?php _e('ADD', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_positiv_add_progresivos; ?>" pattern="^[0-9]+" name="rango-positivo-add" title="<?php _e('Valor del rango positivo más alto', 'tecno-opticas'); ?>">
                        </td>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_negativ_add_progresivos; ?>" pattern="^[0-9]-" name="rango-negativo-add" title="<?php _e('Valor del rango negativo más bajo', 'tecno-opticas'); ?>">
                        </td>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_step_add_progresivos; ?>" pattern="^[0-9]+" name="step-add" title="<?php _e('salto de los valores', 'tecno-opticas'); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th class="titledesc">
                            <label for=""><?php _e('Eje', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_alto_eje_progresivos; ?>" pattern="^[0-9]+" name="rango-positivo-alto-eje" title="<?php _e('Valor del rango positivo más alto', 'tecno-opticas'); ?>">
                        </td>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_bajo_eje_progresivos; ?>" pattern="^[0-9]+" name="rango-positivo-bajo-eje" title="<?php _e('Valor del rango positivo más bajo', 'tecno-opticas'); ?>">
                        </td>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_step_eje_progresivos; ?>" pattern="^[0-9]+" name="step-eje" title="<?php _e('salto de los valores', 'tecno-opticas'); ?>">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <button id="guardar-progresivos" class="button-primary woocommerce-save-button" value="Guardar los cambios">
                                <?php _e('Guardar los cambios', 'tecno-opticas'); ?>
                            </button>
                        </td>
                    </tr>
                </table>

                <hr>

                <p style="display: <?php echo $class_mostrar_progresivos; ?>"> Así se verán los campos de la fórmula para lentes Progresivos con los rangos que usted ha configurado:</p>

                <table class="form-table vista_previa" style="display: <?php echo $class_mostrar_progresivos; ?>">
                    <tr>
                        <th class="titledesc">
                            <label for=""><?php _e('Esfera', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="forminp forminp-text">
                            <select name="" id="esfera_progresivos">
                                <?php echo $opciones_esfera_progresivos; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th class="titledesc">
                            <label for=""><?php _e('Cilindro', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="forminp forminp-text">
                            <select name="" id="cilindro_progresivos">
                                <?php echo $opciones_cilindro_progresivos; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th class="titledesc">
                            <label for=""><?php _e('ADD', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="forminp forminp-text">
                            <select name="" id="add_progresivos">
                                <?php echo $opciones_add_progresivos; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th class="titledesc">
                            <label for=""><?php _e('Eje', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="forminp forminp-text">
                            <select name="" id="eje_progresivos">
                                <?php echo $opciones_eje_progresivos; ?>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
            <div id="ocupacionales" class="content formula" style="display: none;">
                <h2><?php _e('Rango de fórmulas para lentes Ocupacionales', 'tecno-opticas'); ?></h2>
                <div id="descripcion_ocupacionales" class="descripcionform">
                    <p>
                        <?php _e('Aquí usted debe configurar los rangos correspondientes a los campos Esfera, Cilindro, ADD y Eje para los lentes Ocupacionales.', 'tecno-opticas'); ?>
                    </p>
                </div>

                <table class="form-table">
                    <tr>
                        <th></th>
                        <th><?php _e('Rango más alto', 'tecno-opticas'); ?></th>
                        <th><?php _e('Rango más bajo', 'tecno-opticas'); ?></th>
                        <th><?php _e('Salto del rango', 'tecno-opticas'); ?></th>
                    </tr>
                    <tr>
                        <th class="titledesc">
                            <label for=""><?php _e('Esfera', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_positiv_esfera_ocupacionales; ?>" pattern="^[0-9]+" name="rango-positivo-esfera" title="<?php _e('Valor del rango positivo más alto', 'tecno-opticas'); ?>">
                        </td>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_negativ_esfera_ocupacionales; ?>" name="rango-negativo-esfera" pattern="^[0-9]-" title="<?php _e('Valor del rango negativo más bajo', 'tecno-opticas'); ?>">
                        </td>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_step_esfera_ocupacionales; ?>" pattern="^[0-9]+" name="step-esfera" title="<?php _e('salto de los valores', 'tecno-opticas'); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th class="titledesc">
                            <label for=""><?php _e('Cilindro', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_positiv_cilindro_ocupacionales; ?>" pattern="^[0-9]+" name="rango-positivo-cilindro" title="<?php _e('Valor del rango positivo más alto', 'tecno-opticas'); ?>">
                        </td>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_negativ_cilindro_ocupacionales; ?>" pattern="^[0-9]-" name="rango-negativo-cilindro" title="<?php _e('Valor del rango negativo más bajo', 'tecno-opticas'); ?>">
                        </td>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_step_cilindro_ocupacionales; ?>" pattern="^[0-9]+" name="step-cilindro" title="<?php _e('salto de los valores', 'tecno-opticas'); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th class="titledesc">
                            <label for=""><?php _e('ADD', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_positiv_add_ocupacionales; ?>" pattern="^[0-9]+" name="rango-positivo-add" title="<?php _e('Valor del rango positivo más alto', 'tecno-opticas'); ?>">
                        </td>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_negativ_add_ocupacionales; ?>" pattern="^[0-9]-" name="rango-negativo-add" title="<?php _e('Valor del rango negativo más bajo', 'tecno-opticas'); ?>">
                        </td>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_step_add_ocupacionales; ?>" pattern="^[0-9]+" name="step-add" title="<?php _e('salto de los valores', 'tecno-opticas'); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th class="titledesc">
                            <label for=""><?php _e('Eje', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_alto_eje_ocupacionales; ?>" pattern="^[0-9]+" name="rango-positivo-alto-eje" title="<?php _e('Valor del rango positivo más alto', 'tecno-opticas'); ?>">
                        </td>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_bajo_eje_ocupacionales; ?>" pattern="^[0-9]+" name="rango-positivo-bajo-eje" title="<?php _e('Valor del rango positivo más bajo', 'tecno-opticas'); ?>">
                        </td>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_step_eje_ocupacionales; ?>" pattern="^[0-9]+" name="step-eje" title="<?php _e('salto de los valores', 'tecno-opticas'); ?>">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <button id="guardar-ocupacionales" class="button-primary woocommerce-save-button" value="Guardar los cambios">
                                <?php _e('Guardar los cambios', 'tecno-opticas'); ?>
                            </button>
                        </td>
                    </tr>
                </table>

                <hr>

                <p style="display: <?php echo $class_mostrar_ocupacionales; ?>"> Así se verán los campos de la fórmula para lentes Ocupacionales con los rangos que usted ha configurado:</p>

                <table class="form-table vista_previa" style="display: <?php echo $class_mostrar_ocupacionales; ?>">
                    <tr>
                        <th class="titledesc">
                            <label for=""><?php _e('Esfera', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="forminp forminp-text">
                            <select name="" id="esfera_ocupacionales">
                                <?php echo $opciones_esfera_ocupacionales; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th class="titledesc">
                            <label for=""><?php _e('Cilindro', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="forminp forminp-text">
                            <select name="" id="cilindro_ocupacionales">
                                <?php echo $opciones_cilindro_ocupacionales; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th class="titledesc">
                            <label for=""><?php _e('ADD', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="forminp forminp-text">
                            <select name="" id="add_ocupacionales">
                                <?php echo $opciones_add_ocupacionales; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th class="titledesc">
                            <label for=""><?php _e('Eje', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="forminp forminp-text">
                            <select name="" id="eje_ocupacionales">
                                <?php echo $opciones_eje_ocupacionales; ?>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
<?php

?>