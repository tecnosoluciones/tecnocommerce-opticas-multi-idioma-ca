<?php
/**
 * Created by PhpStorm.
 * User: DESAR01
 * Date: 13/09/2021
 * Time: 3:19 PM
 */
add_action( 'woocommerce_before_add_to_cart_quantity', 'display' );
add_action( 'woocommerce_product_meta_end', 'opciones_medidas');
add_action( 'woocommerce_after_single_product', 'conenedor_medidas');
add_action( 'woocommerce_add_to_cart', 'inicio_proceso', 10,3 );
add_filter( 'woocommerce_add_to_cart_validation', 'validar_add_to_cart_validation', 10, 4 );
add_filter( 'woocommerce_add_cart_item_data', 'agregar_meta_formulado', 10, 3 );
add_filter( 'woocommerce_get_item_data', 'mostrar_meta_en_cart', 10, 2 );
add_action( 'woocommerce_before_calculate_totals', 'woocommerce_custom_price_to_cart_item', 99 );
add_action( 'woocommerce_remove_cart_item', 'eliminar_producto', 10 , 2);
add_filter( 'woocommerce_add_to_cart_url', 'add_to_cart_url_tecno_opticas',10, 1);
add_filter( 'woocommerce_product_add_to_cart_url', 'add_to_cart_url_tecno_opticas',10, 2);
add_filter( 'woocommerce_product_add_to_cart_text', 'replace_loop_add_to_cart_button', 10, 2 );
add_action( 'woocommerce_add_order_item_meta', 'add_order_item_meta' , 10, 3 );
add_action( 'woocommerce_before_cart_contents','limpiar_productos_proceso_compra');
add_action( 'woocommerce_before_single_product', 'validar_product', 10 );

add_action('wp_ajax_form_proceso_compra','mostrar_form_proceso_compra');
add_action('wp_ajax_nopriv_form_proceso_compra','mostrar_form_proceso_compra');
add_action('wp_ajax_form_buscar_lentes','buscar_lentes');
add_action('wp_ajax_nopriv_form_buscar_lentes','buscar_lentes');
add_action('wp_ajax_remover_product','remover_product');
add_action('wp_ajax_nopriv_remover_product','remover_product');
add_action('wp_ajax_nopriv_guardar_plantilla','guardar_plantilla');
add_action('wp_ajax_guardar_plantilla','guardar_plantilla');
add_action('wp_ajax_nopriv_validar_plantilla','validar_plantilla');
add_action('wp_ajax_validar_plantilla','validar_plantilla');
add_action('wp_ajax_nopriv_buscar_plantilla','buscar_plantilla');
add_action('wp_ajax_buscar_plantilla','buscar_plantilla');
add_action('wp_ajax_buscar_opciones_filtro','buscar_filtro');
add_action('wp_ajax_nopriv_buscar_opciones_filtro','buscar_filtro');

function validar_product(){

    global $product;
    $product_id = $product->get_id();
    if(has_term("lentes", "product_type", $product_id)){
        $page_url = get_permalink( wc_get_page_id( 'shop' ) );
        foreach(WC()->cart->get_cart() AS $key => $value){
            if($value['product_id'] == $product_id){
                $page_url = get_permalink( wc_get_page_id( 'cart' ) );
                break;
            }
        }

        wp_redirect( $page_url );
    }

}

function limpiar_productos_proceso_compra(){
    $user_id = get_current_user_id();
    $eliminar = get_user_meta($user_id, 'eliminar', true);
    WC()->cart->remove_cart_item($eliminar);
    update_user_meta($user_id, 'eliminar', "");

}

function add_order_item_meta ( $item_id, $cart_item, $cart_item_key ) {

    if ( isset( $cart_item[ 'formulado' ] ) ) {

        if($cart_item[ 'formulado' ] == "Si"){
            $valor = __( 'Si', 'tecno-opticas' );
        }
        else{
            $valor = "No";
        }

        wc_add_order_item_meta( $item_id, __( "¿Deseas la montura con lentes formulados?", 'tecno-opticas'), $valor );
    }

    if( isset( $cart_item['esfera-ojo-der'] ) ) {
        wc_add_order_item_meta($item_id, __( 'Esfera ojo Der', 'tecno-opticas' ), $cart_item['esfera-ojo-der'] );
    }

    if( isset( $cart_item['cilindro-ojo-der'] ) ) {
        wc_add_order_item_meta($item_id, __( 'Cilindro ojo Der', 'tecno-opticas' ), $cart_item['cilindro-ojo-der'] );
    }

    if( isset( $cart_item['eje-ojo-der'] ) ) {
        wc_add_order_item_meta($item_id, __( 'Eje ojo Der', 'tecno-opticas' ), $cart_item['eje-ojo-der'] );
    }

    if( isset( $cart_item['add-ojo-der'] ) ) {
        wc_add_order_item_meta($item_id, __( 'ADD ojo Der', 'tecno-opticas' ), $cart_item['add-ojo-der'] );
    }

    if( isset( $cart_item['esfera-ojo-izq'] ) ) {
        wc_add_order_item_meta($item_id, __( 'Esfera ojo Izq', 'tecno-opticas' ), $cart_item['esfera-ojo-izq'] );
    }

    if( isset( $cart_item['cilindro-ojo-izq'] ) ) {
        wc_add_order_item_meta($item_id, __( 'Cilindro ojo Izq', 'tecno-opticas' ), $cart_item['cilindro-ojo-izq'] );
    }

    if( isset( $cart_item['eje-ojo-izq'] ) ) {
        wc_add_order_item_meta($item_id, __( 'Eje ojo Izq', 'tecno-opticas' ), $cart_item['eje-ojo-izq'] );
    }

    if( isset( $cart_item['add-ojo-izq'] ) ) {
        wc_add_order_item_meta($item_id, __( 'ADD ojo Izq', 'tecno-opticas' ), $cart_item['add-ojo-izq'] );
    }

    if( isset( $cart_item['dp'] ) ) {
        wc_add_order_item_meta($item_id, __( 'Distancia pupilar', 'tecno-opticas' ), $cart_item['dp'] );
    }

    if( isset( $cart_item['altura'] ) ) {
        wc_add_order_item_meta($item_id, __( 'Altura', 'tecno-opticas' ), $cart_item['altura'] );
    }

    if( isset( $cart_item['tipo_vision'] ) ) {
        wc_add_order_item_meta($item_id, __( 'Tipo de Vision', 'tecno-opticas' ), $cart_item['tipo_vision'] );
    }

    if( isset( $cart_item['formu_name'] ) ) {
        wc_add_order_item_meta($item_id, __( 'Nombre de la plantilla', 'tecno-opticas' ), $cart_item['formu_name'] );
    }

    if( isset( $cart_item['tonalidad'] ) ) {
        wc_add_order_item_meta($item_id, __( 'Tonalidad del color', 'tecno-opticas' ), $cart_item['tonalidad'] );
    }

    if( isset( $cart_item['opciones_filtro'] ) ) {
        wc_add_order_item_meta($item_id, __( 'Tintura del lente', 'tecno-opticas' ), $cart_item['tintura'] );
    }

    if( isset( $cart_item['formulado_imagen'] ) ) {
        wc_add_order_item_meta($item_id, __( 'Fórmula', 'tecno-opticas' ),$cart_item['formulado_imagen'] );
    }

    if( isset( $cart_item['foto_face_imagen'] ) ) {
        wc_add_order_item_meta($item_id, __( 'Foto del Rostro', 'tecno-opticas' ),$cart_item['foto_face_imagen'] );
    }

    if( isset( $cart_item['caracteristica'] ) ) {
        wc_add_order_item_meta($item_id, __( 'Característica de lentes', 'tecno-opticas' ),$cart_item['caracteristica']);
    }

    if( isset( $cart_item['sku_montura'] ) ) {
        wc_add_order_item_meta($item_id, __( 'SKU de la montura', 'tecno-opticas' ),$cart_item['sku_montura']);
    }

    if( isset( $cart_item['comentario_formula'] ) ) {
        wc_add_order_item_meta($item_id, __( 'Comentario', 'tecno-opticas' ),$cart_item['comentario_formula']);
    }
}

function eliminar_producto($cart_item_key, $instance){
    foreach(WC()->cart->get_cart() AS $key => $value){
        if($cart_item_key == $key) {
            if (isset($value['llave_montura'])) {
                WC()->cart->remove_cart_item($value['llave_montura']);
            }
        }
        else{
            if (isset($value['llave_montura'])) {
                if ($value['llave_montura'] == $cart_item_key) {
                    $user_id = get_current_user_id();
                    update_user_meta($user_id, 'eliminar', $key);
                }
            }
        }

    }
}

