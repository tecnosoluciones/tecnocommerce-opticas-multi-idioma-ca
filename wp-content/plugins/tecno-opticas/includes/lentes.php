<?php
/**
 * Created by PhpStorm.
 * User: DESAR01
 * Date: 3/10/2022
 * Time: 3:38 PM
 */


if($control != 0) {
    if (is_admin()) {
        add_filter('woocommerce_product_data_tabs', 'create_form_tab_lentes');
        add_filter('woocommerce_product_data_tabs', 'create_form_tab_lentes_atributos');
        add_filter('woocommerce_product_data_tabs', 'create_form_tab_lentes_filtros');
        add_action('woocommerce_product_data_panels', 'display_form_fields_lentes');
        add_action('woocommerce_product_data_panels', 'display_form_fields_lentes_atributos');
        add_action('woocommerce_product_data_panels', 'display_form_fields_lentes_filtros');
        add_action('woocommerce_process_product_meta', 'guarda_opciones_lentes', 99);
        add_action( 'add_meta_boxes', 'meta_precio_filtro' );
        add_action( 'add_meta_boxes', 'meta_tonalidad_filtro' );
        add_action( 'save_post', 'twp_save_meta_box' );
        add_action('wp_ajax_buscar_opciones_filtros','buscar_opciones_filtros');
        add_action( 'created_opciones_filtro', 'guardar_color_opciones_filtro' );
        add_action( 'edited_opciones_filtro', 'guardar_color_opciones_filtro' );
        add_action( 'opciones_filtro_add_form_fields', 'agregar_color_a_op_filtros' );
        add_action( 'opciones_filtro_edit_form_fields', 'mostrar_color_al_editar', 10, 2 );
    }
}

add_action( 'init', 'filtros_para_lentes' );
add_action( 'init', 'crear_opciones_filtro', 0 );
add_action( 'init', 'crear_opciones_marca_lentes', 0 );

function create_form_tab_lentes($tabs){
    $tabs['formulate'] = array(
        'label'         => __( 'Configurar Fórmulas', 'tecno-opticas' ),
        'target'        => 'form_panel',
        'class'         => array( 'form_tab'),
        'priority'      => 10,
    );
    return $tabs;
}

function create_form_tab_lentes_atributos($tabs){
    $tabs['atributos_lentes'] = array(
        'label'         => __( 'Atributos de Lentes', 'tecno-opticas' ),
        'target'        => 'form_panel',
        'class'         => array( 'form_tab atributos_lentes'),
        'priority'      => 10,
    );
    return $tabs;
}

function create_form_tab_lentes_filtros($tabs){
    $tabs['filtros_lentes'] = array(
        'label'         => __( 'Filtros para Lentes', 'tecno-opticas' ),
        'target'        => 'form_panel',
        'class'         => array( 'form_tab filtros_lentes'),
        'priority'      => 10,
    );
    return $tabs;
}

