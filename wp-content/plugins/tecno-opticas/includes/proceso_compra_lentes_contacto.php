<?php
/**
 * Created by PhpStorm.
 * User: DESAR01
 * Date: 13/09/2021
 * Time: 3:19 PM
 */



//require_once 'widget.php';

add_action( 'woocommerce_before_add_to_cart_quantity', 'mostrar_formulas_lentes_contacto' );
add_filter( 'woocommerce_add_cart_item_data', 'agregar_meta_lente_contacto', 10, 3 );
add_filter( 'woocommerce_get_item_data', 'mostrar_meta_lente_contacto_cart', 10, 2 );
add_action( 'woocommerce_add_order_item_meta', 'agregar_meta__order_lentes_contactos' , 10, 3 );

function agregar_meta__order_lentes_contactos ( $item_id, $cart_item, $cart_item_key ) {

    if ( isset( $cart_item[ 'esfera_ojo_der' ] ) ) {
        wc_add_order_item_meta( $item_id, __( "Esfera Ojo Derecho", 'tecno-opticas'), $cart_item[ 'esfera_ojo_der' ] );
    }

    if ( isset( $cart_item[ 'esfera_ojo_izq' ] ) ) {
        wc_add_order_item_meta( $item_id, __( "Esfera Ojo Izquierdo", 'tecno-opticas'), $cart_item[ 'esfera_ojo_izq' ] );
    }

    if ( isset( $cart_item[ 'cilindro_ojo_der' ] ) ) {
        wc_add_order_item_meta( $item_id, __( "Cilindro Ojo Derecho", 'tecno-opticas'), $cart_item[ 'cilindro_ojo_der' ] );
    }

    if ( isset( $cart_item[ 'cilindro_ojo_izq' ] ) ) {
        wc_add_order_item_meta( $item_id, __( "Cilindro Ojo Izquierdo", 'tecno-opticas'), $cart_item[ 'cilindro_ojo_izq' ] );
    }

    if ( isset( $cart_item[ 'eje_ojo_der' ] ) ) {
        wc_add_order_item_meta( $item_id, __( "Eje Ojo Derecho", 'tecno-opticas'), $cart_item[ 'eje_ojo_der' ] );
    }

    if ( isset( $cart_item[ 'eje_ojo_izq' ] ) ) {
        wc_add_order_item_meta( $item_id, __( "Eje Ojo Izquierdo", 'tecno-opticas'), $cart_item[ 'eje_ojo_izq' ] );
    }

    if ( isset( $cart_item[ 'cantidad_esfera_ojo_der' ] ) ) {
        wc_add_order_item_meta( $item_id, __( "Cajas Ojo Derecho", 'tecno-opticas'), $cart_item[ 'cantidad_esfera_ojo_der' ] );
    }

    if ( isset( $cart_item[ 'cantidad_esfera_ojo_izq' ] ) ) {
        wc_add_order_item_meta( $item_id, __( "Cajas Ojo Izquierdo", 'tecno-opticas'), $cart_item[ 'cantidad_esfera_ojo_izq' ] );
    }
}

