<?php
/**
 * Created by PhpStorm.
 * User: DESAR01
 * Date: 21/10/2021
 * Time: 3:38 PM
 */

if($control != 0) {
    if (is_admin()) {
        add_filter('woocommerce_product_data_tabs', 'tab_precio_monturas');
        add_filter('woocommerce_product_data_tabs', 'tab_atributo_monturas');
        add_action('woocommerce_product_data_panels', 'display_form_fields_precio_monturas');
        add_action('woocommerce_product_data_panels', 'display_form_fields_atributo_monturas');
        add_action( 'woocommerce_process_product_meta', 'guarda_atributos_monturas',99);
        add_action( 'created_term', 'save_category_fields' , 10, 3 );
        add_action( 'edit_term', 'save_category_fields', 10, 3 );
        add_action( 'siluetas_montura_add_form_fields', 'img_siluetas_montura' );
        add_action( 'siluetas_montura_edit_form_fields', 'mostrar_silueta_editar', 10, 2 );
    }
}

add_action( 'init', 'crear_opciones_materiales', 0 );
add_action( 'init', 'crear_opciones_silueta', 0 );
add_action( 'init', 'crear_opciones_genero', 0 );




function tab_precio_monturas($tabs){
    $tabs['monturas_prices'] = array(
        'label'         => __( 'Precio de la Montura', 'tecno-opticas' ),
        'target'        => 'form_panel',
        'class'         => array( 'form_tab'),
        'priority'      => 10,
    );
    return $tabs;
}

function tab_atributo_monturas($tabs){
    $tabs['monturas_atributos'] = array(
        'label'         => __( 'Atributos de la Montura', 'tecno-opticas' ),
        'target'        => 'form_panel',
        'class'         => array( 'form_tab atribu_mont'),
        'priority'      => 10,
    );
    return $tabs;
}

function display_form_fields_precio_monturas(){
    global $post;

    ?>
    <div id='monturas_prices_panel' class='panel woocommerce_options_panel'>
        <div class="options_group">
            <?php

            $label = sprintf(
                __( 'Precio Montura (%s)', 'tecno-opticas' ),
                get_woocommerce_currency_symbol()
            );

            woocommerce_wp_text_input(
                array(
                    'id'            => '_regular_price',
                    'name'            => '_no_prices',
                    'wrapper_class' => '_regular_price_montura',
                    'label'         => $label,
                    'type'          => 'text',
                    'class'   => 'short wc_input_price montura_price',
                )
            );

            $label = sprintf(
                __( 'Precio Rebajado (%s)', 'tecno-opticas' ),
                get_woocommerce_currency_symbol()
            );

            woocommerce_wp_text_input(
                array(
                    'id'            => '_sale_price',
                    'name'            => '_sale_price',
                    'wrapper_class' => '_regular_price_montura',
                    'label'         => $label,
                    'type'          => 'text',
                    'class'   => 'short wc_input_price montura_sale_price',
                )
            );
            ?>
        </div>
    </div>
    <?php
}