function proceso_compra_style() {
    wp_enqueue_style('boostra_cdn_optica-styles', "https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css");
    wp_register_script('boostra_cdn_optica', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js', array('jquery'), '2', true );
    wp_enqueue_script('boostra_cdn_optica');
}

function display($post_id = false, $prefix = false){
    global $product;

    $upload_max_size = ini_get('upload_max_filesize');

    if ( ! $post_id ) {
        global $post;
        $post_id = $post->ID;
    }

    // We do not currently support grouped or external products.
    if ( 'grouped' === $product->get_type() || 'external' === $product->get_type() ) {
        return;
    }

    $seleccionar = $desactivar = "";
    if(has_term( "specials", 'product_cat', $post_id) || has_term( "paquetes-especiales", 'product_cat', $post_id)){
        $seleccionar = 'checked';
        $desactivar = 'disabled';
    }

    if(has_term("monturas", "product_type", $post_id)) {

        echo '<div class="container_addon formulados">

            <div class="fomulados">
    
                <fieldset class="form-field deseas-la-montura-con-lentes-formulados-o-de-descanso_field" style="">
                    <legend>'.__("¿Deseas la montura con lentes formulados?", "tecno-opticas").'  <em class="required" title="'.__("Campo obligatorio", "tecno-opticas").'">*</em></legend>
                    <ul class="wc-radios">
                        <li><label><input name="formulado" required value="Si" type="radio" class="select short" '.$seleccionar.' style=""> '.__('Si', 'tecno-opticas').'</label>
                        </li>
                        <li>
                            <label><input name="formulado" required value="No" type="radio" class="select short" style="" '.$desactivar.'> '.__('No', 'tecno-opticas').'</label>
                        </li>
                    </ul>
                </fieldset>
    
            </div>
    
        </div>';
    }

}

function conenedor_medidas($post_id = false, $prefix = false){
    global $product;

    if ( ! $post_id ) {
        global $post;
        $post_id = $post->ID;
        $nombre_montura = $post->post_title;
        $ancho_montura = get_post_meta( $post->ID, '_ancho_montura', true );
        $ancho_puente = get_post_meta( $post->ID, '_ancho_puente', true );
        $ancho_mica = get_post_meta( $post->ID, '_ancho_mica', true );
        $alto_mica = get_post_meta( $post->ID, '_alto_mica', true );
        $brazo = get_post_meta( $post->ID, '_brazo', true );
        $peso = get_post_meta( $post->ID, '_peso', true );
    }

    if(has_term("monturas", "product_type", $post_id)) {

        echo '
            <div id="conenedor_medidas">
                   <div class="modal-row">
                        <div class="modal-container">
                            <div class="modal-header">
                                <h3>'.__("Medidas para la montura: ",'tecno-opticas').$nombre_montura.'</h3>
                                <button type="button" class="close-modal">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                   <p>'.sprintf(__("<strong>%s</strong> ofrece 3 tamaños de montura diferentes (S, M, L). Por lo tanto, elegir la correcta es la clave para asegurarse de que sus nuevas gafas se ajustan correctamente a su cara.",'tecno-opticas') , get_bloginfo( 'name' )).'</p>
                                   <br>
                                   <h4 class="med_marc">'.__('Medidas del marco', 'tecno-opticas').'</h4>
                                   <br>
                                   <div class="cuadr_medidas">
                                        <div class="label">'.__('Ancho de la Montura', 'tecno-opticas').': <strong>'.$ancho_montura.' (mm)</strong></div>
                                        <div class="img_montura">
                                            <img src="'.get_site_url().'/wp-content/plugins/tecno-opticas/images/montura/Frontal_Ancho.jpg" alt="Frontal Ancho Montura" title="Frontal Ancho Montura">
                                        </div>
                                   </div>
                                   <br>
                                   <div class="cuadr_medidas">
                                        <div class="label">'.__('Puente', 'tecno-opticas').': <strong>'.$ancho_puente.' (mm)</strong></div>
                                        <div class="img_montura">
                                            <img src="'.get_site_url().'/wp-content/plugins/tecno-opticas/images/montura/Montura_Puente.jpg" alt="Ancho del Puente" title="Ancho del Puente">
                                        </div>
                                   </div>
                                   <br>
                                   <div class="cuadr_medidas">
                                        <div class="label">'.__('Brazo', 'tecno-opticas').': <strong>'.$brazo.' (mm)</strong></div>
                                        <div class="img_montura">
                                            <img src="'.get_site_url().'/wp-content/plugins/tecno-opticas/images/montura/Montura_Lateral.jpg" alt="Largo del Brazo" title="Largo del Brazo">
                                        </div>
                                   </div>
                                   <br>
                                   <h4 class="med_mica">'.__('Medidas de la Lente', 'tecno-opticas').'</h4>
                                   <br>
                                   <div class="cuadr_medidas">
                                        <div class="label">'.__('Ancho de la Lente', 'tecno-opticas').': <strong>'.$ancho_mica.' (mm)</strong></div>
                                        <div class="img_montura">
                                            <img src="'.get_site_url().'/wp-content/plugins/tecno-opticas/images/montura/Cristal_Ancho.jpg" alt="Ancho de la Mica" title="Ancho de la Mica">
                                        </div>
                                   </div>
                                   <br>
                                   <div class="cuadr_medidas">
                                        <div class="label">'.__('Alto de la Lente', 'tecno-opticas').': <strong>'.$alto_mica.' (mm)</strong></div>
                                        <div class="img_montura">
                                            <img src="'.get_site_url().'/wp-content/plugins/tecno-opticas/images/montura/Cristal_Alto.jpg" alt="Alto de la Mica" title="Alto de la Mica">
                                        </div>
                                   </div>
                                   <br>
                                   <p>'.__("Le sugerimos que mida las dimensiones de su montura para asegurarse de que tiene el mejor ajuste para su cara.",'tecno-opticas').'</p>
                            </div>
                        </div>
                   </div>
            </div>
            <div class="modal-backdrop-opti"></div>
        ';
    }else{
        return ;
    }
}

function opciones_medidas($post_id = false, $prefix = false){
    global $product;

    if ( ! $post_id ) {
        global $post;
        $post_id = $post->ID;
    }

    if(has_term("monturas", "product_type", $post_id)) {
        $genero = get_post_meta( $post_id, '_genero', true );
        $silueta = get_post_meta( $post_id, '_silueta', true );

        echo '<span class="posted_in">'.__("Guía de tamaños:", "tecno-opticas").' <a id="mostrar_guia" rel="tag">'.__("Tamaños", "tecno-opticas").'</a></span>';

        if(!empty($silueta)){

            $siluetas_montura_id = get_term_by('name', $silueta, 'siluetas_montura');
            $thumbnail_id = absint( get_term_meta( $siluetas_montura_id->term_id, '_silueta_thumbnail_id', true ) );
            if ( $thumbnail_id ) {
                $image = wp_get_attachment_thumb_url( $thumbnail_id );
            } else {
                $image = wc_placeholder_img_src();
            }

            echo '<span class="posted_in silueta">'.__('Silueta:', 'tecno-opticas').' <img id="silueta_produc" title="'.$silueta.'" src="'.esc_url( $image ).'" width="67px" height="30px" /></span>';
        }

        if(!empty($genero)){
            echo '<span class="posted_in">'.__('Genero:', 'tecno-opticas').' <a id="genero" rel="tag">'.$genero.'</a></span>';
        }
    }else{
        return ;
    }
}

function validar_add_to_cart_validation( $passed, $product_id, $quantity, $variation_id=null ) {

    if(has_term("monturas", "product_type", $product_id)){
        if (empty($_POST['formulado'])) {
            $passed = false;
            wc_add_notice(__('Debe indicar si desea comprar la montura formulada o no.', 'tecno-opticas'), 'error');
        }
    }

    return $passed;
}

function agregar_meta_formulado( $cart_item_data, $product_id, $variation_id ) {

    if(has_term("monturas", "product_type", $product_id)) {

        if (isset($_POST['formulado'])) {
            if($_POST[ 'formulado' ] == "Si"){
                $valor = __( 'Si', 'tecno-opticas' );
            }
            else{
                $valor = "No";
            }
            $cart_item_data['formulado'] = sanitize_text_field($valor);
        }
    }

    if(has_term("lentes", "product_type", $product_id)) {

        if (!empty($_FILES['formula']) && $_FILES['formula']['error'] == 0) {
            $archivo = $_FILES['formula'];
            $respuesta_imagen = procesar_imagen($archivo);
            $imagen = '<a href="' . $respuesta_imagen . '" target="_blank">' . $archivo['name'] . '</a>';

            $cart_item_data['formulado_imagen'] = $imagen;
        }

        if (!empty($_FILES['foto_face']) && $_FILES['foto_face']['error'] == 0) {
            $archivo_foto_face = $_FILES['foto_face'];
            $respuesta_imagen_foto_face = procesar_imagen($archivo_foto_face);
            $imagen_foto_face = '<a href="' . $respuesta_imagen_foto_face . '" target="_blank">' . $archivo_foto_face['name'] . '</a>';
            $cart_item_data['foto_face_imagen'] = $imagen_foto_face;
        }

        if (!empty($_POST['esfera-ojo-der']) || $_POST['esfera-ojo-der'] == 0) {
            $cart_item_data['esfera-ojo-der'] = sanitize_text_field($_POST['esfera-ojo-der']);
        }

        if (!empty($_POST['cilindro-ojo-der']) || $_POST['cilindro-ojo-der'] == 0) {
            $cart_item_data['cilindro-ojo-der'] = sanitize_text_field($_POST['cilindro-ojo-der']);
        }

        if (!empty($_POST['eje-ojo-der']) || $_POST['eje-ojo-der'] == 0) {
            $cart_item_data['eje-ojo-der'] = sanitize_text_field($_POST['eje-ojo-der']);
        }

        if (!empty($_POST['add-ojo-der']) || $_POST['add-ojo-der'] == 0) {
            $cart_item_data['add-ojo-der'] = sanitize_text_field($_POST['add-ojo-der']);
        }

        if (!empty($_POST['esfera-ojo-izq']) || $_POST['esfera-ojo-izq'] == 0) {
            $cart_item_data['esfera-ojo-izq'] = sanitize_text_field($_POST['esfera-ojo-izq']);
        }

        if (!empty($_POST['cilindro-ojo-izq']) || $_POST['cilindro-ojo-izq'] == 0) {
            $cart_item_data['cilindro-ojo-izq'] = sanitize_text_field($_POST['cilindro-ojo-izq']);
        }

        if (!empty($_POST['eje-ojo-izq']) || $_POST['eje-ojo-izq'] == 0) {
            $cart_item_data['eje-ojo-izq'] = sanitize_text_field($_POST['eje-ojo-izq']);
        }

        if (!empty($_POST['add-ojo-izq']) || $_POST['add-ojo-izq'] == 0) {
            $cart_item_data['add-ojo-izq'] = sanitize_text_field($_POST['add-ojo-izq']);
        }

        if (!empty($_POST['dp']) || $_POST['dp'] == 0) {
            $cart_item_data['dp'] = sanitize_text_field($_POST['dp']);
        }

        if (!empty($_POST['altura']) || $_POST['altura'] == 0) {
            $cart_item_data['altura'] = sanitize_text_field($_POST['altura']);
        }

        if (isset($_POST['formu_name'])) {
            $cart_item_data['formu_name'] = sanitize_text_field(!empty($_POST['formu_name']) ? $_POST['formu_name'] : $_POST['selec_form']);
        }

        if (isset($_POST['tonalidad_definitiva'])) {
            if(get_option('tecnooptica-setupexclude_form_habilitar_porcentaje_tonalidad') == "yes") {
                $cart_item_data['tonalidad'] = $_POST['tonalidad_definitiva'] . "%";
            }
            else{
                $cart_item_data['tonalidad'] = $_POST['tonalidad_definitiva'];
            }
        }

        if (isset($_POST['tipo_vision'])) {
            $cart_item_data['tipo_vision'] = sanitize_text_field($_POST['tipo_vision']);
        }

        if (!empty($_POST['prices'])) {
            $cart_item_data['precio_formulado'] = sanitize_text_field($_POST['prices']);
        }

        if (!empty($_POST['tintura'])) {
            $cart_item_data['tintura'] = sanitize_text_field($_POST['tintura']);
        }

        if (!empty($_POST['sku_montura'])) {
            $cart_item_data['sku_montura'] = sanitize_text_field($_POST['sku_montura']);
        }

        if (!empty($_POST['llave_montura'])) {
            $cart_item_data['llave_montura'] = sanitize_text_field($_POST['llave_montura']);
        }

        if (!empty($_POST['opciones_filtro'])) {
            $cart_item_data['opciones_filtro'] = sanitize_text_field($_POST['opciones_filtro']);
        }

        if (!empty($_POST['comentario_formula'])) {
            $cart_item_data['comentario_formula'] = sanitize_text_field($_POST['comentario_formula']);
        }

        if (!empty($_POST['caracteristica'])) {
            $cart_item_data['caracteristica'] = sanitize_text_field($_POST['caracteristica']);
        }

        if (!empty($_POST['filtro'])) {
            $cart_item_data['filtro'] = sanitize_text_field($_POST['filtro']);
        }
    }

    return $cart_item_data;
}

function mostrar_meta_en_cart( $item_data, $cart_item_data ) {
    if( isset( $cart_item_data['formulado'] ) ) {
        $item_data[] = array(
            'key' => __( '¿Deseas la montura con lentes formulados?:', 'tecno-opticas' ),
            'value' => wc_clean( $cart_item_data[ 'formulado' ] )
        );
    }

    if( isset( $cart_item_data['esfera-ojo-der'] ) ) {
        $item_data[] = array(
            'key' => __( 'Esfera ojo Der:', 'tecno-opticas' ),
            'value' => wc_clean( $cart_item_data['esfera-ojo-der'] )
        );
    }

    if( isset( $cart_item_data['cilindro-ojo-der'] ) ) {
        $item_data[] = array(
            'key' => __( 'Cilindro ojo Der:', 'tecno-opticas' ),
            'value' => wc_clean( $cart_item_data['cilindro-ojo-der'] )
        );
    }

    if( isset( $cart_item_data['eje-ojo-der'] ) ) {
        $item_data[] = array(
            'key' => __( 'Eje ojo Der:', 'tecno-opticas' ),
            'value' => wc_clean( $cart_item_data['eje-ojo-der'] )
        );
    }

    if( isset( $cart_item_data['add-ojo-der'] ) && $cart_item_data['add-ojo-der'] != "" ) {
        $item_data[] = array(
            'key' => __( 'ADD ojo Der:', 'tecno-opticas' ),
            'value' => wc_clean( $cart_item_data['add-ojo-der'] )
        );
    }

    if( isset( $cart_item_data['esfera-ojo-izq'] ) ) {
        $item_data[] = array(
            'key' => __( 'Esfera ojo Izq:', 'tecno-opticas' ),
            'value' => wc_clean( $cart_item_data['esfera-ojo-izq'] )
        );
    }

    if( isset( $cart_item_data['cilindro-ojo-izq'] ) ) {
        $item_data[] = array(
            'key' => __( 'Cilindro ojo Izq', 'tecno-opticas' ),
            'value' => wc_clean( $cart_item_data['cilindro-ojo-izq'] )
        );
    }

    if( isset( $cart_item_data['eje-ojo-izq'] ) ) {
        $item_data[] = array(
            'key' => __( 'Eje ojo Izq:', 'tecno-opticas' ),
            'value' => wc_clean( $cart_item_data['eje-ojo-izq'] )
        );
    }

    if( isset( $cart_item_data['add-ojo-izq'] ) && $cart_item_data['add-ojo-izq'] != "") {
        $item_data[] = array(
            'key' => __( 'ADD ojo Izq:', 'tecno-opticas' ),
            'value' => wc_clean( $cart_item_data['add-ojo-izq'] )
        );
    }

    if( isset( $cart_item_data['altura'] ) && $cart_item_data['altura'] != "" ) {
        $item_data[] = array(
            'key' => __( 'Altura:', 'tecno-opticas' ),
            'value' => wc_clean( $cart_item_data['altura'] )
        );
    }

    if( isset( $cart_item_data['dp'] ) ) {
        $item_data[] = array(
            'key' => __( 'Distancia pupilar:', 'tecno-opticas' ),
            'value' => wc_clean( $cart_item_data['dp'] )
        );
    }

    if( isset( $cart_item_data['tipo_vision'] ) ) {
        $item_data[] = array(
            'key' => __( 'Tipo de Vision:', 'tecno-opticas' ),
            'value' => wc_clean( $cart_item_data['tipo_vision'] )
        );
    }

    if( !empty( $cart_item_data['formu_name'] ) ) {
        $item_data[] = array(
            'key' => __( 'Nombre de la plantilla:', 'tecno-opticas' ),
            'value' => wc_clean( $cart_item_data['formu_name'] )
        );
    }

    if( !empty( $cart_item_data['tonalidad'] ) ) {
        $item_data[] = array(
            'key' => __( 'Tonalidad del color:', 'tecno-opticas' ),
            'value' => wc_clean( $cart_item_data['tonalidad'] )
        );
    }

    if( !empty( $cart_item_data['comentario_formula'] ) ) {
        $item_data[] = array(
            'key' => __( 'Comentario:', 'tecno-opticas' ),
            'value' => wc_clean( $cart_item_data['comentario_formula'] )
        );
    }

    if( !empty( $cart_item_data['opciones_filtro'] ) ) {
        $item_data[] = array(
            'key' => __( 'Tintura del lente:', 'tecno-opticas' ),
            'value' => wc_clean( $cart_item_data['opciones_filtro'] )
        );
    }

    if( isset( $cart_item_data['formulado_imagen'] ) ) {
        $item_data[] = array(
            'key' => __( 'Fórmula:', 'tecno-opticas' ),
            'value' =>  $cart_item_data['formulado_imagen']
        );
    }

    if( isset( $cart_item_data['foto_face_imagen'] ) ) {
        $item_data[] = array(
            'key' => __( 'Foto del Rostro:', 'tecno-opticas' ),
            'value' =>  $cart_item_data['foto_face_imagen']
        );
    }

    if( isset( $cart_item_data['caracteristica'] ) ) {
        $item_data[] = array(
            'key' => __( 'Características de lentes:', 'tecno-opticas' ),
            'value' =>  $cart_item_data['caracteristica']
        );
    }

    if( isset( $cart_item_data['sku_montura'] ) ) {
        $item_data[] = array(
            'key' => __( 'SKU de la montura:', 'tecno-opticas' ),
            'value' =>  $cart_item_data['sku_montura']
        );
    }

    if( isset( $cart_item_data['filtro'] ) ) {
        $item_data[] = array(
            'key' => __( 'Filtros para Lentes:', 'tecno-opticas' ),
            'value' =>  $cart_item_data['filtro']
        );
    }

    return $item_data;
}

add_filter( 'woocommerce_add_to_cart_redirect', 'proceso_compra' );

function proceso_compra( $url ) {
    if ( ! isset( $_REQUEST['add-to-cart'] ) || ! is_numeric( $_REQUEST['add-to-cart'] ) ) {

        return $url;
    }

    if(!isset($_REQUEST['formulado']) || $_REQUEST['formulado'] == "No"){
        return get_permalink( wc_get_page_id( 'cart' ) );
    }

    return $url;
}

function inicio_proceso($item_id, $values, $cart_item_key){

    $product = new WC_Product($values);

    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $values ), 'single-post-thumbnail' );
    $tipo = wc_get_object_terms($values,'product_type', 'name');

    $unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
        'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
        'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
        'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );

    add_action( 'wp_enqueue_scripts','proceso_compra_style' );

    if($tipo[0] === "monturas"){

        if($_POST['formulado'] == "Si"){
            $args = array(
                'post_type' => "filtros",
                'order' => 'ASC',
                'orderby' => 'title',
                'posts_per_page' => '-1',
            );
            $loop = new WP_Query($args);

            $elemento_filtros = "";
            $description = "";
            $opciones_filtro = "";

            $opciones_tipo_vision = "";

            if(get_option('tecnooptica-setupexclude_form_descanso') == "yes"){
                $opciones_tipo_vision .= '
                    <div class="contenedor">
                        <input id="descanso" class="tipo_form" type="radio" name="t_vis" value="descanso">
                        <label for="descanso" class="tit_pcomra">'.__( 'Descanso', 'tecno-opticas' ).'</label>
                    </div>
                ';
            }

            if(get_option('tecnooptica-setupexclude_form_vs') == "yes"){
                $opciones_tipo_vision .= '
                    <div class="contenedor">
                        <input id="vision_sencilla" class="tipo_form" type="radio" name="t_vis" value="vision_sencilla">
                        <label for="vision_sencilla" class="tit_pcomra">'.__( 'Visión sencilla', 'tecno-opticas' ).'</label>
                    </div>
                ';
            }

            if(get_option('tecnooptica-setupexclude_form_bifocales') == "yes"){
                $opciones_tipo_vision .= '
                    <div class="contenedor">
                        <input id="bifocales" class="tipo_form" type="radio" name="t_vis" value="bifocales">
                        <label for="bifocales" class="tit_pcomra">'.__( 'Bifocal', 'tecno-opticas' ).'</label>
                    </div>
                ';
            }

            if(get_option('tecnooptica-setupexclude_form_progresivo') == "yes"){
                $opciones_tipo_vision .= '
                    <div class="contenedor">
                        <input id="progresivos" class="tipo_form" type="radio" name="t_vis" value="progresivos">
                        <label class="tit_pcomra" for="progresivos">'.__( 'Progresivo', 'tecno-opticas' ).'</label>
                    </div>
                ';
            }

            if(get_option('tecnooptica-setupexclude_form_ocupacionales') == "yes"){
                $opciones_tipo_vision .= '
                    <div class="contenedor">
                        <input id="ocupacionales" class="tipo_form" type="radio" name="t_vis" value="ocupacionales">
                        <label class="tit_pcomra" for="ocupacionales">'.__( 'Ocupacionales', 'tecno-opticas' ).'</label>
                    </div>
                ';
            }

            foreach($loop->posts AS $key => $value){
                $id = $value->ID;
                $name = strtolower(str_replace(" ","_",$value->post_title));
                $name = strtr( $name, $unwanted_array );
                $title = $value->post_title;
                $descripcion = $value->post_content;

                $precio_filtro = get_post_meta( $id, 'precio_filtro', true );

                if($precio_filtro > 0){
                    $precio_filtro = '<span id="precio_filtro" class="precio_filtro" data-precio="' . $precio_filtro . '"> +' . wc_price($precio_filtro) . '</span>';
                }
                else{
                    $precio_filtro = '<span id="precio_filtro" class="precio_filtro" data-precio="0"></span>';
                }

                $elemento_filtros .= '
                    <div class="contenedor">
                        <input id="'.$name.'" class="filtro_proc_com" type="radio" name="filtro" value="'.$name.'" data-id="'.$id.'">
                        <label for="'.$name.'" class="filtro_proc_com">'.$title.'</label>
                        '.$precio_filtro.'
                    </div>
                ';

                $description .= '
                    <p id="'.$name.'" style="display:none;">'.$descripcion.'</p>
                ';

                $opciones_filtro .= opciones_filtro($id);
            }

            $args = apply_filters(
                'wc_price_args',
                wp_parse_args(
                    $args,
                    array(
                        'ex_tax_label'       => false,
                        'currency'           => '',
                        'decimal_separator'  => wc_get_price_decimal_separator(),
                        'thousand_separator' => wc_get_price_thousand_separator(),
                        'decimals'           => wc_get_price_decimals(),
                        'price_format'       => get_woocommerce_price_format(),
                    )
                )
            );

            if(get_option('tecnooptica-tipo_proceso_compra') == "opcion_2"){

                $datos = array (
                    "img" => $image[0],
                    "llave" => $item_id,
                    "proceso" => "Si",
                    "precio_montura" => $product->get_price(),
                    "nombre_m" => $product->get_name(),
                    "SKU" => $product->get_sku(),
                    "mensaje_paso_1" => stripslashes(pll__(get_option('tecnooptica-setup_mensaje_paso_1'))),
                    "mensaje_paso_2" => stripslashes(pll__(get_option('tecnooptica-setup_mensaje_paso_2'))),
                    "mensaje_paso_3" => stripslashes(pll__(get_option('tecnooptica-setup_mensaje_paso_3'))),
                    "mensaje_paso_4" => stripslashes(pll__(get_option('tecnooptica-setup_mensaje_paso_4'))),
                    "mensaje_paso_5" => stripslashes(pll__(get_option('tecnooptica-setup_mensaje_paso_5'))),
                    "mensaje_paso_6" => stripslashes(pll__(get_option('tecnooptica-setup_mensaje_paso_6'))),
                    "mensaje_error_tintura" => stripslashes(pll__(get_option('tecnooptica-setup_mensaje_error_tintura'))),
                    "mensaje_error_tonalidad" => stripslashes(pll__(get_option('tecnooptica-setup_mensaje_error_tonalidad'))),
                    "mensaje_proceso_listo" => stripslashes(pll__(get_option('tecnooptica-setup_mensaje_proceso_listo'))),
                    "mensaje_error_plantilla" => stripslashes(pll__(get_option('tecnooptica-setup_mensaje_error_plantilla'))),
                    "filtros" => $elemento_filtros,
                    "descripcion_filtros" => $description,
                    "opciones_filtro" => $opciones_filtro,
                    "descripcion_descanso" =>stripslashes(pll__(get_option('tecnooptica-descripcion_descanso'))),
                    "descripcion_vision_sencilla" =>stripslashes(pll__(get_option('tecnooptica-descripcion_vision_sencilla'))),
                    "descripcion_progresivos" =>stripslashes(pll__(get_option('tecnooptica-descripcion_progresivo'))),
                    "descripcion_bifocales" =>stripslashes(pll__(get_option('tecnooptica-descripcion_bifocales'))),
                    "opciones_tipo_vision" =>$opciones_tipo_vision,
                );

                wc_get_template(
                    'proceso_compra/configurar_formula_opcion_2.php',
                    array(
                        'datos' => $datos,
                    ),
                    'tecno-opticas',
                    TECNO_OPTICAS_RUTA. 'templates/'
                );
            }
            else{
                $datos = array (
                    "img" => $image[0],
                    "llave" => $item_id,
                    "proceso" => "Si",
                    "precio_montura" => $product->get_price(),
                    "nombre_m" => $product->get_name(),
                    "SKU" => $product->get_sku(),
                    "opciones_filtro" => $opciones_filtro,
                    "lable_paso_one" => pll__(get_option('tecnooptica-setup_paso_1')),
                    "descripcion_paso_one" => pll__(get_option('tecnooptica-setup_descripcion_paso_1')),
                    "lable_paso_two" => pll__(get_option('tecnooptica-setup_paso_2')),
                    "descripcion_paso_two" => pll__(get_option('tecnooptica-setup_descripcion_paso_2')),
                    "lable_paso_three" => pll__(get_option('tecnooptica-setup_paso_3')),
                    "descripcion_paso_three" => pll__(get_option('tecnooptica-setup_descripcion_paso_3')),
                    "lable_paso_four" => pll__(get_option('tecnooptica-setup_paso_4')),
                    "descripcion_paso_four" => pll__(get_option('tecnooptica-setup_descripcion_paso_4')),
                    "lable_paso_five" => pll__(get_option('tecnooptica-setup_paso_5')),
                    "descripcion_paso_five" => pll__(get_option('tecnooptica-setup_descripcion_paso_5')),
                    "lable_paso_six" => pll__(get_option('tecnooptica-setup_paso_6')),
                    "descripcion_paso_six" => pll__(get_option('tecnooptica-setup_descripcion_paso_6')),
                    "lable_paso_seven" => pll__(get_option('tecnooptica-setup_paso_7')),
                    "descripcion_paso_seven" => pll__(get_option('tecnooptica-setup_descripcion_paso_7')),
                    "filtros" => $elemento_filtros,
                    "descripcion_filtros" => $description,
                    "descripcion_descanso" =>pll__(get_option('tecnooptica-descripcion_descanso')),
                    "descripcion_vision_sencilla" =>pll__(get_option('tecnooptica-descripcion_vision_sencilla')),
                    "descripcion_progresivos" =>pll__(get_option('tecnooptica-descripcion_progresivo')),
                    "descripcion_bifocales" =>pll__(get_option('tecnooptica-descripcion_bifocales')),
                    "opciones_tipo_vision" =>$opciones_tipo_vision,
                );
                wc_get_template(
                    'proceso_compra/configurar_formula.php',
                    array(
                        'datos' => $datos,
                    ),
                    'tecno-opticas',
                    TECNO_OPTICAS_RUTA. 'templates/'
                );
            }


        }
    }
}