function mostrar_formulas_lentes_contacto($post_id = false, $prefix = false){
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

    if(has_term("lentes-contacto", "product_type", $post_id)) {

        $caracteristica_lente_contacto = get_post_meta($post_id,"_caracteristica_lente_contacto", true);
        $opciones_der = "";
        $opciones_izq = "";
        $opciones_esfera_der = "";
        $opciones_esfera_izq = "";
        $opciones_cilindro_der = "";
        $opciones_cilindro_izq = "";
        $opciones_eje_der = "";
        $opciones_eje_izq = "";
        if($caracteristica_lente_contacto == "miopia_o_hipermetropía" || $caracteristica_lente_contacto == "miopia_o_hipermetropia"){
            $args = array(
                'post_type' => 'miopia',
            );

            $loop = new WP_Query($args);
            $miopia = $loop->post->ID;
            $formula = get_post_meta($miopia, "formula", true);
            foreach($formula['esfera'] AS $key => $value){
                if($value == 0){
                    $opciones_der .= '<option selected value="'.$value.'">'.$value.'</option>';
                    $opciones_izq .= '<option selected value="'.$value.'">'.$value.'</option>';
                }
                else{
                    $opciones_der .= '<option value="'.$value.'">'.$value.'</option>';
                    $opciones_izq .= '<option value="'.$value.'">'.$value.'</option>';
                }
            }

            echo '

                <style>
                    input.qty {
                        display: none;
                    }
                </style>
                <div class="container_addon formulados">
                
                    <div class="fomulados">
                
                        <table data-control="0">
                            <tbody>
                                <tr>
                                    <td class="title_formula lente_contacto der">'.__('Esfera Ojo Derecho', 'tecno-opticas').'</td>
                                    <td class="title_formula lente_contacto izq">'.__('Esfera Ojo Izquierdo', 'tecno-opticas').'</td>
                                    
                                </tr>
                                <tr>
                                    <td class="campo_lentes_contacto der">
                                         <select name="esfera_ojo_der" class="lente_contacto" id="esfera">
                                            '.$opciones_der.'
                                        </select>
                                    </td>
                                    <td class="campo_lentes_contacto izq">
                                        <select name="esfera_ojo_izq" class="lente_contacto" id="esfera">
                                            '.$opciones_izq.'
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="title_formula lente_contacto der">'.__('Cajas Ojo Derecho', 'tecno-opticas').'</td>
                                    <td class="title_formula lente_contacto izq">'.__('Cajas Ojo Izquierdo', 'tecno-opticas').'</td>
                                    
                                </tr>
                                <tr>
                                    <td class="campo_lentes_contacto der">
                                         <select name="cantidad_esfera_ojo_der" class="lente_contacto  caja_ojo_der" id="esfera_ojo_der">
                                            <option value="0">0</option>
                                            <option value="1" selected>1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                        </select>
                                    </td>
                                    <td class="campo_lentes_contacto izq">
                                        <select name="cantidad_esfera_ojo_izq" class="lente_contacto caja_ojo_izq" id="esfera_ojo_izq">
                                            <option value="0">0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div class="txt_ayud_what lente_contacto">
                                        '.__('Si tienes problemas para interpretar tu fórmula, escríbenos vía whatsapp, uno de nuestros asesores te ayudará lo más rápido posible.', 'tecno-opticas').'
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div class="btn_wh lente_contacto">
                                            <a target="_blank" href="https://api.whatsapp.com/send?phone='.get_option('tecnooptica-num-whatsapp').'text='.get_option('tecnooptica-text-whatsapp').'" class="btn_what">
                                            '.__('CONTACTO WHATSAPP <i class="fa fa fa-whatsapp"></i>', 'tecno-opticas').'</a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <div class="cont_file lente_contacto">
                                        <span for="">
                                        '.__('Seleccione la imagen de la fórmula preescrita por su oftalmólogo/optómetra para poder seguir con el proceso de compra.', 'tecno-opticas').'                                            
                                        </span>
                                        <p class="file-formula">
                                            <input type="file" class="formula-file-upload input-text" name="formula"> 
                                            <small>' . sprintf(__('(tamaño máx. de archivo %s)', 'tecno-opticas'), $upload_max_size) . '</small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <style>
                    .quantity,.qty {
                        display: none !important;
                    }
                </style>
            ';
        }
        else if($caracteristica_lente_contacto == "astigmatismo"){
            $args = array(
                'post_type' => 'astigmatismo',
            );

            $loop = new WP_Query($args);
            $miopia = $loop->post->ID;
            $formula = get_post_meta($miopia, "formula", true);
            foreach($formula['esfera'] AS $key => $value){
                if($value == 0){
                    $opciones_esfera_der .= '<option selected value="'.$value.'">'.$value.'</option>';
                    $opciones_esfera_izq .= '<option selected value="'.$value.'">'.$value.'</option>';
                }
                else{
                    $opciones_esfera_der .= '<option value="'.$value.'">'.$value.'</option>';
                    $opciones_esfera_izq .= '<option value="'.$value.'">'.$value.'</option>';
                }
            }

            foreach($formula['cilindro'] AS $key => $value){
                if($value == 0){
                    $opciones_cilindro_der .= '<option selected value="'.$value.'">'.$value.'</option>';
                    $opciones_cilindro_izq .= '<option selected value="'.$value.'">'.$value.'</option>';
                }
                else{
                    $opciones_cilindro_der .= '<option value="'.$value.'">'.$value.'</option>';
                    $opciones_cilindro_izq .= '<option value="'.$value.'">'.$value.'</option>';
                }
            }

            foreach($formula['eje'] AS $key => $value){
                if($value == 0){
                    $opciones_eje_der .= '<option selected value="'.$value.'">'.$value.'</option>';
                    $opciones_eje_izq .= '<option selected value="'.$value.'">'.$value.'</option>';
                }
                else{
                    $opciones_eje_der .= '<option value="'.$value.'">'.$value.'</option>';
                    $opciones_eje_izq .= '<option value="'.$value.'">'.$value.'</option>';
                }
            }

            echo '
                <div class="container_addon formulados">
                
                    <div class="fomulados">
                
                        <table data-control="0">
                            <tbody>
                                <tr>
                                    <td class="title_formula lente_contacto der">'.__('Esfera Ojo Derecho', 'tecno-opticas').'</td>
                                    <td class="title_formula lente_contacto izq">'.__('Esfera Ojo Izquierdo', 'tecno-opticas').'</td>
                                    
                                </tr>
                                <tr>
                                    <td class="campo_lentes_contacto der">
                                         <select name="esfera_ojo_der" class="lente_contacto" id="esfera_ojo_astigmatismo_der">
                                            '.$opciones_esfera_der.'
                                        </select>
                                    </td>
                                    <td class="campo_lentes_contacto izq">
                                        <select name="esfera_ojo_izq" class="lente_contacto" id="esfera_ojo_astigmatismo_izq">
                                            '.$opciones_esfera_izq.'
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="title_formula lente_contacto der">'.__('Cilindro Ojo Derecho', 'tecno-opticas').'</td>
                                    <td class="title_formula lente_contacto izq">'.__('Cilindro Ojo Izquierdo', 'tecno-opticas').'</td>
                                    
                                </tr>
                                <tr>
                                    <td class="campo_lentes_contacto der">
                                         <select name="cilindro_ojo_der" class="lente_contacto" id="cilindro_ojo_der">
                                            '.$opciones_cilindro_der.'
                                        </select>
                                    </td>
                                    <td class="campo_lentes_contacto izq">
                                        <select name="cilindro_ojo_izq" class="lente_contacto" id="cilindro_ojo_izq">
                                            '.$opciones_cilindro_izq.'
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="title_formula lente_contacto der">'.__('Eje Ojo Derecho', 'tecno-opticas').'</td>
                                    <td class="title_formula lente_contacto izq">'.__('Eje Ojo Izquierdo', 'tecno-opticas').'</td>
                                    
                                </tr>
                                <tr>
                                    <td class="campo_lentes_contacto der">
                                         <select name="eje_ojo_der" class="lente_contacto" id="eje_ojo_der">
                                            '.$opciones_eje_der.'
                                        </select>
                                    </td>
                                    <td class="campo_lentes_contacto izq">
                                        <select name="eje_ojo_izq" class="lente_contacto" id="eje_ojo_izq">
                                            '.$opciones_eje_izq.'
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="title_formula lente_contacto der">'.__('Cajas Ojo Derecho', 'tecno-opticas').'</td>
                                    <td class="title_formula lente_contacto izq">'.__('Cajas Ojo Izquierdo', 'tecno-opticas').'</td>
                                    
                                </tr>
                                <tr>
                                    <td class="campo_lentes_contacto der">
                                         <select name="cantidad_esfera_ojo_der" class="lente_contacto  caja_ojo_der" id="esfera_ojo_der">
                                            <option value="0">0</option>
                                            <option value="1" selected>1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                        </select>
                                    </td>
                                    <td class="campo_lentes_contacto izq">
                                        <select name="cantidad_esfera_ojo_izq" class="lente_contacto caja_ojo_izq" id="esfera_ojo_izq">
                                            <option value="0">0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div class="txt_ayud_what lente_contacto">
                                        '.__('Si tienes problemas para interpretar tu fórmula,escríbenos vía whatsapp, uno de nuestros asesores te ayudará lo más rápido posible.', 'tecno-opticas').'                                            
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div class="btn_wh lente_contacto">
                                            <a target="_blank" href="https://api.whatsapp.com/send?phone='.get_option('tecnooptica-num-whatsapp').'text='.get_option('tecnooptica-text-whatsapp').'" class="btn_what">                                            
                                            '.__('CONTACTO WHATSAPP <i class="fab fa-whatsapp"></i>', 'tecno-opticas').'
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <div class="cont_file lente_contacto">
                                        <span for="">
                                        '.__('Seleccione la imagen de la fórmula preescrita por su oftalmólogo/optómetra para poder seguir con el proceso de compra.', 'tecno-opticas').'                                            
                                        </span>
                                        <p class="file-formula">
                                            <input type="file" class="formula-file-upload input-text" name="formula" multiple=”false”> 
                                            <small>' . sprintf(__('(tamaño máx. de archivo %s)', 'tecno-opticas'), $upload_max_size) . '</small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <style>
                    .quantity,.qty {
                        display: none !important;
                    }
                </style>' .
                '
            ';
        }
    }
}