function display_form_fields_lentes(){
    global $post;
    $tipo_vision = get_post_meta( $post->ID, '_tipo_lente', true );
    $price = get_post_meta( $post->ID, '_price', true );
    ?>
    <div id='formulate_panel' class='panel woocommerce_options_panel'>
        <div class="options_group">
            <?php
            if( empty( $tipo_vision ) ) $tipo_vision = '';
            $options = [
                '' => __('Seleccionar', 'tecno-opticas'),
                'descanso' => __('Descanso', 'tecno-opticas'),
                'vision_sencilla' => __('Visión Sencilla', 'tecno-opticas'),
                'bifocales' => __('Bifocales', 'tecno-opticas'),
                'progresivos' => __('Progresivos', 'tecno-opticas'),
                'ocupacionales' => __('Ocupacionales', 'tecno-opticas'),
            ];

            if(get_option('tecnooptica-setupexclude_form_descanso') == "no"){
                unset($options['descanso']);
            }

            $args = array(
                'post_type' => 'vision_sencilla',
            );
            $vision_sencilla = new WP_Query($args);

            if(get_option('tecnooptica-setupexclude_form_vs') == "no"){
                unset($options['vision_sencilla']);
            }
            else{
                if($vision_sencilla->post_count == 0){
                    unset($options['vision_sencilla']);
                }
            }

            $args = array(
                'post_type' => 'bifocales',
            );
            $bifocales = new WP_Query($args);

            if(get_option('tecnooptica-setupexclude_form_bifocales') == "no"){
                unset($options['bifocales']);
            }
            else{
                if($bifocales->post_count == 0){
                    unset($options['bifocales']);
                }
            }

            $args = array(
                'post_type' => 'progresivos',
            );
            $progresivos = new WP_Query($args);

            if(get_option('tecnooptica-setupexclude_form_progresivo') == "no"){
                unset($options['progresivos']);
            }
            else {
                if ($progresivos->post_count == 0) {
                    unset($options['progresivos']);
                }
            }

            $args = array(
                'post_type' => 'ocupacionales',
            );
            $ocupacionales = new WP_Query($args);


            if(get_option('tecnooptica-setupexclude_form_ocupacionales') == "no"){
                unset($options['ocupacionales']);
            }
            else{
                if($ocupacionales->post_count == 0){
                    unset($options['ocupacionales']);
                }
            }

            woocommerce_wp_select( array(
                'id'      => '_tipo_lente',
                'label'   => __( 'Seleccione el tipo de lentes', 'tecno-opticas' ),
                'options' =>  $options, //this is where I am having trouble
                'value'   => $tipo_vision,
                'class'   => "selec_tipo_lente select short",
            ) );

            $label = sprintf(
                __( 'Precio EOC (%s)', 'tecno-opticas' ),
                get_woocommerce_currency_symbol()
            );

            if(get_option('tecnooptica-setupexclude_form') == "yes"){
                $style_eoc = "display:none;";
                $classe_contenedor = "excluido";
            }
            else{
                $style_eoc = "";
                $classe_contenedor = "";
            }

            woocommerce_wp_text_input(
                array(
                    'id'            => '_regular_price',
                    'name'            => '_no_prices',
                    'wrapper_class' => '_regular_price_eoc '.$classe_contenedor,
                    'label'         => $label,
                    'type'          => 'text',
                    'value'          => $price,
                    'class'   => 'short wc_input_price eco_price',
                    'style'   => $style_eoc,
                )
            );
            ?>
        </div>

        <div id="config_form_camp"></div>
    </div>
    <?php
}

function display_form_fields_lentes_atributos(){
    global $post;
    $tipo_gama = get_post_meta( $post->ID, '_gama_lente', true );
    $marca = get_post_meta( $post->ID, '_marca_lente', true );

    $marcas = get_terms( array(
        'taxonomy' => 'marca_lentes',
        'hide_empty' => false,
    ) );

    $opciones_marcas[0] = 'Seleccionar';
    foreach ($marcas AS $key => $value){
        $opciones_marcas[$value->name] = $value->name;
    }

    ?>
    <div id='atributos_lentes_panel' class='panel woocommerce_options_panel'>
        <div class="options_group">
            <?php
            if( empty( $tipo_gama ) ) $tipo_gama = '';
            $options = [
                '' => __('Seleccionar', 'tecno-opticas'),
                'alta' => __('Alta', 'tecno-opticas'),
                'media' => __('Media', 'tecno-opticas'),
                'baja' => __('Baja', 'tecno-opticas'),
                'hd' => __('HD', 'tecno-opticas'),
                'hq' => __('HQ', 'tecno-opticas'),
            ];

            woocommerce_wp_select( array(
                'id'      => '_gama_lente',
                'label'   => __( 'Gama del Lente', 'tecno-opticas' ),
                'options' =>  $options, //this is where I am having trouble
                'value'   => $tipo_gama,
                'class'   => "selec_gama_lente select short",
            ) );

            woocommerce_wp_select( array(
                'id'      => '_marca',
                'options' =>  $opciones_marcas, //this is where I am having trouble
                'value'   => $marca,
                'name'            => '_marca_lente',
                'wrapper_class' => '_regular_marca_lente',
                'label'         => __( "Marca", 'tecno-opticas' ),
                'class'   => 'short select',
            ) );

            ?>
        </div>
    </div>
    <?php
}

