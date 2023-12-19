<?php
/**
 * Created by PhpStorm.
 * User: DESAR01
 * Date: 13/09/2021
 * Time: 3:19 PM
 */

defined( 'ABSPATH' ) or die( 'Acceso denegado' );

include(TECNO_OPTICAS_RUTA.'/includes/monturas.php');
include(TECNO_OPTICAS_RUTA.'/includes/lentes.php');
include(TECNO_OPTICAS_RUTA.'/includes/lentes_contacto.php');

if($control != 0) {
    if (is_admin()) {
        add_action('admin_enqueue_scripts', 'enqueue_styles_scripts');
        add_filter('product_type_selector', 'add_optioptions_products_to_select');
        add_action('save_post', 'save_optica_taxonomi');
        add_action('woocommerce_process_product_meta', 'save_optica_meta', 99);

        add_action('wp_ajax_insert_rang_form_vision_sencilla', 'insert_formula_vision_sencilla');
        add_action('wp_ajax_insert_rang_form_bifocales', 'insert_formula_bifocales');
        add_action('wp_ajax_insert_rang_form_progresivos', 'insert_formula_progresivos');
        add_action('wp_ajax_insert_rang_form_ocupacionales', 'insert_formula_ocupacionales');
        add_action('wp_ajax_consultar_rangos', 'consultar_rangos');
        add_action('wp_ajax_segundo_campo', 'hablitar_segundo_campo');
        add_action('wp_ajax_insertar_tabla_terc', 'insert_tabla_terc');
        add_action('wp_ajax_insertar_tabla_terc_row', 'insertar_tabla_terc_row');
        add_action('wp_ajax_insertar_tabla_cuarta', 'insert_tabla_cuarta');
        add_action('wp_ajax_insertar_nuevo_row', 'insertar_nuevo_row');
        add_action('wp_ajax_insertar_nuevo_rango', 'insertar_nuevo_rango');
        add_action('wp_ajax_mostrar_vision_sencilla', 'mostrar_configuraci_vision_sencilla');
        add_action('wp_ajax_mostrar_bifocales', 'mostrar_configuraci_bifocales');
        add_action('wp_ajax_mostrar_progresivos', 'mostrar_configuraci_progresivo');
        add_action('wp_ajax_mostrar_ocupacionales', 'mostrar_configuraci_ocupacionales');
    }
}

function add_optioptions_products_to_select($product_types){
    $product_types['monturas']          = __( 'Monturas', 'tecno-opticas' );
    $product_types['lentes'] = __( 'Lentes', 'tecno-opticas' );
    $product_types['lentes-contacto'] = __( 'Lentes de Contacto', 'tecno-opticas' );

    add_action( 'admin_footer', 'enable_js_on_wc_product' );

    return $product_types;
}

function enqueue_styles_scripts() {
    global $post;

    // Get admin screen id
    $screen = get_current_screen();

    $is_woocommerce_screen = in_array( $screen->id, array( 'tecno-opticas/admin/licencia', 'product', 'edit-shop_order', 'shop_order', 'edit-shop_subscription', 'shop_subscription', 'users', 'woocommerce_page_wc-settings', 'tecno-opticas/admin/formulas' ) );
    $is_woocommerce_screen_ajustes = in_array( $screen->id, array( 'tecno-opticas/admin/ajustes') );
    $is_woocommerce_screen_lentes_contacto = in_array( $screen->id, array( 'tecno-opticas/admin/formulas_lentes_contacto') );
    $is_activation_screen  = true;

    if(isset($post)) {
        if ($post->post_type == "filtros") {
            $dependencies = array('jquery');

            $script_params['ajaxLoaderImage'] = WC()->plugin_url() . '/assets/images/select2-spinner.gif';
            $script_params['ajaxUrl'] = admin_url('admin-ajax.php');
            $script_params['validar_exlucir_form'] = get_option('tecnooptica-setupexclude_form');

            wp_enqueue_script('woocommerce_optioptions_admin_filtros', plugin_dir_url(__FILE__) . 'assets/js/admin/filtros.js', $dependencies, filemtime(plugin_dir_path(__FILE__) . 'assets/js/admin/filtros.js'));
            wp_localize_script('woocommerce_optioptions_admin_filtros', 'tecnooptica_filtros', $script_params);
        }
    }

    if ( $is_woocommerce_screen ) {

        $dependencies = array( 'jquery' );

        $script_params_lentes['ajaxLoaderImage'] = WC()->plugin_url() . '/assets/images/select2-spinner.gif';
        $script_params_lentes['ajaxUrl']         = admin_url( 'admin-ajax.php' );
        $script_params_lentes['validar_exlucir_form'] = get_option('tecnooptica-setupexclude_form');

        wp_enqueue_script( 'woocommerce_optioptions_lentes', plugin_dir_url( __FILE__ ) . 'assets/js/admin/lentes.js', $dependencies, filemtime( plugin_dir_path( __FILE__ ) . 'assets/js/admin/lentes.js' ) );
        wp_localize_script( 'woocommerce_optioptions_lentes', 'tecnooptica_lentes', $script_params_lentes );

        $script_params_monturas['ajaxLoaderImage'] = WC()->plugin_url() . '/assets/images/select2-spinner.gif';
        $script_params_monturas['ajaxUrl']         = admin_url( 'admin-ajax.php' );
        $script_params_monturas['validar_exlucir_form'] = get_option('tecnooptica-setupexclude_form');

        wp_enqueue_script( 'woocommerce_optioptions_monturas', plugin_dir_url( __FILE__ ) . 'assets/js/admin/monturas.js', $dependencies, filemtime( plugin_dir_path( __FILE__ ) . 'assets/js/admin/monturas.js' ) );
        wp_localize_script( 'woocommerce_optioptions_monturas', 'tecnooptica_monturas', $script_params_monturas );
    }

    if ( $is_woocommerce_screen_ajustes ) {

        $dependencies = array( 'jquery' );

        $script_params['ajaxLoaderImage'] = WC()->plugin_url() . '/assets/images/select2-spinner.gif';
        $script_params['ajaxUrl']         = admin_url( 'admin-ajax.php' );
        $script_params['validar_exlucir_form'] = get_option('tecnooptica-setupexclude_form');

        wp_enqueue_script( 'woocommerce_optioptions_ajustes', plugin_dir_url( __FILE__ ) . 'assets/js/admin/ajustes.js', $dependencies, filemtime( plugin_dir_path( __FILE__ ) . 'assets/js/admin/ajustes.js' ) );
        wp_localize_script( 'woocommerce_optioptions_ajustes', 'tecnooptica_ajustes', $script_params );
    }

    if ( $is_woocommerce_screen_lentes_contacto ) {

        $dependencies = array( 'jquery' );

        $script_params['ajaxLoaderImage'] = WC()->plugin_url() . '/assets/images/select2-spinner.gif';
        $script_params['ajaxUrl']         = admin_url( 'admin-ajax.php' );
        $script_params['validar_exlucir_form'] = get_option('tecnooptica-setupexclude_form');

        wp_enqueue_script( 'woocommerce_lentes_contacto', plugin_dir_url( __FILE__ ) . 'assets/js/admin/lentes_contacto.js', $dependencies, filemtime( plugin_dir_path( __FILE__ ) . 'assets/js/admin/lentes_contacto.js' ) );
        wp_localize_script( 'woocommerce_lentes_contacto', 'tecnooptica_lentes_contacto', $script_params );
    }
}

function get_woocommerce_plugin_dir_file() {

    $woocommerce_plugin_file = '';

    foreach ( get_option( 'active_plugins', array() ) as $plugin ) {
        if ( substr( $plugin, strlen( '/woocommerce.php' ) * -1 ) === '/woocommerce.php' ) {
            $woocommerce_plugin_file = $plugin;
            break;
        }
    }

    return $woocommerce_plugin_file;
}

function save_optica_meta($post_id){
    $product = wc_get_product( $post_id );

    if(!empty($_POST['_caracteristica_lente_contacto'])){
        $tipo_lente_contacto = $_POST['_caracteristica_lente_contacto'];
        $product->update_meta_data( '_caracteristica_lente_contacto',  $tipo_lente_contacto  );
    }

    $product->save();
}

function save_optica_taxonomi($post_id){

    if(!empty($_POST)) {

        if(isset($_POST['product-type'])){
            if (taxonomy_exists("product_type")) {
                wp_set_object_terms($post_id, $_POST['product-type'], "product_type");
            }

            if (taxonomy_exists("product_visibility")) {
                if ("lentes" == $_POST['product-type']) {
                    $terms = array('exclude-from-catalog', 'exclude-from-search');
                    wp_set_object_terms($post_id, $terms, 'product_visibility');
                    $_POST['current_visibility'] = 'hidden';
                    $_POST['_visibility'] = 'hidden';
                }
            }

            if ($_POST['product-type'] == 'tintura') {
                $actualizar_tintura = array(
                    'ID' => $post_id,
                    'post_title' => wp_strip_all_tags($_POST['post_title']),
                );
                wp_update_post($actualizar_tintura);
            }
        }
    }
}

function campos_options($tipo_vision, $valor_seleccionado, $contador, $valor_primario, $valor_secundario, $valor_terciario, $valor_cuarteriano){
    switch ($valor_seleccionado){
        case 'Esfera':
            $options['Seleccionar'] = '<option value="">Seleccionar</option>';
            $options['Esfera'] = '<option value="Esfera'.$contador.'" selected="selected">'.__('Esfera', 'tecno-opticas').'</option>';
            $options['Cilindro'] = '<option value="Cilindro'.$contador.'">'.__('Cilindro', 'tecno-opticas').'</option>';
            $options['Eje'] = '<option value="Eje'.$contador.'">'.__('Eje', 'tecno-opticas').'</option>';

            if($tipo_vision != "vision_sencilla"){
                $options['ADD'] = '<option value="ADD'.$contador.'">'.__('ADD', 'tecno-opticas').'</option>';
            }
            break;
        case 'Cilindro':
            $options['Seleccionar'] = '<option value="">Seleccionar</option>';
            $options['Esfera'] = '<option value="Esfera'.$contador.'">'.__('Esfera', 'tecno-opticas').'</option>';
            $options['Cilindro'] = '<option value="Cilindro'.$contador.'" selected="selected">'.__('Cilindro', 'tecno-opticas').'</option>';
            $options['Eje'] = '<option value="Eje'.$contador.'">'.__('Eje', 'tecno-opticas').'</option>';

            if($tipo_vision != "vision_sencilla"){
                $options['ADD'] = '<option value="ADD'.$contador.'">'.__('ADD', 'tecno-opticas').'</option>';
            }
            break;
        case 'Eje':
            $options['Seleccionar'] = '<option value="">Seleccionar</option>';
            $options['Esfera'] = '<option value="Esfera'.$contador.'">'.__('Esfera', 'tecno-opticas').'</option>';
            $options['Cilindro'] = '<option value="Cilindro'.$contador.'">'.__('Cilindro', 'tecno-opticas').'</option>';
            $options['Eje'] = '<option value="Eje'.$contador.'" selected="selected">'.__('Eje', 'tecno-opticas').'</option>';

            if($tipo_vision != "vision_sencilla"){
                $options['ADD'] = '<option value="ADD'.$contador.'">'.__('ADD', 'tecno-opticas').'</option>';
            }
            break;
        case 'ADD':
            $options['Seleccionar'] = '<option value="">Seleccionar</option>';
            $options['Esfera'] = '<option value="Esfera'.$contador.'">'.__('Esfera', 'tecno-opticas').'</option>';
            $options['Cilindro'] = '<option value="Cilindro'.$contador.'">'.__('Cilindro', 'tecno-opticas').'</option>';
            $options['Eje'] = '<option value="Eje'.$contador.'" selected="selected">'.__('Eje', 'tecno-opticas').'</option>';
            $options['ADD'] = '<option value="ADD'.$contador.'" selected="selected">'.__('ADD', 'tecno-opticas').'</option>';
            break;
    }

    unset($options[$valor_primario], $options[$valor_secundario], $options[$valor_terciario], $options[$valor_cuarteriano]);
    $options_new = "";
    foreach($options AS $key => $value){
        $options_new .= $value;
    }

    return $options_new;
}

