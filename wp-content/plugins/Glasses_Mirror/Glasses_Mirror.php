<?php

/*

Plugin Name: Virtual try on popup

Plugin URI: http://bootstrapweb.co.uk/popup/

Description: Let shoppers try and compare eyeglasses on the shop page .

Version: 1.1

Author: Gordon

Author URI:

License: Commercial License

*/
add_action( 'init', 'register_Glasses_Mirror');
add_action('wp_enqueue_scripts', 'Glasses_Mirror_scripts');
add_action('wp_enqueue_scripts', 'Glasses_Mirror_styles');
add_action('admin_menu', 'slm_Virtual_eyewear_popup_license_menu');
add_action( 'wp_enqueue_scripts', 'wp_enqueue_woocommerce_style' );
add_action( 'wp_enqueue_scripts', 'wp_enqueue_woocommerce_js' );
add_action( 'save_post', 'myplugin_save_meta_box_datax' );
add_action( 'save_post', 'myplugin_save_meta_box_dataaQ' );
add_action( 'save_post', 'myplugin_save_meta_box_dataaaz' );
add_action( 'save_post', 'myplugin_save_meta_box_dataaP' );
add_action( 'woocommerce_simple_add_to_cart' , 'custom_woocommerce_before_cartO', 10, 2 );
add_action( 'add_meta_boxes', 'myplugin_add_meta_boxxy' );
add_action( 'save_post', 'myplugin_save_meta_box_dataay' );
add_action( 'woocommerce_after_shop_loop_item' , 'custom_woocommerce_before_cart_shop', 10, 2);
//add_action( 'woocommerce_before_shop_loop_item_title' , 'custom_woocommerce_before_cart_shop', 10, 2 );
add_action( 'add_meta_boxes', 'myplugin_add_meta_boxx' );
add_action( 'save_post', 'myplugin_save_meta_box_dataa' );
add_action( 'woocommerce_before_add_to_cart_button' , 'custom_woocommerce_before_cart', 10, 2 );
add_action( 'woocommerce_after_shop_loop_item' , 'custom_woocommerce_before_cart', 10, 2 );
add_action( 'woocommerce_before_single_product', 'Glasses_Mirror_display', 10, 2);
add_action( 'woocommerce_before_shop_loop', 'Glasses_Mirror_display', 10, 2);
add_action( 'woocommerce_after_shop_loop_item', 'Glasses_Mirror_display', 99, 3);
add_action("wp_enqueue_scripts", "proba_js");