function display_form_fields_lentes_filtros(){
    global $post;
    $filtros = get_post_meta( $post->ID, '_filtros', true );

    $unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
        'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
        'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
        'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );

    $args = array(
        'post_type' => "filtros",
    );
    $loop = new WP_Query($args);
    ?>
    <div id='filtros_lentes_panel' class='panel woocommerce_options_panel'>
        <div class="options_group">
            <?php

            foreach($loop->posts AS $key => $value){
                $id = $value->ID;
                $name = strtolower(str_replace(" ","_",$value->post_title));
                $name = strtr( $name, $unwanted_array );
                $title = $value->post_title;

                $taxonomias = wp_get_post_terms($id,"opciones_filtro");

                if(!empty($filtros[$name])){
                    $resp = "yes";
                    $class_precio_filtro = "";
                }
                else{
                    $resp = "no";
                    $class_precio_filtro = "precio_filtros";
                }

                woocommerce_wp_checkbox(
                    array(
                        'id'          => $name,
                        'name'          => 'filtros['.$name.']',
                        'label'       => __( $title, 'tecno-opticas' ),
                        'value'       => $resp,
                        'wrapper_class'  => $name,
                        'desc_tip'       => true,
                        'description' => sprintf(
                            __( 'Marque esta opción si sus lentes poseen el filtro %s', 'tecno-opticas' ),
                            $title
                        ),
                        'class'  => "checkbox element_".$id,
                    )
                );

                echo "<div class='opciones_filtro_".$id."'>";
                if(!empty($filtros[$name]['opciones_filtros'])){

                    if(!empty($taxonomias)) {
                        $opciones = "";
                        foreach ($taxonomias AS $key_op_fil => $value_op_fil) {
                            $color = get_term_meta($value_op_fil->term_id, 'color', true);
                            $validado = "";
                            foreach($filtros[$name]['opciones_filtros'] AS $key_op => $value_op){
                                if ($value_op == $value_op_fil->term_id){
                                    $validado = 'checked="checked"';
                                }
                            }
                            $opciones .= '
                                <p class="form-field lentes_de_colores_tintados_field opciones_filtro" style="background: ' . $color . ';">
                                    <label for="lentes_de_colores_tintados" style="color: #000; text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white; font-weight: bold;">
                                        ' . $value_op_fil->name . '
                                    </label>
                                    <input '.$validado.' type="checkbox" class="checkbox" style="" name="filtros[' . $name . '][opciones_filtros][]" id="" value="' . $value_op_fil->term_id . '">
                                </p>
                            ';
                        }

                        $opciones_header = "
                            <p>".__('Opciones del filtro', 'tecno-opticas')."</p>
                            <div class='contener_opciones_filtro'>" . $opciones . "</div>
                            <div class='clear-both'></div>
                        ";
                    }

                    echo $opciones_header;
                }
                echo "</div>";
            }
            ?>
        </div>
    </div>
    <?php
}

function filtros_para_lentes() {
    register_post_type( 'filtros',
        array(
            'labels' => array(
                'name' => __( 'Filtro', 'tecno-opticas' ),
                'singular_name' => __( 'Filtros', 'tecno-opticas' ),
                'edit_item' => array( __( 'Editar Filtro', 'tecno-opticas' )),
                'new_item' => array( __( 'Nuevo Filtro', 'tecno-opticas' )),
            ),
            'show_ui' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
            'rewrite' => true,
            'exclude_from_search' => true,
            'public' => true,
            'show_in_menu' => false,
            'has_archive' => true,
            'supports' => array( 'title', 'editor')
        )
    );
}

function crear_opciones_filtro() {

// Labels part for the GUI

    $labels = array(
        'name' => __( 'Opción del filtro', 'tecno-opticas' ),
        'singular_name' => __( 'Opciones de filtros', 'tecno-opticas' ),
        'menu_name' => __( 'Opción del filtro', 'tecno-opticas' ),
    );

// Now register the non-hierarchical taxonomy like tag

    register_taxonomy('opciones_filtro','filtros',array(
        'hierarchical' => false,
        'labels' => $labels,
        'show_ui' => true,
        'public' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
        'show_in_menu' => false,
        'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        'rewrite' => array( 'slug' => 'opciones_filtros' ),
    ));
}