function rangos_opciones($tipo_vision, $inicio, $fin, $campo_seleccionado,$campo_primario, $tipo_rango, $campo_secundario, $campo_terciario, $campo_cuarteriano){

    $valor_seleccionado = strstr($campo_seleccionado,"_", true);

    $args = array(
        'post_type' => $tipo_vision,
    );
    $loop = new WP_Query($args);
    $id_tipo_lente = $loop->post->ID;
    if($valor_seleccionado == "Eje"){
        $valor_seleccionado = strtolower($valor_seleccionado);
        $rang_positiv_esfera = get_post_meta($id_tipo_lente, "rang_alto_" . $valor_seleccionado, true);
        $rang_negativ_esfera = get_post_meta($id_tipo_lente, "rang_bajo_" . $valor_seleccionado, true);
        $rang_step_esfera = get_post_meta($id_tipo_lente, "rang_step_" . $valor_seleccionado, true);
    }
    else {
        $valor_seleccionado = strtolower($valor_seleccionado);
        $rang_positiv_esfera = get_post_meta($id_tipo_lente, "rang_positiv_" . $valor_seleccionado, true);
        $rang_negativ_esfera = get_post_meta($id_tipo_lente, "rang_negativ_" . $valor_seleccionado, true);
        $rang_step_esfera = get_post_meta($id_tipo_lente, "rang_step_" . $valor_seleccionado, true);
    }

    switch ($tipo_rango){
        case "sub-rango":
            $name_inicio = '_rang_one['.$campo_primario.'][sub-rango]['.$campo_secundario.'][inicio]';
            $name_fin = '_rang_one['.$campo_primario.'][sub-rango]['.$campo_secundario.'][fin]';
            break;
        case "sub-rango-2":
            $name_inicio = '_rang_one['.$campo_primario.'][sub-rango]['.$campo_secundario.'][sub-rango-2]['.$campo_terciario.'][inicio]';
            $name_fin = '_rang_one['.$campo_primario.'][sub-rango]['.$campo_secundario.'][sub-rango-2]['.$campo_terciario.'][fin]';
            break;
        case "sub-rango-3":
            $name_inicio = '_rang_one['.$campo_primario.'][sub-rango]['.$campo_secundario.'][sub-rango-2]['.$campo_terciario.'][sub-rango-3]['.$campo_cuarteriano.'][inicio]';
            $name_fin = '_rang_one['.$campo_primario.'][sub-rango]['.$campo_secundario.'][sub-rango-2]['.$campo_terciario.'][sub-rango-3]['.$campo_cuarteriano.'][fin]';
            break;
        default:
            $name_inicio = '_rang_one['.$campo_primario.'][inicio]';
            $name_fin = '_rang_one['.$campo_primario.'][fin]';
            break;

    }

    $opciones_esfera_inicio = "";
    $opciones_esfera_fin = "";

    for($i=$rang_positiv_esfera;$i>=$rang_negativ_esfera;$i=$i-$rang_step_esfera){
        if($i == $inicio){
            if($i > 0){
                $opciones_esfera_inicio .= '<option value="'.$i.'" selected="selected"> +'.number_format($i, 2, ",", ".").'</option>';
            }
            else{
                $opciones_esfera_inicio .= '<option value="'.$i.'" selected="selected">'.number_format($i, 2, ",", ".").'</option>';
            }
        }
        else{
            if($i > 0){
                $opciones_esfera_inicio .= '<option value="'.$i.'"> +'.number_format($i, 2, ",", ".").'</option>';
            }
            else{
                $opciones_esfera_inicio .= '<option value="'.$i.'"> '.number_format($i, 2, ",", ".").'</option>';
            }
        }

        if($i == $fin){
            $opciones_esfera_fin .= '<option value="'.$i.'" selected="selected">'.number_format($i, 2, ",", ".").'</option>';
        }
        else{
            if($i > 0){
                $opciones_esfera_fin .= '<option value="'.$i.'"> +'.number_format($i, 2, ",", ".").'</option>';
            }
            else{
                $opciones_esfera_fin .= '<option value="'.$i.'"> '.number_format($i, 2, ",", ".").'</option>';
            }
        }
        if($i == 500){
            imprimir_plugin("exploto");
            die;
        }
    }

    $contenedor_campos = '
        <div class="camp_form"> 
            <p class="selec_tcampo form-field _field">
                    <label for="">Mayor</label>
                    <select style="" id="" name="'.$name_inicio.'" class="selec_form_campo select rang_formul_inicio">
                        '.$opciones_esfera_inicio.'
                    </select>
            </p>
            <p class="selec_tcampo form-field _field">
                    <label for="">Menor</label>
                    <select style="" id="" name="'.$name_fin.'" class="selec_form_campo select rang_formul_final">
                        '.$opciones_esfera_fin.'
                    </select>
            </p>
        </div>
    ';

    return $contenedor_campos;
}

function enable_js_on_wc_product(){
    global $post, $product_object;

    if($post){
        if(!empty(wp_get_object_terms( $post->ID, "product_type"))){
            $type = wp_get_object_terms( $post->ID, "product_type")[0]->name;

            echo "
                <script type='text/javascript'>
                    jQuery( window ).load(function() {
                        jQuery('select#product-type option[value=".$type."]').attr('selected', 'selected');
                        jQuery('select#product-type').trigger( 'select' ).trigger( 'change' );
                    });
                </script>
            ";
        }
    }
}

function insert_formula_vision_sencilla(){
    $datos = $_POST['datos'];
    $args = array(
        'post_type' => 'vision_sencilla',
    );
    $loop = new WP_Query($args);
    $id = $loop->post->ID;

    if( $id != 0){
        update_post_meta( $id, 'rang_positiv_esfera', sanitize_text_field( $datos['rang_positiv_esfera'] ) );
        update_post_meta( $id, 'rang_negativ_esfera', sanitize_text_field( $datos['rang_negativ_esfera'] ) );
        update_post_meta( $id, 'rang_step_esfera', sanitize_text_field( $datos['rang_step_esfera'] ) );
        update_post_meta( $id, 'rang_positiv_cilindro', sanitize_text_field( $datos['rang_positiv_cilindro'] ) );
        update_post_meta( $id, 'rang_negativ_cilindro', sanitize_text_field( $datos['rang_negativ_cilindro'] ) );
        update_post_meta( $id, 'rang_step_cilindro', sanitize_text_field( $datos['rang_step_cilindro'] ) );
        update_post_meta( $id, 'rang_alto_eje', sanitize_text_field( $datos['rang_alto_eje'] ) );
        update_post_meta( $id, 'rang_bajo_eje', sanitize_text_field( $datos['rang_bajo_eje'] ) );
        update_post_meta( $id, 'rang_step_eje', sanitize_text_field( $datos['rang_step_eje'] ) );
    }
    else{
        $title = "Visión Sencilla";
        $post_data = array(
            'post_title'    => wp_strip_all_tags( $title ),
            'post_status'   => 'publish',
            'post_type'     => 'vision_sencilla',
            'post_author'   => '1',
            'post_category' => '',
            'meta_input'   => array(
                'rang_positiv_esfera' => $datos['rang_positiv_esfera'],
                'rang_negativ_esfera' => $datos['rang_negativ_esfera'],
                'rang_step_esfera' => $datos['rang_step_esfera'],
                'rang_positiv_cilindro' => $datos['rang_positiv_cilindro'],
                'rang_negativ_cilindro' => $datos['rang_negativ_cilindro'],
                'rang_step_cilindro' => $datos['rang_step_cilindro'],
                'rang_alto_eje' => $datos['rang_alto_eje'],
                'rang_bajo_eje' => $datos['rang_bajo_eje'],
                'rang_step_eje' => $datos['rang_step_eje'],
            ),
            'page_template' => NULL
        );

        $id = wp_insert_post( $post_data );
    }

    echo $id;

    wp_die();
}

function insert_formula_bifocales(){
    $datos = $_POST['datos'];
    $args = array(
        'post_type' => 'bifocales',
    );
    $loop = new WP_Query($args);
    $id = $loop->post->ID;

    if( $id != 0){
        update_post_meta( $id, 'rang_positiv_esfera', sanitize_text_field( $datos['rang_positiv_esfera'] ) );
        update_post_meta( $id, 'rang_negativ_esfera', sanitize_text_field( $datos['rang_negativ_esfera'] ) );
        update_post_meta( $id, 'rang_step_esfera', sanitize_text_field( $datos['rang_step_esfera'] ) );
        update_post_meta( $id, 'rang_positiv_cilindro', sanitize_text_field( $datos['rang_positiv_cilindro'] ) );
        update_post_meta( $id, 'rang_negativ_cilindro', sanitize_text_field( $datos['rang_negativ_cilindro'] ) );
        update_post_meta( $id, 'rang_step_cilindro', sanitize_text_field( $datos['rang_step_cilindro'] ) );
        update_post_meta( $id, 'rang_positiv_add', sanitize_text_field( $datos['rang_positiv_add'] ) );
        update_post_meta( $id, 'rang_negativ_add', sanitize_text_field( $datos['rang_negativ_add'] ) );
        update_post_meta( $id, 'rang_step_add', sanitize_text_field( $datos['rang_step_add'] ) );
        update_post_meta( $id, 'rang_alto_eje', sanitize_text_field( $datos['rang_alto_eje'] ) );
        update_post_meta( $id, 'rang_bajo_eje', sanitize_text_field( $datos['rang_bajo_eje'] ) );
        update_post_meta( $id, 'rang_step_eje', sanitize_text_field( $datos['rang_step_eje'] ) );
    }
    else{
        $title = "Bifocales";
        $post_data = array(
            'post_title'    => wp_strip_all_tags( $title ),
            'post_status'   => 'publish',
            'post_type'     => 'bifocales',
            'post_author'   => '1',
            'post_category' => '',
            'meta_input'   => array(
                'rang_positiv_esfera' => $datos['rang_positiv_esfera'],
                'rang_negativ_esfera' => $datos['rang_negativ_esfera'],
                'rang_step_esfera' => $datos['rang_step_esfera'],
                'rang_positiv_cilindro' => $datos['rang_positiv_cilindro'],
                'rang_negativ_cilindro' => $datos['rang_negativ_cilindro'],
                'rang_step_cilindro' => $datos['rang_step_cilindro'],
                'rang_positiv_add' => $datos['rang_positiv_add'],
                'rang_negativ_add' => $datos['rang_negativ_add'],
                'rang_step_add' => $datos['rang_step_add'],
                'rang_alto_eje' => $datos['rang_alto_eje'],
                'rang_bajo_eje' => $datos['rang_bajo_eje'],
                'rang_step_eje' => $datos['rang_step_eje'],
            ),
            'page_template' => NULL
        );

        $id = wp_insert_post( $post_data );
    }

    echo $id;

    wp_die();
}

function insert_formula_progresivos(){
    $datos = $_POST['datos'];

    $args = array(
        'post_type' => 'progresivos',
    );
    $loop = new WP_Query($args);
    $id = $loop->post->ID;

    if( $id != 0){
        update_post_meta( $id, 'rang_positiv_esfera', sanitize_text_field( $datos['rang_positiv_esfera'] ) );
        update_post_meta( $id, 'rang_negativ_esfera', sanitize_text_field( $datos['rang_negativ_esfera'] ) );
        update_post_meta( $id, 'rang_step_esfera', sanitize_text_field( $datos['rang_step_esfera'] ) );
        update_post_meta( $id, 'rang_positiv_cilindro', sanitize_text_field( $datos['rang_positiv_cilindro'] ) );
        update_post_meta( $id, 'rang_negativ_cilindro', sanitize_text_field( $datos['rang_negativ_cilindro'] ) );
        update_post_meta( $id, 'rang_step_cilindro', sanitize_text_field( $datos['rang_step_cilindro'] ) );
        update_post_meta( $id, 'rang_positiv_add', sanitize_text_field( $datos['rang_positiv_add'] ) );
        update_post_meta( $id, 'rang_negativ_add', sanitize_text_field( $datos['rang_negativ_add'] ) );
        update_post_meta( $id, 'rang_step_add', sanitize_text_field( $datos['rang_step_add'] ) );
        update_post_meta( $id, 'rang_alto_eje', sanitize_text_field( $datos['rang_alto_eje'] ) );
        update_post_meta( $id, 'rang_bajo_eje', sanitize_text_field( $datos['rang_bajo_eje'] ) );
        update_post_meta( $id, 'rang_step_eje', sanitize_text_field( $datos['rang_step_eje'] ) );
    }
    else{
        $title = "Progresivos";
        $post_data = array(
            'post_title'    => wp_strip_all_tags( $title ),
            'post_status'   => 'publish',
            'post_type'     => 'progresivos',
            'post_author'   => '1',
            'post_category' => '',
            'meta_input'   => array(
                'rang_positiv_esfera' => $datos['rang_positiv_esfera'],
                'rang_negativ_esfera' => $datos['rang_negativ_esfera'],
                'rang_step_esfera' => $datos['rang_step_esfera'],
                'rang_positiv_cilindro' => $datos['rang_positiv_cilindro'],
                'rang_negativ_cilindro' => $datos['rang_negativ_cilindro'],
                'rang_step_cilindro' => $datos['rang_step_cilindro'],
                'rang_positiv_add' => $datos['rang_positiv_add'],
                'rang_negativ_add' => $datos['rang_negativ_add'],
                'rang_step_add' => $datos['rang_step_add'],
                'rang_alto_eje' => $datos['rang_alto_eje'],
                'rang_bajo_eje' => $datos['rang_bajo_eje'],
                'rang_step_eje' => $datos['rang_step_eje'],
            ),
            'page_template' => NULL
        );

        $id = wp_insert_post( $post_data );
    }

    echo $id;

    wp_die();
}