function agregar_meta_lente_contacto( $cart_item_data, $product_id, $variation_id ) {

    if(has_term("lentes-contacto", "product_type", $product_id)) {

        if (!empty($_FILES['formula']) && $_FILES['formula']['error'] == 0) {
            $archivo = $_FILES['formula'];
            $resp_imagen = procesar_imagen($archivo);

            $imagen = '<a href="' . $resp_imagen . '" target="_blank">' . $archivo['name'] . '</a>';

            $cart_item_data['formulado_imagen'] = $imagen;
        }

        if (isset($_POST['esfera_ojo_der'])) {
            $cart_item_data['esfera_ojo_der'] = sanitize_text_field($_POST['esfera_ojo_der']);
        }

        if (isset($_POST['esfera_ojo_izq'])) {
            $cart_item_data['esfera_ojo_izq'] = sanitize_text_field($_POST['esfera_ojo_izq']);
        }

        if (isset($_POST['cantidad_esfera_ojo_der'])) {
            $cart_item_data['cantidad_esfera_ojo_der'] = sanitize_text_field($_POST['cantidad_esfera_ojo_der']);
        }

        if (isset($_POST['cantidad_esfera_ojo_izq'])) {
            $cart_item_data['cantidad_esfera_ojo_izq'] = sanitize_text_field($_POST['cantidad_esfera_ojo_izq']);
        }

        if (isset($_POST['cilindro_ojo_der'])) {
            $cart_item_data['cilindro_ojo_der'] = sanitize_text_field($_POST['cilindro_ojo_der']);
        }

        if (isset($_POST['cilindro_ojo_izq'])) {
            $cart_item_data['cilindro_ojo_izq'] = sanitize_text_field($_POST['cilindro_ojo_izq']);
        }

        if (isset($_POST['eje_ojo_der'])) {
            $cart_item_data['eje_ojo_der'] = sanitize_text_field($_POST['eje_ojo_der']);
        }

        if (isset($_POST['eje_ojo_izq'])) {
            $cart_item_data['eje_ojo_izq'] = sanitize_text_field($_POST['eje_ojo_izq']);
        }
    }

    return $cart_item_data;
}