function buscar_opciones_filtros(){
    $id_filtro = $_POST['id_elemento'];
    $name = $_POST['name'];
    $taxonomias = wp_get_post_terms($id_filtro,"opciones_filtro");

    if(!empty($taxonomias)){
        $opciones = "";
        foreach($taxonomias AS $key => $value){
            $color = get_term_meta( $value->term_id, 'color', true );
            $opciones .= '
                <p class="form-field lentes_de_colores_tintados_field opciones_filtro" style="background: '.$color.';">
                    <label for="lentes_de_colores_tintados" style="color: #000; text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white; font-weight: bold;">
                        '.$value->name.'
                    </label>
                    <input type="checkbox" class="checkbox" style="" name="filtros['.$name.'][opciones_filtros][]" id="" value="'.$value->term_id.'">
                </p>
            ';
        }

        $opciones_header = "
            <p>".__('Opciones del filtro', 'tecno-opticas')."</p>
            <div class='contener_opciones_filtro'>".$opciones."</div>
            <div class='clear-both'></div>
        ";

        echo $opciones_header;
    }
    else{
        echo 0;
    }

    wp_die();
}

function agregar_color_a_op_filtros( $taxonomy ) {

    echo '
    <div class="form-field">
        <label for="misha-text">'.__('Color', 'tecno-opticas').'</label>
        <input type="color" name="_color" id="color" />
	</div>';

}

function mostrar_color_al_editar( $term, $taxonomy ) {

    $value = get_term_meta( $term->term_id, 'color', true );

    echo '
        <tr class="form-field">
            <th>
                <label for="misha-text">'.__('Color', 'tecno-opticas').'</label>
            </th>
            <td>
                <input name="_color" id="color" type="color" value="' . esc_attr( $value ) .'" />
            </td>
        </tr>
    ';
}

function guardar_color_opciones_filtro( $term_id ) {

    update_term_meta(
        $term_id,
        'color',
        sanitize_text_field( $_POST[ '_color' ] )
    );

}

function guarda_opciones_lentes($post_id){
    $product = wc_get_product( $post_id );

    if(!empty($_POST['_tipo_lente'])){
        $tipo_lente_seleccionado = $_POST['_tipo_lente'];
        $product->update_meta_data( '_tipo_lente', sanitize_text_field( $tipo_lente_seleccionado ) );
    }

    if($_POST['_gama_lente']){
        $tipo_lente_seleccionado = $_POST['_gama_lente'];
        $product->update_meta_data( '_gama_lente', sanitize_text_field( $tipo_lente_seleccionado ) );
    }
    else if($_POST['_gama_lente'] == 0){
        $product->delete_meta_data( '_gama_lente', sanitize_text_field( $tipo_lente_seleccionado ) );
    }

    if($_POST['_marca_lente']){
        $tipo_lente_seleccionado = $_POST['_marca_lente'];
        $product->update_meta_data( '_marca_lente', sanitize_text_field( $tipo_lente_seleccionado ) );
    }
    else if($_POST['_marca_lente'] == 0){
        $product->delete_meta_data( '_marca_lente', sanitize_text_field( $tipo_lente_seleccionado ) );
    }

    if(!empty($_POST['_rang_one'])){
        $formula_lente = $_POST['_rang_one'];
        foreach($formula_lente AS $key => $value){
            if(count($value) == 1){
                $formula_vacia = 0;
                break;
            }
            else{
                $formula_vacia = 1;
                break;
            }
        }
        if($formula_vacia == 1){
            $product->update_meta_data( '_rang_form',  $formula_lente  );
        }
    }

    if(!empty($_POST['filtros'])){
        $lentes_claros = $_POST['filtros'];
        $product->update_meta_data( '_filtros',  $lentes_claros  );
    }

    $product->save();
}

function meta_precio_filtro() {
    $label = sprintf(
        __( 'Precio del filtro (%s)', 'tecno-opticas' ),
        get_woocommerce_currency_symbol()
    );
    add_meta_box( 'mi-meta-box-id', __( $label, 'tecnooptica' ), 'mostrar_campo_meta_precio_filtro', 'filtros' );
}

function meta_tonalidad_filtro() {
    $label = __( 'Tonalidad del filtro', 'tecno-opticas' );
    add_meta_box( 'tonalidad-filtro', __( $label, 'tecnooptica' ), 'mostrar_campo_meta_tonalidad_filtro', 'filtros' );
}