function insert_formula_ocupacionales(){
    $datos = $_POST['datos'];

    $args = array(
        'post_type' => 'ocupacionales',
    );
    $loop = new WP_Query($args);
    $id = $loop->post->ID;

    if( $id != 0){
        update_post_meta( $id, 'rang_positiv_esfera', sanitize_text_field( $datos['rang_positiv_esfera'] ) );
        update_post_meta( $id, 'rang_negativ_esfera', sanitize_text_field( $datos['rang_negativ_esfera'] ) );
        update_post_meta( $id, 'rang_step_esfera', sanitize_text_field( $datos['rang_step_esfera'] ) );
        update_post_meta( $id, 'rang_positiv_cilindro', sanitize_text_field( $datos['rang_positiv_cilindro'] ) );
        update_post_meta( $id, 'rang_negativ_cilindro', sanitize_text_field( $datos['rang_negativ_cilindro'] ) );
        update_post_meta( $id, 'rang_step_cilindro', sanitize_text_field( $datos['rang_step_cilindro'] ) );
        update_post_meta( $id, 'rang_positiv_add', sanitize_text_field( $datos['rang_positiv_add'] ) );
        update_post_meta( $id, 'rang_negativ_add', sanitize_text_field( $datos['rang_negativ_add'] ) );
        update_post_meta( $id, 'rang_step_add', sanitize_text_field( $datos['rang_step_add'] ) );
        update_post_meta( $id, 'rang_alto_eje', sanitize_text_field( $datos['rang_alto_eje'] ) );
        update_post_meta( $id, 'rang_bajo_eje', sanitize_text_field( $datos['rang_bajo_eje'] ) );
        update_post_meta( $id, 'rang_step_eje', sanitize_text_field( $datos['rang_step_eje'] ) );
    }
    else{
        $title = "Ocupacionales";
        $post_data = array(
            'post_title'    => wp_strip_all_tags( $title ),
            'post_status'   => 'publish',
            'post_type'     => 'ocupacionales',
            'post_author'   => '1',
            'post_category' => '',
            'meta_input'   => array(
                'rang_positiv_esfera' => $datos['rang_positiv_esfera'],
                'rang_negativ_esfera' => $datos['rang_negativ_esfera'],
                'rang_step_esfera' => $datos['rang_step_esfera'],
                'rang_positiv_cilindro' => $datos['rang_positiv_cilindro'],
                'rang_negativ_cilindro' => $datos['rang_negativ_cilindro'],
                'rang_step_cilindro' => $datos['rang_step_cilindro'],
                'rang_positiv_add' => $datos['rang_positiv_add'],
                'rang_negativ_add' => $datos['rang_negativ_add'],
                'rang_step_add' => $datos['rang_step_add'],
                'rang_alto_eje' => $datos['rang_alto_eje'],
                'rang_bajo_eje' => $datos['rang_bajo_eje'],
                'rang_step_eje' => $datos['rang_step_eje'],
            ),
            'page_template' => NULL
        );

        $id = wp_insert_post( $post_data );
    }

    echo $id;

    wp_die();
}

function consultar_rangos(){
    $tipo_lente = $_POST['tipo_lente'];
    $buscar_campos = $_POST['buscar_campos'];
    $tip_element_campo = $_POST['tip_element_campo'];
    $campo_primario =  isset( $_POST['campo_primario'] ) ? $_POST['campo_primario'] : '';
    $campo_secundario =  isset( $_POST['campo_secundario'] ) ? $_POST['campo_secundario'] : '';
    $campo_terciario =  isset( $_POST['campo_terciario'] ) ? $_POST['campo_terciario'] : '';
    $campo_cuarteriano =  isset( $_POST['campo_cuarteriano'] ) ? $_POST['campo_cuarteriano'] : '';

    if($tip_element_campo == "sub-campo"){
        $name_inicio = '_rang_one['.$campo_primario.'][sub-rango]['.$campo_secundario.'][inicio]';
        $name_fin = '_rang_one['.$campo_primario.'][sub-rango]['.$campo_secundario.'][fin]';
    }
    else if($tip_element_campo == "sub-campo-2"){
        $name_inicio = '_rang_one['.$campo_primario.'][sub-rango]['.$campo_secundario.'][sub-rango-2]['.$campo_terciario.'][inicio]';
        $name_fin = '_rang_one['.$campo_primario.'][sub-rango]['.$campo_secundario.'][sub-rango-2]['.$campo_terciario.'][fin]';
    }
    else if($tip_element_campo == "sub-campo-3"){
        $name_inicio = '_rang_one['.$campo_primario.'][sub-rango]['.$campo_secundario.'][sub-rango-2]['.$campo_terciario.'][sub-rango-3]['.$campo_cuarteriano.'][inicio]';
        $name_fin = '_rang_one['.$campo_primario.'][sub-rango]['.$campo_secundario.'][sub-rango-2]['.$campo_terciario.'][sub-rango-3]['.$campo_cuarteriano.'][fin]';
    }
    else{
        $name_inicio = '_rang_one['.$buscar_campos.'][inicio]';
        $name_fin = '_rang_one['.$buscar_campos.'][fin]';
    }

    $args = array(
        'post_type' => $tipo_lente,
    );
    $loop = new WP_Query($args);
    $id_tipo_lente = $loop->post->ID;
    $buscar_campos = strstr($buscar_campos,"_",true);

    switch ($buscar_campos){
        case "Esfera":
            $rang_positiv_esfera = get_post_meta($id_tipo_lente, "rang_positiv_esfera", true);
            $rang_negativ_esfera = get_post_meta($id_tipo_lente, "rang_negativ_esfera", true);
            $rang_step_esfera = get_post_meta($id_tipo_lente, "rang_step_esfera", true);
            for($i=$rang_positiv_esfera;$i>=$rang_negativ_esfera;$i=$i-$rang_step_esfera){
                if($i > 0){
                    $opciones_esfera["".$i.""] = "+".number_format($i, 2, ",", ".");
                }
                else{
                    $opciones_esfera["".$i.""] = number_format($i, 2, ",", ".");
                }

                if($i == 100){
                    imprimir_plugin("exploto");
                    die;
                }
            }

            woocommerce_wp_select( array(
                'id'      => '',
                'options' =>  $opciones_esfera, //this is where I am having trouble
                'value'   => "0",
                'name'   => $name_inicio,
                'label'   => __( 'Mayor', 'tecno-opticas' ),
                'wrapper_class'   => "selec_tcampo",
                'class'   => "selec_form_campo select rang_formul_inicio",
            ) );

            woocommerce_wp_select( array(
                'id'      => '',
                'options' =>  $opciones_esfera, //this is where I am having trouble
                'value'   => "0",
                'name'   => $name_fin,
                'label'   => __( 'Menor', 'tecno-opticas' ),
                'wrapper_class'   => "selec_tcampo",
                'class'   => "selec_form_campo select rang_formul_final",
            ) );
        break;
        case "Cilindro":
            $rang_positiv_cilindro = get_post_meta($id_tipo_lente, "rang_positiv_cilindro", true);
            $rang_negativ_cilindro = get_post_meta($id_tipo_lente, "rang_negativ_cilindro", true);
            $rang_step_cilindro = get_post_meta($id_tipo_lente, "rang_step_cilindro", true);

            for($i=$rang_positiv_cilindro;$i>=$rang_negativ_cilindro;$i=$i-$rang_step_cilindro){
                if($i > 0){
                    $opciones_cilindro["".$i.""] = "+".number_format($i, 2, ",", ".");
                }
                else{
                    $opciones_cilindro["".$i.""] = number_format($i, 2, ",", ".");
                }

                if($i == 1000){
                    imprimir_plugin("exploto");
                    die;
                }
            }

            woocommerce_wp_select( array(
                'id'      => '',
                'options' =>  $opciones_cilindro, //this is where I am having trouble
                'value'   => "0",
                'name'   => $name_inicio,
                'label'   => __( 'Mayor', 'tecno-opticas' ),
                'wrapper_class'   => "selec_tcampo",
                'class'   => "selec_form_campo select rang_formul_inicio",
            ) );

            woocommerce_wp_select( array(
                'id'      => '',
                'options' =>  $opciones_cilindro, //this is where I am having trouble
                'value'   => "0",
                'name'   => $name_fin,
                'label'   => __( 'Menor', 'tecno-opticas' ),
                'wrapper_class'   => "selec_tcampo",
                'class'   => "selec_form_campo select rang_formul_final",
            ) );
            break;
        case "Eje":
            $rang_alto_eje = get_post_meta($id_tipo_lente, "rang_alto_eje", true);
            $rang_bajo_eje = get_post_meta($id_tipo_lente, "rang_bajo_eje", true);
            $rang_step_eje = get_post_meta($id_tipo_lente, "rang_step_eje", true);
            for($i=$rang_alto_eje;$i>$rang_bajo_eje ;$i=$i-$rang_step_eje){
                $opciones_eje["".$i.""] = $i;

                if($i == 1000){
                    imprimir_plugin("exploto");
                    die;
                }
            }

            woocommerce_wp_select( array(
                'id'      => '',
                'options' =>  $opciones_eje, //this is where I am having trouble
                'value'   => "0",
                'name'   => $name_inicio,
                'label'   => __( 'Mayor', 'tecno-opticas' ),
                'wrapper_class'   => "selec_tcampo",
                'class'   => "selec_form_campo select rang_formul_inicio",
            ) );

            woocommerce_wp_select( array(
                'id'      => '',
                'options' =>  $opciones_eje, //this is where I am having trouble
                'value'   => "0",
                'name'   => $name_fin,
                'label'   => __( 'Menor', 'tecno-opticas' ),
                'wrapper_class'   => "selec_tcampo",
                'class'   => "selec_form_campo select rang_formul_final",
            ) );
            break;
        case "ADD":
            $rang_positiv_add = get_post_meta($id_tipo_lente, "rang_positiv_add", true);
            $rang_negativ_add = get_post_meta($id_tipo_lente, "rang_negativ_add", true);
            $rang_step_add = get_post_meta($id_tipo_lente, "rang_step_add", true);

            for($i=$rang_positiv_add;$i>=$rang_negativ_add;$i=$i-$rang_step_add){
                if($i > 0){
                    $opciones_add["".$i.""] = "+".number_format($i, 2, ",", ".");
                }
                else{
                    $opciones_add["".$i.""] = number_format($i, 2, ",", ".");
                }

                if($i == 1000){
                    imprimir_plugin("exploto");
                    die;
                }
            }

            woocommerce_wp_select( array(
                'id'      => '',
                'options' =>  $opciones_add, //this is where I am having trouble
                'value'   => "0",
                'name'   => $name_inicio,
                'label'   => __( 'Mayor', 'tecno-opticas' ),
                'wrapper_class'   => "selec_tcampo",
                'class'   => "selec_form_campo select rang_formul_inicio",
            ) );

            woocommerce_wp_select( array(
                'id'      => '',
                'options' =>  $opciones_add, //this is where I am having trouble
                'value'   => "0",
                'name'   => $name_fin,
                'label'   => __( 'Menor', 'tecno-opticas' ),
                'wrapper_class'   => "selec_tcampo",
                'class'   => "selec_form_campo select rang_formul_final",
            ) );
            break;
    }

    wp_die();
}

function hablitar_segundo_campo(){
    $campos_posibles = $_POST['select_valores'];
    $tip_visi_selected = $_POST['valor_selected'];
    $conteo = $_POST['contador'];

    $opciones = '<option value="" selected>Seleccionar</option>';
    foreach ($campos_posibles as $key => $value){
        $opciones .= '<option value="'.strstr($value,"_",true).'_'.$conteo.'">'.strstr($value,"_",true).'</option>';
    }

    $select_campo = '
        <p class="selec_tcampo form-field _camp_rang_two_field">
            <select style="" name="_rang_one['.$tip_visi_selected.'][sub-rango]" class="selec_form_campo select _camp_rang_two"  data-count="'.$conteo.'" campo-primario="'.$tip_visi_selected.'">
                '.$opciones.'
            </select>
        </p>
    ';

    $nueva_tabla = "
        <div class='content_secc_two'>
            <div class='secc_two'>
                ".$select_campo."
                <a class='agregar_campo_terc'>
                    <span class='dashicons dashicons-plus'></span>
                </a>
            </div>
            <div class='camp_form'></div>
            <div class='cam_price_secc'>
                <p class='form-field _price_field _regular_price_form'>
		            <input type='text' class='short wc_input_price price_form' style='' name='_rang_one[".$tip_visi_selected."][sub-rango][_price]' id='_price' value='' placeholder='Precio del rango'> 
                </p>
                <a class='eliminar_second'  data-count='".$conteo."'>
                    <span class='dashicons dashicons-minus'></span>
                </a>
            </div>
        </div>
    ";
    echo $nueva_tabla;
    wp_die();
}

