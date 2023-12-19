<?php
/**
 * Created by PhpStorm.
 * User: DESAR01
 * Date: 13/09/2021
 * Time: 3:21 PM
 */
if (! current_user_can ('manage_options')) wp_die (__('No tienes suficientes permisos para acceder a esta página.', 'tecno-opticas'));

$args = array(
    'post_type' => 'miopia',
);
$loop = new WP_Query($args);
$miopia = $loop->post->ID;

$opciones = "";
$opciones_astigmatismo_esfera = "";
$opciones_astigmatismo_cilindro = "";
$opciones_astigmatismo_eje = "";

$args = array(
    'post_type' => 'astigmatismo',
);
$loop = new WP_Query($args);
$astimagtismo = $loop->post->ID;

$class_mostrar = "none";
$class_mostrar_astigmatismo = "none";

if( $miopia != 0) {
    $rang_alto_esfera = get_post_meta($miopia, "rango-alto", true);
    $rang_bajo_esfera = get_post_meta($miopia, "rango-bajo", true);
    $rang_step_esfera = get_post_meta($miopia, "step-esfera", true);
    $formula = get_post_meta($miopia, "formula", true);
    foreach($formula['esfera'] AS $key => $value){
        if($value == "0,00"){
            $opciones .= '<option selected value="'.$value.'">'.$value.'</option>';
        }
        else{
            $opciones .= '<option value="'.$value.'">'.$value.'</option>';
        }
    }

    $class_mostrar = "block";
}

if($astimagtismo != 0){
    $rang_alto_esfera = get_post_meta($astimagtismo, "rango-alto-esfera", true);
    $rang_bajo_esfera = get_post_meta($astimagtismo, "rango-bajo-esfera", true);
    $rang_step_esfera = get_post_meta($astimagtismo, "step-esfera", true);
    $rang_alto_cilindro = get_post_meta($astimagtismo, "rango-alto-cilindro", true);
    $rang_bajo_cilindro = get_post_meta($astimagtismo, "rango-bajo-cilindro", true);
    $rang_step_cilindro = get_post_meta($astimagtismo, "step-cilindro", true);
    $rang_alto_eje = get_post_meta($astimagtismo, "rango-alto-eje", true);
    $rang_bajo_eje = get_post_meta($astimagtismo, "rango-bajo-eje", true);
    $rang_step_eje = get_post_meta($astimagtismo, "step-eje", true);
    $formula = get_post_meta($astimagtismo, "formula", true);

    foreach($formula['esfera'] AS $key => $value){
        if($value == "0,00"){
            $opciones_astigmatismo_esfera .= '<option selected value="'.$value.'">'.$value.'</option>';
        }
        else if($value > "0,00"){
            if($value == $rang_bajo_esfera){
                $opciones_astigmatismo_esfera .= '<option selected value="'.$value.'">'.$value.'</option>';
            }
            else {
                $opciones_astigmatismo_esfera .= '<option value="'.$value.'">'.$value.'</option>';
            }
        }
        else{
            if($value == $rang_bajo_esfera){
                $opciones_astigmatismo_esfera .= '<option selected value="'.$value.'">'.$value.'</option>';
            }
            else {
                $opciones_astigmatismo_esfera .= '<option value="'.$value.'">'.$value.'</option>';
            }
        }
    }

    foreach($formula['cilindro'] AS $key => $value){
        if($value == "0,00"){
            $opciones_astigmatismo_cilindro .= '<option selected value="'.$value.'">'.$value.'</option>';
        }
        else if($value > "0,00"){
            if($value == $rang_bajo_cilindro){
                $opciones_astigmatismo_cilindro .= '<option selected value="'.$value.'">'.$value.'</option>';
            }
            else {
                $opciones_astigmatismo_cilindro .= '<option value="'.$value.'">'.$value.'</option>';
            }
        }
        else{
            if($value == $rang_bajo_cilindro){
                $opciones_astigmatismo_cilindro .= '<option selected value="'.$value.'">'.$value.'</option>';
            }
            else {
                $opciones_astigmatismo_cilindro .= '<option value="'.$value.'">'.$value.'</option>';
            }
        }
    }

    foreach($formula['eje'] AS $key => $value){
        if($value == 0){
            $opciones_astigmatismo_eje .= '<option selected value="'.$value.'">'.$value.'°</option>';
        }
        else{
            $opciones_astigmatismo_eje .= '<option value="'.$value.'">'.$value.'°</option>';
        }
    }

    $class_mostrar_astigmatismo = "block";
}