function mostrar_campo_meta_precio_filtro( $post ) {

    $precio_filtro = get_post_meta( $post->ID, 'precio_filtro', true );
    wp_nonce_field( 'mi_meta_box_price_filtro', 'meta_box_price_filtro' );

    woocommerce_wp_text_input(
        array(
            'id'            => 'precio_filtro',
            'name'            => 'precio_filtro',
            'wrapper_class' => '_regular_price_filtro',
            'type'          => 'text',
            'value'          => $precio_filtro,
            'class'   => 'short wc_input_price filtro_price',
        )
    );

}

function mostrar_campo_meta_tonalidad_filtro( $post ) {
    $tonalidad_filtro_mayor= get_post_meta( $post->ID, 'tonalidad_filtro_rango_mayor', true );
    $shade_option_no  = get_post_meta( $post->ID, 'shade_option_no', true );
    $tonalidad_filtro_menor  = get_post_meta( $post->ID, 'tonalidad_filtro_rango_menor', true );
    wp_nonce_field( 'mi_meta_box_meta_tonalidad_filtro', 'meta_box_tonalidad_filtro' );
    $clase_oculta = "";
    if ($shade_option_no == "no"){
        $clase_oculta = " ocultar_campo";
    }

    woocommerce_wp_checkbox(
        array(
            'id'          => "shade_option_no",
            'name'          => 'shade_option_no',
            'label'       => __( "Habilitar tonalidad", 'tecno-opticas' ),
            'value'       => $shade_option_no,
            'wrapper_class'  => "shade_option_no",
            'desc_tip'       => true,
            'description' => sprintf(
                __( 'Marque esta opción si desea habilitar la opción de tonalidad en el proceso de compra', 'tecno-opticas' ),
                "Habilitar tonalidad"
            ),
            'class'  => "shade_option_no element_",
        )
    );

    if(get_option('tecnooptica-setupexclude_form_habilitar_porcentaje_tonalidad') == "yes") {

        woocommerce_wp_text_input(
            array(
                'id' => 'tonalidad_filtro_mayor',
                'name' => 'tonalidad_filtro_rango_mayor',
                'wrapper_class' => '_regular_tonalidad_filtro' . $clase_oculta,
                'type' => 'number',
                'value' => $tonalidad_filtro_mayor,
                'class' => 'short filtro_tonalidad',
                'placeholder' => __('Rango mayor', 'tecno-opticas'),
                'description' => __('Rango mayor', 'tecno-opticas'),
                'custom_attributes' => ['min' => 5, 'max' => 85],

            )
        );

        woocommerce_wp_text_input(
            array(
                'id' => 'tonalidad_filtro_menor',
                'name' => 'tonalidad_filtro_rango_menor',
                'wrapper_class' => '_regular_tonalidad_filtro' . $clase_oculta,
                'type' => 'text',
                'value' => $tonalidad_filtro_menor,
                'class' => 'short filtro_tonalidad',
                'placeholder' => __('Rango menor', 'tecno-opticas'),
                'description' => __('Rango menor', 'tecno-opticas'),
                'custom_attributes' => ['min' => 5, 'max' => 85],
            )
        );

        $opciones_tonalidad = "";
        for ($i = $tonalidad_filtro_mayor; $i >= $tonalidad_filtro_menor; $i--) {
            $opciones_tonalidad .= "<option value='" . $i . "'>" . $i . "%</option>";
        }

        echo "
            <select name='tonalidad' id='ejemplo_tonalidad' class='" . $clase_oculta . "'>
                " . $opciones_tonalidad . "
            </select>
        ";
    }
    else{
        echo "
            <div class='tonalidad_selector_content'>
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

function twp_save_meta_box( $post_id ) {

    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if( !isset( $_POST['meta_box_price_filtro'] ) || !wp_verify_nonce( $_POST['meta_box_price_filtro'], 'mi_meta_box_price_filtro' ) ) return;
    if( !isset( $_POST['meta_box_tonalidad_filtro'] ) || !wp_verify_nonce( $_POST['meta_box_tonalidad_filtro'], 'mi_meta_box_meta_tonalidad_filtro' ) ) return;
    if( !current_user_can( 'manage_options' ) ) return;

    if( !empty( $_POST['precio_filtro'] ) ) {
        update_post_meta($post_id, 'precio_filtro', $_POST['precio_filtro']);
    }

    if( !empty( $_POST['tonalidad_filtro_rango_mayor'] ) ) {
        update_post_meta($post_id, 'tonalidad_filtro_rango_mayor', $_POST['tonalidad_filtro_rango_mayor']);
    }

    if( !empty( $_POST['shade_option_no'] ) ) {
        update_post_meta($post_id, 'shade_option_no', $_POST['shade_option_no']);
    }
    else{
        update_post_meta($post_id, 'shade_option_no', "no");
    }

    if( !empty( $_POST['tonalidad_filtro_rango_menor'] ) ) {
        update_post_meta($post_id, 'tonalidad_filtro_rango_menor', $_POST['tonalidad_filtro_rango_menor']);
    }
}

function crear_opciones_marca_lentes() {

    $labels = array(
        'name' => __( 'Marcas del lente', 'tecno-opticas' ),
        'singular_name' => __( 'Marcas de lentes', 'tecno-opticas' ),
        'menu_name' => __( 'Marcas de lentes', 'tecno-opticas' ),
    );

    register_taxonomy('marca_lentes','product',array(
        'hierarchical' => false,
        'labels' => $labels,
        'show_ui' => true,
        'public' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
        'show_in_menu' => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        'rewrite' => array( 'slug' => 'marca_lentes' ),
    ));
}

function procesar_formul($id_vision, $campo){
    switch ($campo){
        case'esfera':
            $rang_positiv = get_post_meta($id_vision, "rang_positiv_esfera", true);
            $rang_negativ = get_post_meta($id_vision, "rang_negativ_esfera", true);
            $rang_step = get_post_meta($id_vision, "rang_step_esfera", true);
        break;
        case'cilindro':
            $rang_positiv = get_post_meta($id_vision, "rang_positiv_cilindro", true);
            $rang_negativ = get_post_meta($id_vision, "rang_negativ_cilindro", true);
            $rang_step = get_post_meta($id_vision, "rang_step_cilindro", true);
        break;
        case'eje':
            $rang_positiv = get_post_meta($id_vision, "rang_alto_eje", true);
            $rang_negativ = get_post_meta($id_vision, "rang_bajo_eje", true);
            $rang_step = get_post_meta($id_vision, "rang_step_eje", true);
        break;
        case'add':
            $rang_positiv = get_post_meta($id_vision, "rang_positiv_add", true);
            $rang_negativ = get_post_meta($id_vision, "rang_negativ_add", true);
            $rang_step = get_post_meta($id_vision, "rang_step_add", true);
        break;
    }

    $opciones = "";

    if($campo == "eje"){
        for ($i = $rang_positiv; $i >= $rang_negativ; $i = $i - $rang_step) {
            if ($i == 0) {
                $opciones .= '<option selected value="' . $i . '">' . $i . ' °</option>';
            } else {
                $opciones .= '<option value="' . $i . '">' . $i . ' °</option>';
            }
        }
    }
    else{
        for ($i = $rang_positiv; $i >= $rang_negativ; $i = $i - $rang_step) {
            if ($i == 0) {
                $opciones .= '<option selected value="' . $i . '">'.number_format($i, 2, ",", ".").'</option>';
            } else if ($i > 0) {
                if($rang_positiv > $rang_negativ && $i == $rang_negativ){
                    $opciones .= '<option selected value="' . $i . '"> +'.number_format($i, 2, ",", ".").'</option>';
                }
                else {
                    $opciones .= '<option value="' . $i . '"> +'.number_format($i, 2, ",", ".").'</option>';
                }
            } else {
                if(0 > $rang_positiv && $rang_positiv > $rang_negativ && $i == $rang_positiv){
                    $opciones .= '<option selected value="' . $i . '">'.number_format($i, 2, ",", ".").'</option>';
                }
                else {
                    $opciones .= '<option value="' . $i . '">'.number_format($i, 2, ",", ".").'</option>';
                }
            }
        }
    }

    return $opciones;
}