function display_form_fields_atributo_monturas(){
    global $post;
    $materiales = get_terms( array(
        'taxonomy' => 'materiales_montura',
        'hide_empty' => false,
    ) );
    $material = get_post_meta( $post->ID, '_material', true );
    if( empty( $material ) ) $material = '0';

    $opciones_materiales[0] = 'Seleccionar';
    foreach ($materiales AS $key => $value){
        $opciones_materiales[$value->name] = $value->name;
    }

    $genero = get_terms( array(
        'taxonomy' => 'genero_montura',
        'hide_empty' => false,
    ) );

    $genero_producto = get_post_meta( $post->ID, '_genero', true );
    if( empty( $genero_producto ) ) $genero_producto = '0';

    $opciones_genero[0] = 'Seleccionar';
    foreach ($genero AS $key => $value){
        $opciones_genero[$value->name] = $value->name;
    }

    $silueta = get_terms( array(
        'taxonomy' => 'siluetas_montura',
        'hide_empty' => false,
    ) );

    $silueta_producto = get_post_meta( $post->ID, '_silueta', true );
    if( empty( $silueta_producto ) ) $silueta_producto = '0';

    $silueta_genero[0] = 'Seleccionar';
    foreach ($silueta AS $key => $value){
        $silueta_genero[$value->name] = $value->name;
    }

    ?>
    <div id='monturas_atributo_panel' class='panel woocommerce_options_panel'>
        <div class="options_group">
            <?php

            woocommerce_wp_select( array(
                'id'      => '_material',
                'options' =>  $opciones_materiales,
                'value'   => $material,
                'label'         => __( "Material", 'tecno-opticas' ),
                'wrapper_class' => '_material_montura',
                'class'   => 'short wc_input_text montura_material',
            ) );

            woocommerce_wp_select( array(
                'id'      => '_genero',
                'options' =>  $opciones_genero,
                'value'   => $genero_producto,
                'label'         => __( "Género", 'tecno-opticas' ),
                'wrapper_class' => '_genero_montura',
                'class'   => 'short wc_input_text genero_material',
            ) );

            woocommerce_wp_select( array(
                'id'      => '_silueta',
                'options' =>  $silueta_genero,
                'value'   => $silueta_producto,
                'label'         => __( "Silueta", 'tecno-opticas' ),
                'wrapper_class' => '_silueta_montura',
                'class'   => 'short wc_input_text silueta_material',
            ) );

            echo '
                <hr>
                <p>'.__('Dimensiones de la montura', 'tecno-opticas').'</p>
            ';

            woocommerce_wp_text_input(
                array(
                    'id'            => '_ancho_montura',
                    'wrapper_class' => '_ancho_montura_montura',
                    'label'         => __( "Ancho Montura (mm)", 'tecno-opticas' ),
                    'type'          => 'text',
                    'placeholder'   => __('Ancho de la montura en mm', 'tecno-opticas'),
                    'class'   => 'short wc_input_text montura_ancho',
                )
            );

            woocommerce_wp_text_input(
                array(
                    'id'            => '_ancho_puente',
                    'wrapper_class' => '_puente_montura',
                    'label'         => __( "Puente (mm)", 'tecno-opticas' ),
                    'type'          => 'text',
                    'placeholder'   => __('Ancho del puente en mm', 'tecno-opticas'),
                    'class'   => 'short wc_input_text montura_puente',
                )
            );

            woocommerce_wp_text_input(
                array(
                    'id'            => '_ancho_mica',
                    'wrapper_class' => '_ancho_mica_montura',
                    'label'         => __( "Ancho Lente (mm)", 'tecno-opticas' ),
                    'type'          => 'text',
                    'placeholder'   => __('Ancho del lente en mm', 'tecno-opticas'),
                    'class'   => 'short wc_input_text montura_ancho_mica',
                )
            );

            woocommerce_wp_text_input(
                array(
                    'id'            => '_alto_mica',
                    'wrapper_class' => '_alto_mica_montura',
                    'label'         => __( "Alto Lente (mm)", 'tecno-opticas' ),
                    'type'          => 'text',
                    'placeholder'   => __( "Alto Lente (mm)", 'tecno-opticas' ),
                    'class'   => 'short wc_input_text montura_alto_mica',
                )
            );

            woocommerce_wp_text_input(
                array(
                    'id'            => '_brazo',
                    'wrapper_class' => '_brazo_montura',
                    'label'         => __( "Brazo (mm)", 'tecno-opticas' ),
                    'type'          => 'text',
                    'placeholder'   => __( "Largo del brazo en mm", 'tecno-opticas' ),
                    'class'   => 'short wc_input_text montura_brazo',
                )
            );

            woocommerce_wp_text_input(
                array(
                    'id'            => '_peso',
                    'wrapper_class' => '_peso_montura',
                    'label'         => __( "Peso (g)", 'tecno-opticas' ),
                    'type'          => 'text',
                    'class'   => 'short wc_input_text montura_peso',
                )
            );
            ?>
        </div>
    </div>
    <?php
}

