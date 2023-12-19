<?php
/**
 * Created by PhpStorm.
 * User: DESAR01
 * Date: 7/10/2021
 * Time: 4:53 PM
 */

defined( 'ABSPATH' ) or die( 'Acceso denegado' );

add_action('wp_ajax_insert_rang_form_miopia','insert_rang_form_miopia');
add_action('wp_ajax_insert_rang_form_astigmatismo','insert_rang_form_astigmatismo');

function insert_rang_form_miopia(){
    $datos = $_POST['datos'];
    $formula = [];
    for($i=$datos['rango-alto-esfera'];$i>=$datos['rango-bajo-esfera'];$i=$i-$datos['step-esfera']) {
        if ($i > 0) {
            $formula['esfera'][] .= "+".number_format($i, 2, ",", ".");
        } else {
            $formula['esfera'][] .= number_format($i, 2, ",", ".");
        }
    }

    $args = array(
        'post_type' => 'miopia',
    );
    $loop = new WP_Query($args);
    $id = $loop->post->ID;

    if( $id != 0){
        update_post_meta($id,'formula', $formula );
        update_post_meta($id,'rango-alto', $datos['rango-alto-esfera']);
        update_post_meta($id,'rango-bajo', $datos['rango-bajo-esfera']);
        update_post_meta($id,'step-esfera', $datos['step-esfera']);
    }
    else{
        $title = __('Miopia o Hipermetropía', 'tecno-opticas');
        $post_data = array(
            'post_title'    => wp_strip_all_tags( $title ),
            'post_status'   => 'publish',
            'post_type'     => 'miopia',
            'post_author'   => '1',
            'post_category' => '',
            'meta_input'   => array(
                'formula' => $formula,
                'rango-alto' => $datos['rango-alto-esfera'],
                'rango-bajo' => $datos['rango-bajo-esfera'],
                'step-esfera' => $datos['step-esfera'],
            ),
            'page_template' => NULL
        );

        $id = wp_insert_post( $post_data );
    }

    echo $id;

    wp_die();
}

function insert_rang_form_astigmatismo(){
    $datos = $_POST['datos'];
    $formula = [];
    for($i=$datos['rango-alto-esfera'];$i>=$datos['rango-bajo-esfera'];$i=$i-$datos['step-esfera']){
        if ($i > 0) {
            $formula['esfera'][] .= "+".number_format($i, 2, ",", ".");
        } else {
            $formula['esfera'][] .= number_format($i, 2, ",", ".");
        }
    }

    for($i=$datos['rango-alto-cilindro'];$i>=$datos['rango-bajo-cilindro'];$i=$i-$datos['step-cilindro']){
        if ($i > 0) {
            $formula['cilindro'][] .= "+".number_format($i, 2, ",", ".");
        } else {
            $formula['cilindro'][] .= number_format($i, 2, ",", ".");
        }
    }

    for($i=$datos['rango-alto-eje'];$i>=$datos['rango-bajo-eje'];$i=$i-$datos['step-eje']){
        $formula['eje'][] .= $i;
    }

    $args = array(
        'post_type' => 'astigmatismo',
    );
    $loop = new WP_Query($args);
    $id = $loop->post->ID;

    if( $id != 0){
        update_post_meta($id,'formula', $formula );
        update_post_meta($id,'rango-alto-esfera', $datos['rango-alto-esfera']);
        update_post_meta($id,'rango-bajo-esfera', $datos['rango-bajo-esfera']);
        update_post_meta($id,'step-esfera', $datos['step-esfera']);
        update_post_meta($id,'rango-alto-cilindro', $datos['rango-alto-cilindro']);
        update_post_meta($id,'rango-bajo-cilindro', $datos['rango-bajo-cilindro']);
        update_post_meta($id,'step-cilindro', $datos['step-cilindro']);
        update_post_meta($id,'rango-alto-eje', $datos['rango-alto-eje']);
        update_post_meta($id,'rango-bajo-eje', $datos['rango-bajo-eje']);
        update_post_meta($id,'step-eje', $datos['step-eje']);
    }
    else{
        $title = __('Miopia o Hipermetropía', 'tecno-opticas');
        $post_data = array(
            'post_title'    => wp_strip_all_tags( $title ),
            'post_status'   => 'publish',
            'post_type'     => 'astigmatismo',
            'post_author'   => '1',
            'post_category' => '',
            'meta_input'   => array(
                'formula' => $formula,
                'rango-alto-esfera' => $datos['rango-alto-esfera'],
                'rango-bajo-esfera' => $datos['rango-bajo-esfera'],
                'step-esfera' => $datos['step-esfera'],
                'rango-alto-cilindro' => $datos['rango-alto-cilindro'],
                'rango-bajo-cilindro' => $datos['rango-bajo-cilindro'],
                'step-cilindro' => $datos['step-cilindro'],
                'rango-alto-eje' => $datos['rango-alto-eje'],
                'rango-bajo-eje' => $datos['rango-bajo-eje'],
                'step-eje' => $datos['step-eje'],
            ),
            'page_template' => NULL
        );

        $id = wp_insert_post( $post_data );
    }

    echo $id;

    wp_die();
}