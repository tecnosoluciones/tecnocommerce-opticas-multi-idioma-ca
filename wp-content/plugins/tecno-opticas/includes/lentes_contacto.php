<?php
/**
 * Created by PhpStorm.
 * User: DESAR01
 * Date: 21/10/2021
 * Time: 3:42 PM
 */

if($control != 0) {
    if (is_admin()) {
        add_filter('woocommerce_product_data_tabs', 'tab_lentes_de_contacto');
    }
}
add_action( 'woocommerce_product_data_panels', 'display_form_fields_lentes_contacto' );

function tab_lentes_de_contacto($tabs){
    $tabs['lentes_contacto_prices'] = array(
        'label'         => __( 'Configurar lente de contacto', 'tecno-opticas' ),
        'target'        => 'form_panel',
        'class'         => array( 'form_tab'),
        'priority'      => 10,
    );
    return $tabs;
}

function display_form_fields_lentes_contacto(){
    global $post;
    $caracteristica_lente_contacto = get_post_meta( $post->ID, '_caracteristica_lente_contacto', true );
    ?>
    <div id='lentes_contacto_panel' class='panel woocommerce_options_panel'>
        <div class="options_group">
            <?php

            $label = sprintf(
                __( 'Precio Lente (%s)', 'tecno-opticas' ),
                get_woocommerce_currency_symbol()
            );

            woocommerce_wp_text_input(
                array(
                    'id'            => '_regular_price',
                    'name'            => '_no_prices',
                    'wrapper_class' => '_regular_price_lente_contacto',
                    'label'         => $label,
                    'type'          => 'text',
                    'class'   => 'short wc_input_price lentes_contacto_price',
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
                    'wrapper_class' => '_regular_price_lentes_contacto',
                    'label'         => $label,
                    'type'          => 'text',
                    'class'   => 'short wc_input_price lentes_contacto_sale_price',
                )
            );

            echo '<h2>'.__("CARACTERÍSTICAS DE LENTES", "tecno-opticas").'</h2>';

            echo '<div id="contenedor_lente_contacto">';

            woocommerce_wp_radio(
                array(
                    'id' => '_caracteristica_lente_contacto',
                    'value' => $caracteristica_lente_contacto,
                    'class' => 'wcpbc_price_method',
                    'label' => __('Por favor indique la característica para el lente de contacto', 'tecno-opticas'),
                    'options' => array(
                        'miopia_o_hipermetropia' => __( 'Miopia o Hipermetropía', 'tecno-opticas' ),
                        'astigmatismo' => __( 'Astigmatismo', 'tecno-opticas' ),
                        'lentes_contacto_tintados' => __( 'Lentes tintados', 'tecno-opticas' ),
                    ),
                    'description' => __('Marque la opción correspondiente al tipo de lente de contacto','tecno-opticas'),
                )
            );

            echo '</div>';

            ?>
        </div>
    </div>
    <?php
}