function mostrar_form_proceso_compra(){
    $tipo_vision = $_POST['tipo_vision'];
    $ancho = $_POST['ancho'];
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

    $form_impri = "";
    if($tipo_vision != "descanso") {

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
                $opciones_esfera .= '<option value="' . $i . '" selected="selected">' . $i . '</option>';
            } else if ($i == 100) {
                imprimir_plugin("exploto");
                die;
            } else {
                $opciones_esfera .= '<option value="' . $i . '">' . $i . '</option>';
            }
        }

        $esfera_der = '<select name="esfera-ojo-der" id="esfera-ojo-der" style="outline: rgb(244, 67, 54) solid;">' . $opciones_esfera . '</select>';
        $esfera_izq = '<select name="esfera-ojo-izq" id="esfera-ojo-izq" style="outline: rgb(244, 67, 54) solid;">' . $opciones_esfera . '</select>';

        $rang_positiv_cilindro = get_post_meta($id_tipo_lente, "rang_positiv_cilindro", true);
        $rang_negativ_cilindro = get_post_meta($id_tipo_lente, "rang_negativ_cilindro", true);
        $rang_step_cilindro = get_post_meta($id_tipo_lente, "rang_step_cilindro", true);

        for ($i = $rang_positiv_cilindro; $i >= $rang_negativ_cilindro; $i = $i - $rang_step_cilindro) {
            if ($i == 0) {
                $opciones_cilindro .= '<option value="' . $i . '" selected="selected">' . $i . '</option>';
            } else if ($i == 100) {
                imprimir_plugin("exploto");
                die;
            } else {
                $opciones_cilindro .= '<option value="' . $i . '">' . $i . '</option>';
            }
        }

        $cilindro_der = '<select name="cilindro-ojo-der" id="cilindro-ojo-der" style="outline: rgb(244, 67, 54) solid;">' . $opciones_cilindro . '</select>';
        $cilindro_izq = '<select name="cilindro-ojo-izq" id="cilindro-ojo-izq" style="outline: rgb(244, 67, 54) solid;">' . $opciones_cilindro . '</select>';

        $rang_alto_eje = get_post_meta($id_tipo_lente, "rang_alto_eje", true);
        $rang_bajo_eje = get_post_meta($id_tipo_lente, "rang_bajo_eje", true);
        $rang_step_eje = get_post_meta($id_tipo_lente, "rang_step_eje", true);
        for ($i = $rang_alto_eje; $i >= $rang_bajo_eje; $i = $i - $rang_step_eje) {
            if ($i == 0) {
                $opciones_eje .= '<option value="' . $i . '" selected="selected">°' . $i . '</option>';
            } else if ($i == 300) {
                imprimir_plugin("exploto");
                die;
            } else {
                $opciones_eje .= '<option value="' . $i . '"> °' . $i . '</option>';
            }
        }

        $eje_der = '<select name="eje-ojo-der" id="eje-ojo-der" style="outline: rgb(244, 67, 54) solid;">' . $opciones_eje . '</select>';
        $eje_izq = '<select name="eje-ojo-izq" id="eje-ojo-izq" style="outline: rgb(244, 67, 54) solid;">' . $opciones_eje . '</select>';

        switch ($tipo_vision) {
            case "progresivos":
            case "bifocales":
            case "ocupacionales":
                $rang_positiv_add = get_post_meta($id_tipo_lente, "rang_positiv_add", true);
                $rang_negativ_add = get_post_meta($id_tipo_lente, "rang_negativ_add", true);
                $rang_step_add = get_post_meta($id_tipo_lente, "rang_step_add", true);
                $altura = "";
                $altura_tr = "";

                for ($i = $rang_positiv_add; $i >= $rang_negativ_add; $i = $i - $rang_step_add) {
                    if ($i == 0) {
                        $opciones_add .= '<option value="' . $i . '" selected="selected">' . $i . '</option>';
                    } else if ($i == 100) {
                        imprimir_plugin("exploto");
                        die;
                    } else {
                        $opciones_add .= '<option value="' . $i . '">' . $i . '</option>';
                    }
                }
                $add_der = '<select name="add-ojo-der" id="add-ojo-der" style="outline: rgb(244, 67, 54) solid;">' . $opciones_add . '</select>';
                $add_izq = '<select name="add-ojo-izq" id="add-ojo-izq" style="outline: rgb(244, 67, 54) solid;">' . $opciones_add . '</select>';
                $th_add = '<th class="title_formula">'.__('ADD', 'tecno-opticas').'</th>';
                $add_der = '<td>' . $add_der . '</td>';
                $add_izq = '<td>' . $add_izq . '</td>';

                if($ancho < 768) {
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
                }
                if(get_option('tecnooptica-setupexclude_form_habli_altur') == "yes"){

                    $altura = '
                        <div class="altura">                       
                            <label class="title_form_compr">Altura</label>
                            <input placeholder="31/31" type="text" class="altura-formulate" data-raw-price="" data-price="" name="altura" value="" style="outline: rgb(244, 67, 54) solid;">
                        </div>
                    ';

                    $altura_tr = '
                        <tr>
                            <td class="title_formula">Altura</td>
                            <td colspan="4" class="altura-formulate">
                                <input placeholder="" type="text" class="altura-formulate" data-raw-price="" data-price="" name="altura" value="" style="outline: rgb(244, 67, 54) solid;">
                            </td>
                        </tr>
                    ';
                }

            break;
        }

        if($ancho < 768) {
            $tabla_formula = '
                <div class="form_mov_proc_comr">
                    <div class="ojo_der">
                        <label class="title_form_compr">Ojo Derecho</label>
                        <div class="form_ojo_der">
                            <div class="esfera">
                                <label for="">Esfera</label>
                                ' . $esfera_der . '
                            </div>
                            <div class="cilindro">
                                <label for="">Cilindro</label>
                                ' . $cilindro_der . '
                            </div>
                            <div class="eje">
                                <label for="">Eje</label>
                                ' . $eje_der . '
                            </div>
                        </div>
                        '.$add_movil_derecho.'
                    </div>
                    <div class="ojo_izq">
                        <label class="title_form_compr">'.__('Ojo Izquierdo', 'tecno-opticas').'</label>
                        <div class="form_ojo_der">
                            <div class="esfera">
                                <label for="">'.__('Esfera', 'tecno-opticas').'</label>
                                ' . $esfera_izq . '
                            </div>
                            <div class="cilindro">
                                <label for="">'.__('Cilindro', 'tecno-opticas').'</label>
                                ' . $cilindro_izq . '
                            </div>
                            <div class="eje">
                                <label for="">'.__('Eje', 'tecno-opticas').'</label>
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
        }
        else{

            $tabla_formula = '
                    
                <table data-control="0">
                    <thead>
                        <tr>
                            <th></th>
                            <th class="title_formula">'.__('Esfera', 'tecno-opticas').'</th>
                            <th class="title_formula">'.__('Cilindro', 'tecno-opticas').'</th>
                            <th class="title_formula">'.__('Eje', 'tecno-opticas').'</th>
                            ' . $th_add . '
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="title_formula">'.__('Ojo Derecho', 'tecno-opticas').'</td>
                            <td>' . $esfera_der . '</td>
                            <td>' . $cilindro_der . '</td>
                            <td>' . $eje_der . '</td>
                            ' . $add_der . '
                        </tr>
                        <tr>
                            <td class="title_formula">'.__('Ojo Izquierdo', 'tecno-opticas').'</td>
                            <td>' . $esfera_izq . '</td>
                            <td>' . $cilindro_izq . '</td>
                            <td>' . $eje_izq . '</td>
                            ' . $add_izq . '
                        </tr>
                        <tr>
                            <td class="title_formula">DP</td>
                            <td colspan="4" class="dp-formulate">
                                <input placeholder="31/31" type="text" class="dp-formulate" data-raw-price="" data-price="" name="dp" value="" style="outline: rgb(244, 67, 54) solid;">
                                
                            </td>
                        </tr>
                        '.$altura_tr.'
                    </tbody>
                </table>
            ';
        }

        $form_impri = '
                <div class="tt_ff">
                    <h5>'.__('ESPECIFICACIONES DE FÓRMULA', 'tecno-opticas').'</h5>
                </div>
                <div class="txt_ff_ayu">
                    <span>
                    '.__('Por favor llene los datos que se muestran a continuación. Todos los campos en rojo son obligatorios.', 'tecno-opticas').'
                    </span>
                </div>                        
                '.$tabla_formula.'
                <div class="container">
                    <div class="row contac_ws">
                        <div class="col col-sm-12 col-lg-6 align-self-center">
                            <div class="txt_ayud_what">
                            '.__('Si tienes problemas para interpretar tu fórmula, escríbenos vía whatsapp, uno de nuestros asesores te ayudará lo más rápido posible.', 'tecno-opticas').'                                
                            </div>
                        </div>
                        <div class="col col-sm-12 col-lg-6 align-self-center">
                            <div class="btn_wh">
                                <a target="_blank" href="https://api.whatsapp.com/send?phone=' . get_option('tecnooptica-num-whatsapp') . 'text=' . get_option('tecnooptica-text-whatsapp') . '" class="btn_what">'.__('Atención personalizada', 'tecno-opticas').' <i class="fa fa-whatsapp"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="cont_file">
                                <span for="">
                                '.__('Seleccione la imagen de la fórmula preescrita por su oftalmólogo/optómetra, así nosotros verificaremos que los datos que hayas ingresado sean correctos, si decides no subir tu fórmula y te equivocas al configurar las especificaciones la fórmula el lente quedará exactamente como ingresaste la fórmula.', 'tecno-opticas').'                                    
                                </span>
                                <p class="file-formula">
                                    <input type="file" class="formula-file-upload input-text" name="formula"> 
                                    <small>' . sprintf(__('(tamaño máx. de archivo %s)', 'tecno-opticas'), $upload_max_size) . '</small>
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

        echo $form_impri;
    }

    wp_die();
}

