<?php
/*
Plugin Name: Tecno Opticas
Plugin URI: https://tecnosoluciones.com
Description: TecnoCommerce Ópticas es un Catálogo de Monturas Oftálmicas, Lentes de Contacto, Lentes para Monturas, Gafas y Accesorios.
Version: 3.0
Author: TecnoSoluciones de Colombia S.A.S
Author URI: https://tecnosoluciones.com
License: Undefined
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


/**
 * Cargar Archivos de idioma
 * */
add_action('plugins_loaded', 'plugin_init');

function plugin_init() {

		load_plugin_textdomain( 'tecno-opticas', false, dirname(plugin_basename(__FILE__)).'/languages/' );

		if( function_exists('pll_register_string') ) { // only run if function exists
            if(get_option('tecnooptica-tipo_proceso_compra') == "opcion_1") {
                pll_register_string('tecnooptica-setup_mensaje_0', get_option("tecnooptica-setup_mensaje_0"), 'tecnooptica', true);
                pll_register_string("tecnooptica-setup_mensaje_0_1", get_option("tecnooptica-setup_mensaje_0_1"),'tecnooptica', true);
                pll_register_string("tecnooptica-setup_paso_1", get_option("tecnooptica-setup_paso_1"),'tecnooptica', true);
                pll_register_string("tecnooptica-setup_paso_2", get_option("tecnooptica-setup_paso_2"),'tecnooptica', true);
                pll_register_string("tecnooptica-setup_paso_3", get_option("tecnooptica-setup_paso_3"),'tecnooptica', true);
                pll_register_string("tecnooptica-setup_paso_4", get_option("tecnooptica-setup_paso_4"),'tecnooptica', true);
                pll_register_string("tecnooptica-setup_paso_5", get_option("tecnooptica-setup_paso_5"),'tecnooptica', true);
                pll_register_string("tecnooptica-setup_paso_6", get_option("tecnooptica-setup_paso_6"),'tecnooptica', true);
                pll_register_string("tecnooptica-setup_paso_7", get_option("tecnooptica-setup_paso_7"),'tecnooptica', true);
                pll_register_string("tecnooptica-setup_paso_8", get_option("tecnooptica-setup_paso_8"),'tecnooptica', true);
                pll_register_string("tecnooptica-setup_paso_9", get_option("tecnooptica-setup_paso_9"),'tecnooptica', true);
                pll_register_string("tecnooptica-setup_paso_10", get_option("tecnooptica-setup_paso_10"),'tecnooptica', true);
                pll_register_string("tecnooptica-setup_error_paso_2", get_option("tecnooptica-setup_error_paso_2"),'tecnooptica', true);
            }
            else{
                pll_register_string('tecnooptica-setup_mensaje_0', get_option("tecnooptica-setup_mensaje_0"), 'tecnooptica', true);
                pll_register_string('tecnooptica-setup_mensaje_paso_inicio', get_option("tecnooptica-setup_mensaje_paso_inicio"), 'tecnooptica', true);
                pll_register_string('tecnooptica-setup_mensaje_paso_1', get_option("tecnooptica-setup_mensaje_paso_1"), 'tecnooptica', true);
                pll_register_string('tecnooptica-setup_mensaje_paso_2', get_option("tecnooptica-setup_mensaje_paso_2"), 'tecnooptica', true);
                pll_register_string('tecnooptica-setup_mensaje_paso_3', get_option("tecnooptica-setup_mensaje_paso_3"), 'tecnooptica', true);
                pll_register_string('tecnooptica-setup_mensaje_paso_4', get_option("tecnooptica-setup_mensaje_paso_4"), 'tecnooptica', true);
                pll_register_string('tecnooptica-setup_mensaje_paso_5', get_option("tecnooptica-setup_mensaje_paso_5"), 'tecnooptica', true);
                pll_register_string('tecnooptica-setup_mensaje_paso_6', get_option("tecnooptica-setup_mensaje_paso_6"), 'tecnooptica', true);
                pll_register_string('tecnooptica-setup_mensaje_error_tintura', get_option("tecnooptica-setup_mensaje_error_tintura"), 'tecnooptica', true);
                pll_register_string('tecnooptica-setup_mensaje_error_tonalidad', get_option("tecnooptica-setup_mensaje_error_tonalidad"), 'tecnooptica', true);
                pll_register_string('tecnooptica-setup_mensaje_error_plantilla', get_option("tecnooptica-setup_mensaje_error_plantilla"), 'tecnooptica', true);
                pll_register_string('tecnooptica-setup_mensaje_proceso_listo', get_option("tecnooptica-setup_mensaje_proceso_listo"), 'tecnooptica', true);
            }

            pll_register_string('tecnooptica-text-whatsapp', get_option("tecnooptica-text-whatsapp"), 'tecnooptica', true);
            pll_register_string('tecnooptica-descripcion_descanso', get_option("tecnooptica-descripcion_descanso"), 'tecnooptica', true);
            pll_register_string('tecnooptica-descripcion_vision_sencilla', get_option("tecnooptica-descripcion_vision_sencilla"), 'tecnooptica', true);
            pll_register_string('tecnooptica-descripcion_progresivo', get_option("tecnooptica-descripcion_progresivo"), 'tecnooptica', true);
            pll_register_string('tecnooptica-descripcion_bifocales', get_option("tecnooptica-descripcion_bifocales"), 'tecnooptica', true);
            pll_register_string('tecnooptica-descripcion_ocupacionales', get_option("tecnooptica-descripcion_ocupacionales"), 'tecnooptica', true);
        }

}

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
include_once (ABSPATH . 'wp-includes/pluggable.php');
$current_usuario  = wp_get_current_user();
$control = 0;

foreach($current_usuario->roles AS $key => $value) {
    if(in_array( $value, array( 'administrator', 'shop_manager','administrador' ), true )){
        $control = 1;
    }
}


define('TECNO_OPTICAS_RUTA',plugin_dir_path(__FILE__));
define('TECNO_OPTICAS_NOMBRE', 'Tecno Ópticas');

if(get_option('tecnooptica-verifi_licen')){
    $retorno = validar_licencia(get_option('tecnooptica-verifi_licen'));
}
else{
    $retorno = [
        'licencia' => "no_active",
        'mensaje' => __('Licencia no Activa', 'tecno-opticas'),
        'estado' => "error"
    ];
}

define('TECNO_OPTICAS_LICENSE', $retorno);

if ( !is_plugin_active( 'woocommerce/woocommerce.php' ) ){
    $notice= sprintf(__('Para poder activar el módulo <strong>%s</strong>, necesita tener instalado primero Woocommerce', 'tecno-opticas'), TECNO_OPTICAS_NOMBRE);
    update_option('error_need_woocommerce', $notice);
    deactivate_plugins("tecno-opticas/tecno-opticas.php");

    function tecno_optica_mensaje($notice){
        $class = 'notice notice-error';
        if ($notices = get_option('error_need_woocommerce')){
            echo '<div class="'.$class.'"><p>'.get_option('error_need_woocommerce').'</p></div>';
            delete_option('error_need_woocommerce');
        }
    }

    add_action( 'admin_notices','tecno_optica_mensaje');

    return 0;
}

add_action("wp_enqueue_scripts", "js_optica");
add_action( 'wp_enqueue_scripts', 'styles_optica');

if($control != 0){
    if(is_admin()) {
        add_action('admin_enqueue_scripts', 'estilos_administracion');
        add_action('wp_ajax_validar_licencia', 'validar_licencia_c');
        add_action('init', 'maybe_activate_tecnocommerces_optica');
    }
}