function insert_tabla_terc(){
    $campos_posibles = $_POST['select_valores'];
    $campo_primario = $_POST['select_valor'];
    $campo_segundario = $_POST['select_valor_secundario'];
    $conteo = $_POST['contador'];
    $tipo_lente = $_POST['tipo_lente'];
    $cuarto_rang = "";

    if($tipo_lente == "bifocales" || $tipo_lente == "progresivos"){
        $cuarto_rang = '<a class="agregar_campo_cuart"><span class="dashicons dashicons-plus"></span></a>';
    }

    $opciones = '<option value="" selected>Seleccionar</option>';
    foreach ($campos_posibles as $key => $value){
        $opciones .= '<option value="'.strstr($value,"_",true)."_".$conteo.'">'.strstr($value,"_",true).'</option>';
        $campo_terciario = strstr($value,"_",true)."_".$conteo;
    }

    $select_campo = '
        <p class="selec_tcampo form-field _camp_rang_tree_field">
            <select style="" name="_rang_one['.$campo_primario.'][sub-rango]['.$campo_segundario.'][sub-rango-2]['.$campo_terciario.']" class="_camp_rang_tree selec_form_campo select"  data-count="'.$conteo.'" campo-primario="'.$campo_primario.'" campo-secundario="'.$campo_segundario.'">
                '.$opciones.'
            </select>
        </p>
    ';

    $nueva_tabla = "
        <div class='content_secc_tree'>
            <div class='secc_tree'>
                ".$select_campo."
                ".$cuarto_rang."
            </div>
            <div class='camp_form'></div>
            <div class='cam_price_tree'>
                <p class='form-field _price_field _regular_price_form'>
		            <input type='text' class='short wc_input_price price_form' style='' name='_rang_one[".$campo_primario."][sub-rango][".$campo_segundario."][sub-rango-2][".$campo_terciario."][_price]' id='_price' value='' placeholder='Precio del rango'> 
                </p>
                <a class='eliminar_tercer'  data-count='".$conteo."'>
                    <span class='dashicons dashicons-minus'></span>
                </a>
            </div>
        </div>
    ";
    echo $nueva_tabla;

    wp_die();
}

function insertar_tabla_terc_row(){
    $campos_posibles = $_POST['select_valores'];
    $campo_primario = $_POST['select_valor'];
    $campo_segundario = $_POST['select_valor_secundario'];
    $conteo = $_POST['contador'];
    $tipo_lente = $_POST['tipo_lente'];
    $cuarto_rang = '<a class="agregar_campo_cuart"><span class="dashicons dashicons-plus"></span></a>';

    $control_class = str_replace("_","",strstr($campo_primario,"_"));

    if($control_class%2 == 0){
        $clase ="rango_par";
    }
    else{
        $clase ="rango_impar";
    }

    $conteo++;

    $opciones = '<option value="" selected>Seleccionar</option>';
    foreach ($campos_posibles as $key => $value){
        $opciones .= '<option value="'.strstr($value,"_",true)."_".$conteo.'">'.strstr($value,"_",true).'</option>';
        $campo_terciario = strstr($value,"_",true)."_".$conteo;
    }

    $select_campo = '
        <p class="selec_tcampo form-field _camp_rang_tree_field">
            <select style="" name="_rang_one['.$campo_primario.'][sub-rango]['.$campo_segundario.'][sub-rango-2]" class="_camp_rang_tree selec_form_campo select"  data-count="'.$conteo.'"
            campo-primario="'.$campo_primario.'" campo-secundario="'.$campo_segundario.'">
                '.$opciones.'
            </select>
        </p>
    ';
    $td_cuarto = "";
    if($tipo_lente == "bifocales" || $tipo_lente == "progresivos"){
        $td_cuarto = "<td class='conte_cuart_rang'></td>";
    }

    $nuevo_tr = "

        <tr data-primario='".$campo_primario."' data-secundario='".$campo_segundario."' class='".$clase."'>
            <td class='conte_terc_rang'>
                <div class='content_secc_tree'>
                    <div class='secc_tree'>
                        ".$select_campo."
                        ".$cuarto_rang."
                    </div>
                    <div class='camp_form'></div>
                    <div class='cam_price_tree'>
                        <p class='form-field _price_field _regular_price_form'>
                            <input type='text' class='short wc_input_price price_form' style='' name='_rang_one[".$campo_primario."][sub-rango][".$campo_segundario."][sub-rango-2][_price]' id='_price' value='' placeholder='Precio del rango'> 
                        </p>
                        <a class='eliminar_tercer'  data-count='".$conteo."'>
                            <span class='dashicons dashicons-minus'></span>
                        </a>
                    </div>
                </div>
            </td>
            <td class='conte_cuart_rang'></td>
            ".$td_cuarto."
        </tr>
    ";
    echo $nuevo_tr;

    wp_die();
}

function insert_tabla_cuarta(){
    $campos_posibles = $_POST['select_valores'];
    $campo_primario = $_POST['select_valor'];
    $campo_segundario = $_POST['select_valor_secundario'];
    $campo_terciario = $_POST['select_valor_terciario'];
    $conteo = $_POST['contador'];
    $conteo++;

    $opciones = '<option value="" selected>Seleccionar</option>';
    foreach ($campos_posibles as $key => $value){
        $opciones .= '<option value="'.strstr($value,"_",true)."_".$conteo.'">'.strstr($value,"_",true).'</option>';
        $campo_cuarteriano = strstr($value,"_",true)."_".$conteo;
    }

    $select_campo = '
        <p class="selec_tcampo form-field _camp_rang_cuart_field">
            <select style="" name="_rang_one['.$campo_primario.'][sub-rango]['.$campo_segundario.'][sub-rango-2]['.$campo_terciario.'][sub-rango-3]['.$campo_cuarteriano.']" class="_camp_rang_cuart selec_form_campo select"  data-count="'.$conteo.'" campo-primario="'.$campo_primario.'" campo-secundario="'.$campo_segundario.'" campo-terciario="'.$campo_terciario.'">
                '.$opciones.'
            </select>
        </p>
    ';

    $nueva_tabla = "
        <div class='content_secc_cuart'>
            <div class='secc_cuart'>
                ".$select_campo."
            </div>
            <div class='camp_form'></div>
            <div class='cam_price_cuart'>
                <p class='form-field _price_field _regular_price_form'>
		            <input type='text' class='short wc_input_price price_form' style='' name='_rang_one[".$campo_primario."][sub-rango][".$campo_segundario."][sub-rango-2][".$campo_terciario."][sub-rango-3][".$campo_cuarteriano."][_price]' id='_price' value='' placeholder='Precio del rango'> 
                </p>
                <a class='eliminar_cuart'  data-count='".$conteo."'>
                    <span class='dashicons dashicons-minus'></span>
                </a>
            </div>
        </div>
    ";
    echo $nueva_tabla;

    wp_die();
}

function insertar_nuevo_row(){
    $campos_posibles = $_POST['select_valores'];
    $campo_primario = $_POST['select_valor'];
    $conteo = $_POST['contador'];
    $tipo_vision = $_POST['tipo_vision'];
    $conteo++;

    $opciones = '<option value="" selected>Seleccionar</option>';
    foreach ($campos_posibles as $key => $value){
        $opciones .= '<option value="'.strstr($value,"_",true).'_'.$conteo.'">'.strstr($value,"_",true).'</option>';
    }

    $control_class = str_replace("_","",strstr($campo_primario,"_"));

    if($control_class%2 == 0){
        $clase ="rango_par";
    }
    else{
        $clase ="rango_impar";
    }

    $select_campo = '
        <p class="selec_tcampo form-field _camp_rang_two_field">
            <select style="" name="_rang_one['.$campo_primario.'][sub-rango]" class="selec_form_campo select _camp_rang_two"  data-count="'.$conteo.'" campo-primario="'.$campo_primario.'">
                '.$opciones.'
            </select>
        </p>
    ';

    $td_cuarto = "";
    if($tipo_vision == "bifocales" || $tipo_vision == "progresivos"){
        $td_cuarto = "<td class='conte_cuart_rang' data-primario='".$campo_primario."'></td>";
    }

    $nueva_tabla = "
        <tr data-primario='".$campo_primario."' class='".$clase."'>
            <td class='conte_seg_rang' data-primario='".$campo_primario."'>
                <div class='content_secc_two'>
                    <div class='secc_two'>
                        ".$select_campo."
                        <a class='agregar_campo_terc'>
                            <span class='dashicons dashicons-plus'></span>
                        </a>
                    </div>
                    <div class='camp_form'></div>
                    <div class='cam_price_secc'>
                        <p class='form-field _price_field _regular_price_form'>
                            <input type='text' class='short wc_input_price price_form' style='' name='_rang_one[".$campo_primario."][sub-rango][_price]' id='_price' value='' placeholder='Precio del rango'> 
                        </p>
                        <a class='eliminar_second'  data-count='".$conteo."'>
                            <span class='dashicons dashicons-minus'></span>
                        </a>
                    </div>
                </div>
            </td>
            <td class='conte_terc_rang' data-primario='".$campo_primario."'></td>
            ".$td_cuarto."
        </tr>
    ";
    echo $nueva_tabla;
    wp_die();
}

function insertar_nuevo_rango(){
    $conteo = $_POST['contador'];
    $tipo_vision = $_POST['tipo_vision'];
    $opcion = "";
    $td_add = "";
    if($tipo_vision == "bifocales" || $tipo_vision == "progresivos"){
        $opcion = '<option value="ADD_'.$conteo.'">'.__("ADD", "tecno-opticas").'</option>';
        $td_add = '<td class="conte_cuart_rang"></td>';
    }

    if($conteo%2 == 0){
        $clase ="rango_par";
    }
    else{
        $clase ="rango_impar";
    }

    $selec_campos = '
        <select  data-count="'.$conteo.'" style="" name="_rang_one" class="selec_form_campo select _camp_rang_one">
			<option value="" selected="selected">'.__("Seleccionar", "tecno-opticas").'</option>
			<option value="Esfera_'.$conteo.'">'.__("Esfera", "tecno-opticas").'</option>
			<option value="Cilindro_'.$conteo.'">'.__("Cilindro", "tecno-opticas").'</option>
			<option value="Eje_'.$conteo.'">'.__("Eje", "tecno-opticas").'</option>
			'.$opcion.'	
        </select>
    
    ';
    $tabla = '
        <tr class="'.$clase.'">
            <td class="cont_form" rowspan="1" style="">
                <div class="secc_one">        
                    <p class="selec_tcampo form-field _field">
                        <label for=""></label>
                        '.$selec_campos.'
                    </p>    
                    <a class="agregar_campo" data-count="1">
                        <span class="dashicons dashicons-plus"></span>
                    </a>
                    <a class="otro_row"  data-count="1">
                        <span class="dashicons dashicons-plus"></span>
                    </a>
                </div>
                <div class="camp_form"></div>
                <div class="cam_price_one">
                    <p class="form-field _price_field _regular_price_form">
                        <input type="text" class="short wc_input_price price_form" style="" name="_rang_one[][_price]" id="_price" value="" placeholder="Precio del rango">
                    </p>
                </div>
            </td>
            <td class="conte_seg_rang"></td>
            <td class="conte_terc_rang"></td>
            '.$td_add.'
            <td class="otro_rang">
                <a class="eliminar_otro_rang"  data-count="'.$conteo.'">
                    <span class="dashicons dashicons-minus"></span>
                </a>
            </td>
        </tr>
   ';

    echo $tabla;

    wp_die();
}