function buscar_lentes(){

    $tipo_vision = $_POST['tipo_vision'];
    $filtro = $_POST['filtro'];
    $datos_formula = $_POST['datos_formula'];
    $opcion_filtro = $_POST['opcion_filtro'];
    $precio_final = $list_lentes = $baja = $media = $alta = $hd = $hq = "";
    $gama_titulo_baja = "";
    $gama_titulo_media = "";
    $gama_titulo_alta = "";
    $gama_titulo_hd = "";
    $gama_titulo_hq = "";

    if($tipo_vision == "vision_sencilla"){
        $datos_formula['add-ojo-der'] = "";
        $datos_formula['add-ojo-izq'] = "";
    }

    $args = array(
        'post_type'	=> 'product',
        'numberposts' => -1,
        'meta_query' => array(
            'relation'		=> 'AND',
            array(
                'key'		=> '_tipo_lente',
                'value'		=> $tipo_vision,
                'compare'	=> '=',
            )
        )
    );

    $custom_posts = get_posts( $args );

    if( ! empty( $custom_posts ) ){
        foreach ( $custom_posts as $p ){
            $filtros = get_post_meta( $p->ID ,'_filtros', true);
            $precio = get_post_meta( $p->ID ,'_price', true);
            $rango_formula = get_post_meta( $p->ID ,'_rang_form', true);
            if(empty($filtros[$filtro]['opciones_filtros'])){
                if ($tipo_vision == "descanso") {
                    $precio_final = get_post_meta($p->ID, '_price', true);
                }
                else {
                    if (empty($rango_formula)) {
                        $precio_final = get_post_meta($p->ID, '_price', true);
                    } else {
                        if(get_option('tecnooptica-setupexclude_form') == "yes") {
                            if ($datos_formula['esfera-ojo-der'] > $datos_formula['esfera-ojo-izq']) {
                                $precio_final = encontrar_precio_formula($datos_formula['esfera-ojo-der'], $datos_formula['cilindro-ojo-der'], $datos_formula['eje-ojo-der'], $datos_formula['add-ojo-der'], $rango_formula, $precio);
                                $precio_ojo_der = "non_excluyente";
                                $precio_ojo_izq = "Excluyente";
                            } else if ($datos_formula['esfera-ojo-der'] < $datos_formula['esfera-ojo-izq']) {
                                $precio_final = encontrar_precio_formula($datos_formula['esfera-ojo-izq'], $datos_formula['cilindro-ojo-izq'], $datos_formula['eje-ojo-der'], $datos_formula['add-ojo-der'], $rango_formula, $precio);
                                $precio_ojo_der = "Excluyente";
                                $precio_ojo_izq = "non_excluyente";
                            }
                            else{
                                $precio_ojo_der = encontrar_precio_formula($datos_formula['esfera-ojo-der'], $datos_formula['cilindro-ojo-der'], $datos_formula['eje-ojo-der'], $datos_formula['add-ojo-der'], $rango_formula, $precio);
                                $precio_ojo_izq = encontrar_precio_formula($datos_formula['esfera-ojo-izq'], $datos_formula['cilindro-ojo-izq'], $datos_formula['eje-ojo-der'], $datos_formula['add-ojo-der'], $rango_formula, $precio);

                                if($precio_ojo_der == "Excluyente" && $precio_ojo_izq != "Excluyente"){
                                    $precio_final = $precio_ojo_izq;
                                }
                                else if($precio_ojo_der != "Excluyente" && $precio_ojo_izq == "Excluyente"){
                                    $precio_final = $precio_ojo_der;
                                }
                                else{
                                    if ($precio_ojo_der >= $precio_ojo_izq) {
                                        $precio_final = $precio_ojo_der;
                                    } else {
                                        $precio_final = $precio_ojo_izq;
                                    }
                                }

                                $precio_ojo_der = "non_excluyente";
                                $precio_ojo_izq = "non_excluyente";
                            }
                        }
                        else{
                            $precio_ojo_der = encontrar_precio_formula($datos_formula['esfera-ojo-der'], $datos_formula['cilindro-ojo-der'], $datos_formula['eje-ojo-der'], $datos_formula['add-ojo-der'], $rango_formula, $precio);
                            $precio_ojo_izq = encontrar_precio_formula($datos_formula['esfera-ojo-izq'], $datos_formula['cilindro-ojo-izq'], $datos_formula['eje-ojo-der'], $datos_formula['add-ojo-der'], $rango_formula, $precio);
                        }

                        $excluido = 1;

                        if($precio_ojo_der == "non_excluyente" && $precio_ojo_izq == "Excluyente"){
                            if($precio_final != 0){
                                $excluido = 0;
                            }
                            else{
                                $excluido = 1;
                            }
                        }
                        else if($precio_ojo_der == "Excluyente" && $precio_ojo_izq == "non_excluyente"){
                            if($precio_final != 0){
                                $excluido = 0;
                            }
                            else{
                                $excluido = 1;
                            }
                        }
                        else if($precio_ojo_der == "non_excluyente" && $precio_ojo_izq == "non_excluyente"){
                            if($precio_final != 0){
                                $excluido = 0;
                            }
                            else{
                                $excluido = 1;
                            }
                        }
                        else{

                            if($precio_ojo_der == 0 || $precio_ojo_izq == 0){
                                $precio_final = 0;
                            }
                            else {
                                if ($precio_ojo_der >= $precio_ojo_izq) {
                                    $precio_final = $precio_ojo_der;
                                } else {
                                    $precio_final = $precio_ojo_izq;
                                }
                                $excluido = 0;
                            }
                        }
                    }
                }

                if($precio_final == 0 || $precio_final == "Excluyente"){
                    $excluido = 1;
                }
            }
            else {
                foreach ($filtros[$filtro]['opciones_filtros'] AS $key => $value) {
                    if ($opcion_filtro == $value || get_option('tecnooptica-tipo_proceso_compra') == "opcion_2") {

                        if ($tipo_vision == "descanso") {
                            $precio_final = get_post_meta($p->ID, '_price', true);
                        } else {
                            if (empty($rango_formula)) {
                                $precio_final = get_post_meta($p->ID, '_price', true);
                            } else {
                                if(get_option('tecnooptica-setupexclude_form') == "yes") {
                                    if ($datos_formula['esfera-ojo-der'] > $datos_formula['esfera-ojo-izq']) {
                                        $precio_final = encontrar_precio_formula($datos_formula['esfera-ojo-der'], $datos_formula['cilindro-ojo-der'], $datos_formula['eje-ojo-der'], $datos_formula['add-ojo-der'], $rango_formula, $precio);
                                        $precio_ojo_der = "non_excluyente";
                                        $precio_ojo_izq = "Excluyente";
                                    } else if ($datos_formula['esfera-ojo-der'] < $datos_formula['esfera-ojo-izq']) {
                                        $precio_final = encontrar_precio_formula($datos_formula['esfera-ojo-izq'], $datos_formula['cilindro-ojo-izq'], $datos_formula['eje-ojo-der'], $datos_formula['add-ojo-der'], $rango_formula, $precio);
                                        $precio_ojo_der = "Excluyente";
                                        $precio_ojo_izq = "non_excluyente";
                                    }
                                    else{
                                        $precio_ojo_der = encontrar_precio_formula($datos_formula['esfera-ojo-der'], $datos_formula['cilindro-ojo-der'], $datos_formula['eje-ojo-der'], $datos_formula['add-ojo-der'], $rango_formula, $precio);
                                        $precio_ojo_izq = encontrar_precio_formula($datos_formula['esfera-ojo-izq'], $datos_formula['cilindro-ojo-izq'], $datos_formula['eje-ojo-der'], $datos_formula['add-ojo-der'], $rango_formula, $precio);
                                        if($precio_ojo_der == "Excluyente" && $precio_ojo_izq != "Excluyente"){
                                            $precio_final = $precio_ojo_izq;
                                        }
                                        else if($precio_ojo_der != "Excluyente" && $precio_ojo_izq == "Excluyente"){
                                            $precio_final = $precio_ojo_der;
                                        }
                                        else{
                                            if ($precio_ojo_der >= $precio_ojo_izq) {
                                                $precio_final = $precio_ojo_der;
                                            } else {
                                                $precio_final = $precio_ojo_izq;
                                            }
                                        }

                                        $precio_ojo_der = "non_excluyente";
                                        $precio_ojo_izq = "non_excluyente";
                                    }
                                }
                                else{
                                    $precio_ojo_der = encontrar_precio_formula($datos_formula['esfera-ojo-der'], $datos_formula['cilindro-ojo-der'], $datos_formula['eje-ojo-der'], $datos_formula['add-ojo-der'], $rango_formula, $precio);
                                    $precio_ojo_izq = encontrar_precio_formula($datos_formula['esfera-ojo-izq'], $datos_formula['cilindro-ojo-izq'], $datos_formula['eje-ojo-der'], $datos_formula['add-ojo-der'], $rango_formula, $precio);
                                }

                                $excluido = 1;

                                if($precio_ojo_der == "non_excluyente" && $precio_ojo_izq == "Excluyente"){
                                    if($precio_final != 0){
                                        $excluido = 0;
                                    }
                                    else{
                                        $excluido = 1;
                                        continue;
                                    }
                                }
                                else if($precio_ojo_der == "Excluyente" && $precio_ojo_izq == "non_excluyente"){
                                    if($precio_final != 0){
                                        $excluido = 0;
                                    }
                                    else{
                                        $excluido = 1;
                                        continue;
                                    }
                                }
                                else{
                                    if($precio_ojo_der == 0 || $precio_ojo_izq == 0){
                                        $precio_final = 0;
                                    }
                                    else {
                                        if ($precio_ojo_der >= $precio_ojo_izq) {
                                            $precio_final = $precio_ojo_der;
                                        } else {
                                            $precio_final = $precio_ojo_izq;
                                        }
                                    }
                                    $excluido = 0;
                                }
                            }
                        }

                        if($precio_final == 0){
                            $excluido = 1;
                        }
                    }
                }
            }

            if($filtros[$filtro] != "yes" && !is_array($filtros[$filtro])) {
                $excluido = 1;
            }
            else{
                $excluido = 0;
            }

            if($precio_final == 0 || $precio_final == "Excluyente"){
                $excluido = 1;
            }

            $nombre = $p->post_title;
            $descripcion_corta = $p->post_excerpt;
            $gama = get_post_meta( $p->ID ,'_gama_lente', true);
            $marca = get_post_meta( $p->ID ,'_marca_lente', true);
            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $p ), 'single-post-thumbnail' );

            $opciones = "";
            if(get_option('tecnooptica-tipo_proceso_compra') == "opcion_2"){
                if($filtros[$filtro] != "yes") {
                    $opciones = "<div class='opciones_filtro_contenedor' style='display: none;'><p>".__( 'Tintura del lente', 'tecno-opticas' )."</p><div id='conte_tintur'> ";
                    foreach ($filtros[$filtro]['opciones_filtros'] AS $key => $value) {
                        $color = get_term_meta($value, 'color', true);
                        $opcion_filtro_nombre = get_term($value);
                        $opciones .= '
                        <p class="form-field lentes_de_colores_tintados_field opciones_filtro" style="background: ' . $color . ';">
                            <label for="lentes_de_colores_tintados" style="color: #000; text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white; font-weight: bold;">
                                ' . $opcion_filtro_nombre->name . '
                            </label>
                            <input type="radio" class="opcio_filtro" style="" name="opciones_filtro" id="" data-opcion="' . $value . '" value="' . $opcion_filtro_nombre->name . '">
                        </p>
                    ';
                    }
                    $opciones .= "</div> </div><div class='clear-both'></div>";
                }

                $args = array(
                    'post_type' => "filtros",
                    'name' => str_replace("_", "-", $filtro),
                );
                $filtro_consulta = new WP_Query($args);


                    if ($filtro_consulta->have_posts()) {
                        $opciones_tonalidad = "";
                        $shade_option_no  = get_post_meta( $filtro_consulta->post->ID, 'shade_option_no', true );
                        if($shade_option_no == "yes") {
                            if(get_option('tecnooptica-setupexclude_form_habilitar_porcentaje_tonalidad') == "yes"){
                                $mayor = get_post_meta($filtro_consulta->post->ID, "tonalidad_filtro_rango_mayor", true);
                                $menor = get_post_meta($filtro_consulta->post->ID, "tonalidad_filtro_rango_menor", true);
                                if ($mayor && $menor) {
                                    for ($i = $mayor; $i >= $menor; $i -= 5) {
                                        $opciones_tonalidad .= "<option value='" . $i . "'>" . $i . "%</option>";
                                    }

                                    $opciones .= "
                                        <div class='tonalidad_selector_content' style='display: none;'>
                                            <p>" . __('Tonalidad', 'tecno-opticas') . "</p>
                                            <select name='tonalidad' id='tonalidad_selector' >
                                                <option value=''>" . __('Seleccione una opción', 'tecno-opticas') . "</option>
                                                " . $opciones_tonalidad . "
                                            </select>
                                        </div>
                                    ";
                                }
                            }
                            else{
                                $opciones .= "
                                    <div class='tonalidad_selector_content' style='display: none;'>
                                        <p>".__( 'Tonalidad', 'tecno-opticas' )."</p>
                                        <select name='tonalidad' id='tonalidad_selector' >
                                            <option value=''>".__('Seleccione una opción', 'tecno-opticas')."</option>
                                            <option value='".__('Claro Sólido', 'tecno-opticas')."'>".__('Claro Sólido', 'tecno-opticas')."</option>
                                            <option value='".__('Medio Sólido', 'tecno-opticas')."'>".__('Medio Sólido', 'tecno-opticas')."</option>
                                            <option value='".__('Oscuro Sólido', 'tecno-opticas')."'>".__('Oscuro Sólido', 'tecno-opticas')."</option>
                                            <option value='".__('Claro Degradado', 'tecno-opticas')."'>".__('Claro Degradado', 'tecno-opticas')."</option>
                                            <option value='".__('Medio Degradado', 'tecno-opticas')."'>".__('Medio Degradado', 'tecno-opticas')."</option>
                                            <option value='".__('Oscuro Degradado', 'tecno-opticas')."'>".__('Oscuro Degradado', 'tecno-opticas')."</option>
                                        </select>
                                    </div> 
                                ";
                            }
                        }
                }

                $opciones .= "                              
                    <div class=\"camp_formula_nombre\" style='display: none;'>
                        <p>".__('Por favor ingrese un nombre para identificar la fórmula', 'tecno-opticas')."</p>
                        <input type=\"text\" name=\"formu_name\" id=\"dueno_form\" class=\"dueno_form\" value=\"\">
                    </div>
                ";
            }

            if(!empty($image)){
                $imagen_lente = "<img src='".$image['0']."' class='img-fluid' alt='".$nombre."' style='width: 50px; margin-left: 10px;'>";
            }
            else {
                $imagen_lente = "";
            }

            switch ($gama) {
                case "baja":
                    if($excluido == 0) {
                        $gama_titulo_baja = "<h5>".__('Gama Baja:', 'tecno-opticas')."</h5>";
                        $baja .= '
                            <div class="cont_enedor_lentes">
                                <div class="conten_text">
                                    <div id="list_tit">
                                        <input type="radio" name="lente" data-url="' . get_permalink($p->ID) . '" data-precio="' . $precio_final . '" data-id="' . $p->ID . '" class="seleccionar" data-marca="' . $marca . '" data-modelo="' . $nombre . '">
                                        '.$imagen_lente.'
                                        <h5 class="titulo_lentes">' . $marca . ' | ' . $nombre . ' | ' . $descripcion_corta . '</h5>
                                    </div>
                                    <div id="btn_selc">
                                        <label for="">'.__("Precio:", "tecno-opticas").'</label>
                                        <span class="pr_proce_com" data-precio="' . $precio_final . '">' . wc_price($precio_final) . '</span>
                                    </div>
                                    '.$opciones.'
                                </div>
                            </div>
                        ';
                    }
                    break;
                case "media":
                    if($excluido == 0) {
                        $gama_titulo_media = "<h5>".__('Gama Media:', 'tecno-opticas')."</h5>";
                        $media .= '
                            <div class="cont_enedor_lentes">
                                <div class="conten_text">
                                    <div id="list_tit">
                                        <input type="radio" name="lente" data-url="' . get_permalink($p->ID) . '" data-precio="' . $precio_final . '" data-id="' . $p->ID . '" class="seleccionar" data-marca="' . $marca . '" data-modelo="' . $nombre . '">
                                        '.$imagen_lente.'
                                        <h5 class="titulo_lentes">' . $marca . ' | ' . $nombre . ' | ' . $descripcion_corta . '</h5>
                                    </div>
                                    <div id="btn_selc">
                                        <label for="">'.__('Precio:', 'tecno-opticas').'</label>
                                        <span class="pr_proce_com" data-precio="' . $precio_final . '">' . wc_price($precio_final) . '</span>
                                    </div>
                                    '.$opciones.'
                                </div>
                            </div>
                        ';
                    }
                    break;
                case "alta":
                    if($excluido == 0) {
                        $gama_titulo_alta = "<h5>".__('Gama Alta:', 'tecno-opticas')."</h5>";
                        $alta .= '
                            <div class="cont_enedor_lentes">
                                <div class="conten_text">
                                    <div id="list_tit">
                                        <input type="radio" name="lente" data-url="' . get_permalink($p->ID) . '" data-precio="' . $precio_final . '" data-id="' . $p->ID . '" class="seleccionar" data-marca="' . $marca . '" data-modelo="' . $nombre . '">
                                        '.$imagen_lente.'
                                        <h5 class="titulo_lentes">' . $marca . ' | ' . $nombre . ' | ' . $descripcion_corta . '</h5>
                                    </div>
                                    <div id="btn_selc">
                                        <label for="">'.__("Precio:", "tecno-opticas").'</label>
                                        <span class="pr_proce_com" data-precio="' . $precio_final . '">' . wc_price($precio_final) . '</span>
                                    </div>
                                    '.$opciones.'
                                </div>
                            </div>
                        ';
                    }
                    break;
                case "hd":
                    if($excluido == 0) {
                        $gama_titulo_hd = "<h5>".__('HD:', 'tecno-opticas')."</h5>";
                        $hd .= '
                            <div class="cont_enedor_lentes">
                                <div class="conten_text">
                                    <div id="list_tit">
                                        <input type="radio" name="lente" data-url="' . get_permalink($p->ID) . '" data-precio="' . $precio_final . '" data-id="' . $p->ID . '" class="seleccionar" data-marca="' . $marca . '" data-modelo="' . $nombre . '">
                                        '.$imagen_lente.'
                                        <h5 class="titulo_lentes">' . $marca . ' | ' . $nombre . ' | ' . $descripcion_corta . '</h5>
                                    </div>
                                    <div id="btn_selc">
                                        <label for="">'.__("Precio:", "tecno-opticas").'</label>
                                        <span class="pr_proce_com" data-precio="' . $precio_final . '">' . wc_price($precio_final) . '</span>
                                    </div>
                                    '.$opciones.'
                                </div>
                            </div>
                        ';
                    }
                    break;
                case "hq":
                    if($excluido == 0) {
                        $gama_titulo_hq = "<h5>".__('HQ:', 'tecno-opticas')."</h5>";
                        $hq .= '
                            <div class="cont_enedor_lentes">
                                <div class="conten_text">
                                    <div id="list_tit">
                                        <input type="radio" name="lente" data-url="' . get_permalink($p->ID) . '" data-precio="' . $precio_final . '" data-id="' . $p->ID . '" class="seleccionar" data-marca="' . $marca . '" data-modelo="' . $nombre . '">
                                        '.$imagen_lente.'
                                        <h5 class="titulo_lentes">' . $marca . ' | ' . $nombre . ' | ' . $descripcion_corta . '</h5>
                                    </div>
                                    <div id="btn_selc">
                                        <label for="">'.__("Precio:", "tecno-opticas").'</label>
                                        <span class="pr_proce_com" data-precio="' . $precio_final . '">' . wc_price($precio_final) . '</span>
                                    </div>
                                    '.$opciones.'
                                </div>
                            </div>
                        ';
                    }
                    break;
            }
        }
    }

    if(empty($baja) && empty($media) && empty($alta) && empty($hd) && empty($hq)){
        $lista_productos = "<h4>".__('En este momento no hay productos', 'tecno-opticas')."</h4>";
    }
    else{
        $lista_productos = '
            <div class="ls_dlen"><h5> </span>'.__('LISTADO DE LENTES', 'tecno-opticas').'</h5></div>
            
            <div class="list_lentes">
                '.$gama_titulo_baja.'
                '.$baja.'
                '.$gama_titulo_media.'
                '.$media.'
                '.$gama_titulo_alta.'
                '.$alta.'
                '.$gama_titulo_hd.'
                '.$hd.'
                '.$gama_titulo_hq.'
                '.$hq.'
            </div>
        ';
    }

    echo $lista_productos;
    wp_die();
}