add_action( 'woocommerce_update_cart_action_cart_updated', 'on_action_cart_updated', 20 );
add_action("woocommerce_before_cart_contents", "modifcar_carito");
add_action( 'wp_enqueue_scripts','plaantilla_style' );


function estilos_administracion(){
    $screen = get_current_screen();

    $is_woocommerce_screen = in_array( $screen->id, array( 'tecno-opticas/admin/licencia', 'product', 'edit-shop_order', 'shop_order', 'edit-shop_subscription', 'shop_subscription', 'users', 'woocommerce_page_wc-settings', 'tecno-opticas/admin/formulas' ) );

    wp_enqueue_style( 'woocommerce_tecnooptica_admin', plugin_dir_url( __FILE__ ) . 'includes/assets/css/admin.css', array( 'woocommerce_admin_styles' ), "1.0.0" );
    wp_enqueue_style( 'font-awesome-tecno-optica', plugin_dir_url( __FILE__ ) . 'includes/assets/css/fontawesome.min.css', array( ), "5.15.4" );

    if ( $is_woocommerce_screen ) {
        $dependencies = array('jquery');
        $script_params['ajaxLoaderImage'] = WC()->plugin_url() . '/assets/images/select2-spinner.gif';
        $script_params['ajaxUrl'] = admin_url('admin-ajax.php');
        $script_params['validar_exlucir_form'] = get_option('tecnooptica-setupexclude_form');
        wp_enqueue_script('woocommerce_optioptions_admin', plugin_dir_url(__FILE__) . 'includes/assets/js/admin/admin.js', $dependencies, filemtime(plugin_dir_path(__FILE__) . 'assets/js/admin/admin.js'));
        wp_localize_script('woocommerce_optioptions_admin', 'tecnooptica', $script_params);
    }
    
     if(TECNO_OPTICAS_LICENSE['licencia'] == "no_active") {
        $script_params['licencia'] = '<div class="notice notice-error" id="tecno-optica-noticia">
                 <p>'.sprintf( __("El estado de su licencia es <strong>%s</strong>", "tecno-opticas"), TECNO_OPTICAS_LICENSE['mensaje'] ).'</p>
                 <p>'.__("Por favor, compre una licencia para desbloquear el acceso a las actualizaciones, mejoras de seguridad, soporte en línea y documentación.','tecno-opticas").'</p>
                 <p>'.__("Si ya usted tiene su licencia por favor ingrese <a href=\"/wp-admin/admin.php?page=tecno-opticas/admin/licencia.php\">aquí</a> para activar el plugin.", "tecno-opticas").'</p>
            </div>';
            
        wp_enqueue_script('woocommerce_optioptions_admin', plugin_dir_url(__FILE__) . 'includes/assets/js/admin/licencia.js', $dependencies, filemtime(plugin_dir_path(__FILE__) . 'assets/js/admin/admin.js'));
        wp_localize_script('woocommerce_optioptions_admin', 'licence_tecnooptica', $script_params);
    }
}

function styles_optica() {
    wp_enqueue_style( 'tecno-optica-styles',plugins_url( '/css/styles.css',__FILE__) ,array());
}

function js_optica(){
    global $woocommerce;
    if(is_product() || $_POST['formulado'] == "Si") {
    $dependencies = array( 'jquery' );
    $cart_page_url = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : $woocommerce->cart->get_cart_url();

    $rates = WC_Tax::get_rates();

        if (count($rates) != 0) {
            foreach ($rates AS $key => $value) {
                $base_iva = $value['rate'];
            }
        } else {
            $base_iva = "no_aplica";
        }

        $script_params['ajaxLoaderImage'] = WC()->plugin_url() . '/assets/images/select2-spinner.gif';
        $script_params['ajaxUrl'] = admin_url('admin-ajax.php');
        $script_params['mensajes'] = get_mensaje();
        $script_params['mensajes_ajax'] = mensajes_ajax();
        $script_params['validar_exlucir_form'] = get_option('tecnooptica-setupexclude_form');
        $script_params['url_carrito'] = $cart_page_url;
        $script_params['iva'] = $base_iva;
        $formulas = pre_cargarform();
        $script_params['fomulas'] = $formulas;

        if (get_option('tecnooptica-tipo_proceso_compra') == "opcion_1") {
            wp_register_script('tecno-optica-scripts', plugins_url('/js/tecno_optic.js', __FILE__), $dependencies, 1.0, true);
        } else {
            wp_register_script('tecno-optica-scripts', plugins_url('/js/tecno_optic_op_do.js', __FILE__), $dependencies, 1.0, true);
        }
        wp_localize_script('tecno-optica-scripts', 'tecnooptica_proceso', $script_params);
        wp_enqueue_script('tecno-optica-scripts');
    }
}

function mensajes_ajax(){
    $data["tecnooptica_ajax_1"] = __("Estimado cliente no ha agregado un nombre a su plantilla, si no agrega un nombre no podra guardarse para futuras compras. ¿Seguro que desea continuar sin nombrar la plantilla?", "tecno-opticas");
    $data["tecnooptica_ajax_2"] = __("El valor del campo ADD para el ojo Izquierdo esta en %variable_cambio%, esta seguro de que es correcto?", "tecno-opticas");
    $data["tecnooptica_ajax_3"] = __("El valor del campo ADD para el ojo Derecho esta en %variable_cambio%, esta seguro de que es correcto?", "tecno-opticas");
    $data["tecnooptica_ajax_4"] = __("El valor del campo EJE para el ojo Izquierdo esta en %variable_cambio%, esta seguro de que es correcto?", "tecno-opticas");
    $data["tecnooptica_ajax_5"] = __("El valor del campo EJE para el ojo Derecho esta en %variable_cambio%, esta seguro de que es correcto?", "tecno-opticas");
    $data["tecnooptica_ajax_6"] = __("El valor del campo CILINDRO para el ojo Izquierdo esta en %variable_cambio%, esta seguro de que es correcto?", "tecno-opticas");
    $data["tecnooptica_ajax_7"] = __("El valor del campo CILINDRO para el ojo Derecho esta en %variable_cambio%, esta seguro de que es correcto?", "tecno-opticas");
    $data["tecnooptica_ajax_8"] = __("El valor del campo ESFERA para el ojo Izquierdo esta en %variable_cambio%, esta seguro de que es correcto?", "tecno-opticas");
    $data["tecnooptica_ajax_9"] = __("El valor del campo ESFERA para el ojo Derecho esta en %variable_cambio%, esta seguro de que es correcto?", "tecno-opticas");
    $data["tecnooptica_ajax_10"] = __("El valor del campo Altura esta vacio o es igual a 0 (cero), este campo es obligatorio.", "tecno-opticas");
    $data["tecnooptica_ajax_11"] = __("El valor del campo DP esta vacio o es igual a 0 (cero), este campo es obligatorio.", "tecno-opticas");
    $data["tecnooptica_ajax_12"] = __("Observamos datos incoherentes en la formula, ¿Seguro que ingresaste los datos correctos? Si crees que todo está bien presiona el botón Aceptar, de lo contrario por favor corrige la fórmula.", "tecno-opticas");
    $data["tecnooptica_ajax_13"] = __("Debe seleccionar algun lente para continuar en el proceso de compra.", "tecno-opticas");
    $data["tecnooptica_ajax_14"] = __("El valor del campo ADD esta en 0, debe agregar su ADD para poder avanzar.", "tecno-opticas");

    return $data;
}

