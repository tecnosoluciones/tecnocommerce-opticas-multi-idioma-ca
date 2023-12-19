<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:
add_filter('show_admin_bar', '__return_false');

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );

if ( !function_exists( 'chld_thm_cfg_parent_css' ) ):
    function chld_thm_cfg_parent_css() {
        wp_enqueue_style( 'chld_thm_cfg_parent', trailingslashit( get_template_directory_uri() ) . 'style.css', array(  ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'chld_thm_cfg_parent_css', 10 );
         
if ( !function_exists( 'child_theme_configurator_css' ) ):
    function child_theme_configurator_css() {
        wp_enqueue_style( 'chld_thm_cfg_child', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css', array( 'chld_thm_cfg_parent' ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'child_theme_configurator_css', 10 );

// END ENQUEUE PARENT ACTION
/* Para mostrar la cortina*/

/*if($_SERVER["REQUEST_URI"] === "/") {
    header('Location: https://eyewiz2020.com/index.html');
    die();
} elseif($_SERVER["REQUEST_URI"] === "/index.php") {
    add_filter('redirect_canonical', 'remove_redirect',1,10);

}*/

add_action("wp_enqueue_scripts", "dcms_insertar_js");
function dcms_insertar_js(){
    $dependencies = array( 'jquery' );
    $script_params['ajaxUrl']         = admin_url( 'admin-ajax.php' );
    $script_params['siluetas'] = mostrar_silueta();
    wp_register_script('eyewiz_js', get_site_url(). '/wp-content/themes/eyewiz2020/js/tecno.js', $dependencies, 1.0, true);
    wp_localize_script( 'eyewiz_js', 'opticom', $script_params );
    wp_enqueue_script('eyewiz_js');
}

function mostrar_silueta(){
    $silueta = get_terms( array(
        'taxonomy' => 'siluetas_montura',
        'hide_empty' => false,
    ) );

    foreach ($silueta AS $key => $value){
        $thumbnail_id = absint( get_term_meta( $value->term_id, '_silueta_thumbnail_id', true ) );
        if ( $thumbnail_id ) {
            $image = wp_get_attachment_thumb_url( $thumbnail_id );
            $imagen[$value->term_id] = '<img title="'.$value->name.'" alt="'.$value->name.'" src="'.esc_url( $image ).'" width="80px" height="33px" id="silueta_thimbnail"/>';
        }
    }

    return $imagen;
}

add_filter( 'woocommerce_quantity_input_args', 'bloomer_woocommerce_quantity_changes', 9999, 2 );

function bloomer_woocommerce_quantity_changes( $args, $product ) {

    $args['min_value'] = 1; // Min quantity (default = 0)

   return $args;

}

add_filter( 'woocommerce_product_export_delimiter', function ( $delimiter ) {

	// set your custom delimiter
	$delimiter = ';';

	return $delimiter;
} );

function custom_woocommerce_product_add_to_cart_text( $text ) {
    
    if (function_exists('pll_current_language')) {
        if( pll_current_language() == 'es' ){
            return "Más Información";
        }
       
    } 
	return __( 'More Info' );
}

add_filter( 'woocommerce_product_add_to_cart_text', 'custom_woocommerce_product_add_to_cart_text' );

/* Ocultar barra admin todos los usuarios */
add_filter('show_admin_bar', '__return_false');