function encontrar_precio_formula($esfera, $cilindro, $eje, $add, $rango_formulas, $precio_eoc){

    foreach($rango_formulas AS $key => $value){
        $campo = strstr($key,"_",true);
        $esfera = str_replace(",",".",$esfera);
        $cilindro = str_replace(",",".",$cilindro);
        $eje = str_replace(",",".",$eje);
        $add = str_replace(",",".",$add);
        if($campo == "Esfera"){
            if($esfera <= $value['inicio'] && $esfera >= $value['fin']){
                if(count($value['sub-rango']) != 0){
                    $precio = conocer_precio_sub_rango("",$cilindro, $eje, $add,  $value['sub-rango'], $precio_eoc);
                    return $precio;
                }
                else{
                    return $value['_price'];
                }
            }
            else{
                if(get_option('tecnooptica-setupexclude_form') == "yes"){
                    $precio = "Excluyente";
                }
                else{
                    $precio = $precio_eoc;
                }
            }
        }
        else if ($campo == "Cilindro"){
            if($cilindro <= $value['inicio'] && $cilindro >= $value['fin']){
                if(count($value['sub-rango']) != 0){
                    $precio = conocer_precio_sub_rango($esfera,"", $eje, $add, $value['sub-rango'], $precio_eoc);
                    return $precio;
                }
                else{
                    return  $value['_price'];
                }
            }
            else{
                if(get_option('tecnooptica-setupexclude_form') == "yes"){
                    $precio = "Excluyente";
                }
                else{
                    $precio = $precio_eoc;
                }
            }
        }
        else if($campo == "Eje"){
            if($eje <= $value['inicio'] && $eje >= $value['fin']){
                if(count($value['sub-rango']) != 0){
                    $precio = conocer_precio_sub_rango($esfera, $cilindro, "", $add, $value['sub-rango'], $precio_eoc);
                    return $precio;
                }
                else{
                    return $value['_price'];
                }
            }
            else{
                if(get_option('tecnooptica-setupexclude_form') == "yes"){
                    $precio = "Excluyente";
                }
                else{
                    $precio = $precio_eoc;
                }
            }
        }
        else if($campo == "ADD"){
            if($add <= $value['inicio'] && $add >= $value['fin']){
                if(count($value['sub-rango']) != 0){
                    $precio = conocer_precio_sub_rango($esfera, $cilindro, $eje, "", $value['sub-rango'], $precio_eoc);
                    return $precio;
                }
                else{
                    return $value['_price'];
                }
            }
            else{
                if(get_option('tecnooptica-setupexclude_form') == "yes"){
                    $precio = "Excluyente";
                }
                else{
                    $precio = $precio_eoc;
                }
            }
        }
    }

    return $precio;
}