function Glasses_Mirror_activation() {
     //require('update-notifier.php');
}
register_activation_hook(__FILE__, 'Glasses_Mirror_activation');
function Glasses_Mirror_deactivation() {

}
register_deactivation_hook(__FILE__, 'Glasses_Mirror_deactivation');
// When unistall Clean database
function Glasses_Mirror_uninstall(){



    $args = array (

    'post_type' => 'faces',

    'nopaging' => true

    );

    $faces = new WP_Query ($args);

    while ($faces->have_posts ()) {

        $faces->the_post ();

        wp_delete_post (get_the_ID (), true);

    }









	    $args = array (

        'post_type' => 'Glasses',

        'nopaging' => true

    );

    $Glasses = new WP_Query ($args);

    while ($Glasses->have_posts ()) {

        $Glasses->the_post ();

        wp_delete_post (get_the_ID (), true);

    }





    wp_reset_postdata ();

}
register_uninstall_hook( __FILE__, 'Glasses_Mirror_uninstall' );
function register_Glasses_Mirror() {



    //Custom Post to add Faces templates

    $labels = array(

        'name' => 'Caras',

        'singular_name' => 'Cara',

        'add_new' => 'Agregar nueva',

        'add_new_item' => 'Agregar nueva plantilla',

        'edit_item' => 'Editar plantilla',

        'new_item' => 'Nueva plantilla',

        'view_item' => 'Ver plantilla',

        'search_items' => 'Buscar plantilla',

        'not_found' => 'No se encontró plantilla',

        'not_found_in_trash' => 'No se encontró ninguna plantilla en la Papelera',

        'parent_item_colon' => 'Plantilla principal:',

        'menu_name' => 'Plantilla de caras',

    );



    $args = array(

        'labels' => $labels,

        'hierarchical' => false,

        'description' => 'Upload template',

        'supports' => array( 'title', 'excerpt', 'thumbnail' ),



        'public' => true,

        'menu_icon' => admin_url() . 'images/media-button-image.gif',

        'show_ui' => true,

        'show_in_menu' => true,





        'show_in_nav_menus' => true,

        'publicly_queryable' => true,

        'exclude_from_search' => false,

        'has_archive' => false,

        'query_var' => true,

        'can_export' => false,

        'rewrite' => true,

        'capability_type' => 'post'

    );



    register_post_type( 'faces', $args );



 //Custom Post to add Glasses templates

    $labels = array(

        'name' => 'Lentes',

        'singular_name' => 'Lente',

        'add_new' => 'Agregar nuevo',

        'add_new_item' => 'Agregar nueva plantilla',

        'edit_item' => 'Editar plantilla',

        'new_item' => 'Nueva plantilla',

        'view_item' => 'Ver plantilla',

        'search_items' =>'Buscar plantilla',

        'not_found' => 'Plantilla no encontrada',

        'not_found_in_trash' => 'Plantilla no encontrada en papelera',

        'parent_item_colon' => 'Plantilla principal:',

        'menu_name' => 'Lentes'

    );



    $args = array(

        'labels' => $labels,

        'hierarchical' => false,

        'description' => 'Upload template',

        'supports' => array( 'title', 'excerpt', 'thumbnail' ),



        'public' => true,

        'menu_icon' => admin_url() . 'images/media-button-image.gif',

        'show_ui' => true,

        'show_in_menu' => true,





        'show_in_nav_menus' => true,

        'publicly_queryable' => true,

        'exclude_from_search' => false,

        'has_archive' => false,

        'query_var' => true,

        'can_export' => false,

        'rewrite' => true,

        'capability_type' => 'post'

    );



    register_post_type( 'Glasses', $args );





}
// add scripts
function Glasses_Mirror_scripts() {
    global $post;

    if( has_shortcode( $post->post_content, 'Glasses_Mirror_display') ) {
       // wp_enqueue_script( 'custom-script');
        wp_enqueue_script( 'jquery', plugins_url('/js/jquery.js', __FILE__) );
        wp_enqueue_script('modernizr', plugins_url('js/modernizr.custom.28468.js', __FILE__),array("jquery"));
        // bootstrap
        wp_enqueue_script('bootstrap', plugins_url('js/bootstrap.js', __FILE__),array("jquery"));
        wp_enqueue_script('jquery-ui', plugins_url('js/jquery-ui-1.10.3.custom.min.js', __FILE__),array("jquery"));
        $script_params['btn_subir'] =  __("Subir","Glasses_Mirror");
        $script_params['no_image_input'] =  __("No se cargó ninguna imagen","Glasses_Mirror");
        $script_params['button_change_text'] =  __("Subir imagen","Glasses_Mirror");
        wp_localize_script('jquery-ui', 'glasses_mirror_text', $script_params);
        wp_enqueue_script('pick-a-color', plugins_url('js/pick-a-color-1.1.7.min.js', __FILE__),array("jquery"));
        wp_enqueue_script('tinycolor', plugins_url('js/tinycolor-0.9.15.min.js', __FILE__),array("jquery"));
        wp_enqueue_script('jquery.print-preview', plugins_url('js/jquery.print-preview.js', __FILE__),array("jquery"));
        wp_enqueue_script('html2canvas', plugins_url('js/html2canvas.js', __FILE__));
        wp_enqueue_script('Canvas2Image', plugins_url('js/Canvas2Image.js', __FILE__));
        wp_enqueue_script('base64', plugins_url('js/base64.js', __FILE__));
	    		    	//   <!-- Default Script call -->
        wp_enqueue_script('jquery.ui.touch-punch', plugins_url('js/jquery.ui.touch-punch.js', __FILE__));
        wp_enqueue_script('jquery.Jcrop.min', plugins_url('assets/js/jquery.Jcrop.min.js', __FILE__));
	    wp_enqueue_script('jquery.imgpicker', plugins_url('assets/js/jquery.imgpicker.js', __FILE__));
        wp_enqueue_script('app', plugins_url('./js/app.js', __FILE__));
        // if Internet explorer IE<=8 ( IE fixes)
        if(preg_match('/(?i)msie [1-8]/',$_SERVER['HTTP_USER_AGENT']))
            {
                wp_enqueue_script('respond', plugins_url('js/respond.js', __FILE__));
                wp_enqueue_script('excanvas', plugins_url('js/excanvas.js', __FILE__));
                wp_enqueue_script('html5shim', "http://html5shim.googlecode.com/svn/trunk/html5.js");
            }

            // if Internet explorer IE<=9
            if(preg_match('/(?i)msie [1-9]/',$_SERVER['HTTP_USER_AGENT']))
            {
                wp_enqueue_script('dropfileFix', plugins_url('js/dropfileFix.js', __FILE__));

            }
    }

}
//add styles
function Glasses_Mirror_styles() {
    global $post;
    if( has_shortcode( $post->post_content, 'Glasses_Mirror_display') ) {
        wp_enqueue_style('bootstrap', plugins_url('css/bootstrap.css', __FILE__));
        wp_enqueue_style('bootstrap-responsive', plugins_url('css/bootstrap-responsive.css', __FILE__));
        wp_enqueue_style('font-awesome', plugins_url('css/font-awesome.css', __FILE__));
        wp_enqueue_style('animate', plugins_url('css/animate.css', __FILE__));
        wp_enqueue_style('jquery-ui-1.8.17.custom', plugins_url('css/jquery-ui-1.8.17.custom.css', __FILE__));
        wp_enqueue_style('app', plugins_url('css/app.css', __FILE__));
        wp_enqueue_style('pick-a-color', plugins_url('css/pick-a-color-1.1.7.min.css', __FILE__));
        wp_enqueue_style('app', plugins_url('css/app.css', __FILE__));
        wp_enqueue_style('font-awesome', plugins_url('css/font-awesome.min.css', __FILE__));
        //<!-- HTML5 shim,Responsive design, canvas, fontawesome for IE6-8 support -->
        if(preg_match('/(?i)msie [1-8]/',$_SERVER['HTTP_USER_AGENT']))
            {
                // if IE<=8
                wp_enqueue_style('font-awesome_ie', plugins_url('css/font-awesome-ie7.min.css.css', __FILE__));
                wp_enqueue_style('bootstrap', plugins_url('css/bootstrap.css', __FILE__));
        }
    }

}
define('YOUR_SPECIAL_SECRET_KEY', '5d23f00b3ae301.53187118');
define('YOUR_LICENSE_SERVER_URL', 'http://terribleplugins.com/www');
define('YOUR_ITEM_REFERENCE', 'Virtual_eyewear_popup Plugin');
function slm_Virtual_eyewear_popup_license_menu() {
    add_options_page('Virtual_eyewear_popup License Activation Menu', 'Virtual Tryon License', 'manage_options', __FILE__, 'Virtual_eyewear_popup_license_management_page');
}
function Virtual_eyewear_popup_license_management_page() {
    echo '<div class="wrap">';
    echo '<h2>Virtual_eyewear_popup License Management</h2>';

    /*** License activate button was clicked ***/
    if (isset($_REQUEST['activate_license'])) {
        $license_key = $_REQUEST['Virtual_eyewear_popup_license_key'];

        // API query parameters
        $api_params = array(
            'slm_action' => 'slm_activate',
            'secret_key' => YOUR_SPECIAL_SECRET_KEY,
            'license_key' => $license_key,
            'registered_domain' => $_SERVER['SERVER_NAME'],
            'item_reference' => urlencode(YOUR_ITEM_REFERENCE),
        );

        // Send query to the license manager server
        $query = esc_url_raw(add_query_arg($api_params, YOUR_LICENSE_SERVER_URL));
        $response = wp_remote_get($query, array('timeout' => 20, 'sslverify' => false));

        // Check for error in the response
        if (is_wp_error($response)){
            echo "Unexpected Error! The query returned with an error.";
        }

        //var_dump($response);//uncomment it if you want to look at the full response

        // License data.
        $license_data = json_decode(wp_remote_retrieve_body($response));

        // TODO - Do something with it.
        //var_dump($license_data);//uncomment it to look at the data

        if($license_data->result == 'success'){//Success was returned for the license activation

            //Uncomment the followng line to see the message that returned from the license server
            echo '<br />The following message was returned from the server: '.$license_data->message;

            //Save the license key in the options table
            update_option('Virtual_eyewear_popup_license_key', $license_key);
        }
        else{
            //Show error to the user. Probably entered incorrect license key.

            //Uncomment the followng line to see the message that returned from the license server
            echo '<br />The following message was returned from the server: '.$license_data->message;
        }

    }
    /*** End of license activation ***/

    /*** License activate button was clicked ***/
    if (isset($_REQUEST['deactivate_license'])) {
        $license_key = $_REQUEST['Virtual_eyewear_popup_license_key'];

        // API query parameters
        $api_params = array(
            'slm_action' => 'slm_deactivate',
            'secret_key' => YOUR_SPECIAL_SECRET_KEY,
            'license_key' => $license_key,
            'registered_domain' => $_SERVER['SERVER_NAME'],
            'item_reference' => urlencode(YOUR_ITEM_REFERENCE),
        );

        // Send query to the license manager server
        $query = esc_url_raw(add_query_arg($api_params, YOUR_LICENSE_SERVER_URL));
        $response = wp_remote_get($query, array('timeout' => 20, 'sslverify' => false));

        // Check for error in the response
        if (is_wp_error($response)){
            echo "Unexpected Error! The query returned with an error.";
        }

        //var_dump($response);//uncomment it if you want to look at the full response

        // License data.
        $license_data = json_decode(wp_remote_retrieve_body($response));

        // TODO - Do something with it.
        //var_dump($license_data);//uncomment it to look at the data

        if($license_data->result == 'success'){
          //Success was returned for the license activation

            //Uncomment the followng line to see the message that returned from the license server
            echo '<br />The following message was returned from the server: '.$license_data->message;

            //Remove the licensse key from the options table. It will need to be activated again.
            update_option('Virtual_eyewear_popup_license_key', '');
        }
        else{
            //Show error to the user. Probably entered incorrect license key.

            //Uncomment the followng line to see the message that returned from the license server
            echo '<br />The following message was returned from the server: '.$license_data->message;
        }

    }
    /*** End of Virtual_eyewear_popup license deactivation ***/

    ?>
    <p>Please enter the license key for this plugin to activate it. You were given a license key when you purchased this item.</p>
    <form action="" method="post">
        <table class="form-table">
            <tr>
                <th style="width:100px;"><label for="Virtual_eyewear_popup_license_key">License Key</label></th>
                <td ><input class="regular-text" type="text" id="Virtual_eyewear_popup_license_key" name="Virtual_eyewear_popup_license_key"  value="<?php echo get_option('Virtual_eyewear_popup_license_key'); ?>" ></td>
            </tr>
        </table>
        <p class="submit">
            <input type="submit" name="activate_license" value="Activate" class="button-primary" />
            <input type="submit" name="deactivate_license" value="Deactivate" class="button" />
        </p>
    </form>
    <?php

    echo '</div>';
}
function wp_enqueue_woocommerce_style(){
	if ( class_exists( 'woocommerce' ) ) {
		//wp_enqueue_style('bootstrap', plugins_url('css/bootstrap.css', __FILE__));
		wp_enqueue_style('imgSelect', plugins_url('css/imgSelect.css', __FILE__));
        wp_enqueue_style('bootstrap-responsive', plugins_url('css/bootstrap-responsive.css', __FILE__));
        wp_enqueue_style('font-awesome', plugins_url('css/font-awesome.css', __FILE__));
        wp_enqueue_style('animate', plugins_url('css/animate.css', __FILE__));
        wp_enqueue_style('jquery-ui-1.8.17.custom', plugins_url('css/jquery-ui-1.8.17.custom.css', __FILE__));
        wp_enqueue_style('app', plugins_url('css/app.css', __FILE__));
        wp_enqueue_style('pick-a-color', plugins_url('css/pick-a-color-1.1.7.min.css', __FILE__));
        wp_enqueue_style('app', plugins_url('css/app.css', __FILE__));
        wp_enqueue_style('font-awesome', plugins_url('css/font-awesome.min.css', __FILE__));
        //<!-- HTML5 shim,Responsive design, canvas, fontawesome for IE6-8 support -->
        if(preg_match('/(?i)msie [1-8]/',$_SERVER['HTTP_USER_AGENT'])) {
                // if IE<=8
                wp_enqueue_style('font-awesome_ie', plugins_url('css/font-awesome-ie7.min.css.css', __FILE__));
                wp_enqueue_style('bootstrap', plugins_url('css/bootstrap.css', __FILE__));
        }
	}
}
function wp_enqueue_woocommerce_js(){
	//if (  is_product() ) {
	if ( class_exists( 'woocommerce' ) ) {
	    // wp_enqueue_script( 'custom-script');
        wp_enqueue_script( 'jquery', plugins_url('/js/jquery.js', __FILE__) );
        wp_enqueue_script('modernizr', plugins_url('js/modernizr.custom.28468.js', __FILE__),array("jquery"));
        // bootstrap
        wp_enqueue_script('bootstrap', plugins_url('js/bootstrap.js', __FILE__),array("jquery"));
        wp_enqueue_script('jquery-ui', plugins_url('js/jquery-ui-1.10.3.custom.min.js', __FILE__),array("jquery"));
        $script_params['btn_subir'] =  __("Upload","Glasses_Mirror");
        $script_params['no_image_input'] =  __("No image loaded","Glasses_Mirror");
        $script_params['button_change_text'] =  __("Upload image","Glasses_Mirror");
        wp_localize_script('jquery-ui', 'glasses_mirror_text', $script_params);
        wp_enqueue_script('pick-a-color', plugins_url('js/pick-a-color-1.1.7.min.js', __FILE__),array("jquery"));
        wp_enqueue_script('tinycolor', plugins_url('js/tinycolor-0.9.15.min.js', __FILE__),array("jquery"));
        wp_enqueue_script('jquery.print-preview', plugins_url('js/jquery.print-preview.js', __FILE__),array("jquery"));
        wp_enqueue_script('html2canvas', plugins_url('js/html2canvas.js', __FILE__));
        wp_enqueue_script('Canvas2Image', plugins_url('js/Canvas2Image.js', __FILE__));
        wp_enqueue_script('base64', plugins_url('js/base64.js', __FILE__));
        // <!-- Default Script call -->
        wp_enqueue_script('jquery.ui.touch-punch', plugins_url('js/jquery.ui.touch-punch.js', __FILE__));
		wp_enqueue_script('jquery.Jcrop.min', plugins_url('assets/js/jquery.Jcrop.min.js', __FILE__));
        wp_enqueue_script('jquery.imgpicker', plugins_url('assets/js/jquery.imgpicker.js', __FILE__));
        wp_enqueue_script('app', plugins_url('js/app.js', __FILE__));
        // if Internet explorer IE<=8 ( IE fixes)
        if(preg_match('/(?i)msie [1-8]/',$_SERVER['HTTP_USER_AGENT'])){
            wp_enqueue_script('respond', plugins_url('js/respond.js', __FILE__));
            wp_enqueue_script('excanvas', plugins_url('js/excanvas.js', __FILE__));
            wp_enqueue_script('html5shim', "http://html5shim.googlecode.com/svn/trunk/html5.js");
        }
        // if Internet explorer IE<=9
        if(preg_match('/(?i)msie [1-9]/',$_SERVER['HTTP_USER_AGENT'])) {
            wp_enqueue_script('dropfileFix', plugins_url('js/dropfileFix.js', __FILE__));
        }
	}
}
// Shortcode to use
add_shortcode("Glasses_Mirror_display", "Glasses_Mirror_display");
/**

 * Adds a box to the main column on the Post and Page edit screens.

 */