function crear_opciones_materiales() {

    $labels = array(
        'name' => __( 'Materiales para las monturas', 'tecno-opticas' ),
        'singular_name' => __( 'Materiales para las monturas', 'tecno-opticas' ),
        'menu_name' => __( 'Materiales para las monturas', 'tecno-opticas' ),
    );

    register_taxonomy('materiales_montura','product',array(
        'hierarchical' => false,
        'labels' => $labels,
        'show_ui' => true,
        'show_in_rest' => true,
        'public' => true,
        'show_admin_column' => true,
        'show_in_menu' => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        'rewrite' => array( 'slug' => 'materiales_mmonturas' ),
    ));
}

function crear_opciones_silueta() {

    $labels = array(
        'name' => __( 'Siluetas', 'tecno-opticas' ),
        'singular_name' => __( 'Siluetas para las monturas', 'tecno-opticas' ),
        'menu_name' => __( 'Siluetas para las monturas', 'tecno-opticas' ),
    );

    register_taxonomy('siluetas_montura','product',array(
        'hierarchical' => false,
        'labels' => $labels,
        'show_ui' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
        'public' => true,
        'show_in_menu' => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        'rewrite' => array( 'slug' => 'siluetas_montura' ),
    ));
}

function crear_opciones_genero() {

    $labels = array(
        'name' => __( 'Géneros para las monturas', 'tecno-opticas' ),
        'singular_name' => __( 'Géneros para las monturas', 'tecno-opticas' ),
        'menu_name' => __( 'Géneros para las monturas', 'tecno-opticas' ),
    );

    register_taxonomy('genero_montura','product',array(
        'hierarchical' => false,
        'labels' => $labels,
        'show_ui' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
        'public' => true,
        'show_in_menu' => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        'rewrite' => array( 'slug' => 'genero_montura' ),
    ));
}

function guarda_atributos_monturas($post_id){
    $product = wc_get_product( $post_id );

    if(!empty($_POST['_material'])){
        $material = $_POST['_material'];
        if($material != "0"){
            wp_set_object_terms($post_id, $material, "materiales_montura");
            $product->update_meta_data( '_material', sanitize_text_field( $material ) );
        }
    }

    if(!empty($_POST['_ancho_montura'])){
        $material = $_POST['_ancho_montura'];
        $product->update_meta_data( '_ancho_montura', sanitize_text_field( $material ) );
    }

    if(!empty($_POST['_ancho_puente'])){
        $material = $_POST['_ancho_puente'];
        $product->update_meta_data( '_ancho_puente', sanitize_text_field( $material ) );
    }

    if(!empty($_POST['_ancho_mica'])){
        $material = $_POST['_ancho_mica'];
        $product->update_meta_data( '_ancho_mica', sanitize_text_field( $material ) );
    }

    if(!empty($_POST['_alto_mica'])){
        $material = $_POST['_alto_mica'];
        $product->update_meta_data( '_alto_mica', sanitize_text_field( $material ) );
    }

    if(!empty($_POST['_brazo'])){
        $material = $_POST['_brazo'];
        $product->update_meta_data( '_brazo', sanitize_text_field( $material ) );
    }

    if(!empty($_POST['_peso'])){
        $material = $_POST['_peso'];
        $product->update_meta_data( '_peso', sanitize_text_field( $material ) );
    }

    if(!empty($_POST['_silueta'])){
        $silueta = $_POST['_silueta'];
        if($silueta != "0") {
            wp_set_object_terms($post_id, $silueta, "siluetas_montura");
            $product->update_meta_data('_silueta', sanitize_text_field($silueta));
        }
    }

    if(!empty($_POST['_genero'])){
        $genero = $_POST['_genero'];
        if($genero != "0") {
            wp_set_object_terms($post_id, $genero, "genero_montura");
            $product->update_meta_data('_genero', sanitize_text_field($genero));
        }
    }

    $product->save();
}