function conocer_precio_sub_rango($esfera, $cilindro, $eje, $add, $rango_formulas, $precio_eoc){

    foreach($rango_formulas AS $key => $value){
        $campo = strstr($key,"_",true);

        if($campo == "Esfera"){
            if($esfera <= $value['inicio'] && $esfera >= $value['fin']){
                if(isset($value['sub-rango-2'])){
                    $precio = conocer_precio_sub_rango_2("",$cilindro, $eje, $add,  $value['sub-rango-2'], $precio_eoc);
                    return $precio;
                }
                else{
                    return $value['_price'];
                }
            }
            else{
                if(get_option('tecnooptica-setupexclude_form') == "yes"){
                    $precio = "Excluyente";
                }
                else{
                    $precio = $precio_eoc;
                }
            }
        }
        else if ($campo == "Cilindro"){
            if($cilindro <= $value['inicio'] && $cilindro >= $value['fin']){

                if(isset($value['sub-rango-2'])){
                    $precio = conocer_precio_sub_rango_2($esfera,"", $eje, $add,  $value['sub-rango-2'], $precio_eoc);
                    return $precio;
                }
                else{
                    return $value['_price'];
                }
            }
            else{
                if(get_option('tecnooptica-setupexclude_form') == "yes"){
                    $precio = "Excluyente";
                }
                else{
                    $precio = $precio_eoc;
                }
            }
        }
        else if($campo == "Eje"){
            if($eje <= $value['inicio'] && $eje >= $value['fin']){
                if(isset($value['sub-rango-2'])){
                    $precio = conocer_precio_sub_rango_2($esfera, $cilindro, "", $add,  $value['sub-rango-2'], $precio_eoc);
                    return $precio;
                }
                else{
                    return $value['_price'];
                }
            }
            else{
                if(get_option('tecnooptica-setupexclude_form') == "yes"){
                    $precio = "Excluyente";
                }
                else{
                    $precio = $precio_eoc;
                }
            }
        }
        else if($campo == "ADD"){
            if($add <= $value['inicio'] && $add >= $value['fin']){
                if(isset($value['sub-rango-2'])){
                    $precio = conocer_precio_sub_rango_2($esfera, $cilindro, $eje, "",  $value['sub-rango-2'], $precio_eoc);
                    return $precio;
                }
                else{
                    return $value['_price'];
                }
            }
            else{
                if(get_option('tecnooptica-setupexclude_form') == "yes"){
                    $precio = "Excluyente";
                }
                else{
                    $precio = $precio_eoc;
                }
            }
        }
    }

    return $precio;

}