/**

 * Prints the box content.

 *

 * @param WP_Post $post The object for the current post/page.

 */
/**

 * When the post is saved, saves our custom data.

 *

 * @param int $post_id The ID of the post being saved.

 */
function myplugin_save_meta_box_datax( $post_id ) {



	/*

	 * We need to verify this came from our screen and with proper authorization,

	 * because the save_post action can be triggered at other times.

	 */



	// Check if our nonce is set.

	if ( ! isset( $_POST['myplugin_meta_box_nonce'] ) ) {

		return;

	}



	// Verify that the nonce is valid.

	if ( ! wp_verify_nonce( $_POST['myplugin_meta_box_nonce'], 'myplugin_meta_box' ) ) {

		return;

	}



	// If this is an autosave, our form has not been submitted, so we don't want to do anything.

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {

		return;

	}



	// Check the user's permissions.

	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {



		if ( ! current_user_can( 'edit_page', $post_id ) ) {

			return;

		}



	} else {



		if ( ! current_user_can( 'edit_post', $post_id ) ) {

			return;

		}

	}



	/* OK, it's safe for us to save the data now. */



	// Make sure that it is set.

	if ( ! isset( $_POST['myplugin_new_field'] ) ) {

		return;

	}



	// Sanitize user input.

	$my_data = sanitize_text_field( $_POST['myplugin_new_field'] );



	// Update the meta field in the database.

	update_post_meta( $post_id, '_my_meta_value_key', $my_data );

}
function myplugin_save_meta_box_dataaQ( $post_id ) {

	/*

	 * We need to verify this came from our screen and with proper authorization,

	 * because the save_post action can be triggered at other times.

	 */



	// Check if our nonce is set.

	if ( ! isset( $_POST['myplugin_meta_box_nonceeQ'] ) ) {

		return;

	}



	// Verify that the nonce is valid.

	if ( ! wp_verify_nonce( $_POST['myplugin_meta_box_nonceeQ'], 'myplugin_meta_boxxQ' ) ) {

		return;

	}



	// If this is an autosave, our form has not been submitted, so we don't want to do anything.

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {

		return;

	}



	// Check the user's permissions.

	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {



		if ( ! current_user_can( 'edit_page', $post_id ) ) {

			return;

		}



	} else {



		if ( ! current_user_can( 'edit_post', $post_id ) ) {

			return;

		}

	}



	/* OK, it's safe for us to save the data now. */

	// Make sure that it is set.

	if ( ! isset( $_POST['myplugin_new_fielddQ'] ) ) {

		return;

	}



	// Sanitize user input.

	$my_data = sanitize_text_field( $_POST['myplugin_new_fielddQ'] );



	// Update the meta field in the database.

	update_post_meta( $post_id, '_my_meta_value_keyyQ', $my_data );

}
function myplugin_save_meta_box_dataaaz( $post_id ) {

	/*

	 * We need to verify this came from our screen and with proper authorization,

	 * because the save_post action can be triggered at other times.

	 */



	// Check if our nonce is set.

	if ( ! isset( $_POST['myplugin_meta_box_nonceeez'] ) ) {

		return;

	}



	// Verify that the nonce is valid.

	if ( ! wp_verify_nonce( $_POST['myplugin_meta_box_nonceeez'], 'myplugin_meta_boxxxz' ) ) {

		return;

	}



	// If this is an autosave, our form has not been submitted, so we don't want to do anything.

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {

		return;

	}



	// Check the user's permissions.

	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {



		if ( ! current_user_can( 'edit_page', $post_id ) ) {

			return;

		}



	} else {



		if ( ! current_user_can( 'edit_post', $post_id ) ) {

			return;

		}

	}



	/* OK, it's safe for us to save the data now. */

	// Make sure that it is set.

	if ( ! isset( $_POST['myplugin_new_fieldddz'] ) ) {

		return;

	}



	// Sanitize user input.

	$my_data = sanitize_text_field( $_POST['myplugin_new_fieldddz'] );



	// Update the meta field in the database.

	update_post_meta( $post_id, '_my_meta_value_keyyyz', $my_data );

}
function myplugin_save_meta_box_dataaP( $post_id ) {

	/*

	 * We need to verify this came from our screen and with proper authorization,

	 * because the save_post action can be triggered at other times.

	 */

	// Check if our nonce is set.

	if ( ! isset( $_POST['myplugin_meta_box_noncee'] ) ) {

		return;

	}



	// Verify that the nonce is valid.

	if ( ! wp_verify_nonce( $_POST['myplugin_meta_box_noncee'], 'myplugin_meta_boxx' ) ) {

		return;

	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {

		return;

	}

	// Check the user's permissions.

	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {

			return;

		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {

			return;

		}

	}

	/* OK, it's safe for us to save the data now. */

	// Make sure that it is set.

	if ( ! isset( $_POST['myplugin_new_fieldd'] ) ) {

		return;

	}

	// Sanitize user input.

	$my_data = sanitize_text_field( $_POST['myplugin_new_fieldd'] );

	// Update the meta field in the database.

	update_post_meta( $post_id, '_my_meta_value_keyy', $my_data );

}
 // Our hooked in function - $fields is passed via the filter!
function custom_woocommerce_before_cartO() {

            global $product;

			$product_title= get_the_title();
            $product_title= $product->get_sku();
            
			$urlp = home_url();



		$_url = get_permalink(get_page_by_title('TRY-ON'));





		$product_url=get_post_meta( get_the_ID(),'_my_meta_value_keyy',true );

		 if ($product_url=='Yes'){

		echo"

		<form id='zip_search' method='post' action=".$_url.">



		​<textarea id='zipfield' name='zip' rows='5' cols='70' style='display:none'>$product_title</textarea>

		​<textarea id='zipfieldl' name='ziplink' rows='5' cols='70' style='display:none' >$urlp</textarea>







		</form>";

	 }}
/*

 * Adds a box to the main column on the Post and Page edit screens.

 */
function myplugin_add_meta_boxxy() {

	$screens = array( 'product');

	foreach ( $screens as $screen ) {

		add_meta_box(

			'myplugin_sectioniddy',

			__( 'Virtual Try-On Solution 1', 'myplugin_textdomainny' ),

			'myplugin_meta_box_callbackky',

			$screen

		);

	}

}
function myplugin_meta_box_callbackky( $post ) {

	// Add an nonce field so we can check for it later.

	wp_nonce_field( 'myplugin_meta_boxxy', 'myplugin_meta_box_nonceey' );

	/*retrieve an existing value of get_post_meta()

	 * Use get_post_meta() to retrieve an existing value

	 * from the database and use the value for the form.

	 */

	$value = get_post_meta( $post->ID, '_my_meta_value_keyyy', true );

	echo '<label for="myplugin_new_fielddy">';

	_e( '¿Mostrar el botón "Pruébelo" para este producto en la página de la tienda?  <br> ', 'myplugin_textdomainny' );

	echo '</label> ';



		$args = array( 'post_type' => 'product');

        $product = new WP_Query( $args ); // get post templates

		if($value=='Yes'){

		echo'

        <input type="Radio" id="myplugin_new_fielddy" name="myplugin_new_fielddy" value="Yes" checked/>Si<br>

		<input type="Radio" id="myplugin_new_fielddy" name="myplugin_new_fielddy" value="No" />No';



		echo'<label id="poo"></label>';

       }else {echo'

      <input type="Radio" id="myplugin_new_fielddy" name="myplugin_new_fielddy" value="Yes" />Si<br>

		<input type="Radio" id="myplugin_new_fielddy" name="myplugin_new_fielddy" value="No" checked/>No';

		echo'<label id="poo"></label>';}

		}
function myplugin_save_meta_box_dataay( $post_id ) {

	/*

	 * We need to verify this came from our screen and with proper authorization,

	 * because the save_post action can be triggered at other times.

	 */

	// Check if our nonce is set.

	if ( ! isset( $_POST['myplugin_meta_box_nonceey'] ) ) {

		return;

	}



	// Verify that the nonce is valid.

	if ( ! wp_verify_nonce( $_POST['myplugin_meta_box_nonceey'], 'myplugin_meta_boxxy' ) ) {

		return;

	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {

		return;

	}

	// Check the user's permissions.

	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {

			return;

		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {

			return;

		}

	}

	/* OK, it's safe for us to save the data now. */

	// Make sure that it is set.

	if ( ! isset( $_POST['myplugin_new_fielddy'] ) ) {

		return;

	}

	// Sanitize user input.

	$my_data = sanitize_text_field( $_POST['myplugin_new_fielddy'] );

	// Update the meta field in the database.

	update_post_meta( $post_id, '_my_meta_value_keyyy', $my_data );

}
// Our hooked in function - $fields is passed via the filter!
function custom_woocommerce_before_cart_shop() {
    global $product;
    $is_caregory_page = preg_match('/categoria-producto/', $_SERVER['REQUEST_URI']);
    if( is_shop() or $is_caregory_page ){
        $product_title= get_the_title();
        $product_title = $product->get_sku();
        $urlp = home_url();
        $_url = get_permalink(get_page_by_title('TRY-ON'));
        $urlimg = plugins_url('img/forshoppage.png',__FILE__) ;
        $product_url = get_post_meta( get_the_ID(),'_my_meta_value_keyyy',true );
        if ($product_url=='Yes'){
            echo"
                <form name='btn_add_cart_s'>
                    ​<textarea id='zipfield' name='zip' rows='5' cols='70' style='display:none'>$product_title</textarea>
                    ​<textarea id='zipfieldl' name='ziplink' rows='5' cols='70' style='display:none' >$urlp</textarea>
                    <div value='$product_title' style='margin-bottom: 10px;' id='scrapy'  class='button probador_vr'><svg xmlns=\"http://www.w3.org/2000/svg\" height=\"1em\" viewBox=\"0 0 576 512\"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M118.6 80c-11.5 0-21.4 7.9-24 19.1L57 260.3c20.5-6.2 48.3-12.3 78.7-12.3c32.3 0 61.8 6.9 82.8 13.5c10.6 3.3 19.3 6.7 25.4 9.2c3.1 1.3 5.5 2.4 7.3 3.2c.9 .4 1.6 .7 2.1 1l.6 .3 .2 .1 .1 0 0 0 0 0s0 0-6.3 12.7h0l6.3-12.7c5.8 2.9 10.4 7.3 13.5 12.7h40.6c3.1-5.3 7.7-9.8 13.5-12.7l6.3 12.7h0c-6.3-12.7-6.3-12.7-6.3-12.7l0 0 0 0 .1 0 .2-.1 .6-.3c.5-.2 1.2-.6 2.1-1c1.8-.8 4.2-1.9 7.3-3.2c6.1-2.6 14.8-5.9 25.4-9.2c21-6.6 50.4-13.5 82.8-13.5c30.4 0 58.2 6.1 78.7 12.3L481.4 99.1c-2.6-11.2-12.6-19.1-24-19.1c-3.1 0-6.2 .6-9.2 1.8L416.9 94.3c-12.3 4.9-26.3-1.1-31.2-13.4s1.1-26.3 13.4-31.2l31.3-12.5c8.6-3.4 17.7-5.2 27-5.2c33.8 0 63.1 23.3 70.8 56.2l43.9 188c1.7 7.3 2.9 14.7 3.5 22.1c.3 1.9 .5 3.8 .5 5.7v6.7V352v16c0 61.9-50.1 112-112 112H419.7c-59.4 0-108.5-46.4-111.8-105.8L306.6 352H269.4l-1.2 22.2C264.9 433.6 215.8 480 156.3 480H112C50.1 480 0 429.9 0 368V352 310.7 304c0-1.9 .2-3.8 .5-5.7c.6-7.4 1.8-14.8 3.5-22.1l43.9-188C55.5 55.3 84.8 32 118.6 32c9.2 0 18.4 1.8 27 5.2l31.3 12.5c12.3 4.9 18.3 18.9 13.4 31.2s-18.9 18.3-31.2 13.4L127.8 81.8c-2.9-1.2-6-1.8-9.2-1.8zM64 325.4V368c0 26.5 21.5 48 48 48h44.3c25.5 0 46.5-19.9 47.9-45.3l2.5-45.6c-2.3-.8-4.9-1.7-7.5-2.5c-17.2-5.4-39.9-10.5-63.6-10.5c-23.7 0-46.2 5.1-63.2 10.5c-3.1 1-5.9 1.9-8.5 2.9zM512 368V325.4c-2.6-.9-5.5-1.9-8.5-2.9c-17-5.4-39.5-10.5-63.2-10.5c-23.7 0-46.4 5.1-63.6 10.5c-2.7 .8-5.2 1.7-7.5 2.5l2.5 45.6c1.4 25.4 22.5 45.3 47.9 45.3H464c26.5 0 48-21.5 48-48z\"/></svg>&nbsp;".__("Virtual Try-On",'Glasses_Mirror')."</div>
               </form>
            ";
        }
    }
}
/*

 * Adds a box to the main column on the Post and Page edit screens.

 */
function myplugin_add_meta_boxx() {

	$screens = array( 'product');

	foreach ( $screens as $screen ) {

		add_meta_box(

			'myplugin_sectionidd',

			__( 'Virtual Try-On Solution 2', 'myplugin_textdomainn' ),

			'myplugin_meta_box_callbackk',

			$screen

		);

	}

}
function myplugin_meta_box_callbackk( $post ) {

	// Add an nonce field so we can check for it later.

	wp_nonce_field( 'myplugin_meta_boxx', 'myplugin_meta_box_noncee' );

	/*retrieve an existing value of get_post_meta()

	 * Use get_post_meta() to retrieve an existing value

	 * from the database and use the value for the form.

	 */

	$value = get_post_meta( $post->ID, '_my_meta_value_keyy', true );

	echo '<label for="myplugin_new_fieldd">';

	_e( '¿Mostrar el botón "Pruébelo" en la página única de este producto? <br> ', 'myplugin_textdomainn' );

	echo '</label> ';



		$args = array( 'post_type' => 'product');

        $product = new WP_Query( $args ); // get post templates

		if($value=='Yes'){

		echo'

        <input type="Radio" id="myplugin_new_fieldd" name="myplugin_new_fieldd" value="Yes" checked/>Si<br>

		<input type="Radio" id="myplugin_new_fieldd" name="myplugin_new_fieldd" value="No" />No';



		echo'<label id="po"></label>';

       }else {echo'

      <input type="Radio" id="myplugin_new_fieldd" name="myplugin_new_fieldd" value="Yes" />Si<br>

		<input type="Radio" id="myplugin_new_fieldd" name="myplugin_new_fieldd" value="No" checked/>No';

		echo'<label id="po"></label>';}

		}
function myplugin_save_meta_box_dataa( $post_id ) {

	/*

	 * We need to verify this came from our screen and with proper authorization,

	 * because the save_post action can be triggered at other times.

	 */

	// Check if our nonce is set.

	if ( ! isset( $_POST['myplugin_meta_box_noncee'] ) ) {

		return;

	}



	// Verify that the nonce is valid.

	if ( ! wp_verify_nonce( $_POST['myplugin_meta_box_noncee'], 'myplugin_meta_boxx' ) ) {

		return;

	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {

		return;

	}

	// Check the user's permissions.

	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {

			return;

		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {

			return;

		}

	}

	/* OK, it's safe for us to save the data now. */

	// Make sure that it is set.

	if ( ! isset( $_POST['myplugin_new_fieldd'] ) ) {

		return;

	}

	// Sanitize user input.

	$my_data = sanitize_text_field( $_POST['myplugin_new_fieldd'] );

	// Update the meta field in the database.

	update_post_meta( $post_id, '_my_meta_value_keyy', $my_data );

}
// Our hooked in function - $fields is passed via the filter!
function custom_woocommerce_before_cart() {
    global $product;
    $product_title= get_the_title();
    $product_title = $product->get_sku();
    $urlp = home_url();
    $_url = get_permalink(get_page_by_title('TRY-ON'));
    $urlimg=  plugins_url('img/buttontryeiton.png',__FILE__) ;
    $product_url=get_post_meta( get_the_ID(),'_my_meta_value_keyy',true );
    if ($product_url=='Yes'){
        echo"
            <div class='containr_probador_virtual'>
                <div style='margin-bottom: 10px;' id='scrapy' value='$product_title' class='button probador_vr'><svg xmlns=\"http://www.w3.org/2000/svg\" height=\"1em\" viewBox=\"0 0 576 512\"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M118.6 80c-11.5 0-21.4 7.9-24 19.1L57 260.3c20.5-6.2 48.3-12.3 78.7-12.3c32.3 0 61.8 6.9 82.8 13.5c10.6 3.3 19.3 6.7 25.4 9.2c3.1 1.3 5.5 2.4 7.3 3.2c.9 .4 1.6 .7 2.1 1l.6 .3 .2 .1 .1 0 0 0 0 0s0 0-6.3 12.7h0l6.3-12.7c5.8 2.9 10.4 7.3 13.5 12.7h40.6c3.1-5.3 7.7-9.8 13.5-12.7l6.3 12.7h0c-6.3-12.7-6.3-12.7-6.3-12.7l0 0 0 0 .1 0 .2-.1 .6-.3c.5-.2 1.2-.6 2.1-1c1.8-.8 4.2-1.9 7.3-3.2c6.1-2.6 14.8-5.9 25.4-9.2c21-6.6 50.4-13.5 82.8-13.5c30.4 0 58.2 6.1 78.7 12.3L481.4 99.1c-2.6-11.2-12.6-19.1-24-19.1c-3.1 0-6.2 .6-9.2 1.8L416.9 94.3c-12.3 4.9-26.3-1.1-31.2-13.4s1.1-26.3 13.4-31.2l31.3-12.5c8.6-3.4 17.7-5.2 27-5.2c33.8 0 63.1 23.3 70.8 56.2l43.9 188c1.7 7.3 2.9 14.7 3.5 22.1c.3 1.9 .5 3.8 .5 5.7v6.7V352v16c0 61.9-50.1 112-112 112H419.7c-59.4 0-108.5-46.4-111.8-105.8L306.6 352H269.4l-1.2 22.2C264.9 433.6 215.8 480 156.3 480H112C50.1 480 0 429.9 0 368V352 310.7 304c0-1.9 .2-3.8 .5-5.7c.6-7.4 1.8-14.8 3.5-22.1l43.9-188C55.5 55.3 84.8 32 118.6 32c9.2 0 18.4 1.8 27 5.2l31.3 12.5c12.3 4.9 18.3 18.9 13.4 31.2s-18.9 18.3-31.2 13.4L127.8 81.8c-2.9-1.2-6-1.8-9.2-1.8zM64 325.4V368c0 26.5 21.5 48 48 48h44.3c25.5 0 46.5-19.9 47.9-45.3l2.5-45.6c-2.3-.8-4.9-1.7-7.5-2.5c-17.2-5.4-39.9-10.5-63.6-10.5c-23.7 0-46.2 5.1-63.2 10.5c-3.1 1-5.9 1.9-8.5 2.9zM512 368V325.4c-2.6-.9-5.5-1.9-8.5-2.9c-17-5.4-39.5-10.5-63.2-10.5c-23.7 0-46.4 5.1-63.6 10.5c-2.7 .8-5.2 1.7-7.5 2.5l2.5 45.6c1.4 25.4 22.5 45.3 47.9 45.3H464c26.5 0 48-21.5 48-48z\"/></svg>&nbsp;".__("Virtual Try-On",'Glasses_Mirror')."</div>
            </div>
        ";
	 }
}
//display tryon on the single product page & shop page
function Glasses_Mirror_display(){
    $myflash= plugins_url('assets/webcam.swf',__FILE__) ;
    $urly = home_url();
    $urltofile= plugins_url('server/upload_avatar.php',__FILE__) ;
    $urltofile1= plugins_url('assets/img/default-avatar.png',__FILE__) ;
    $urltofile2= plugins_url('/',__FILE__);
    $presc_ = get_option('Virtual_eyewear_popup_license_key');
    $presc_out= strlen($presc_);
    echo'
        <div class="span6 container-fluid" id="fullall" style="display:none; ">
            <div class="row-fluid content">';
                //get posts Type
                $args = array(
                    'post_type' => 'faces',
                    'tax_query' => array(
                        'relation' => 'AND',
                        array(
                            'taxonomy' => 'language',
                            'terms'    => '22',
                        ),
                    )
                );
                $faces = new WP_Query( $args ); // get Faces templates
                if( $faces->have_posts() ) { // if there is Faces templates
                    $faces->the_post();
                    //the_post_thumbnail();
                    $large_image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                    $url = home_url();
                    echo '
                        <div class="span12 " id="fordrag">
                            <div class="widget"  >
                                <div class="widget-header" >
                                    <i class="icon-star"></i><h3>'.__("Virtual Try-On", "Glasses_Mirror").'</h3>
                                    <div class="closeplug" style="float:right; text-align: center;" >
                                        <i aria-hidden="true" class="fa fa-times" style="font-size:22px;"></i>
                                    </div>
                                    <div class="sizeplus" style="float:right; text-align: center;" > 
                                        <i aria-hidden="true" class="fa fa-expand" style="font-size:22px;"></i>
                                    </div>
                                    <div class="sizeminus" style="float:right; text-align: center;" >
                                        <i aria-hidden="true" class="fa fa-compress" style="font-size:22px;"></i>
                                    </div>
                                    <div class="navbar21" style="float:right; text-align: center;" >
                                        <i aria-hidden="true" class="fa fa-arrow-up" style="font-size:22px;"></i>
                                    </div>                                    
                                    <div class="navbardown" style="float:right; text-align: center;" >
                                        <i class="fa fa-arrow-down " style="font-size:22px;"></i>
                                    </div>
                                </div>
                                <div class="forurl" style="display:none;">' .$urly. '</div>
                                <div class="forflash" style="display:none;">'.$myflash.'</div>
                                <div class="urltofile" style="display:none;">' .$urltofile. '</div>
                                <div class="urltofile1" style="display:none;">' .$urltofile1. '</div>
                                <div class="urltofile2" style="display:none;">' .$urltofile2. '</div>
                                    <div class="widget-content">  
                                        <div class="span6" id="POP">
                                            <div class="designContainer" id="printable">
                                                <div class="imageContainerLimit">
                                                    <div class="span12" id="imagesContainer" >
                                                    </div>
                                                    <img id="Backgroundimg" src="'.$large_image_url[0].'" alt="">
                                                </div>
                                            </div>
                    ';
                    wp_reset_postdata ();
                    echo'	
                                            <div class="span12">
                                                <h5><i class="icon-zoom-in"></i>'.__("Change the size of the glasses", "Glasses_Mirror").'</h5>
                                                <!-- Slider to change font size -->
                                                <div class="slidere">
                                                    <!-- default value -->
                                                    <div class="sizee">50%</div>
                                                    <div class="sizkoko">TOP</div>
                                                    <div class="sKRAPPYkoko">LEFT</div>
                                                    <!-- slider generated by jQuery UI -->
                                                    <div id="slidere"></div>
                                                </div>
                                            </div>
                                            <div class="span12">
                                                <h5><i class="icon-repeat"></i> '.__("Rotate", "Glasses_Mirror").'</h5>
                                                <!-- Slider to change font size -->
                                                <div class="sliderg">
                                                    <!-- default value -->
                                                    <div class="sizeg" >180°</div>
                                                    <!-- slider generated by jQuery UI -->
                                                    <div id="sliderg"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span6">
                                            <div class="span12">
                                                <br>                                                  
                                                <p style="text-align: justify;font-size: 12px;">
                                                    '.__("<strong>NOTE:</strong> Dear customer, note that it is important that you verify the measurements of the frame, which you can see in the frame details page. Please compare the measurements of the chosen frame with the glasses you are currently wearing.
                                                    <br>
                                                    Your complete satisfaction is our goal. 
                                                    <br>", "Glasses_Mirror").'
                                                    <a class="btn-whatsapp" href="https://api.whatsapp.com/send?phone=' . get_option('tecnooptica-num-whatsapp') . '&text=' . get_option('tecnooptica-text-whatsapp') . '" target="_BLANK"> 
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) --><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg>'.__("WhatsApp Contact", "Glasses_Mirror").' 
                                                    </a>
                                                </p>
                                            </div>
                                            <div class="span12" > 	
                                                <br>
                                                <h5><i class="icon-picture"></i>'.__("Upload an image", "Glasses_Mirror").'</h5>
                                                <input type="file" id="imgInp" class="span10" name="file" />
                                            </div >
                                            <div class="span12" >
                                                <h5 class="title-cam"><i class="icon-camera"></i>'.__("Take a picture", "Glasses_Mirror").'</h5>
                                                <div class="ip-modal" id="avatarModal">
                                                    <div class="ip-modal-dialog">
                                                        <div class="ip-modal-content">
                                                            <div class="ip-modal-body" >
                                                                <button type="button" class="btn btn-primary ip-webcam">'.__("Webcam", "Glasses_Mirror").'</button>
                                                                <div class="alert ip-alert"></div>
                                                                <br>
                                                                <div class="ip-modal-footer">
                                                                <div class="flex ip-actions">
                                                                    <button type="button" class="btn btn-success ip-save" style="display:none;">'.__("Save image", "Glasses_Mirror").'</button>
                                                                    <button type="button" class="btn btn-primary ip-capture" style="display:none;">'.__("Capture", "Glasses_Mirror").'</button>
                                                                    <button type="button" class="btn btn-default ip-cancel" style="display:none;">'.__("Cancel", "Glasses_Mirror").'</button>
                                                                </div>
                                                            </div>
                                                                <div class="ip-preview"></div>
                                                                <div class="ip-progress">
                                                                    <div class="text">'.__("Uploading...", "Glasses_Mirror").'</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="span12" >
                                                <ul class="tshirts unstyled clearfix tooltip-show">';
                                                    // get post type
                                                    $args = array(
                                                            'post_type' => 'faces',
                                                            'posts_per_page' => -1,
                                                            'tax_query' => array(
                                                                'relation' => 'AND',
                                                                array(
                                                                    'taxonomy' => 'language',
                                                                    'terms'    => '22',
                                                                ),
                                                            )
                                                    );
                                                    $faces = new WP_Query( $args ); // get Faces templates
                                                    while( $faces->have_posts() ) {
                                                        $faces->the_post();
                                                        //the_excerpt()
                                                        if ( has_post_thumbnail() ) { ?>
                                                            <li>
                                                                <a href="#" data-toggle="tooltip" data-placement="bottom" title='<?php echo the_title(); ?>'>
                                                                    <?php
                                                                    //the_post_thumbnail();
                                                                    $large_image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
                                                                    ?>
                                                                    <img src="<?php echo $large_image_url[0]; ?>" alt="<?php echo  the_title() ?>">
                                                                </a>
                                                            </li>
                                                        <?php } ?>
                                                    <?php }
                                                    wp_reset_postdata ();
                    echo '
                                                </ul> 
                                            </div>
                                        </div><!--.span6-->
                                    </div>
                                    <div class="glasses-container">    
                                        <ul class="glasses unstyled clearfix tooltip-show">';
                                            // get post type
                                            $args = array(
                                                'post_type' => 'Glasses',
                                                'posts_per_page' => 20,'tax_query' => array(
                                                'relation' => 'AND',
                                                array(
                                                    'taxonomy' => 'language',
                                                    'terms'    => '22',
                                                ),
                                            ));
                                            $Glasses = new WP_Query( $args ); // get Glasses templates
                                            while( $Glasses->have_posts() ) {
                                                $Glasses->the_post();
                                                //the_excerpt()
                                                if ( has_post_thumbnail() ) { ?>
                                                    <li>
                                                        <a href="#" data-toggle="tooltip" data-placement="bottom" title='<?php echo the_title(); ?>'>
                                                            <?php
                                                            //the_post_thumbnail();
                                                            $large_image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
                                                            ?>
                                                            <img src="<?php echo $large_image_url[0]; ?>" alt="<?php echo  the_title() ?>">
                                                        </a>
                                                    </li>
                                                <?php } // end if ?><?php
                                            } // end while
                                            wp_reset_postdata ();
                    echo '
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    }
                    else {
                      //  echo __('No face templates found! please log in with your administrator and add a few', 'Glasses_Mirror');
                    }
echo '</div>';
}
function proba_js(){
    $dependencies = array( 'jquery' );
    $script_params['url'] = home_url();
    $script_params['urltofile'] = plugins_url('server/upload_avatar.php',__FILE__);
    $script_params['urltofile1'] = plugins_url('assets/img/default-avatar.png',__FILE__);
    $script_params['urltofile2'] = plugins_url('/',__FILE__);
    $script_params['ajaxUrl']         = admin_url( 'admin-ajax.php' );
    wp_register_script('probador-virtual-new', plugins_url('/js/mostrar_probador_virtual.js', __FILE__), $dependencies, 1.0, true);
    wp_localize_script( 'probador-virtual-new', 'probador_virtual', $script_params );
    wp_enqueue_script('probador-virtual-new');

    wp_register_script('habilitar_webcam', plugins_url('/js/webcam_probador_virtual.js', __FILE__), $dependencies, 1.0, true);
    wp_localize_script( 'habilitar_webcam', 'webcam_probador_virtual', $script_params );
    wp_enqueue_script('habilitar_webcam');
}

add_action('wp_ajax_nopriv_validar_probador','validar_probador');
add_action('wp_ajax_validar_probador','validar_probador');

function validar_probador(){
    $id_product = $_POST['id_product'];

    foreach(array_unique($id_product) AS $key => $value) {
        $product = new WC_Product($value);
        $product_title = $product->get_title();
        $product_sku = $product->get_sku();
        $product_url = get_post_meta($product->get_ID(), '_my_meta_value_keyyy', true);
        $probador = [];
        if ($product_url == 'Yes') {
            $probador["boton"] = "
                <div class='containr_probador_virtual'>
                    <div style='margin-bottom: 10px;' id='scrapy' value='$product_sku' class='button probador_vr'><svg xmlns=\"http://www.w3.org/2000/svg\" height=\"1em\" viewBox=\"0 0 576 512\"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M118.6 80c-11.5 0-21.4 7.9-24 19.1L57 260.3c20.5-6.2 48.3-12.3 78.7-12.3c32.3 0 61.8 6.9 82.8 13.5c10.6 3.3 19.3 6.7 25.4 9.2c3.1 1.3 5.5 2.4 7.3 3.2c.9 .4 1.6 .7 2.1 1l.6 .3 .2 .1 .1 0 0 0 0 0s0 0-6.3 12.7h0l6.3-12.7c5.8 2.9 10.4 7.3 13.5 12.7h40.6c3.1-5.3 7.7-9.8 13.5-12.7l6.3 12.7h0c-6.3-12.7-6.3-12.7-6.3-12.7l0 0 0 0 .1 0 .2-.1 .6-.3c.5-.2 1.2-.6 2.1-1c1.8-.8 4.2-1.9 7.3-3.2c6.1-2.6 14.8-5.9 25.4-9.2c21-6.6 50.4-13.5 82.8-13.5c30.4 0 58.2 6.1 78.7 12.3L481.4 99.1c-2.6-11.2-12.6-19.1-24-19.1c-3.1 0-6.2 .6-9.2 1.8L416.9 94.3c-12.3 4.9-26.3-1.1-31.2-13.4s1.1-26.3 13.4-31.2l31.3-12.5c8.6-3.4 17.7-5.2 27-5.2c33.8 0 63.1 23.3 70.8 56.2l43.9 188c1.7 7.3 2.9 14.7 3.5 22.1c.3 1.9 .5 3.8 .5 5.7v6.7V352v16c0 61.9-50.1 112-112 112H419.7c-59.4 0-108.5-46.4-111.8-105.8L306.6 352H269.4l-1.2 22.2C264.9 433.6 215.8 480 156.3 480H112C50.1 480 0 429.9 0 368V352 310.7 304c0-1.9 .2-3.8 .5-5.7c.6-7.4 1.8-14.8 3.5-22.1l43.9-188C55.5 55.3 84.8 32 118.6 32c9.2 0 18.4 1.8 27 5.2l31.3 12.5c12.3 4.9 18.3 18.9 13.4 31.2s-18.9 18.3-31.2 13.4L127.8 81.8c-2.9-1.2-6-1.8-9.2-1.8zM64 325.4V368c0 26.5 21.5 48 48 48h44.3c25.5 0 46.5-19.9 47.9-45.3l2.5-45.6c-2.3-.8-4.9-1.7-7.5-2.5c-17.2-5.4-39.9-10.5-63.6-10.5c-23.7 0-46.2 5.1-63.2 10.5c-3.1 1-5.9 1.9-8.5 2.9zM512 368V325.4c-2.6-.9-5.5-1.9-8.5-2.9c-17-5.4-39.5-10.5-63.2-10.5c-23.7 0-46.4 5.1-63.6 10.5c-2.7 .8-5.2 1.7-7.5 2.5l2.5 45.6c1.4 25.4 22.5 45.3 47.9 45.3H464c26.5 0 48-21.5 48-48z\"/></svg>&nbsp;".__("Virtual Try-On",'Glasses_Mirror')."</div>
                </div>
            ";
            $elemento = imprimir_probador_carrusel($product);
            $probador['elemento'] = $elemento;
            $probador['sku'] = $product_sku;
            $probador_final[$value] = $probador;
        }
    }

    echo json_encode($probador_final);
    wp_die();
}

add_action('wp_ajax_nopriv_get_probador','get_probador');
add_action('wp_ajax_get_probador','get_probador');

function get_probador(){
    $sku = $_POST['sku'];

    $args = array(
        'post_type' => 'glasses',
        'title' => $sku,
        'tax_query' => array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'language',
                'terms'    => '22',
            ),
        )
    );
    $lentes_probador = new WP_Query($args);

    $large_image_url = wp_get_attachment_image_src(get_post_thumbnail_id($lentes_probador->post), 'large');

    echo json_encode($large_image_url[0]);
    wp_die();
}