?>
    <div class="wrap woocommerce">
        <nav class="nav-tab-wrapper woo-nav-tab-wrapper" id="cam_vision">
            <a class="nav-tab nav-tab-active" id="miopia_o_hipermetropia"><?php _e('Miopía o Hipermetropía', 'tecno-opticas'); ?></a>
            <a class="nav-tab" id="astigmatismo"><?php _e('Astigmatismo', 'tecno-opticas'); ?></a>
        </nav>
        <div class="content-form">

            <div id="mensaje"></div>

            <div id="miopia_o_hipermetropia" class="content formula">
                <h2><?php _e('Rango de fórmulas para lentes de contacto con visión Miopía o Hipermetropía', 'tecno-opticas'); ?></h2>
                <div id="descripcion_miopia_o_hipermetropia" class="descripcionform">
                    <p>
                    <?php _e('Aquí usted debe configurar el rango correspondiente al campo Esfera para los lentes de contacto con visión Miopía o Hipermetropía.', 'tecno-opticas'); ?>
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
                            <input type="text" value="<?php echo $rang_alto_esfera; ?>" data-name="<?php _e('rango alto de la esfera', 'tecno-opticas'); ?>" pattern="^[0-9]+" name="rango-alto-esfera" title="<?php _e('Valor del rango más alto', 'tecno-opticas'); ?>">
                        </td>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_bajo_esfera; ?>" data-name="<?php _e('rango bajo de la esfera', 'tecno-opticas'); ?>" name="rango-bajo-esfera" pattern="^[0-9]-" title="<?php _e('Valor del rango más bajo', 'tecno-opticas'); ?>">
                        </td>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_step_esfera; ?>" data-name="<?php _e('salto de la esfera', 'tecno-opticas'); ?>" pattern="^[0-9]+" name="step-esfera" title="<?php _e('salto de los valores', 'tecno-opticas'); ?>">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <button id="guardar-miopia_o_hipermetropia" class="button-primary woocommerce-save-button" value="Guardar los cambios">
                                <?php _e('Guardar los cambios', 'tecno-opticas'); ?>
                            </button>
                        </td>
                    </tr>
                </table>

                <hr>

                <p style="display: <?php echo $class_mostrar; ?>"> <?php _e('Así se verá el campo de la fórmula para lentes de contacto de visión Miopía o Hipermetropía con el rango que usted ha configurado:', 'tecno-opticas'); ?> </p>

                <table class="form-table vista_previa" style="display: <?php echo $class_mostrar; ?>">
                    <tr>
                        <th class="titledesc">
                            <label for=""><?php _e('Esfera', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="forminp forminp-text">
                            <select name="" id="esfera">
                                <?php echo $opciones; ?>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>

            <div id="astigmatismo" class="content formula" style="display: none;">
                <h2><?php _e('Rango de fórmulas para lentes de contacto con visión Astigmatismo', 'tecno-opticas'); ?></h2>
                <div id="descripcion_astigmatismo" class="descripcionform">
                    <p>
                        <?php _e('Aquí usted debe configurar los rangos correspondientes a los campos Esfera, Cilindro y Eje para los lentes de contacto con visión Astigmatismo.', 'tecno-opticas'); ?>
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
                            <input type="text" value="<?php echo $rang_alto_esfera; ?>" pattern="^[0-9]+" name="rango-alto-esfera" title="<?php _e('Valor del rango más alto', 'tecno-opticas'); ?>" data-name="<?php _e('rango alto de la esfera', 'tecno-opticas'); ?>">
                        </td>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_bajo_esfera; ?>" name="rango-bajo-esfera" pattern="^[0-9]-" title="<?php _e('Valor del rango más bajo', 'tecno-opticas'); ?>" data-name="<?php _e('rango bajo de la esfera', 'tecno-opticas'); ?>">
                        </td>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_step_esfera; ?>" pattern="^[0-9]+" name="step-esfera" title="<?php _e('salto de los valores', 'tecno-opticas'); ?>" data-name="<?php _e('salto de la esfera', 'tecno-opticas'); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th class="titledesc">
                            <label for=""><?php _e('Cilindro', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_alto_cilindro; ?>" pattern="^[0-9]+" name="rango-alto-cilindro" title="<?php _e('Valor del rango más alto', 'tecno-opticas'); ?>" data-name="<?php _e('rango alto de la cilindro', 'tecno-opticas'); ?>">
                        </td>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_bajo_cilindro; ?>" pattern="^[0-9]-" name="rango-bajo-cilindro" title="<?php _e('Valor del rango más bajo', 'tecno-opticas'); ?>" data-name="<?php _e('rango bajo de la cilindro', 'tecno-opticas'); ?>">
                        </td>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_step_cilindro; ?>" pattern="^[0-9]+" name="step-cilindro" title="<?php _e('salto de los valores', 'tecno-opticas'); ?>" data-name="<?php _e('salto de la cilindro', 'tecno-opticas'); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th class="titledesc">
                            <label for=""><?php _e('Eje', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_alto_eje; ?>" pattern="^[0-9]+" name="rango-alto-eje" title="<?php _e('Valor del rango más alto', 'tecno-opticas'); ?>" data-name="<?php _e('rango alto de la eje', 'tecno-opticas'); ?>">
                        </td>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_bajo_eje; ?>" pattern="^[0-9]+" name="rango-bajo-eje" title="<?php _e('Valor del rango más bajo', 'tecno-opticas'); ?>" data-name="<?php _e('rango bajo de la eje', 'tecno-opticas'); ?>">
                        </td>
                        <td class="forminp forminp-text">
                            <input type="text" value="<?php echo $rang_step_eje; ?>" pattern="^[0-9]+" name="step-eje" title="<?php _e('salto de los valores', 'tecno-opticas'); ?>" data-name="<?php _e('salto de la eje', 'tecno-opticas'); ?>">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <button id="guardar-astigmatismo" class="button-primary woocommerce-save-button" value="Guardar los cambios">
                                <?php _e('Guardar los cambios', 'tecno-opticas'); ?>
                            </button>
                        </td>
                    </tr>
                </table>

                <hr>

                <p style="display: <?php echo $class_mostrar_astigmatismo; ?>"> <?php _e('Así se verán los campos de la fórmula para lentes de contacto de visión Astigmatismo con los rangos que usted ha configurado:', 'tecno-opticas'); ?> </p>

                <table class="form-table vista_previa" style="display: <?php echo $class_mostrar_astigmatismo; ?>">
                    <tr>
                        <th class="titledesc">
                            <label for=""><?php _e('Esfera', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="forminp forminp-text">
                            <select name="" id="esfera">
                                <?php echo $opciones_astigmatismo_esfera; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th class="titledesc">
                            <label for=""><?php _e('Cilindro', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="forminp forminp-text">
                            <select name="" id="cilindro">
                                <?php echo $opciones_astigmatismo_cilindro; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th class="titledesc">
                            <label for=""><?php _e('Eje', 'tecno-opticas'); ?></label>
                        </th>
                        <td class="forminp forminp-text">
                            <select name="" id="eje">
                                <?php echo $opciones_astigmatismo_eje; ?>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
<?php

?>