function img_siluetas_montura( $taxonomy ) {

    ?>
    <div class="form-field term-thumbnail-wrap">
        <label><?php esc_html_e( 'Thumbnail', 'woocommerce' ); ?></label>
        <div id="product_cat_thumbnail" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( wc_placeholder_img_src() ); ?>" width="60px" height="60px" /></div>
        <div style="line-height: 60px;">
            <input type="hidden" id="silueta_thumbnail_id" name="silueta_thumbnail_id" />
            <button type="button" class="upload_image_button button"><?php esc_html_e( 'Upload/Add image', 'woocommerce' ); ?></button>
            <button type="button" class="remove_image_button button"><?php esc_html_e( 'Remove image', 'woocommerce' ); ?></button>
        </div>
        <p class="description">
            <?php _e('La imagen de la silueta debe tener un tamaño de 60 de ancho por 25 de alto.', 'tecno-opticas'); ?>            
        </p>
        <script type="text/javascript">

            // Only show the "remove image" button when needed
            if ( ! jQuery( '#silueta_thumbnail_id' ).val() ) {
                jQuery( '.remove_image_button' ).hide();
            }

            // Uploading files
            var file_frame;

            jQuery( document ).on( 'click', '.upload_image_button', function( event ) {

                event.preventDefault();

                // If the media frame already exists, reopen it.
                if ( file_frame ) {
                    file_frame.open();
                    return;
                }

                // Create the media frame.
                file_frame = wp.media.frames.downloadable_file = wp.media({
                    title: '<?php esc_html_e( 'Choose an image', 'woocommerce' ); ?>',
                    button: {
                        text: '<?php esc_html_e( 'Use image', 'woocommerce' ); ?>'
                    },
                    multiple: false
                });

                // When an image is selected, run a callback.
                file_frame.on( 'select', function() {
                    var attachment           = file_frame.state().get( 'selection' ).first().toJSON();
                    if(typeof attachment.sizes !== "undefined") {

                        var attachment_thumbnail = attachment.sizes.thumbnail || attachment.sizes.full;

                        jQuery('#silueta_thumbnail_id').val(attachment.id);
                        jQuery('#product_cat_thumbnail').find('img').attr('src', attachment_thumbnail.url);
                        jQuery('.remove_image_button').show();
                    }
                    else{
                        alert("<?php _e('Estimado cliente esa imagen no puede ser usada para las siluetas por favor sube la imagen nuevamente.', 'tecno-opticas'); ?>")
                    }
                });

                // Finally, open the modal.
                file_frame.open();
            });

            jQuery( document ).on( 'click', '.remove_image_button', function() {
                jQuery( '#product_cat_thumbnail' ).find( 'img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
                jQuery( '#silueta_thumbnail_id' ).val( '' );
                jQuery( '.remove_image_button' ).hide();
                return false;
            });

            jQuery( document ).ajaxComplete( function( event, request, options ) {
                if ( request && 4 === request.readyState && 200 === request.status
                    && options.data && 0 <= options.data.indexOf( 'action=add-tag' ) ) {

                    var res = wpAjax.parseAjaxResponse( request.responseXML, 'ajax-response' );
                    if ( ! res || res.errors ) {
                        return;
                    }
                    // Clear Thumbnail fields on submit
                    jQuery( '#product_cat_thumbnail' ).find( 'img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
                    jQuery( '#silueta_thumbnail_id' ).val( '' );
                    jQuery( '.remove_image_button' ).hide();
                    // Clear Display type field on submit
                    jQuery( '#display_type' ).val( '' );
                    return;
                }
            } );

        </script>
        <div class="clear"></div>
    </div>
<?php

}

function save_category_fields( $term_id, $tt_id = '', $taxonomy = '' ) {

    if ( isset( $_POST['silueta_thumbnail_id'] ) && 'siluetas_montura' === $taxonomy ) { // WPCS: CSRF ok, input var ok.
        update_term_meta( $term_id, '_silueta_thumbnail_id', absint( $_POST['silueta_thumbnail_id'] ) ); // WPCS: CSRF ok, input var ok.
    }
}

function mostrar_silueta_editar( $term, $taxonomy ) {

    $thumbnail_id = absint( get_term_meta( $term->term_id, '_silueta_thumbnail_id', true ) );

    if ( $thumbnail_id ) {
        $image = wp_get_attachment_thumb_url( $thumbnail_id );
    } else {
        $image = wc_placeholder_img_src();
    }
    ?>
    <tr class="form-field term-thumbnail-wrap">
        <th scope="row" valign="top"><label><?php esc_html_e( 'Thumbnail', 'woocommerce' ); ?></label></th>
        <td>
            <div id="product_cat_thumbnail" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( $image ); ?>" width="60px" height="60px" id="silueta_thimbnail"/></div>
            <div style="line-height: 60px;">
                <input type="hidden" id="silueta_thumbnail_id" name="silueta_thumbnail_id" value="<?php echo esc_attr( $thumbnail_id ); ?>" />
                <button type="button" class="upload_image_button button"><?php esc_html_e( 'Upload/Add image', 'woocommerce' ); ?></button>
                <button type="button" class="remove_image_button button"><?php esc_html_e( 'Remove image', 'woocommerce' ); ?></button>
            </div>
            <p class="description">
                <?php _e('La imagen de la silueta debe tener un tamaño de 60 de ancho por 25 de alto.', 'tecno-opticas'); ?>
            </p>
            <script type="text/javascript">

                // Only show the "remove image" button when needed
                if ( '0' === jQuery( '#silueta_thumbnail_id' ).val() ) {
                    jQuery( '.remove_image_button' ).hide();
                }

                // Uploading files
                var file_frame;

                jQuery( document ).on( 'click', '.upload_image_button', function( event ) {

                    event.preventDefault();

                    // If the media frame already exists, reopen it.
                    if ( file_frame ) {
                        file_frame.open();
                        return;
                    }

                    // Create the media frame.
                    file_frame = wp.media.frames.downloadable_file = wp.media({
                        title: '<?php esc_html_e( 'Choose an image', 'woocommerce' ); ?>',
                        button: {
                            text: '<?php esc_html_e( 'Use image', 'woocommerce' ); ?>'
                        },
                        multiple: false
                    });

                    // When an image is selected, run a callback.
                    file_frame.on( 'select', function() {
                        var attachment           = file_frame.state().get( 'selection' ).first().toJSON();
                        if(typeof attachment.sizes !== "undefined") {

                            var attachment_thumbnail = attachment.sizes.thumbnail || attachment.sizes.full;

                            jQuery('#silueta_thumbnail_id').val(attachment.id);
                            jQuery('#product_cat_thumbnail').find('img').attr('src', attachment_thumbnail.url);
                            jQuery('.remove_image_button').show();
                        }
                        else{
                            alert("<?php _e('Estimado cliente esa imagen no puede ser usada para las siluetas por favor sube la imagen nuevamente. ', 'tecno-opticas'); ?>")
                        }
                    });

                    // Finally, open the modal.
                    file_frame.open();
                });

                jQuery( document ).on( 'click', '.remove_image_button', function() {
                    jQuery( '#product_cat_thumbnail' ).find( 'img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
                    jQuery( '#silueta_thumbnail_id' ).val( '' );
                    jQuery( '.remove_image_button' ).hide();
                    return false;
                });

            </script>
            <div class="clear"></div>
        </td>
    </tr>
    <?php
}