function mostrar_meta_lente_contacto_cart( $item_data, $cart_item_data ) {

    if( isset( $cart_item_data['esfera_ojo_der'] ) ) {
        $item_data[] = array(
            'key' => __( 'Esfera Ojo Derecho', 'tecno-opticas' ),
            'value' => wc_clean( $cart_item_data['esfera_ojo_der'] )
        );
    }

    if( isset( $cart_item_data['esfera_ojo_izq'] ) ) {
        $item_data[] = array(
            'key' => __( 'Esfera Ojo Izquierdo', 'tecno-opticas' ),
            'value' => wc_clean( $cart_item_data['esfera_ojo_izq'] )
        );
    }

    if( isset( $cart_item_data['cilindro_ojo_der'] ) ) {
        $item_data[] = array(
            'key' => __( 'Cilindro Ojo Derecho', 'tecno-opticas' ),
            'value' => wc_clean( $cart_item_data['cilindro_ojo_der'] )
        );
    }

    if( isset( $cart_item_data['cilindro_ojo_izq'] ) ) {
        $item_data[] = array(
            'key' => __( 'Cilindro Ojo Izquierdo', 'tecno-opticas' ),
            'value' => wc_clean( $cart_item_data['cilindro_ojo_izq'] )
        );
    }

    if( isset( $cart_item_data['eje_ojo_der'] ) ) {
        $item_data[] = array(
            'key' => __( 'Eje Ojo Derecho', 'tecno-opticas' ),
            'value' => wc_clean( $cart_item_data['eje_ojo_der'] )
        );
    }

    if( isset( $cart_item_data['eje_ojo_izq'] ) ) {
        $item_data[] = array(
            'key' => __( 'Eje Ojo Izquierdo', 'tecno-opticas' ),
            'value' => wc_clean( $cart_item_data['eje_ojo_izq'] )
        );
    }

    if( isset( $cart_item_data['cantidad_esfera_ojo_der'] ) ) {
        $item_data[] = array(
            'key' => __( 'Cajas Ojo Derecho', 'tecno-opticas' ),
            'value' => wc_clean( $cart_item_data['cantidad_esfera_ojo_der'] )
        );
    }

    if( isset( $cart_item_data['cantidad_esfera_ojo_izq'] ) ) {
        $item_data[] = array(
            'key' => __( 'Cajas Ojo Izquierdo', 'tecno-opticas' ),
            'value' => wc_clean( $cart_item_data['cantidad_esfera_ojo_izq'] )
        );
    }

    return $item_data;
}