function conocer_precio_sub_rango_2($esfera, $cilindro, $eje, $add, $rango_formulas, $precio_eoc){

    foreach($rango_formulas AS $key => $value){
        $campo = strstr($key,"_",true);

        if($campo == "Esfera"){
            if($esfera <= $value['inicio'] && $esfera >= $value['fin']){
                if(isset($value['sub-rango-3']) != 0){
                    $precio = conocer_precio_sub_rango_3("",$cilindro, $eje, $add,  $value['sub-rango-3'], $precio_eoc);
                    return $precio;
                }
                else{
                    return $value['_price'];
                }
            }
            else{
                if(get_option('tecnooptica-setupexclude_form') == "yes"){
                    $precio = "Excluyente";
                }
                else{
                    $precio = $precio_eoc;
                }
            }
        }
        else if ($campo == "Cilindro"){
            if($cilindro <= $value['inicio'] && $cilindro >= $value['fin']){
                if(isset($value['sub-rango-3']) != 0){
                    $precio = conocer_precio_sub_rango_3($esfera,"", $eje, $add,  $value['sub-rango-3'], $precio_eoc);
                    return $precio;
                }
                else{
                    return $value['_price'];
                }
            }
            else{
                if(get_option('tecnooptica-setupexclude_form') == "yes"){
                    $precio = "Excluyente";
                }
                else{
                    $precio = $precio_eoc;
                }
            }
        }
        else if($campo == "Eje"){
            if($eje <= $value['inicio'] && $eje >= $value['fin']){
                if(isset($value['sub-rango-3']) != 0){
                    $precio = conocer_precio_sub_rango_3($esfera, $cilindro, "", $add,  $value['sub-rango-3'], $precio_eoc);
                    return $precio;
                }
                else{
                    return $value['_price'];
                }
            }
            else{
                if(get_option('tecnooptica-setupexclude_form') == "yes"){
                    $precio = "Excluyente";
                }
                else{
                    $precio = $precio_eoc;
                }
            }
        }
        else if($campo == "ADD"){
            if($add <= $value['inicio'] && $add >= $value['fin']){
                if(isset($value['sub-rango-3']) != 0){
                    $precio = conocer_precio_sub_rango_3($esfera, $cilindro, $eje, "",  $value['sub-rango-3'], $precio_eoc);
                    return $precio;
                }
                else{
                    return $value['_price'];
                }
            }
            else{
                if(get_option('tecnooptica-setupexclude_form') == "yes"){
                    $precio = "Excluyente";
                }
                else{
                    $precio = $precio_eoc;
                }
            }
        }
    }

    return $precio;
}