function mostrar_configuraci_vision_sencilla(){

    $id_product = $_POST['id_product'];
    $tipo_vision = get_post_meta( $id_product, '_tipo_lente', true );
    $formula = maybe_unserialize(get_post_meta( $id_product, '_rang_form', true ));

    if(!empty($formula)) {
        $tbalcount = count($formula)+1;
        $conteo = 1;
        foreach ($formula AS $key => $value) {
            $contador = strstr($key, "_");
            $valor_seleccionado = strstr($key, "_", true);
            $options = campos_options($tipo_vision, $valor_seleccionado, $contador, "","","","");
            $div_camp_form_primario = rangos_opciones($tipo_vision, $value['inicio'], $value['fin'], $key, $key, "", "", "", "");
            if ($contador == "_1") {
                $tr = imprimir_subrango_vision_sencilla($key, $options, $value,$tipo_vision, $valor_seleccionado, $div_camp_form_primario, false, $tbalcount);
            }
            else{
                $nueva_tabla = '';

                $tr_otra_tabla = imprimir_subrango_vision_sencilla($key, $options, $value,$tipo_vision, $valor_seleccionado, $div_camp_form_primario, true, $conteo);
                $nueva_tabla .= $tr_otra_tabla;
            }

            $conteo++;

            $tr .= $nueva_tabla;
        }
    }

    ?>
    <div class="options_groups" id="visi_sencilla">
    <?php
    $campos_vision_sencilla = [
        '' => __('Seleccionar', 'tecno-opticas'),
        'Esfera_1' => __('Esfera', 'tecno-opticas'),
        'Cilindro_1' => __('Cilindro', 'tecno-opticas'),
        'Eje_1' => __('Eje', 'tecno-opticas'),
    ];
    ?>
    <div id="tabla_formula_config">
        <h2><?php _e('Configuración de Rangos y Precios para Fórmulas', 'tecno-opticas'); ?></h2>
        <table class="matr_form"  data-countent="1">
            <tr id="cabecera">
                <th>
                    <?php _e('Primer Rango', 'tecno-opticas'); ?>
                </th>
                <th id="segun_rang">
                    <?php _e('Segundo Rango', 'tecno-opticas'); ?>
                </th>
                <th id="terc_rang">
                    <?php _e('Tercer Rango', 'tecno-opticas'); ?>
                </th>
                <th>

                </th>
            </tr>
            <?php if(!empty($formula) && $tipo_vision == "vision_sencilla"){
                echo $tr;
            }else { ?>
                <tr class="primer_rang rango_impar">
                    <td class="cont_form">
                        <div class="secc_one">
                            <?php
                            woocommerce_wp_select( array(
                                'id'      => '',
                                'options' =>  $campos_vision_sencilla, //this is where I am having trouble
                                'value'   => "",
                                'name'   => '_rang_one',
                                'label'   => '',
                                'wrapper_class'   => "selec_tcampo",
                                'class'   => "selec_form_campo select _camp_rang_one",
                                'custom_attributes'   => [" data-count" => 1],
                            ) );
                            ?>
                            <a class="agregar_campo" data-count="1">
                                <span class="dashicons dashicons-plus"></span>
                            </a>
                            <a class="otro_row"  data-count="1">
                                <span class="dashicons dashicons-plus"></span>
                            </a>
                        </div>
                        <div class="camp_form"></div>
                        <div class='cam_price_one'>
                            <p class='form-field _price_field _regular_price_form'>
                                <input type='text' class='short wc_input_price price_form' style='' name='_rang_one[][_price]' id='_price' value='' placeholder='Precio del rango'>
                            </p>
                        </div>
                    </td>
                    <td class="conte_seg_rang"></td>
                    <td class="conte_terc_rang"></td>
                    <td class="otro_rang">
                        <a class="otro_rang"  data-count="2">
                            <span class="dashicons dashicons-plus-alt"></span>
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
<?php
    wp_die();
}

function mostrar_configuraci_bifocales(){
    $id_product = $_POST['id_product'];
    $tipo_vision = get_post_meta( $id_product, '_tipo_lente', true );
    $formula = maybe_unserialize(get_post_meta( $id_product, '_rang_form', true ));

    if(!empty($formula)) {
        $tbalcount = count($formula)+1;
        $conteo = 1;
        foreach ($formula AS $key => $value) {
            $contador = strstr($key, "_");
            $valor_seleccionado = strstr($key, "_", true);
            $options = campos_options($tipo_vision, $valor_seleccionado, $contador, "","","","");
            $div_camp_form_primario = rangos_opciones($tipo_vision, $value['inicio'], $value['fin'], $key, $key, "", "", "", "");
            if ($contador == "_1") {
                $tr = imprimir_subrango_2($key, $options, $value,$tipo_vision, $valor_seleccionado, $div_camp_form_primario, false, $tbalcount);
            }
            else{
                $nueva_tabla = '';

                $tr_otra_tabla = imprimir_subrango_2($key, $options, $value,$tipo_vision, $valor_seleccionado, $div_camp_form_primario, true, $conteo);
                $nueva_tabla .= $tr_otra_tabla;
            }

            $conteo++;

            $tr .= $nueva_tabla;
        }
    }

    ?>
    <div class="options_groups" id="bifocales">
        <?php
        $campos_vision_sencilla = [
            '' => __('Seleccionar', 'tecno-opticas'),
            'Esfera_1' => __('Esfera', 'tecno-opticas'),
            'Cilindro_1' => __('Cilindro', 'tecno-opticas'),
            'Eje_1' => __('Eje', 'tecno-opticas'),
            'ADD_1' => __('ADD', 'tecno-opticas'),
        ];
        ?>
        <div id="tabla_formula_config">
            <h2><?php _e('Configuración de Rangos y Precios para Fórmulas', 'tecno-opticas'); ?></h2>
            <table class="matr_form"  data-countent="1">
                <tr id="cabecera">
                    <th>
                        <?php _e('Primer Rango', 'tecno-opticas'); ?>
                    </th>
                    <th id="segun_rang">
                        <?php _e('Segundo Rango', 'tecno-opticas'); ?>
                    </th>
                    <th id="terc_rang">
                        <?php _e('Tercer Rango', 'tecno-opticas'); ?>
                    </th>
                    <th id="terc_rang">
                        <?php _e('Cuarto Rango', 'tecno-opticas'); ?>
                    </th>
                    <th>

                    </th>
                </tr>
                <?php if(!empty($formula) && $tipo_vision == "bifocales"){
                    echo $tr;
                }else { ?>
                <tr class="primer_rang rango_impar">
                    <td class="cont_form">
                        <div class="secc_one">
                            <?php
                            woocommerce_wp_select( array(
                                'id'      => '',
                                'options' =>  $campos_vision_sencilla, //this is where I am having trouble
                                'value'   => "",
                                'label'   => '',
                                'name'   => '_rang_one',
                                'wrapper_class'   => "selec_tcampo",
                                'class'   => "selec_form_campo select _camp_rang_one",
                                'custom_attributes'   => [" data-count" => 1],
                            ) );
                            ?>
                            <a class="agregar_campo" data-count="1">
                                <span class="dashicons dashicons-plus"></span>
                            </a>
                            <a class="otro_row"  data-count="1">
                                <span class="dashicons dashicons-plus"></span>
                            </a>
                        </div>
                        <div class="camp_form"></div>
                        <div class='cam_price_one'>
                            <p class='form-field _price_field _regular_price_form'>
                                <input type='text' class='short wc_input_price price_form' style='' name='_rang_one[][_price]' id='_price' value='' placeholder='Precio del rango'>
                            </p>
                        </div>
                    </td>
                    <td class="conte_seg_rang"></td>
                    <td class="conte_terc_rang"></td>
                    <td class="conte_cuart_rang"></td>
                    <td class="otro_rang">
                        <a class="otro_rang"  data-count="2">
                            <span class="dashicons dashicons-plus-alt"></span>
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
<?php
    wp_die();
}

function mostrar_configuraci_progresivo(){
    $id_product = $_POST['id_product'];
    $tipo_vision = get_post_meta( $id_product, '_tipo_lente', true );
    $formula = maybe_unserialize(get_post_meta( $id_product, '_rang_form', true ));

    if(!empty($formula)) {
        $tbalcount = count($formula)+1;
        $conteo = 1;
        foreach ($formula AS $key => $value) {
            $contador = strstr($key, "_");
            $valor_seleccionado = strstr($key, "_", true);
            $options = campos_options($tipo_vision, $valor_seleccionado, $contador, "","","","");
            $div_camp_form_primario = rangos_opciones($tipo_vision, $value['inicio'], $value['fin'], $key, $key, "", "", "", "");
            if ($contador == "_1") {
                $tr = imprimir_subrango_2($key, $options, $value,$tipo_vision, $valor_seleccionado, $div_camp_form_primario, false, $tbalcount);
            }
            else{
                $nueva_tabla = '';
                $tr_otra_tabla = imprimir_subrango_2($key, $options, $value,$tipo_vision, $valor_seleccionado, $div_camp_form_primario, true, $conteo);
                $nueva_tabla .= $tr_otra_tabla;
            }

            $conteo++;

            $tr .= $nueva_tabla;
        }
    }

    ?>
    <div class="options_groups" id="progresivos">
        <?php
        $campos_vision_sencilla = [
            '' => __('Seleccionar', 'tecno-opticas'),
            'Esfera_1' => __('Esfera', 'tecno-opticas'),
            'Cilindro_1' => __('Cilindro', 'tecno-opticas'),
            'Eje_1' => __('Eje', 'tecno-opticas'),
            'ADD_1' => __('ADD', 'tecno-opticas'),
        ];
        ?>
        <div id="tabla_formula_config">
            <h2><?php _e('Configuración de Rangos y Precios para Fórmulas', 'tecno-opticas'); ?></h2>
            <table class="matr_form"  data-countent="1">
                <tr id="cabecera">
                    <th>
                        <?php _e('Primer Rango', 'tecno-opticas'); ?>
                    </th>
                    <th id="segun_rang">
                        <?php _e('Segundo Rango', 'tecno-opticas'); ?>
                    </th>
                    <th id="terc_rang">
                        <?php _e('Tercer Rango', 'tecno-opticas'); ?>
                    </th>
                    <th id="terc_rang">
                        <?php _e('Cuarto Rango', 'tecno-opticas'); ?>
                    </th>
                    <th>

                    </th>
                </tr>
                <?php if(!empty($formula) && $tipo_vision == "progresivos"){
                    echo $tr;
                }else { ?>
                    <tr class="primer_rang rango_impar">
                        <td class="cont_form">
                            <div class="secc_one">
                                <?php
                                woocommerce_wp_select( array(
                                    'id'      => '',
                                    'options' =>  $campos_vision_sencilla, //this is where I am having trouble
                                    'value'   => "",
                                    'label'   => '',
                                    'name'   => '_rang_one',
                                    'wrapper_class'   => "selec_tcampo",
                                    'class'   => "selec_form_campo select _camp_rang_one",
                                    'custom_attributes'   => [" data-count" => 1],
                                ) );
                                ?>
                                <a class="agregar_campo" data-count="1">
                                    <span class="dashicons dashicons-plus"></span>
                                </a>
                                <a class="otro_row"  data-count="1">
                                    <span class="dashicons dashicons-plus"></span>
                                </a>
                            </div>
                            <div class="camp_form"></div>
                            <div class='cam_price_one'>
                                <p class='form-field _price_field _regular_price_form'>
                                    <input type='text' class='short wc_input_price price_form' style='' name='_rang_one[][_price]' id='_price' value='' placeholder='Precio del rango'>
                                </p>
                            </div>
                        </td>
                        <td class="conte_seg_rang"></td>
                        <td class="conte_terc_rang"></td>
                        <td class="conte_cuart_rang"></td>
                        <td class="otro_rang">
                            <a class="otro_rang"  data-count="2">
                                <span class="dashicons dashicons-plus-alt"></span>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
    <?php
    wp_die();
}

function mostrar_configuraci_ocupacionales(){
    $id_product = $_POST['id_product'];
    $tipo_vision = get_post_meta( $id_product, '_tipo_lente', true );
    $formula = maybe_unserialize(get_post_meta( $id_product, '_rang_form', true ));

    if(!empty($formula)) {
        $tbalcount = count($formula)+1;
        $conteo = 1;
        foreach ($formula AS $key => $value) {
            $contador = strstr($key, "_");
            $valor_seleccionado = strstr($key, "_", true);
            $options = campos_options($tipo_vision, $valor_seleccionado, $contador, "","","","");
            $div_camp_form_primario = rangos_opciones($tipo_vision, $value['inicio'], $value['fin'], $key, $key, "", "", "", "");
            if ($contador == "_1") {
                $tr = imprimir_subrango_2($key, $options, $value,$tipo_vision, $valor_seleccionado, $div_camp_form_primario, false, $tbalcount);
            }
            else{
                $nueva_tabla = '';
                $tr_otra_tabla = imprimir_subrango_2($key, $options, $value,$tipo_vision, $valor_seleccionado, $div_camp_form_primario, true, $conteo);
                $nueva_tabla .= $tr_otra_tabla;
            }

            $conteo++;

            $tr .= $nueva_tabla;
        }
    }

    ?>
    <div class="options_groups" id="progresivos">
        <?php
        $campos_vision_sencilla = [
            '' => __('Seleccionar', 'tecno-opticas'),
            'Esfera_1' => __('Esfera', 'tecno-opticas'),
            'Cilindro_1' => __('Cilindro', 'tecno-opticas'),
            'Eje_1' => __('Eje', 'tecno-opticas'),
            'ADD_1' => __('ADD', 'tecno-opticas'),
        ];
        ?>
        <div id="tabla_formula_config">
            <h2><?php _e('Configuración de Rangos y Precios para Fórmulas', 'tecno-opticas'); ?></h2>
            <table class="matr_form"  data-countent="1">
                <tr id="cabecera">
                    <th>
                        <?php _e('Primer Rango', 'tecno-opticas'); ?>
                    </th>
                    <th id="segun_rang">
                        <?php _e('Segundo Rango', 'tecno-opticas'); ?>
                    </th>
                    <th id="terc_rang">
                        <?php _e('Tercer Rango', 'tecno-opticas'); ?>
                    </th>
                    <th id="terc_rang">
                    <?php _e('Cuarto Rango', 'tecno-opticas'); ?>
                    </th>
                    <th>

                    </th>
                </tr>
                <?php if(!empty($formula) && $tipo_vision == "ocupacionales"){
                    echo $tr;
                }else { ?>
                    <tr class="primer_rang rango_impar">
                        <td class="cont_form">
                            <div class="secc_one">
                                <?php
                                woocommerce_wp_select( array(
                                    'id'      => '',
                                    'options' =>  $campos_vision_sencilla, //this is where I am having trouble
                                    'value'   => "",
                                    'label'   => '',
                                    'name'   => '_rang_one',
                                    'wrapper_class'   => "selec_tcampo",
                                    'class'   => "selec_form_campo select _camp_rang_one",
                                    'custom_attributes'   => [" data-count" => 1],
                                ) );
                                ?>
                                <a class="agregar_campo" data-count="1">
                                    <span class="dashicons dashicons-plus"></span>
                                </a>
                                <a class="otro_row"  data-count="1">
                                    <span class="dashicons dashicons-plus"></span>
                                </a>
                            </div>
                            <div class="camp_form"></div>
                            <div class='cam_price_one'>
                                <p class='form-field _price_field _regular_price_form'>
                                    <input type='text' class='short wc_input_price price_form' style='' name='_rang_one[][_price]' id='_price' value='' placeholder='Precio del rango'>
                                </p>
                            </div>
                        </td>
                        <td class="conte_seg_rang"></td>
                        <td class="conte_terc_rang"></td>
                        <td class="conte_cuart_rang"></td>
                        <td class="otro_rang">
                            <a class="otro_rang"  data-count="2">
                                <span class="dashicons dashicons-plus-alt"></span>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
    <?php
    wp_die();
}

function imprimir_subrango_2($key, $options, $value,$tipo_vision, $valor_seleccionado, $div_camp_form_primario, $menos, $tbalcount){
    $control_class_primaria = str_replace("_","",strstr($key,"_"));
    if($control_class_primaria%2 == 0){
        $clase_primaria ="rango_par";
    }
    else{
        $clase_primaria ="rango_impar";
    }
    $tr = '<tr class="primer_rang '.$clase_primaria.'" data-primario="'.$key.'">';
    $stylo = "display: none;";
    $stylo_td_new = "display: none;";
    $stylo_td_row = "display: none;";
    if(!empty($value['_price'])){
        $stylo = "display: block;";
    }

    if (count($value['sub-rango']) == 0){
        $stylo_td_new = "display: block;";
        $stylo_td_row = "display: none;";
    }
    else{
        $stylo = "display: none;";
        $stylo_td_new = "display: none;";
        $stylo_td_row = "display: block;";
    }

    $select = '
        <select  data-count="1" style="" id="" name="_rang_one[' . $key . ']" class="selec_form_campo select _camp_rang_one" data-value="' . $key . '">
            ' . $options . '
        </select>
    ';

    $div_secc_one = '
        <div class="secc_one">
            <p class="selec_tcampo form-field _field">
                    <label for=""></label>
                    ' . $select . '
            </p>
            <a class="agregar_campo" data-count="1" style="'.$stylo_td_new.'">
                    <span class="dashicons dashicons-plus"></span>
            </a>
            <a class="otro_row"  data-count="2" style="'.$stylo_td_row.'">
                    <span class="dashicons dashicons-plus"></span>
            </a>
        </div>
    ';

    if (count($value['sub-rango']) != 0) {
        $mostrar_precio_primario = 'display: none;';
        $sub_conteo = 1;
        $rwospan_terciario = 1;
        foreach ($value['sub-rango'] AS $sub_rango_key => $sub_rango_value) {
            $contador_subrango = strstr($sub_rango_key, "_");
            $valor_seleccionado_subrango = strstr($sub_rango_key, "_", true);
            $options = campos_options($tipo_vision, $valor_seleccionado_subrango, $contador_subrango, $valor_seleccionado, "","","");
            $div_camp_form_secundario = rangos_opciones($tipo_vision, $sub_rango_value['inicio'], $sub_rango_value['fin'], $sub_rango_key, $key, "sub-rango", $sub_rango_key, "", "");
            $mostrar_eliminar_sub_rango = 'display: none;';
            $rwospan_terciario += count($sub_rango_value['sub-rango-2']);

            if ($contador_subrango == "_1") {
                if(!empty($sub_rango_value['_price'])){
                    $mostrar_eliminar_sub_rango_price = 'display: block;';
                    if (count($value['sub-rango']) == $sub_conteo) {
                        $mostrar_eliminar_sub_rango = 'display: block;';
                    }
                }
                else{
                    $mostrar_eliminar_sub_rango_price = 'display: none;';
                }

                if (!empty($sub_rango_value['sub-rango-2'])) {
                    $sub_conteo_2 = 1;
                    $td_tercer_rang_conten = "";
                    foreach($sub_rango_value['sub-rango-2'] AS $key_subrango_2 => $value_subrango_2){
                        $mostrar_eliminar_sub_rango_2 = 'display: none;';
                        $mostrar_eliminar_sub_rango_2_price = 'display: none;';
                        if(!empty($value_subrango_2['_price'])){
                            $mostrar_eliminar_sub_rango_2_price = 'display: block;';
                            if (count($sub_rango_value['sub-rango-2']) == $sub_conteo_2) {
                                $mostrar_eliminar_sub_rango_2 = 'display: block;';
                            }
                        }
                        $contador_subrango_2 = strstr($key_subrango_2, "_");
                        $valor_seleccionado_subrango_2 = strstr($key_subrango_2, "_", true);
                        $options_secundario_2 = campos_options($tipo_vision, $valor_seleccionado_subrango_2, $contador_subrango_2,$valor_seleccionado,$valor_seleccionado_subrango, "","");

                        $div_camp_form_secundario_2 = rangos_opciones($tipo_vision, $value_subrango_2['inicio'], $value_subrango_2['fin'], $key_subrango_2,$key, "sub-rango-2", $sub_rango_key, $key_subrango_2, "");
                        $td_tercer_rang_conten .= '
                            <div class="content_secc_tree">
                                <div class="secc_tree">
                                    <p class="selec_tcampo form-field _camp_rang_tree_field">
                                        <select style="" name="_rang_one['.$key.'][sub-rango]['.$sub_rango_key.'][sub-rango-2]['.$key_subrango_2.']" class="_camp_rang_tree selec_form_campo select"  data-count="1" campo-primario="'.$key.'" campo-secundario="'.$sub_rango_key.'">
                                            '.$options_secundario_2.'
                                        </select>
                                    </p>        
                                    <a class="agregar_campo_cuart">
                                        <span class="dashicons dashicons-plus"></span>
                                    </a>                                    
                                </div>
                                
                                '.$div_camp_form_secundario_2.'
                                
                                <div class="cam_price_tree">
                                    <p class="form-field _price_field _regular_price_form">
                                        <input type="text" class="short wc_input_price price_form" style="'.$mostrar_eliminar_sub_rango_2_price.'" name="_rang_one['.$key.'][sub-rango]['.$sub_rango_key.'][sub-rango-2]['.$key_subrango_2.'][_price]" id="_price" value="'.$value_subrango_2['_price'].'" placeholder="Precio del rango"> 
                                    </p>
                                    <a class="eliminar_tercer"  data-count="' . $sub_conteo_2 . '" style="'.$mostrar_eliminar_sub_rango_2.'">
                                        <span class="dashicons dashicons-minus"></span>
                                    </a>
                                </div>
                            </div>
                        ';

                        $sub_conteo_2++;
                        if (!empty($value_subrango_2['sub-rango-3'])) {
                            $td_cuarto_rang = "";
                            $sub_conteo_3 = 1;
                            $rwospan_terciario = 1;
                            foreach($value_subrango_2['sub-rango-3'] AS $key_subrango_3 => $value_subrango_3){
                                $rwospan_terciario += count($value_subrango_2['sub-rango-3']);
                                $mostrar_eliminar_sub_rango_3 = 'display: none;';
                                $mostrar_eliminar_sub_rango_3_price = 'display: none;';
                                if(!empty($value_subrango_3['_price'])){
                                    $mostrar_eliminar_sub_rango_3_price = 'display: block;';
                                    if (count($value_subrango_2['sub-rango-3']) == $sub_conteo_3) {
                                        $mostrar_eliminar_sub_rango_3 = 'display: block;';
                                    }
                                }
                                $contador_subrango_3 = strstr($key_subrango_3, "_");
                                $valor_seleccionado_subrango_3 = strstr($key_subrango_3, "_", true);
                                $options_secundario_3 = campos_options($tipo_vision, $valor_seleccionado_subrango_3, $contador_subrango_3,$valor_seleccionado,$valor_seleccionado_subrango, $valor_seleccionado_subrango_2,"");

                                $div_camp_form_secundario_3 = rangos_opciones($tipo_vision, $value_subrango_3['inicio'], $value_subrango_3['fin'], $key_subrango_3,$key, "sub-rango-3", $sub_rango_key, $key_subrango_2, $key_subrango_3);

                                $td_cuarto_rang .= '
                                    <div class="content_secc_cuart">
                                        <div class="secc_cuart">
                                            <p class="selec_tcampo form-field _camp_rang_cuart_field">
                                                <select style="" name="_rang_one['.$key.'][sub-rango]['.$sub_rango_key.'][sub-rango-2]['.$key_subrango_2.'][sub-rango-3]['.$key_subrango_3.']" class="_camp_rang_cuart selec_form_campo select"  data-count="1" campo-primario="'.$key.'" campo-secundario="'.$sub_rango_key.' campo-terciario='.$key_subrango_2.'">
                                                    '.$options_secundario_3.'
                                                </select>
                                            </p>                                            
                                        </div>
                                        
                                        '.$div_camp_form_secundario_3.'
                                        
                                        <div class="cam_price_cuart">
                                            <p class="form-field _price_field _regular_price_form">
                                                <input type="text" class="short wc_input_price price_form" style="'.$mostrar_eliminar_sub_rango_3_price.'" name="_rang_one['.$key.'][sub-rango]['.$sub_rango_key.'][sub-rango-2]['.$key_subrango_2.'][sub-rango-3]['.$key_subrango_3.'][_price]" id="_price" value="'.$value_subrango_3['_price'].'" placeholder="Precio del rango"> 
                                            </p>
                                            <a class="eliminar_cuart"  data-count="' . $sub_conteo_3 . '" style="'.$mostrar_eliminar_sub_rango_3.'">
                                                <span class="dashicons dashicons-minus"></span>
                                            </a>
                                        </div>
                                    </div>
                                ';
                                $sub_conteo_3++;
                            }
                        }

                        if($contador_subrango_2 == "_1"){
                            $td_tercer_rang_prim = '<td class="conte_terc_rang">';
                            $td_tercer_rang_prim .= $td_tercer_rang_conten;
                            $td_tercer_rang_prim .= '</td>';
                            $td_tercer_rang_prim .= '<td class="conte_cuart_rang">'.$td_cuarto_rang.'</td>';
                            $td_tercer_rang_conten = "";
                        }
                        else{
                            $tr_tercer_rang_prim = '
                                <tr class="'.$clase_primaria.'" data-primario="'.$key.'">
                                    <td class="conte_terc_rang">
                                        '.$td_tercer_rang_conten.'
                                    </td>
                                    <td class="conte_cuart_rang">'.$td_cuarto_rang.'</td>
                                </tr>                                        
                            ';
                            $td_tercer_rang_conten = "";
                        }
                    }
                }
                else {
                    $td_tercer_rang_prim = '<td class="conte_terc_rang"></td>';
                    $td_cuart_rang_prim = '<td class="conte_cuart_rang"></td>';
                }

                $td_seg_rang = '
                    <td class="conte_seg_rang" rowspan="'.($rwospan_terciario).'">
                        <div class="content_secc_two">
                            <div class="secc_two">
                                <p class="selec_tcampo form-field _camp_rang_two_field">
                                    <select style="" name="_rang_one[' . $key . '][sub-rango][' . $sub_rango_key . ']" class="selec_form_campo select _camp_rang_two"  data-count="' . $sub_conteo . '" campo-primario="' . $key . '" data-value="">
                                        ' . $options . '
                                    </select>
                                </p>
        
                                <a class="agregar_campo_terc">
                                    <span class="dashicons dashicons-plus"></span>
                                </a>
                            </div>
                            ' . $div_camp_form_secundario . '
                            <div class="cam_price_secc">
                                <p class="form-field _price_field _regular_price_form">
                                    <input type="text" class="short wc_input_price price_form" style="'.$mostrar_eliminar_sub_rango_price.'" name="_rang_one[' . $key . '][sub-rango][' . $sub_rango_key . '][_price]" id="_price" value="' . $sub_rango_value['_price'] . '" placeholder="Precio del rango"> 
                                </p>
                                <a class="eliminar_second"  data-count="' . $sub_conteo . '" style="' . $mostrar_eliminar_sub_rango . '">
                                    <span class="dashicons dashicons-minus"></span>
                                </a>
                            </div>
                        </div>
                    </td>
                ';
            } else {
                if (!empty($sub_rango_value['sub-rango-2'])) {
                    $sub_conteo_2 = 1;
                    $td_tercer_rang_conten = "";
                    $td_tercer_rang = '<td class="conte_terc_rang">';

                    foreach($sub_rango_value['sub-rango-2'] AS $key_subrango_2 => $value_subrango_2){
                        $mostrar_eliminar_sub_rango_2 = 'display: none;';
                        if(!empty($value_subrango_2['_price'])){
                            $mostrar_eliminar_sub_rango_2_price = 'display: block;';
                            if (count($sub_rango_value['sub-rango-2']) == $sub_conteo_2) {
                                $mostrar_eliminar_sub_rango_2 = 'display: block;';
                            }
                        }else{
                            $mostrar_eliminar_sub_rango_2_price = 'display: none;';
                        }

                        $contador_subrango_2 = strstr($key_subrango_2, "_");
                        $valor_seleccionado_subrango_2 = strstr($key_subrango_2, "_", true);
                        $options_secundario_2 = campos_options($tipo_vision, $valor_seleccionado_subrango_2, $contador_subrango_2, $valor_seleccionado,$valor_seleccionado_subrango, "", "");
                        $div_camp_form_secundario_2 = rangos_opciones($tipo_vision, $value_subrango_2['inicio'], $value_subrango_2['fin'], $key_subrango_2, $key, "sub-rango-2", $sub_rango_key, $key_subrango_2, "");
                        $td_tercer_rang_conten .= '
                            <div class="content_secc_tree">
                                <div class="secc_tree">
                                    <p class="selec_tcampo form-field _camp_rang_tree_field">
                                        <select style="" name="_rang_one['.$key.'][sub-rango]['.$sub_rango_key.'][sub-rango-2]['.$key_subrango_2.']" class="_camp_rang_tree selec_form_campo select"  data-count="1" campo-primario="'.$key.'" campo-secundario="'.$sub_rango_key.'">
                                            '.$options_secundario_2.'
                                        </select>
                                    </p>          
                                    <a class="agregar_campo_cuart">
                                        <span class="dashicons dashicons-plus"></span>
                                    </a>                                  
                                </div>
                                
                                '.$div_camp_form_secundario_2.'
                                
                                <div class="cam_price_tree">
                                    <p class="form-field _price_field _regular_price_form">
                                        <input type="text" class="short wc_input_price price_form" style="'.$mostrar_eliminar_sub_rango_2_price.'" name="_rang_one['.$key.'][sub-rango]['.$sub_rango_key.'][sub-rango-2]['.$key_subrango_2.'][_price]" id="_price" value="'.$value_subrango_2['_price'].'" placeholder="Precio del rango"> 
                                    </p>
                                    <a class="eliminar_tercer"  data-count="' . $sub_conteo_2 . '" style="'.$mostrar_eliminar_sub_rango_2.'">
                                        <span class="dashicons dashicons-minus"></span>
                                    </a>
                                </div>
                            </div>
                        ';
                        $sub_conteo_2++;
                        if (!empty($value_subrango_2['sub-rango-3'])) {
                            $td_cuarto_rang = "";
                            $sub_conteo_3 = 1;
                            $rwospan_terciario = "";
                            foreach($value_subrango_2['sub-rango-3'] AS $key_subrango_3 => $value_subrango_3){
                                $rwospan_terciario += count($value_subrango_2['sub-rango-3']);
                                $mostrar_eliminar_sub_rango_3 = 'display: none;';
                                $mostrar_eliminar_sub_rango_3_price = 'display: none;';
                                if(!empty($value_subrango_3['_price'])){
                                    $mostrar_eliminar_sub_rango_3_price = 'display: block;';
                                    if (count($value_subrango_2['sub-rango-3']) == $sub_conteo_3) {
                                        $mostrar_eliminar_sub_rango_3 = 'display: block;';
                                    }
                                }
                                $contador_subrango_3 = strstr($key_subrango_3, "_");
                                $valor_seleccionado_subrango_3 = strstr($key_subrango_3, "_", true);
                                $options_secundario_3 = campos_options($tipo_vision, $valor_seleccionado_subrango_3, $contador_subrango_3,$valor_seleccionado,$valor_seleccionado_subrango, $valor_seleccionado_subrango_2,"");

                                $div_camp_form_secundario_3 = rangos_opciones($tipo_vision, $value_subrango_3['inicio'], $value_subrango_3['fin'], $key_subrango_3,$key, "sub-rango-3", $sub_rango_key, $key_subrango_2, $key_subrango_3);

                                $td_cuarto_rang .= '
                                    <div class="content_secc_cuart">
                                        <div class="secc_cuart">
                                            <p class="selec_tcampo form-field _camp_rang_cuart_field">
                                                <select style="" name="_rang_one['.$key.'][sub-rango]['.$sub_rango_key.'][sub-rango-2]['.$key_subrango_2.'][sub-rango-3]['.$key_subrango_3.']" class="_camp_rang_cuart selec_form_campo select"  data-count="1" campo-primario="'.$key.'" campo-secundario="'.$sub_rango_key.' campo-terciario='.$key_subrango_2.'">
                                                    '.$options_secundario_3.'
                                                </select>
                                            </p>                                            
                                        </div>
                                        
                                        '.$div_camp_form_secundario_3.'
                                        
                                        <div class="cam_price_cuart">
                                            <p class="form-field _price_field _regular_price_form">
                                                <input type="text" class="short wc_input_price price_form" style="'.$mostrar_eliminar_sub_rango_3_price.'" name="_rang_one['.$key.'][sub-rango]['.$sub_rango_key.'][sub-rango-2]['.$key_subrango_2.'][sub-rango-3]['.$key_subrango_3.'][_price]" id="_price" value="'.$value_subrango_2['_price'].'" placeholder="Precio del rango"> 
                                            </p>
                                            <a class="eliminar_cuart"  data-count="' . $sub_conteo_3 . '" style="'.$mostrar_eliminar_sub_rango_3.'">
                                                <span class="dashicons dashicons-minus"></span>
                                            </a>
                                        </div>
                                    </div>
                                ';
                                $sub_conteo_3++;
                            }
                        }

                        if($contador_subrango_2 == "_1"){
                            $td_tercer_rang = '<td class="conte_terc_rang">';
                            $td_tercer_rang .= $td_tercer_rang_conten;
                            $td_tercer_rang .= '</td>';
                            $td_tercer_rang .= '<td class="conte_cuart_rang">'.$td_cuarto_rang.'</td>';
                            $td_tercer_rang_conten = "";
                        }
                        else{
                            $td_tercer_rang = '
                                <tr class="'.$clase_primaria.'" data-primario="'.$key.'">
                                    <td class="conte_terc_rang">
                                        '.$td_tercer_rang_conten.'
                                    </td>
                                    <td class="conte_cuart_rang">'.$td_cuarto_rang.'</td>
                                </tr>                                        
                            ';
                            $td_tercer_rang_conten = "";
                        }
                    }
                } else {
                    $td_tercer_rang = '<td class="conte_terc_rang"></td>';
                    $td_tercer_rang .= '<td class="conte_cuart_rang"></td>';
                }
                if(!empty($sub_rango_value['_price'])){
                    $mostrar_eliminar_sub_rango_price = 'display: block;';
                    if (count($value['sub-rango']) == $sub_conteo) {
                        $mostrar_eliminar_sub_rango = 'display: block;';
                    }
                }else{
                    $mostrar_eliminar_sub_rango_price = 'display: none;';
                }
                $tr_sub_rango = '
                    <tr data-primario="' . $key . '" class="'.$clase_primaria.'">
                        <td class="conte_seg_rang">
                            <div class="content_secc_two">
                                <div class="secc_two">
                                    <p class="selec_tcampo form-field _camp_rang_two_field">
                                        <select style="" name="_rang_one[' . $key . '][sub-rango][' . $sub_rango_key . ']" class="selec_form_campo select _camp_rang_two"  data-count="' . $sub_conteo . '" campo-primario="' . $key . '" data-value="">
                                            ' . $options . '
                                        </select>
                                    </p>
            
                                    <a class="agregar_campo_terc">
                                        <span class="dashicons dashicons-plus"></span>
                                    </a>
                                </div>
                                ' . $div_camp_form_secundario . '
                                <div class="cam_price_secc">
                                    <p class="form-field _price_field _regular_price_form">
                                                <input type="text" class="short wc_input_price price_form" style="'.$mostrar_eliminar_sub_rango_price.'" name="_rang_one[' . $key . '][sub-rango][' . $sub_rango_key . '][_price]" id="_price" value="' . $sub_rango_value['_price'] . '" placeholder="Precio del rango"> 
                                    </p>
                                    <a class="eliminar_second"  data-count="' . $sub_conteo . '" style="' . $mostrar_eliminar_sub_rango . '">
                                        <span class="dashicons dashicons-minus"></span>
                                    </a>
                                </div>
                            </div>
                        </td>
                        ' . $td_tercer_rang . '    
                    </tr>
                ';
            }
            $sub_conteo++;
        }
    }
    else{
        $mostrar_precio_primario = 'display: block;';
        $td_seg_rang = '<td class="conte_seg_rang"></td>';
        $td_tercer_rang_prim = '<td class="conte_terc_rang"></td>';
        $td_cuart_rang_prim = '<td class="conte_cuart_rang"></td>';
    }

    $div_price = '
        <div class="cam_price_one" style="' . $mostrar_precio_primario . '">
            <p class="form-field _price_field _regular_price_form">
                <input type="text" class="short wc_input_price price_form" style="'.$stylo.'" name="_rang_one[' . $key . '][_price]" id="_price" value="' . $value['_price'] . '" placeholder="Precio del rango">
            </p>
        </div>
    ';
    $hijos = ((count($value['sub-rango']) != 0 ) ? count($value['sub-rango'])  : 1);
    $tr .= '
        <td class="cont_form" rowspan="'.$hijos.'">
            ' . $div_secc_one . '
            ' . $div_camp_form_primario . ' 
            ' . $div_price . '
        </td>
    ';

    $tr .= $td_seg_rang;
    $tr .= $td_tercer_rang_prim;
    $tr .= $td_cuart_rang_prim;

    if($menos == true){
        $tr .= '
        <td class="otro_rang">
            <a class="eliminar_otro_rang" data-count="'.$tbalcount.'">
                <span class="dashicons dashicons-minus"></span>
            </a>
        </td>
    ';
    }
    else{
        $tr .= '
            <td class="otro_rang">
                <a class="otro_rang"  data-count="'.$tbalcount.'">
                    <span class="dashicons dashicons-plus-alt"></span>
                </a>
            </td>
        ';
    }

    $tr .= '</tr>';
    $tr .= $tr_tercer_rang_prim;
    $tr .= $tr_sub_rango;

    return $tr;
}

function imprimir_subrango_vision_sencilla($key, $options, $value,$tipo_vision, $valor_seleccionado, $div_camp_form_primario, $menos, $tbalcount){
    $control_class_primaria = str_replace("_","",strstr($key,"_"));
    if($control_class_primaria%2 == 0){
        $clase_primaria ="rango_par";
    }
    else{
        $clase_primaria ="rango_impar";
    }
    $tr = '<tr class="primer_rang '.$clase_primaria.'" data-primario="'.$key.'">';
    $stylo = "display: none;";
    $stylo_td_new = "display: none;";
    $stylo_td_row = "display: none;";
    if(!empty($value['_price'])){
        $stylo = "display: block;";
    }

    if (count($value['sub-rango']) == 0){
        $stylo_td_new = "display: block;";
        $stylo_td_row = "display: none;";
    }
    else{
        $stylo = "display: none;";
        $stylo_td_new = "display: none;";
        $stylo_td_row = "display: block;";
    }

    $select = '
        <select  data-count="1" style="" id="" name="_rang_one[' . $key . ']" class="selec_form_campo select _camp_rang_one" data-value="' . $key . '">
            ' . $options . '
        </select>
    ';

    $div_secc_one = '
        <div class="secc_one">
            <p class="selec_tcampo form-field _field">
                    <label for=""></label>
                    ' . $select . '
            </p>
            <a class="agregar_campo" data-count="1" style="'.$stylo_td_new.'">
                    <span class="dashicons dashicons-plus"></span>
            </a>
            <a class="otro_row"  data-count="2" style="'.$stylo_td_row.'">
                    <span class="dashicons dashicons-plus"></span>
            </a>
        </div>
    ';

    if (count($value['sub-rango']) != 0) {
        $mostrar_precio_primario = 'display: none;';
        $sub_conteo = 1;
        $rwospan_terciario = 0;
        foreach ($value['sub-rango'] AS $sub_rango_key => $sub_rango_value) {
            $contador_subrango = strstr($sub_rango_key, "_");
            $valor_seleccionado_subrango = strstr($sub_rango_key, "_", true);
            $options = campos_options($tipo_vision, $valor_seleccionado_subrango, $contador_subrango, $valor_seleccionado, "","","");
            $div_camp_form_secundario = rangos_opciones($tipo_vision, $sub_rango_value['inicio'], $sub_rango_value['fin'], $sub_rango_key, $key, "sub-rango", $sub_rango_key, "", "");
            $mostrar_eliminar_sub_rango = 'display: none;';
            if($sub_rango_value['sub-rango-2']){
                $rwospan_terciario += count($sub_rango_value['sub-rango-2']);
            }
                if ($contador_subrango == "_1") {
                    if(!empty($sub_rango_value['_price'])){
                        $mostrar_eliminar_sub_rango_price = 'display: block;';
                        if (count($value['sub-rango']) == $sub_conteo) {
                            $mostrar_eliminar_sub_rango = 'display: block;';
                        }
                    }
                    else{
                        $mostrar_eliminar_sub_rango_price = 'display: none;';
                    }

                    if (!empty($sub_rango_value['sub-rango-2'])) {
                        $sub_conteo_2 = 1;
                        $td_tercer_rang_conten = "";
                        foreach($sub_rango_value['sub-rango-2'] AS $key_subrango_2 => $value_subrango_2){
                            $mostrar_eliminar_sub_rango_2 = 'display: none;';
                            $mostrar_eliminar_sub_rango_2_price = 'display: none;';
                            if(!empty($value_subrango_2['_price'])){
                                $mostrar_eliminar_sub_rango_2_price = 'display: block;';
                                if (count($sub_rango_value['sub-rango-2']) == $sub_conteo_2) {
                                    $mostrar_eliminar_sub_rango_2 = 'display: block;';
                                }
                            }
                            $contador_subrango_2 = strstr($key_subrango_2, "_");
                            $valor_seleccionado_subrango_2 = strstr($key_subrango_2, "_", true);
                            $options_secundario_2 = campos_options($tipo_vision, $valor_seleccionado_subrango_2, $contador_subrango_2,$valor_seleccionado,$valor_seleccionado_subrango, "","");

                            $div_camp_form_secundario_2 = rangos_opciones($tipo_vision, $value_subrango_2['inicio'], $value_subrango_2['fin'], $key_subrango_2,$key, "sub-rango-2", $sub_rango_key, $key_subrango_2, "");
                            $td_tercer_rang_conten .= '
                                <div class="content_secc_tree">
                                    <div class="secc_tree">
                                        <p class="selec_tcampo form-field _camp_rang_tree_field">
                                            <select style="" name="_rang_one['.$key.'][sub-rango]['.$sub_rango_key.'][sub-rango-2]['.$key_subrango_2.']" class="_camp_rang_tree selec_form_campo select"  data-count="1" campo-primario="'.$key.'" campo-secundario="'.$sub_rango_key.'">
                                                '.$options_secundario_2.'
                                            </select>
                                        </p>        
                                        <a class="agregar_campo_cuart">
                                            <span class="dashicons dashicons-plus"></span>
                                        </a>                                    
                                    </div>
                                    
                                    '.$div_camp_form_secundario_2.'
                                    
                                    <div class="cam_price_tree">
                                        <p class="form-field _price_field _regular_price_form">
                                            <input type="text" class="short wc_input_price price_form" style="'.$mostrar_eliminar_sub_rango_2_price.'" name="_rang_one['.$key.'][sub-rango]['.$sub_rango_key.'][sub-rango-2]['.$key_subrango_2.'][_price]" id="_price" value="'.$value_subrango_2['_price'].'" placeholder="Precio del rango"> 
                                        </p>
                                        <a class="eliminar_tercer"  data-count="' . $sub_conteo_2 . '" style="'.$mostrar_eliminar_sub_rango_2.'">
                                            <span class="dashicons dashicons-minus"></span>
                                        </a>
                                    </div>
                                </div>
                            ';

                            $sub_conteo_2++;

                            if($contador_subrango_2 == "_1"){
                                $td_tercer_rang_prim = '<td class="conte_terc_rang">';
                                $td_tercer_rang_prim .= $td_tercer_rang_conten;
                                $td_tercer_rang_prim .= '</td>';
                                $td_tercer_rang_conten = "";
                            }
                            else{
                                $tr_tercer_rang_prim = '
                                    <tr class="'.$clase_primaria.'" data-primario="'.$key.'">
                                        <td class="conte_terc_rang">
                                            '.$td_tercer_rang_conten.'
                                        </td>
                                    </tr>                                        
                                ';
                                $td_tercer_rang_conten = "";
                            }
                        }
                    }
                    else {
                        $td_tercer_rang_prim = '<td class="conte_terc_rang"></td>';
                    }

                    $td_seg_rang = '
                        <td class="conte_seg_rang">
                            <div class="content_secc_two">
                                <div class="secc_two">
                                    <p class="selec_tcampo form-field _camp_rang_two_field">
                                        <select style="" name="_rang_one[' . $key . '][sub-rango][' . $sub_rango_key . ']" class="selec_form_campo select _camp_rang_two"  data-count="' . $sub_conteo . '" campo-primario="' . $key . '" data-value="">
                                            ' . $options . '
                                        </select>
                                    </p>
            
                                    <a class="agregar_campo_terc">
                                        <span class="dashicons dashicons-plus"></span>
                                    </a>
                                </div>
                                ' . $div_camp_form_secundario . '
                                <div class="cam_price_secc">
                                    <p class="form-field _price_field _regular_price_form">
                                        <input type="text" class="short wc_input_price price_form" style="'.$mostrar_eliminar_sub_rango_price.'" name="_rang_one[' . $key . '][sub-rango][' . $sub_rango_key . '][_price]" id="_price" value="' . $sub_rango_value['_price'] . '" placeholder="Precio del rango"> 
                                    </p>
                                    <a class="eliminar_second"  data-count="' . $sub_conteo . '" style="' . $mostrar_eliminar_sub_rango . '">
                                        <span class="dashicons dashicons-minus"></span>
                                    </a>
                                </div>
                            </div>
                        </td>
                    ';
                } else {
                    if (!empty($sub_rango_value['sub-rango-2'])) {
                        $sub_conteo_2 = 1;
                        $td_tercer_rang_conten = "";
                        $td_tercer_rang = '<td class="conte_terc_rang">';

                        foreach($sub_rango_value['sub-rango-2'] AS $key_subrango_2 => $value_subrango_2){
                            $mostrar_eliminar_sub_rango_2 = 'display: none;';
                            if(!empty($value_subrango_2['_price'])){
                                $mostrar_eliminar_sub_rango_2_price = 'display: block;';
                                if (count($sub_rango_value['sub-rango-2']) == $sub_conteo_2) {
                                    $mostrar_eliminar_sub_rango_2 = 'display: block;';
                                }
                            }else{
                                $mostrar_eliminar_sub_rango_2_price = 'display: none;';
                            }

                            $contador_subrango_2 = strstr($key_subrango_2, "_");
                            $valor_seleccionado_subrango_2 = strstr($key_subrango_2, "_", true);
                            $options_secundario_2 = campos_options($tipo_vision, $valor_seleccionado_subrango_2, $contador_subrango_2, $valor_seleccionado,$valor_seleccionado_subrango, "", "");
                            $div_camp_form_secundario_2 = rangos_opciones($tipo_vision, $value_subrango_2['inicio'], $value_subrango_2['fin'], $key_subrango_2, $key, "sub-rango-2", $sub_rango_key, $key_subrango_2, "");
                            $td_tercer_rang_conten .= '
                                <div class="content_secc_tree">
                                    <div class="secc_tree">
                                        <p class="selec_tcampo form-field _camp_rang_tree_field">
                                            <select style="" name="_rang_one['.$key.'][sub-rango]['.$sub_rango_key.'][sub-rango-2]['.$key_subrango_2.']" class="_camp_rang_tree selec_form_campo select"  data-count="1" campo-primario="'.$key.'" campo-secundario="'.$sub_rango_key.'">
                                                '.$options_secundario_2.'
                                            </select>
                                        </p>          
                                        <a class="agregar_campo_cuart">
                                            <span class="dashicons dashicons-plus"></span>
                                        </a>                                  
                                    </div>
                                    
                                    '.$div_camp_form_secundario_2.'
                                    
                                    <div class="cam_price_tree">
                                        <p class="form-field _price_field _regular_price_form">
                                            <input type="text" class="short wc_input_price price_form" style="'.$mostrar_eliminar_sub_rango_2_price.'" name="_rang_one['.$key.'][sub-rango]['.$sub_rango_key.'][sub-rango-2]['.$key_subrango_2.'][_price]" id="_price" value="'.$value_subrango_2['_price'].'" placeholder="Precio del rango"> 
                                        </p>
                                        <a class="eliminar_tercer"  data-count="' . $sub_conteo_2 . '" style="'.$mostrar_eliminar_sub_rango_2.'">
                                            <span class="dashicons dashicons-minus"></span>
                                        </a>
                                    </div>
                                </div>
                            ';
                            $sub_conteo_2++;

                            if($contador_subrango_2 == "_1"){
                                $td_tercer_rang = '<td class="conte_terc_rang">';
                                $td_tercer_rang .= $td_tercer_rang_conten;
                                $td_tercer_rang .= '</td>';
                                $td_tercer_rang_conten = "";
                            }
                            else{
                                $td_tercer_rang = '
                                    <tr class="'.$clase_primaria.'" data-primario="'.$key.'">
                                        <td class="conte_terc_rang">
                                            '.$td_tercer_rang_conten.'
                                        </td>
                                    </tr>                                        
                                ';
                                $td_tercer_rang_conten = "";
                            }
                        }
                    } else {
                        $td_tercer_rang = '<td class="conte_terc_rang"></td>';
                    }
                    if(!empty($sub_rango_value['_price'])){
                        $mostrar_eliminar_sub_rango_price = 'display: block;';
                        if (count($value['sub-rango']) == $sub_conteo) {
                            $mostrar_eliminar_sub_rango = 'display: block;';
                        }
                    }else{
                        $mostrar_eliminar_sub_rango_price = 'display: none;';
                    }
                    $tr_sub_rango = '
                        <tr data-primario="' . $key . '" class="'.$clase_primaria.'">
                            <td class="conte_seg_rang">
                                <div class="content_secc_two">
                                    <div class="secc_two">
                                        <p class="selec_tcampo form-field _camp_rang_two_field">
                                            <select style="" name="_rang_one[' . $key . '][sub-rango][' . $sub_rango_key . ']" class="selec_form_campo select _camp_rang_two"  data-count="' . $sub_conteo . '" campo-primario="' . $key . '" data-value="">
                                                ' . $options . '
                                            </select>
                                        </p>
                
                                        <a class="agregar_campo_terc">
                                            <span class="dashicons dashicons-plus"></span>
                                        </a>
                                    </div>
                                    ' . $div_camp_form_secundario . '
                                    <div class="cam_price_secc">
                                        <p class="form-field _price_field _regular_price_form">
                                                    <input type="text" class="short wc_input_price price_form" style="'.$mostrar_eliminar_sub_rango_price.'" name="_rang_one[' . $key . '][sub-rango][' . $sub_rango_key . '][_price]" id="_price" value="' . $sub_rango_value['_price'] . '" placeholder="Precio del rango"> 
                                        </p>
                                        <a class="eliminar_second"  data-count="' . $sub_conteo . '" style="' . $mostrar_eliminar_sub_rango . '">
                                            <span class="dashicons dashicons-minus"></span>
                                        </a>
                                    </div>
                                </div>
                            </td>
                            ' . $td_tercer_rang . '    
                        </tr>
                    ';
                }
                $sub_conteo++;
        }
    }
    else{
        $mostrar_precio_primario = 'display: block;';
        $td_seg_rang = '<td class="conte_seg_rang"></td>';
        $td_tercer_rang_prim = '<td class="conte_terc_rang"></td>';
    }

    $div_price = '
        <div class="cam_price_one" style="' . $mostrar_precio_primario . '">
            <p class="form-field _price_field _regular_price_form">
                <input type="text" class="short wc_input_price price_form" style="'.$stylo.'" name="_rang_one[' . $key . '][_price]" id="_price" value="' . $value['_price'] . '" placeholder="Precio del rango">
            </p>
        </div>
    ';
    $hijos = ((count($value['sub-rango']) != 0 ) ? count($value['sub-rango'])  : 1);
    $tr .= '
        <td class="cont_form" rowspan="'.$hijos.'">
            ' . $div_secc_one . '
            ' . $div_camp_form_primario . ' 
            ' . $div_price . '
        </td>
    ';

    $tr .= $td_seg_rang;
    $tr .= $td_tercer_rang_prim;

    if($menos == true){
        $tr .= '
        <td class="otro_rang">
            <a class="eliminar_otro_rang" data-count="'.$tbalcount.'">
                <span class="dashicons dashicons-minus"></span>
            </a>
        </td>
    ';
    }
    else{
        $tr .= '
            <td class="otro_rang">
                <a class="otro_rang"  data-count="'.$tbalcount.'">
                    <span class="dashicons dashicons-plus-alt"></span>
                </a>
            </td>
        ';
    }

    $tr .= '</tr>';
    $tr .= $tr_tercer_rang_prim;
    $tr .= $tr_sub_rango;

    return $tr;
}