function pre_cargarform(){
    if(get_option('tecnooptica-setupexclude_form_vs') == "yes"){
        $form_impri["vision_sencilla"] = obtener_formulas("vision_sencilla");
    }

    if(get_option('tecnooptica-setupexclude_form_bifocales') == "yes"){
        $form_impri["progresivos"] = obtener_formulas("progresivos");
    }

    if(get_option('tecnooptica-setupexclude_form_progresivo') == "yes"){
        $form_impri["bifocales"] = obtener_formulas("bifocales");
    }

    if(get_option('tecnooptica-setupexclude_form_ocupacionales') == "yes"){
        $form_impri["ocupacionales"] = obtener_formulas("ocupacionales");
    }

    return $form_impri;
}

function obtener_formulas($tipo_vision){
    $opciones_esfera = "";
    $opciones_cilindro = "";
    $opciones_eje = "";
    $opciones_add = "";
    $add_der = "";
    $add_izq = "";
    $th_add = "";
    $add_movil_derecho = "";
    $add_movil_izquierdo = "";
    $upload_max_size = ini_get('upload_max_filesize');

    $args = array(
        'post_type' => $tipo_vision,
    );
    $loop = new WP_Query($args);
    $id_tipo_lente = $loop->post->ID;

    $rang_positiv_esfera = get_post_meta($id_tipo_lente, "rang_positiv_esfera", true);
    $rang_negativ_esfera = get_post_meta($id_tipo_lente, "rang_negativ_esfera", true);
    $rang_step_esfera = get_post_meta($id_tipo_lente, "rang_step_esfera", true);

    for ($i = $rang_positiv_esfera; $i >= $rang_negativ_esfera; $i = $i - $rang_step_esfera) {
        if ($i == 0) {
            $opciones_esfera .= '<option value="'.number_format($i, 2, '.',',').'" selected="selected">'.number_format($i, 2, '.',',').'</option>';
        }
        else if($i > 0){
            if($rang_negativ_esfera == $i){
                $opciones_esfera .= '<option value="'.number_format($i, 2, '.',',').'" selected="selected"> +'.number_format($i, 2, '.',',').'</option>';
            }
            else{
                $opciones_esfera .= '<option value="'.number_format($i, 2, '.',',').'"> +'.number_format($i, 2, '.',',').'</option>';
            }
        }
        else {
            if(0 > $rang_positiv_esfera && $rang_positiv_esfera > $rang_negativ_esfera && $i == $rang_positiv_esfera){
                $opciones_esfera .= '<option value="'.number_format($i, 2, '.',',').'" selected="selected">'.number_format($i, 2, '.',',').'</option>';
            }
            else{
                $opciones_esfera .= '<option value="'.number_format($i, 2, '.',',').'">'.number_format($i, 2, '.',',').'</option>';
            }
        }
    }

    $esfera_der = '<select name="esfera-ojo-der" id="esfera-ojo-der" style="outline: rgb(244, 67, 54) solid;">' . $opciones_esfera . '</select>';
    $esfera_izq = '<select name="esfera-ojo-izq" id="esfera-ojo-izq" style="outline: rgb(244, 67, 54) solid;">' . $opciones_esfera . '</select>';

    $rang_positiv_cilindro = get_post_meta($id_tipo_lente, "rang_positiv_cilindro", true);
    $rang_negativ_cilindro = get_post_meta($id_tipo_lente, "rang_negativ_cilindro", true);
    $rang_step_cilindro = get_post_meta($id_tipo_lente, "rang_step_cilindro", true);

    for ($i = $rang_positiv_cilindro; $i >= $rang_negativ_cilindro; $i = $i - $rang_step_cilindro) {
        if ($i == 0) {
            $opciones_cilindro .= '<option value="'.number_format($i, 2, '.', ',').'" selected="selected">'.number_format($i, 2, '.', ',').'</option>';
        } else if ($i == 100) {
            imprimir_plugin("exploto");
            die;
        }
        else if($i > 0){
            if($rang_negativ_cilindro == $i){
                $opciones_cilindro .= '<option value="'.number_format($i, 2, '.', ',').'" selected="selected"> +'.number_format($i, 2, '.', ',').'</option>';
            }
            else{
                $opciones_cilindro .= '<option value="'.number_format($i, 2, '.',',').'"> +'.number_format($i, 2, '.',',').'</option>';
            }
        }
        else {
            if(0 > $rang_positiv_cilindro && $rang_positiv_cilindro > $rang_negativ_cilindro && $i == $rang_positiv_cilindro){
                $opciones_cilindro .= '<option value="'.number_format($i, 2, '.', ',').'" selected="selected">'.number_format($i, 2, '.', ',').'</option>';
            }
            else{
                $opciones_cilindro .= '<option value="'.number_format($i, 2, '.', ',').'">'.number_format($i, 2, '.', ',').'</option>';
            }
        }
    }

    $cilindro_der = '<select name="cilindro-ojo-der" id="cilindro-ojo-der" style="outline: rgb(244, 67, 54) solid;">' . $opciones_cilindro . '</select>';
    $cilindro_izq = '<select name="cilindro-ojo-izq" id="cilindro-ojo-izq" style="outline: rgb(244, 67, 54) solid;">' . $opciones_cilindro . '</select>';

    $rang_alto_eje = get_post_meta($id_tipo_lente, "rang_alto_eje", true);
    $rang_bajo_eje = get_post_meta($id_tipo_lente, "rang_bajo_eje", true);
    $rang_step_eje = get_post_meta($id_tipo_lente, "rang_step_eje", true);
    for ($i = $rang_alto_eje; $i >= $rang_bajo_eje; $i = $i - $rang_step_eje) {
        if ($i == 0) {
            $opciones_eje .= '<option value="'.$i.'" selected="selected">°'.$i.'</option>';
        } else if ($i == 300) {
            imprimir_plugin("exploto");
            die;
        } else {
            if(0 > $rang_alto_eje && $rang_alto_eje > $rang_bajo_eje && $i == $rang_alto_eje){
                $opciones_eje .= '<option value="' .$i. '" selected="selected">°' .$i. '</option>';
            }
            else{
                $opciones_eje .= '<option value="' .$i. '"> °' .$i. '</option>';
            }
        }
    }

    $eje_der = '<select name="eje-ojo-der" id="eje-ojo-der" style="outline: rgb(244, 67, 54) solid;">' . $opciones_eje . '</select>';
    $eje_izq = '<select name="eje-ojo-izq" id="eje-ojo-izq" style="outline: rgb(244, 67, 54) solid;">' . $opciones_eje . '</select>';
    $altura = "";
    $altura_mobile = "";
    switch ($tipo_vision) {
        case "progresivos":
        case "bifocales":
        case "ocupacionales":
            $rang_positiv_add = get_post_meta($id_tipo_lente, "rang_positiv_add", true);
            $rang_negativ_add = get_post_meta($id_tipo_lente, "rang_negativ_add", true);
            $rang_step_add = get_post_meta($id_tipo_lente, "rang_step_add", true);

            for ($i = $rang_positiv_add; $i >= $rang_negativ_add; $i = $i - $rang_step_add) {
                if ($i == 0) {
                    $opciones_add .= '<option value="'.number_format($i, 2, '.', ',').'" selected="selected">'.number_format($i, 2, '.', ',').'</option>';
                } else if ($i == 100) {
                    imprimir_plugin("exploto");
                    die;
                }
                else if($i > 0){
                    if($rang_negativ_add == $i){
                        $opciones_add .= '<option value="'.number_format($i, 2, '.', ',').'" selected="selected"> +'.number_format($i, 2, '.', ',').'</option>';
                    }
                    else{
                        $opciones_add .= '<option value="'.number_format($i, 2, '.',',').'"> +'.number_format($i, 2, '.',',').'</option>';
                    }
                }
                else {
                    if($i == $rang_negativ_add){
                        $opciones_add .= '<option value="'.number_format($i, 2, '.', ',').'" selected="selected">'.number_format($i, 2, '.', ',').'</option>';
                    }
                    else{
                        $opciones_add .= '<option value="'.number_format($i, 2, '.', ',').'">'.number_format($i, 2, '.', ',').'</option>';
                    }
                }
            }
            $add_der = '<select name="add-ojo-der" id="add-ojo-der" style="outline: rgb(244, 67, 54) solid;">' . $opciones_add . '</select>';
            $add_izq = '<select name="add-ojo-izq" id="add-ojo-izq" style="outline: rgb(244, 67, 54) solid;">' . $opciones_add . '</select>';

            $th_add = '<th class="title_formula">'.__("ADD", "tecno-opticas").'</th>';

            $add_der = '<td>' . $add_der . '</td>';
            $add_izq = '<td>' . $add_izq . '</td>';
            $add_movil_derecho = "
                    <div class='add'>
                        <label for='add'>".__('ADD', 'tecno-opticas')."</label>
                        ".$add_der."
                    </div>
                ";
            $add_movil_izquierdo = "
                    <div class='add'>
                        <label for='add'>".__('ADD', 'tecno-opticas')."</label>
                        ".$add_izq."
                    </div>
                ";

            if(get_option('tecnooptica-setupexclude_form_habli_altur') == "yes") {
                $altura = '
                    <div class="altura">                       
                        <label class="title_form_compr">'.__("Altura", "tecno-opticas").'</label>
                        <input placeholder="31/31" type="text" class="altura-formulate" data-raw-price="" data-price="" name="altura" value="" style="outline: rgb(244, 67, 54) solid;">
                    </div>
                ';

                $altura_mobile = '
                    <tr>
                        <td class="title_formula">'.__("Altura", "tecno-opticas").'</td>
                        <td colspan="4" class="altura-formulate">
                            <input placeholder="" type="text" class="altura-formulate" data-raw-price="" data-price="" name="altura" value="" style="outline: rgb(244, 67, 54) solid;">
                        </td>
                    </tr>
                ';
            }
            break;
    }

    $tabla_formula_mobile = '
                <div class="form_mov_proc_comr">
                    <div class="ojo_der">
                        <label class="title_form_compr">'.__("Ojo Derecho", "tecno-opticas").'</label>
                        <div class="form_ojo_der">
                            <div class="esfera">
                                <label for="">'.__("Esfera", "tecno-opticas").'</label>
                                ' . $esfera_der . '
                            </div>
                            <div class="cilindro">
                                <label for="">'.__("Cilindro", "tecno-opticas").'</label>
                                ' . $cilindro_der . '
                            </div>
                            <div class="eje">
                                <label for="">'.__("Eje", "tecno-opticas").'</label>
                                ' . $eje_der . '
                            </div>
                        </div>
                        '.$add_movil_derecho.'
                    </div>
                    <div class="ojo_izq">
                        <label class="title_form_compr">'.__("Ojo Izquierdo", "tecno-opticas").'</label>
                        <div class="form_ojo_der">
                            <div class="esfera">
                                <label for="">'.__("Esfera", "tecno-opticas").'</label>
                                ' . $esfera_izq . '
                            </div>
                            <div class="cilindro">
                                <label for="">'.__("Cilindro", "tecno-opticas").'</label>
                                ' . $cilindro_izq . '
                            </div>
                            <div class="eje">
                                <label for="">'.__("Eje", "tecno-opticas").'</label>
                                ' . $eje_izq . '
                            </div>
                            '.$add_movil_izquierdo.'
                        </div>
                    </div>
                     <div class="dp">                       
                        <label class="title_form_compr">DP</label>
                        <input placeholder="31/31" type="text" class="dp-formulate" data-raw-price="" data-price="" name="dp" value="" style="outline: rgb(244, 67, 54) solid;">
                        
                    </div>
                    '.$altura.'
                </div>
            ';
    $tabla_formula_full = '        
                <table data-control="0" id="tabla_formula">
                    <thead>
                        <tr>
                            <th></th>
                            <th class="title_formula">'.__("Esfera", "tecno-opticas").'</th>
                            <th class="title_formula">'.__("Cilindro", "tecno-opticas").'</th>
                            <th class="title_formula">'.__("Eje", "tecno-opticas").'</th>
                            ' . $th_add . '
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="title_formula">'.__("Ojo Derecho", "tecno-opticas").'</td>
                            <td>' . $esfera_der . '</td>
                            <td>' . $cilindro_der . '</td>
                            <td>' . $eje_der . '</td>
                            ' . $add_der . '
                        </tr>
                        <tr>
                            <td class="title_formula">'.__("Ojo Izquierdo", "tecno-opticas").'</td>
                            <td>' . $esfera_izq . '</td>
                            <td>' . $cilindro_izq . '</td>
                            <td>' . $eje_izq . '</td>
                            ' . $add_izq . '
                        </tr>
                        <tr>
                            <td class="title_formula">'.__("DP", "tecno-opticas").'</td>
                            <td colspan="4" class="dp-formulate">
                                <input placeholder="31/31" type="text" class="dp-formulate" data-raw-price="" data-price="" name="dp" value="" style="outline: rgb(244, 67, 54) solid;">
                               
                            </td>
                        </tr>
                        '.$altura_mobile.'
                    </tbody>
                </table>
            ';

    $mobile = '
                <div class="tt_ff">
                    <h5>'.__("ESPECIFICACIONES DE FÓRMULA", "tecno-opticas").'</h5>
                </div>
                <div class="txt_ff_ayu"><span>'.__("Por favor llene los datos que se muestran a continuación. Todos los campos en rojo son obligatorios.", "tecno-opticas").'</span></div>
                    
                '.$tabla_formula_mobile.'
                <div class="container">
                    <div class="row contac_ws">
                        <div class="col col-sm-12 col-lg-6 align-self-center">
                            <div class="txt_ayud_what">
                               '.__("Si tienes problemas para interpretar tu fórmula,
                                escríbenos vía whatsapp, uno de nuestros asesores te ayudará lo más rápido posible.", "tecno-opticas").'
                            </div>
                        </div>
                        <div class="col col-sm-12 col-lg-6 align-self-center">
                            <div class="btn_wh">
                                <a target="_blank" href="https://api.whatsapp.com/send?phone=' . get_option('tecnooptica-num-whatsapp') . '&text=' . pll__(get_option('tecnooptica-text-whatsapp')) . '" class="btn_what">'.__("Atención personalizada", "tecno-opticas").' <i class="fa fa-whatsapp"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="cont_file">
                                <span for="">
                                    '.__("Seleccione la imagen de la fórmula preescrita por su oftalmólogo/optómetra, así nosotros verificaremos que los datos que hayas ingresado sean correctos, si decides no subir tu fórmula y te equivocas al configurar las especificaciones la fórmula el lente quedará exactamente como ingresaste la fórmula.", "tecno-opticas").'
                                </span>
                                <p class="file-formula">
                                    <input type="file" class="formula-file-upload input-text" name="formula"> 
                                    <small>' . sprintf(__('(tamaño máx. de archivo %s)', "tecno-opticas"), $upload_max_size) . '</small>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="cont_file">
                                <span for="">
                                    '.__('Por favor, suba una foto de su cara para obtener medidas más precisas:', 'tecno-opticas').'
                                </span>
                                <p class="file-foto_face">
                                    <input type="file" class="foto_face-file-upload input-text" name="foto_face"> 
                                    <small>' . sprintf(__('(tamaño máx. de archivo %s)', 'tecno-opticas'), $upload_max_size) . '</small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            ';

    $full = '
                <div class="tt_ff">
                    <h5>'.__("ESPECIFICACIONES DE FÓRMULA", "tecno-opticas").'</h5>
                </div>
                <div class="txt_ff_ayu"><span>'.__("Por favor llene los datos que se muestran a continuación. Todos los campos en rojo son obligatorios.", "tecno-opticas").'</span></div>
                    
                '.$tabla_formula_full.'
                <div class="container">
                    <div class="row contac_ws">
                        <div class="col col-sm-12 col-lg-6 align-self-center">
                            <div class="txt_ayud_what">
                                '.__("Si tienes problemas para interpretar tu fórmula,
                                escríbenos vía whatsapp, uno de nuestros asesores te ayudará lo más rápido posible.", "tecno-opticas").'
                            </div>
                        </div>
                        <div class="col col-sm-12 col-lg-6 align-self-center">
                            <div class="btn_wh">
                                <a target="_blank" href="https://api.whatsapp.com/send?phone=' . get_option('tecnooptica-num-whatsapp') . '&text=' . pll__(get_option('tecnooptica-text-whatsapp')) . '" class="btn_what">'.__("Atención personalizada", "tecno-opticas").' <i class="fa fa-whatsapp"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="cont_file">
                                <span for="">
                                    '.__("Seleccione la imagen de la fórmula preescrita por su oftalmólogo/optómetra, así nosotros verificaremos que los datos que hayas ingresado sean correctos, si decides no subir tu fórmula y te equivocas al configurar las especificaciones la fórmula el lente quedará exactamente como ingresaste la fórmula.", "tecno-opticas").'
                                </span>
                                <p class="file-formula">
                                    <input type="file" class="formula-file-upload input-text" name="formula"> 
                                    <small>' . sprintf(__('(tamaño máx. de archivo %s)', "tecno-opticas"), $upload_max_size) . '</small>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="cont_file">
                                <span for="">
                                '.__('Por favor, suba una foto de su cara para obtener medidas más precisas:', 'tecno-opticas').'                                    
                                </span>
                                <p class="file-foto_face">
                                    <input type="file" class="foto_face-file-upload input-text" name="foto_face"> 
                                    <small>' . sprintf(__('(tamaño máx. de archivo %s)', 'tecno-opticas'), $upload_max_size) . '</small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            ';
    return [
        'mobile' => $mobile,
        'full' => $full,
    ];
}