function imprimir_probador_carrusel($product){
    $contenedor = "";
    $myflash= plugins_url('assets/webcam.swf',__FILE__) ;
    $urly = home_url();
    $urltofile= plugins_url('server/upload_avatar.php',__FILE__) ;
    $urltofile1= plugins_url('assets/img/default-avatar.png',__FILE__) ;
    $urltofile2= plugins_url('/',__FILE__);
    $presc_ = get_option('Virtual_eyewear_popup_license_key');
    $presc_out= strlen($presc_);
    $contenedor .= '
        <div class="span6 container-fluid" id="fullall" style="display:none; ">
             <div class="row-fluid content">
    ';
    $args = array( 'post_type' => 'faces');
    $faces = new WP_Query( $args ); // get Faces templates
    if( $faces->have_posts() ){
        $faces->the_post();
        $large_image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
        $contenedor .= '
            <div class="span12 " id="fordrag">
                <div class="widget">
                    <div class="widget-header" >
                        <i class="icon-star"></i><h3>'.__("Virtual Try-On", "Glasses_Mirror").'</h3>
                        <div class="closeplug" style="float:right; text-align: center;" >
                            <i aria-hidden="true" class="fa fa-times" style="font-size:22px;"></i>
                        </div>
                        <div class="sizeplus" style="float:right; text-align: center;" > 
                            <i aria-hidden="true" class="fa fa-expand" style="font-size:22px;"></i>
                        </div>
                        <div class="sizeminus" style="float:right; text-align: center;" >
                            <i aria-hidden="true" class="fa fa-compress" style="font-size:22px;"></i>
                        </div>
                        <div class="navbar21" style="float:right; text-align: center;" >
                            <i aria-hidden="true" class="fa fa-arrow-up" style="font-size:22px;"></i>
                        </div>                                    
                        <div class="navbardown" style="float:right; text-align: center;" >
                            <i class="fa fa-arrow-down " style="font-size:22px;"></i>
                        </div>
                    </div>
                    <div class="forurl" style="display:none;">' .$urly. '</div>
                    <div class="forflash" style="display:none;">'.$myflash.'</div>
                    <div class="urltofile" style="display:none;">' .$urltofile. '</div>
                    <div class="urltofile1" style="display:none;">' .$urltofile1. '</div>
                    <div class="urltofile2" style="display:none;">' .$urltofile2. '</div>
                    <div class="widget-content">  
                        <div class="span6" id="POP">
                            <div class="designContainer" id="printable">
                                <div class="imageContainerLimit">
                                    <div class="span12" id="imagesContainer" ></div>
                                        <img id="Backgroundimg" src="'.$large_image_url[0].'" alt="">
                                    </div>
                                </div>';
                                wp_reset_postdata ();
                                $contenedor .= '	
                                <div class="span12">
                                    <h5><i class="icon-zoom-in"></i> '.__("Change the size of the glasses", "Glasses_Mirror").'</h5>
                                    <!-- Slider to change font size -->
                                    <div class="slidere">
                                        <!-- default value -->
                                        <div class="sizee">50%</div>
                                        <div class="sizkoko">TOP</div>
                                        <div class="sKRAPPYkoko">LEFT</div>
                                        <!-- slider generated by jQuery UI -->
                                        <div id="slidere"></div>
                                    </div>
                                </div>
                                <div class="span12">
                                    <h5><i class="icon-repeat"></i>'.__("Rotate", "Glasses_Mirror").'</h5>
                                    <!-- Slider to change font size -->
                                    <div class="sliderg">
                                        <!-- default value -->
                                        <div class="sizeg" >180°</div>
                                        <!-- slider generated by jQuery UI -->
                                        <div id="sliderg"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="span6">
                                <div class="span12">
                                    <br>                                                  
                                    <p style="text-align: justify;font-size: 12px;">
                                            '.__("<strong>NOTE:</strong> Dear customer, note that it is important that you verify the measurements of the frame, which you can see in the frame details page. Please compare the measurements of the chosen frame with the glasses you are currently wearing.
                                                <br>
                                                Your complete satisfaction is our goal. 
                                                <br>", "Glasses_Mirror").'
                                                <a class="btn-whatsapp" href="https://api.whatsapp.com/send?phone=' . get_option('tecnooptica-num-whatsapp') . '&text=' . get_option('tecnooptica-text-whatsapp') . '" target="_BLANK"> 
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) --><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg>'.__("WhatsApp Contact", "Glasses_Mirror").' 
                                                </a>
                                            </p>
                                </div>
                                <div class="span12" > 	
                                    <br>
                                    <h5><i class="icon-picture"></i>'.__("Upload an image", "Glasses_Mirror").'</h5>
                                    <input type="file" id="imgInp" class="span10" name="file" />
                                </div>
                                <div class="span12" >
                                    <h5 class="title-cam"><i class="icon-camera"></i>'.__("Take a picture", "Glasses_Mirror").'</h5>
                                    <div class="ip-modal" id="avatarModal">
                                        <div class="ip-modal-dialog">
                                            <div class="ip-modal-content">
                                                <div class="ip-modal-body" >
                                                    <button type="button" class="btn btn-primary ip-webcam">'.__("Webcam", "Glasses_Mirror").'</button>
                                                    <div class="alert ip-alert"></div>
                                                    <div class="ip-modal-footer">
                                                    		 <div class="flex ip-actions">
                                                                <button type="button" class="btn btn-success ip-save" style="display:none;">'.__("Save image", "Glasses_Mirror").'</button>
                                                                <button type="button" class="btn btn-primary ip-capture" style="display:none;">'.__("Capture", "Glasses_Mirror").'</button>
                                                                <button type="button" class="btn btn-default ip-cancel" style="display:none;">'.__("Cancel", "Glasses_Mirror").'</button>
                                                            </div>
                                                </div>
                                                <br>
                                                    <div class="ip-preview"></div>
                                                    <div class="ip-progress">
                                                        <div class="text">'.__("Uploading...", "Glasses_Mirror").'</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="span12" >
                                    <ul class="tshirts unstyled clearfix tooltip-show">';
                                        $args = array( 'post_type' => 'faces','posts_per_page' => -1);
                                        $faces = new WP_Query( $args ); // get Faces templates
                                        while( $faces->have_posts() ) {
                                            $faces->the_post();
                                            if ( has_post_thumbnail() ) {
                                                $large_image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
                                                $contenedor .= '
                                                    <li>
                                                        <a href="#" data-toggle="tooltip" data-placement="bottom" title="'.the_title("","",false).'">
                                                            <img src="'.$large_image_url[0].'" alt="'.the_title("","",false).'">
                                                        </a>
                                                    </li>
                                                ';
                                            }
                                        }
                                        wp_reset_postdata ();
                                    $contenedor .= '
                                    </ul> 
                                </div>
                            </div>
                            <div class="glasses-container">    
                                <ul class="glasses unstyled clearfix tooltip-show">';
                                    $args = array( 'post_type' => 'Glasses','posts_per_page' => 20);
                                    $Glasses = new WP_Query( $args ); // get Glasses templates
                                    while( $Glasses->have_posts() ) {
                                        $Glasses->the_post();
                                        if ( has_post_thumbnail() ) {
                                            $large_image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
                                            $contenedor .= '
                                            <li>
                                                <a href="#" data-toggle="tooltip" data-placement="bottom" title="'.the_title("","",false).'">
                                                    <img src="'.$large_image_url[0].'" alt="'.the_title("","",false).'">
                                                </a>
                                            </li>';
                                        } // end if
                                    } // end while
                                    wp_reset_postdata ();
                                    $contenedor .= '
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        ';
    }else {
        $contenedor = null;//__('No face templates found! please log in with your administrator and add a few', 'Glasses_Mirror');
    }
    return $contenedor;
}