function conocer_precio_sub_rango_3($esfera, $cilindro, $eje, $add, $rango_formulas, $precio_eoc){

    foreach($rango_formulas AS $key => $value){
        $campo = strstr($key,"_",true);

        if($campo == "Esfera"){
            if($esfera <= $value['inicio'] && $esfera >= $value['fin']){
                return $value['_price'];
            }
            else{
                if(get_option('tecnooptica-setupexclude_form') == "yes"){
                    $precio = "Excluyente";
                }
                else{
                    $precio = $precio_eoc;
                }
            }
        }
        else if ($campo == "Cilindro"){
            if($cilindro <= $value['inicio'] && $cilindro >= $value['fin']){
                return $value['_price'];
            }
            else{
                if(get_option('tecnooptica-setupexclude_form') == "yes"){
                    $precio = "Excluyente";
                }
                else{
                    $precio = $precio_eoc;
                }
            }
        }
        else if($campo == "Eje"){
            if($eje <= $value['inicio'] && $eje >= $value['fin']){
                return $value['_price'];
            }
            else{
                if(get_option('tecnooptica-setupexclude_form') == "yes"){
                    $precio = "Excluyente";
                }
                else{
                    $precio = $precio_eoc;
                }
            }
        }
        else if($campo == "ADD"){
            if($add <= $value['inicio'] && $add >= $value['fin']){
                return $value['_price'];
            }
            else{
                if(get_option('tecnooptica-setupexclude_form') == "yes"){
                    $precio = "Excluyente";
                }
                else{
                    $precio = $precio_eoc;
                }
            }
        }
    }

    return $precio;
}

function remover_product(){
    $cart_key = $_POST['key'];

    $respuesta = WC()->cart->remove_cart_item($cart_key);

    $wc_notices = (array) WC()->session->get( 'wc_notices' );
    unset($wc_notices['success']);

    WC()->session->set( 'wc_notices', $wc_notices );

    wc_add_notice( __( 'Proceso de compra Cancelado', 'tecno-opticas' ), 'error' );

    wp_die();
}

function procesar_imagen($files){

    require_once ABSPATH . 'wp-admin/includes/file.php';

    $overrides = array(
        'test_form' => false
    );

    $upload    = wp_handle_upload( $files, $overrides );

    if ( isset( $upload['error'] ) ) {
        return new WP_Error( 'tecno-opticas-upluoad-image', $upload['error'] );
    }

    $object = array(
        'post_title'     => basename( $upload['file'] ),
        'post_content'   => $upload['url'],
        'post_mime_type' => $upload['type'],
        'guid'           => $upload['url'],
        'context'        => 'import',
        'post_status'    => 'private',
    );

    $id = wp_insert_attachment( $object, $upload['file'] );
    $image_info = getimagesize($upload['file']);
    $image_width = $image_info[0];
    $image_height = $image_info[1];

    $attached_file = get_post_meta($id,"_wp_attached_file", true);

    $datos_imagen = [
        'width' => $image_width,
        'height' => $image_height,
        'file' => $attached_file,
        'sizes' => [],
        'image_meta' => Array
        (
            'aperture' => 0,
            'credit' => "",
            'camera' => "",
            'caption' => "",
            'created_timestamp' => 0,
            'copyright' => "",
            'focal_length' => 0,
            'iso' => 0,
            'shutter_speed' => 0,
            'title' => "",
            'orientation' => 0,
            'keywords' => [],
        )
    ];

    update_post_meta( $id, '_wp_attachment_context',  $datos_imagen );

    return $upload['url'];
}

function woocommerce_custom_price_to_cart_item( $cart_object ) {
    if( !WC()->session->__isset( "reload_checkout" )) {
        foreach ( $cart_object->cart_contents as $key => $value ) {
            if( isset( $value["precio_formulado"] ) ) {
                $value['data']->set_price($value["precio_formulado"]);
            }
        }
    }
}

function guardar_plantilla(){
    $tipo_vision = $_POST['tipo_vision'];
    $dp = $_POST['dp'];
    $datos_formula = $_POST['datos_formula'];
    $nombre_plantilla = $_POST['nombre_plantilla'];
    $user_id = get_current_user_id();
    $plantilla[$nombre_plantilla] = [
        'tipo_vision' => $tipo_vision,
        'dp' => $dp,
        'datos_formula' => $datos_formula,
    ];

    if ($user_id != 0) {

        $plantilla_guardada = get_user_meta($user_id, 'plantilla', true);

        if(empty($plantilla_guardada)){
            $plantilla_final = $plantilla;
        }else{
            $plantilla_final = array_merge($plantilla_guardada,$plantilla);
        }

        if (empty($plantilla_guardada)) {
            add_user_meta($user_id, 'plantilla', $plantilla_final);
        } else {
            update_user_meta($user_id, 'plantilla', $plantilla_final);
        }
    }
    else{
        WC()->session->set( 'plantilla' , $plantilla );
    }

    wp_die();
}

function validar_plantilla()
{
    $nombre_plantilla = $_POST['nombre_plantilla'];
    $user_id = get_current_user_id();

    if ($user_id != 0){
        $plantilla_guardada = get_user_meta($user_id, 'plantilla', true);
        foreach ($plantilla_guardada AS $key => $value) {
            if ($key == $nombre_plantilla) {
                echo 1;
            }
        }
    }
    else{
        $plantilla_session = WC()->session->get_session_data()['plantilla'];
        $plantilla_session = unserialize($plantilla_session);
        echo 2;
    }

    wp_die();
}

function buscar_plantilla(){
    $nombre_plantilla = $_POST['nombre_plantilla'];
    $user_id = get_current_user_id();
    if($user_id != 0) {
        $plantilla_guardada = get_user_meta($user_id, 'plantilla', true);

        foreach ($plantilla_guardada AS $key => $value) {
            if ($key == $nombre_plantilla) {
                $datos_formula = $value;
            }
        }
    }
    else{
        $plantilla_session = WC()->session->get_session_data()['plantilla'];
        $plantilla_session = unserialize($plantilla_session);
        foreach ($plantilla_session AS $key => $value) {
            if ($key == $nombre_plantilla) {
                $datos_formula = $value;
            }
        }
    }

    echo json_encode($datos_formula);

    wp_die();
}

function add_to_cart_url_tecno_opticas( $url, $product = null ) {
    if ( null === $product ) {
        global $product;
    }

    $post_id = $product->get_id();
    if(has_term("monturas", "product_type", $post_id)) {
        $url = get_permalink();
    }

    if(has_term("lentes-contacto", "product_type", $post_id)) {
        $url = get_permalink();
    }

    if ( ! is_a( $product, 'WC_Product' ) ) {
        return $url;
    }

    return $url;
}

function replace_loop_add_to_cart_button( $button, $product  ) {
    $post_id = $product->get_id();

    $url = $button;
    if(has_term("monturas", "product_type", $post_id)) {
        $url = __( "More Info", 'tecno-opticas');
    }

    if(has_term("lentes-contacto", "product_type", $post_id)) {
        $url = __( "More Info", 'tecno-opticas');
    }

    if ( ! is_a( $product, 'WC_Product' ) ) {
        return $button;
    }

    return $url;

}

function buscar_filtro(){
    $id_taxonomia = $_POST['id_taxono'];

    $taxonomias = wp_get_post_terms($id_taxonomia,"opciones_filtro");

    if(!empty($taxonomias)) {
        $opciones = "";
        foreach ($taxonomias AS $key_op_fil => $value_op_fil) {
            $color = get_term_meta($value_op_fil->term_id, 'color', true);

            $opciones .= '
                <p class="form-field lentes_de_colores_tintados_field opciones_filtro" style="background: ' . $color . ';">
                    <label for="lentes_de_colores_tintados" style="color: #000; text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white; font-weight: bold;">
                        ' . $value_op_fil->name . '
                    </label>
                    <input type="radio" class="opcio_filtro" style="" name="opciones_filtro" id="" data-opcion="' . $value_op_fil->term_id . '" value="' . $value_op_fil->name . '">
                </p>
            ';
        }

        $opciones .= "<div class='clear-both'></div>";

        echo $opciones;
    }
    else{
        echo 0;
    }

    wp_die();
}

function opciones_filtro($id_taxonomia){
    $taxonomias = wp_get_post_terms($id_taxonomia,"opciones_filtro");

    $opciones = "<div class='opciones_filtro_contenedor' id='opcion_filtro_".$id_taxonomia."' style='display:none;'>";
    if(!empty($taxonomias)) {
        foreach ($taxonomias AS $key_op_fil => $value_op_fil) {
            $color = get_term_meta($value_op_fil->term_id, 'color', true);
            $opciones .= '
                <p class="form-field lentes_de_colores_tintados_field opciones_filtro" style="background: ' . $color . ';">
                    <label for="lentes_de_colores_tintados" style="color: #000; text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white; font-weight: bold;">
                        ' . $value_op_fil->name . '
                    </label>
                    <input type="radio" class="opcio_filtro" style="" name="opciones_filtro" id="" data-opcion="' . $value_op_fil->term_id . '" value="' . $value_op_fil->name . '">
                </p>
            ';
        }
    }
    $opciones .= "</div> <div class='clear-both'></div>";
    return $opciones;
}