function plaantilla_style() {
    $dependencies = array( 'jquery' );

    $script_params['ajaxLoaderImage'] = WC()->plugin_url() . '/assets/images/select2-spinner.gif';
    $script_params['ajaxUrl']         = admin_url( 'admin-ajax.php' );
    $script_params['validar_exlucir_form'] = get_option('tecnooptica-setupexclude_form');

    wp_register_script('tecno-optica-mi-cuenta-scripts', plugins_url('/js/plantilla.js',__FILE__),$dependencies,1.0,true);
    wp_localize_script( 'tecno-optica-mi-cuenta-scripts', 'tecnooptica_plantilla', $script_params );
    wp_enqueue_script('tecno-optica-mi-cuenta-scripts');
}

function maybe_activate_tecnocommerces_optica(){
    if ( ! get_term_by( 'slug', 'monturas', 'product_type' ) ) {
        wp_insert_term( 'monturas', 'product_type' );
    }

    if ( ! get_term_by( 'slug', 'lentes', 'product_type' ) ) {
        wp_insert_term( 'lentes', 'product_type' );
    }

    if ( ! get_term_by( 'slug', 'lentes-contacto', 'product_type' ) ) {
        wp_insert_term( 'lentes-contacto', 'product_type' );
    }

    $mnesaje_paso_0 = __("Por favor lee el proceso indicado arriba para que conozcas cómo vamos a configurar tus gafas con lentes formulados. Luego haz clic en el botón Continuar.

        <strong>Para el proceso de configuración de tus gafas con lentes formulados, por favor toma en cuenta lo siguiente:</strong>
        <ol>
            <li>Seleccionar el tipo de lente. Si te aparece la casilla <strong>Plantilla de Fórmula</strong>, puedes además escoger alguna de tus fórmulas que hayas guardado previamente.</li>
            <li>Llenar todos los campos de tu fórmula y subir la prescripción de tu optómetra.</li>
            <li>Seleccionar las características de los lentes.</li>
            <li>Seleccionar de la lista de lentes, el que más se ajusta a tus preferencias.</li>
            <li>Si quieres reutilizar la fórmula posteriormente, asigna un nombre a la misma para generar la plantilla.</li>
            <li>Luego de cumplir todos los pasos anteriores, haz clic en el botón Comprar para agregar tu montura y los lentes al carrito de compra.</li>
        </ol>",'tecno-opticas');

    if(!get_option("tecnooptica-setup_mensaje_0")){
        add_option("tecnooptica-setup_mensaje_0", $mnesaje_paso_0, "", 'no');
    }

    if(!get_option("tecnooptica-tipo_proceso_compra")){
        add_option("tecnooptica-tipo_proceso_compra", "opcion_1", "", 'no');
    }

    $mnesaje_paso_1 = __("PASO 1: Plantilla Previa",'tecno-opticas');

    if(!get_option("tecnooptica-setup_paso_1")){
        add_option("tecnooptica-setup_paso_1", $mnesaje_paso_1, "", 'no');
    }

    $descripcion_paso_1 = __("Si haz guardado una plantilla de configuración de tus gafas previamente, por favor selecciónala, de lo contrario haz clic en Continuar:",'tecno-opticas');

    if(get_option("tecnooptica-setup_descripcion_paso_1")){
        add_option("tecnooptica-setup_descripcion_paso_1", $descripcion_paso_1, "", 'no');
    }

    $mnesaje_paso_2 = __("PASO 2: Tipo de Lentes",'tecno-opticas');

    if(get_option("tecnooptica-setup_paso_2")){
        add_option("tecnooptica-setup_paso_2", $mnesaje_paso_2, "", 'no');
    }

    $descripcion_paso_2 = __("Por favor selecciona ahora uno de nuestros tipos de lentes, y luego si no son de Descanso, llena TODOS los campos de tu fórmula. Adicionalmente, te recomendamos cargar la imagen de la prescripción de la fórmula del Optómetra para verificarla. Una vez que hayas llenado todo, haz clic en el botón Continuar:",'tecno-opticas');

    if(get_option("tecnooptica-setup_descripcion_paso_2")){
        add_option("tecnooptica-setup_descripcion_paso_2", $descripcion_paso_2, "", 'no');
    }

    $mnesaje_paso_3 = __("PASO 3: Filtros",'tecno-opticas');

    if(get_option("tecnooptica-setup_paso_3")){
        add_option("tecnooptica-setup_paso_3", $mnesaje_paso_3, "", 'no');
    }

    $descripcion_paso_3 = __("Por favor selecciona el filtro del lente que prefieras, luego haz clic en el botón Continuar:",'tecno-opticas');

    if(get_option("tecnooptica-setup_descripcion_paso_3")){
        add_option("tecnooptica-setup_descripcion_paso_3", $descripcion_paso_3, "", 'no');
    }

    $mnesaje_paso_4 = __("PASO 4: Marca y Modelo de Lentes",'tecno-opticas');

    if(get_option("tecnooptica-setup_paso_4")){
        add_option("tecnooptica-setup_paso_4", $mnesaje_paso_4, "", 'no');
    }

    $descripcion_paso_4 = __("Por favor lee bien la información en pantalla acerca de los parámetros asociados a los lentes. Luego, escoge la marca y el modelo de lente que desees. Para ver los lentes disponibles, mueve la barra lateral hacia abajo.",'tecno-opticas');

    if(get_option("tecnooptica-setup_descripcion_paso_4")){
        add_option("tecnooptica-setup_descripcion_paso_4", $descripcion_paso_4, "", 'no');
    }

    $mnesaje_paso_5 = __("PASO 5: Comentarios",'tecno-opticas');

    if(get_option("tecnooptica-setup_paso_5")){
        add_option("tecnooptica-setup_paso_5", $mnesaje_paso_5, "", 'no');
    }

    $descripcion_paso_5 = __("Por favor escribe cualquier comentario que desees agregar a tu pedido y luego haz clic en el botón Continuar.",'tecno-opticas');

    if(get_option("tecnooptica-setup_descripcion_paso_5")){
        add_option("tecnooptica-setup_descripcion_paso_5", $descripcion_paso_5, "", 'no');
    }

    $mnesaje_paso_6 = __("PASO 6: Crear Plantilla",'tecno-opticas');

    if(get_option("tecnooptica-setup_paso_6")){
        add_option("tecnooptica-setup_paso_6", $mnesaje_paso_6, "", 'no');
    }

    $descripcion_paso_6 = __("Para tu comodidad en el futuro, por favor selecciona un nombre para tu plantilla y haz clic en el botón Continuar.",'tecno-opticas');

    if(get_option("tecnooptica-setup_descripcion_paso_6")){
        add_option("tecnooptica-setup_descripcion_paso_6", $descripcion_paso_6, "", 'no');
    }

    $mnesaje_paso_7 = __("PASO 7: Confirmación",'tecno-opticas');

    if(get_option("tecnooptica-setup_paso_7")){
        add_option("tecnooptica-setup_paso_7", $mnesaje_paso_7, "", 'no');
    }

    $descripcion_paso_7 = __("A continuación te mostramos todas las opciones escogidas. Por favor revisa todo y si estás conforme haz clic en el botón Agregar al Carrito",'tecno-opticas');

    if(get_option("tecnooptica-setup_descripcion_paso_7")){
        add_option("tecnooptica-setup_descripcion_paso_7", $descripcion_paso_7, "", 'no');
    }

    $mensaje_error_paso_2 = __("Observamos datos incoherentes en la formula, ¿Seguro que ingresaste los datos correctos? Si crees que todo está bien presiona el botón Aceptar, de lo contrario por favor corrige la fórmula.",'tecno-opticas');

    if(get_option("tecnooptica-setup_error_paso_2")){
        add_option("tecnooptica-setup_error_paso_2", $mensaje_error_paso_2, "", 'no');
    }

}

function get_mensaje(){
    if(get_option('tecnooptica-tipo_proceso_compra') == "opcion_1") {
        if( function_exists('pll_e') ) { // only run if function exists
            $data["tecnooptica-setup_mensaje_0"] = stripslashes(pll__(get_option("tecnooptica-setup_mensaje_0")));
            $data["tecnooptica-setup_mensaje_0_1"] = stripslashes(pll__(get_option("tecnooptica-setup_mensaje_0_1")));
            $data["tecnooptica-setup_paso_1"] = stripslashes(pll__(get_option("tecnooptica-setup_paso_1")));
            $data["tecnooptica-setup_paso_2"] = stripslashes(pll__(get_option("tecnooptica-setup_paso_2")));
            $data["tecnooptica-setup_paso_3"] = stripslashes(pll__(get_option("tecnooptica-setup_paso_3")));
            $data["tecnooptica-setup_paso_4"] = stripslashes(pll__(get_option("tecnooptica-setup_paso_4")));
            $data["tecnooptica-setup_paso_5"] = stripslashes(pll__(get_option("tecnooptica-setup_paso_5")));
            $data["tecnooptica-setup_paso_6"] = stripslashes(pll__(get_option("tecnooptica-setup_paso_6")));
            $data["tecnooptica-setup_paso_7"] = stripslashes(pll__(get_option("tecnooptica-setup_paso_7")));
            $data["tecnooptica-setup_paso_8"] = stripslashes(pll__(get_option("tecnooptica-setup_paso_8")));
            $data["tecnooptica-setup_paso_9"] = stripslashes(pll__(get_option("tecnooptica-setup_paso_9")));
            $data["tecnooptica-setup_paso_10"] = stripslashes(pll__(get_option("tecnooptica-setup_paso_10")));
            $data["tecnooptica-setup_error_paso_2"] = stripslashes(pll__(get_option("tecnooptica-setup_error_paso_2")));
        }
        else{
            $data["tecnooptica-setup_mensaje_0"] = stripslashes(get_option("tecnooptica-setup_mensaje_0"));
            $data["tecnooptica-setup_mensaje_0_1"] = stripslashes(get_option("tecnooptica-setup_mensaje_0_1"));
            $data["tecnooptica-setup_paso_1"] = stripslashes(get_option("tecnooptica-setup_paso_1"));
            $data["tecnooptica-setup_paso_2"] = stripslashes(get_option("tecnooptica-setup_paso_2"));
            $data["tecnooptica-setup_paso_3"] = stripslashes(get_option("tecnooptica-setup_paso_3"));
            $data["tecnooptica-setup_paso_4"] = stripslashes(get_option("tecnooptica-setup_paso_4"));
            $data["tecnooptica-setup_paso_5"] = stripslashes(get_option("tecnooptica-setup_paso_5"));
            $data["tecnooptica-setup_paso_6"] = stripslashes(get_option("tecnooptica-setup_paso_6"));
            $data["tecnooptica-setup_paso_7"] = stripslashes(get_option("tecnooptica-setup_paso_7"));
            $data["tecnooptica-setup_paso_8"] = stripslashes(get_option("tecnooptica-setup_paso_8"));
            $data["tecnooptica-setup_paso_9"] = stripslashes(get_option("tecnooptica-setup_paso_9"));
            $data["tecnooptica-setup_paso_10"] = stripslashes(get_option("tecnooptica-setup_paso_10"));
            $data["tecnooptica-setup_error_paso_2"] = stripslashes(get_option("tecnooptica-setup_error_paso_2"));
        }
    }
    else{
        if( function_exists('pll_e') ) { // only run if function exists
            $data["tecnooptica-setup_mensaje_paso_inicio"] = stripslashes(pll__(get_option("tecnooptica-setup_mensaje_paso_inicio")));
            $data["tecnooptica-setup_mensaje_paso_1"] = stripslashes(pll__(get_option("tecnooptica-setup_mensaje_paso_1")));
            $data["tecnooptica-setup_mensaje_paso_2"] = stripslashes(pll__(get_option("tecnooptica-setup_mensaje_paso_2")));
            $data["tecnooptica-setup_mensaje_paso_3"] = stripslashes(pll__(get_option("tecnooptica-setup_mensaje_paso_3")));
            $data["tecnooptica-setup_mensaje_paso_4"] = stripslashes(pll__(get_option("tecnooptica-setup_mensaje_paso_4")));
            $data["tecnooptica-setup_mensaje_paso_5"] = stripslashes(pll__(get_option("tecnooptica-setup_mensaje_paso_5")));
            $data["tecnooptica-setup_mensaje_paso_6"] = stripslashes(pll__(get_option("tecnooptica-setup_mensaje_paso_6")));
            $data["tecnooptica-setup_mensaje_error_tintura"] = stripslashes(pll__(get_option("tecnooptica-setup_mensaje_error_tintura")));
            $data["tecnooptica-setup_mensaje_error_tonalidad"] = stripslashes(pll__(get_option("tecnooptica-setup_mensaje_error_tonalidad")));
            $data["tecnooptica-setup_mensaje_error_plantilla"] = stripslashes(pll__(get_option("tecnooptica-setup_mensaje_error_plantilla")));
            $data["tecnooptica-setup_mensaje_proceso_listo"] = stripslashes(pll__(get_option("tecnooptica-setup_mensaje_proceso_listo")));
        }
        else{
            $data["tecnooptica-setup_mensaje_paso_inicio"] = stripslashes(get_option("tecnooptica-setup_mensaje_paso_inicio"));
            $data["tecnooptica-setup_mensaje_paso_1"] = stripslashes(get_option("tecnooptica-setup_mensaje_paso_1"));
            $data["tecnooptica-setup_mensaje_paso_2"] = stripslashes(get_option("tecnooptica-setup_mensaje_paso_2"));
            $data["tecnooptica-setup_mensaje_paso_3"] = stripslashes(get_option("tecnooptica-setup_mensaje_paso_3"));
            $data["tecnooptica-setup_mensaje_paso_4"] = stripslashes(get_option("tecnooptica-setup_mensaje_paso_4"));
            $data["tecnooptica-setup_mensaje_paso_5"] = stripslashes(get_option("tecnooptica-setup_mensaje_paso_5"));
            $data["tecnooptica-setup_mensaje_paso_6"] = stripslashes(get_option("tecnooptica-setup_mensaje_paso_6"));
            $data["tecnooptica-setup_mensaje_error_tintura"] = stripslashes(get_option("tecnooptica-setup_mensaje_error_tintura"));
            $data["tecnooptica-setup_mensaje_error_tonalidad"] = stripslashes(get_option("tecnooptica-setup_mensaje_error_tonalidad"));
            $data["tecnooptica-setup_mensaje_error_plantilla"] = stripslashes(get_option("tecnooptica-setup_mensaje_error_plantilla"));
            $data["tecnooptica-setup_mensaje_proceso_listo"] = stripslashes(get_option("tecnooptica-setup_mensaje_proceso_listo"));
        }


    }

    return $data;
}

function modifcar_carito(){
    ?>

    <script>
        jQuery( window ).load(function() {

            if(parseInt(jQuery("dd.variation-CajasOjoDerecho p").length) !== 0){
                manejar_lentes_contacto_carrito();
                jQuery(document).bind("DOMNodeInserted", function(){
                    if(jQuery(event.target).attr("class") === "woocommerce-cart-form"){
                        manejar_lentes_contacto_carrito();
                    }
                })
            }
        });

        function manejar_lentes_contacto_carrito(){
            let body_t = jQuery('body');

            jQuery("dd").each(function(e,a){
                if(jQuery(a).attr("class") === "variation-CajasOjoIzquierdo"){
                    jQuery(this).parents("td.product-name").siblings("td.product-quantity").find("input.qty").hide();
                    llave = jQuery(this).parents("td.product-name").siblings("td.product-quantity").find("input.qty").attr("name");
                    if(typeof llave === "undefined"){
                        jQuery(this).parents("td.product-details").siblings("td.product-quantity").find("input.qty").attr("style','pointer-events:none;");
                        jQuery(this).parents("td.product-details").siblings("td.product-quantity").find("span.plus").attr("style','pointer-events:none;");
                        jQuery(this).parents("td.product-details").siblings("td.product-quantity").find("span.minus").attr("style','pointer-events:none;");
                        llave = jQuery(this).parents("td.product-details").siblings("td.product-quantity").find("input.qty").attr("name");
                    }
                    llave = llave.substr(5,32);
                    cantidad_caja_ojo_izq = jQuery(a).children("p");
                    input_agregar_izq = ' <input type="number" data-llave="'+llave+'" id="caja_izq" class="input-text text" name="caja_ojo_izq['+llave+'][]" value="' + cantidad_caja_ojo_izq.text() + '" title="Cantidad" size="4" placeholder="" inputmode="numeric">';
                    cantidad_caja_ojo_izq.text("");
                    cantidad_caja_ojo_izq.append(input_agregar_izq);
                }
                if(jQuery(a).attr("class") === "variation-CajasOjoDerecho"){
                    llave = jQuery(this).parents("td.product-name").siblings("td.product-quantity").find("input.qty").attr("name");
                    if(typeof llave === "undefined"){
                        llave = jQuery(this).parents("td.product-details").siblings("td.product-quantity").find("input.qty").attr("name");
                    }
                    llave = llave.substr(5,32);
                    cantidad_caja_ojo_der = jQuery(a).children("p");
                    input_agregar_der = ' <input type="number" id="caja_der" data-llave="'+llave+'" class="input-text text" name="caja_ojo_der['+llave+'][]" value="' + cantidad_caja_ojo_der.text() + '" title="Cantidad" size="4" placeholder="" inputmode="numeric">';
                    cantidad_caja_ojo_der.text("");
                    cantidad_caja_ojo_der.append(input_agregar_der);
                }
            });

            body_t.on('keyup mouseup',"input#caja_der", function () {
                cantidad_actual = jQuery(this).parents("td.product-name").siblings("td.product-quantity").find(".qty");
                if(parseInt(cantidad_actual.length) === 0){
                    cantidad_actual = jQuery(this).parents("td.product-details").siblings("td.product-quantity").find("input.qty");
                }
                cantidad_der = jQuery(this);
                cantidad_izq = jQuery(this).parents("dl.variation").children("dd.variation-CajasOjoIzquierdo").find("input#caja_izq");
                cantidad_nueva = parseInt(cantidad_der.val()) + parseInt(cantidad_izq.val());
                cantidad_actual.val(cantidad_nueva);
                cantidad_actual.change();
            });
            body_t.on('keyup mouseup',"input#caja_izq", function () {
                cantidad_actual = jQuery(this).parents("td.product-name").siblings("td.product-quantity").find(".qty");
                if(parseInt(cantidad_actual.length) === 0){
                    cantidad_actual = jQuery(this).parents("td.product-details").siblings("td.product-quantity").find("input.qty");
                }
                cantidad_izq = jQuery(this);
                cantidad_der = jQuery(this).parents("dl.variation").children("dd.variation-CajasOjoDerecho").find("input#caja_der");
                cantidad_nueva = parseInt(cantidad_der.val()) + parseInt(cantidad_izq.val());
                cantidad_actual.val(cantidad_nueva);
                cantidad_actual.change();
            });
        }
    </script>
    <?php

}

function on_action_cart_updated( ){

    if(!empty($_POST['caja_ojo_der'])) {
        $ojo_der = $_POST['caja_ojo_der'];
        $ojo_izq = $_POST['caja_ojo_izq'];

        foreach ($ojo_der AS $key => $value) {
            WC()->cart->cart_contents[$key]['cantidad_esfera_ojo_der'] = $value[0];
        }

        foreach ($ojo_izq AS $key => $value) {
            WC()->cart->cart_contents[$key]['cantidad_esfera_ojo_izq'] = $value[0];
        }
    }
}

if(is_admin()) {
    include(TECNO_OPTICAS_RUTA . '/includes/opciones.php');
}

if(TECNO_OPTICAS_LICENSE['licencia'] != "no_active") {

    include(TECNO_OPTICAS_RUTA . '/includes/functions.php');
    include(TECNO_OPTICAS_RUTA . '/includes/lentes_contactos_administracion.php');
    include(TECNO_OPTICAS_RUTA . '/includes/proceso_compra.php');
    include(TECNO_OPTICAS_RUTA . '/includes/proceso_compra_lentes_contacto.php');
    include(TECNO_OPTICAS_RUTA . '/includes/plantilla_formula.php');
}

function validar_licencia_c(){
    $licencia = $_POST['licencia'];

    $respuesta = validar_licencia($licencia);

    if($respuesta['estado'] == "error"){
        $mensaje =
            [
                'mensaje' => '
                        <div class="alert alert-'.$respuesta['estado'].'" role="alert">
                            '.$respuesta['mensaje'].'
                        </div>
                    ',
                'estado' => $respuesta['estado']
            ];

        echo json_encode($mensaje);
    }
    else if($respuesta['estado'] == "success"){

        if(!get_option("tecnooptica-verifi_licen")){
            add_option("tecnooptica-verifi_licen", $licencia, "", 'no');
        }
        else{
            update_option("tecnooptica-verifi_licen", $licencia, 'no');
        }

        $mensaje =
            [
                'mensaje' => '
                        <div class="alert alert-'.$respuesta['estado'].'" role="alert">
                            '.$respuesta['mensaje'].'
                        </div>
                    ',
                'estado' => $respuesta['estado']

            ];

        echo json_encode($mensaje);
    }

    wp_die();
}

function activar_licencia($licencia){
    $post_url = 'https://tienda.tecnosoluciones.com/';

    $parameters = array(
        // The API command
        // The fslm_v2_api_request parameter takes one of the following values
        // verify, activate, deactivate, details, extra_data
        'fslm_v2_api_request' => 'activate',

        // Your API Key
        // You can set your API key in the page
        // License Manager > Settings > API
        'fslm_api_key'        => '0A9Q5OXT13in3LGjM9F3',

        // The License Key
        'license_key'         => $licencia,

        // The device ID
        // The Device ID is optional, but if it is used and the license keys was activated with it
        // it becomes required, a license key activated with a Device ID can't be deactivated
        // without it and can't be activated again without it.
        // The device ID can be anything you want, its role is to identify the "Device",
        //  "Machine" or "Domain" where the license was activated.
        'device_id'           => $_SERVER['SERVER_NAME']
    );

    $fields_string = "";
    foreach($parameters as $key=>$value) {
        $fields_string .= $key.'='.$value.'&';
    }
    rtrim($fields_string, '&');

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $post_url);
    curl_setopt($ch, CURLOPT_POST, count($parameters));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $result = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($result);

    $mensaje = licences_code($result);

    if($result->result == "success"){
        $licencia = [
            'licencia' => "active",
            'mensaje' => $mensaje['mensaje'],
            'estado' => $mensaje['result']
        ];
    }
    else{
        $licencia = [
            'licencia' => "no_active",
            'mensaje' => $mensaje['mensaje'],
            'estado' => $mensaje['result']
        ];
    }

    return $licencia;
}

function validar_licencia($licencia){
    $post_url = 'https://tienda.tecnosoluciones.com/';

    $parameters = array(
        // The API command
        // The fslm_v2_api_request parameter takes one of the following values
        // verify, activate, deactivate, details, extra_data
        'fslm_v2_api_request' => 'details',

        // Your API Key
        // You can set your API key in the page
        // License Manager > Settings > API
        'fslm_api_key'        => '0A9Q5OXT13in3LGjM9F3',

        // The License Key
        'license_key'         => $licencia,

        // The device ID
        // The Device ID is optional, but if it is used and the license keys was activated with it
        // it becomes required, a license key activated with a Device ID can't be deactivated
        // without it and can't be activated again without it.
        // The device ID can be anything you want, its role is to identify the "Device",
        //  "Machine" or "Domain" where the license was activated.
        'device_id'           => $_SERVER['SERVER_NAME']
    );

    $fields_string = "";
    foreach($parameters as $key=>$value) {
        $fields_string .= $key.'='.$value.'&';
    }
    rtrim($fields_string, '&');

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $post_url);
    curl_setopt($ch, CURLOPT_POST, count($parameters));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $result = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($result);

    if(empty($result->device_id)){
        $licencia = activar_licencia($licencia);

    }
    else{
        if($result->device_id == '["'.$_SERVER['SERVER_NAME'].'"]'){
            $licencia = activar_licencia($licencia);
        }
        else{
            $mensaje = licences_code($result);
            $licencia = [
                'licencia' => "no_active",
                'mensaje' => $mensaje['mensaje'],
                'estado' => $mensaje['result']
            ];
        }
    }

    return $licencia;
}

function licences_code($result){
    switch ($result->code){
        case "100":
            $respuesta = [
                'mensaje' => __("Clave de licencia inválida", 'tecno-opticas'),
                'code' => $result->code,
                'result' => $result->result
            ];
            break;
        case "200":
            $respuesta = [
                'mensaje' => __("Clave API no válida", 'tecno-opticas'),
                'code' => $result->code,
                'result' => $result->result
            ];
            break;
        case "300":
            $respuesta = [
                'mensaje' => __("Clave de licencia activada", 'tecno-opticas'),
                'code' => $result->code,
                'result' => $result->result
            ];
            break;
        case "400":
            $respuesta = [
                'mensaje' => __("Clave de licencia desactivada", 'tecno-opticas'),
                'code' => $result->code,
                'result' => $result->result
            ];
            break;
        case "450":
            $respuesta = [
                'mensaje' => __("Clave de licencia ya inactiva", 'tecno-opticas'),
                'code' => $result->code,
                'result' => $result->result
            ];
            break;
        case "500":
            $respuesta = [
                'mensaje' => __("Clave de licencia válida", 'tecno-opticas'),
                'code' => $result->code,
                'result' => $result->result
            ];
            break;
        case "550":
            $respuesta = [
                'mensaje' => __("Clave de licencia caducada", 'tecno-opticas'),
                'code' => $result->code,
                'result' => $result->result
            ];
            break;
        case "600":
            $respuesta = [
                'mensaje' => __("Parámetros no válidos", 'tecno-opticas'),
                'code' => $result->code,
                'result' => $result->result
            ];
            break;
        case "650":
            $respuesta = [
                'mensaje' => __("Su dominio no es válido", 'tecno-opticas'),
                'code' => $result->code,
                'result' => $result->result
            ];
            break;
        case "700":
            $respuesta = [
                'mensaje' => __("Se requiere un ID de dispositivo, esta clave de licencia fue activada con un ID de dispositivo, se requiere un ID de dispositivo para desactivarla", 'tecno-opticas'),
                'code' => $result->code,
                'result' => $result->result
            ];
            break;
        case "000":
            $respuesta = [
                'mensaje' => __('Se ha producido un error, vuelva a intentarlo', 'tecno-opticas'),
                'code' => $result->code,
                'result' => $result->result
            ];
            break;
    }

    return $respuesta;
}

function imprimir_plugin($datos){
    echo '<pre>';
    print_r($datos);
    echo '</pre>';
}
?>