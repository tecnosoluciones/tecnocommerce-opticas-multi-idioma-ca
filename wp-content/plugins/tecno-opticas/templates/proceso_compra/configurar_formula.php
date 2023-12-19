<?php
/**
 * Created by PhpStorm.
 * User: DESAR01
 * Date: 30/09/2021
 * Time: 10:01 AM
 */

$bienvenida = stripslashes(pll__(get_option("tecnooptica-setup_mensaje_0")));
$bienvenida_mensaje = stripslashes(pll__(get_option("tecnooptica-setup_mensaje_0_1")));

$user_id = get_current_user_id();

$contendor_plantilla = "";

if($user_id != 0){
    $plantilla_guardada = get_user_meta($user_id, 'plantilla', true);
    if(!empty($plantilla_guardada)) {
        $optiones_plantilla = "";
        foreach ($plantilla_guardada AS $key => $value) {

            if($value['tipo_vision'] == "vision_sencilla"){
                if(get_option('tecnooptica-setupexclude_form_vs') == "yes"){
                    $optiones_plantilla .= '<option value="' . $key . '">' . $key . '</option>';
                }
            }
            else if($value['tipo_vision'] == "descanso"){
                if(get_option('tecnooptica-setupexclude_form_descanso') == "yes"){
                    $optiones_plantilla .= '<option value="' . $key . '">' . $key . '</option>';
                }
            }
            else if($value['tipo_vision'] == "bifocales"){
                if(get_option('tecnooptica-setupexclude_form_bifocales') == "yes"){
                    $optiones_plantilla .= '<option value="' . $key . '">' . $key . '</option>';
                }
            }
            else if($value['tipo_vision'] == "progresivos"){
                if(get_option('tecnooptica-setupexclude_form_progresivo') == "yes"){
                    $optiones_plantilla .= '<option value="' . $key . '">' . $key . '</option>';
                }
            }
            else if($value['tipo_vision'] == "ocupacionales"){
                if(get_option('tecnooptica-setupexclude_form_ocupacionales') == "yes"){
                    $optiones_plantilla .= '<option value="' . $key . '">' . $key . '</option>';
                }
            }
        }

        if(strlen($optiones_plantilla) == 0){
            $contendor_plantilla = "";
        }
        else{
            $contendor_plantilla = '
                <div class="lista_formulas">
                    <label for="" id="plt_form">'.__('Plantilla de Fórmula', 'tecno-opticas').'</label>
                    <select name="selec_form" id="selec_form">
                        <option value="">'.__('Seleccione una fórmula', 'tecno-opticas').'</option>
                        ' . $optiones_plantilla . '
                    </select>
                </div>
            ';
        }

    }
    else{
        $contendor_plantilla = "";
    }
}
else{
    if(isset(WC()->session->get_session_data()['plantilla'])) {
        $plantilla_session = WC()->session->get_session_data()['plantilla'];
        $plantilla_session = unserialize($plantilla_session);
        $optiones_plantilla = "";
        foreach ($plantilla_session AS $key => $value) {
            if($value['tipo_vision'] == "vision_sencilla"){
                if(get_option('tecnooptica-setupexclude_form_vs') == "yes"){
                    $optiones_plantilla .= '<option value="' . $key . '">' . $key . '</option>';
                }
            }
            else if($value['tipo_vision'] == "descanso"){
                if(get_option('tecnooptica-setupexclude_form_descanso') == "yes"){
                    $optiones_plantilla .= '<option value="' . $key . '">' . $key . '</option>';
                }
            }
            else if($value['tipo_vision'] == "bifocales"){
                if(get_option('tecnooptica-setupexclude_form_bifocales') == "yes"){
                    $optiones_plantilla .= '<option value="' . $key . '">' . $key . '</option>';
                }
            }
            else if($value['tipo_vision'] == "progresivos"){
                if(get_option('tecnooptica-setupexclude_form_progresivo') == "yes"){
                    $optiones_plantilla .= '<option value="' . $key . '">' . $key . '</option>';
                }
            }
            else if($value['tipo_vision'] == "ocupacionales"){
                if(get_option('tecnooptica-setupexclude_form_ocupacionales') == "yes"){
                    $optiones_plantilla .= '<option value="' . $key . '">' . $key . '</option>';
                }
            }
        }

        if(strlen($optiones_plantilla) == 0){
            $contendor_plantilla = "";
        }
        else {
            $contendor_plantilla = '
                <div class="lista_formulas">
                    <label for="" id="plt_form">'.__('Plantilla de Fórmula', 'tecno-opticas').'</label>
                    <select name="selec_form" id="selec_form">
                        <option value="">'.__('Seleccione una fórmula', 'tecno-opticas').'</option>
                        ' . $optiones_plantilla . '
                    </select>
                </div>
            ';
        }
    }
    else{
        $contendor_plantilla = "";
    }
}

?>
<!doctype html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>

        <?php wp_body_open(); ?>

        <div id="proceso_compra" class="hfeed site">
            <form class="cart" action="" method="post" enctype="multipart/form-data">
                <input id="sku_montura" name="sku_montura" type="hidden" value="<?php echo $datos['SKU'];?>">
                <input id="llave_montura" name="llave_montura" type="hidden" value="<?php echo $datos['llave'];?>">
                <input id="id_product" name="id_product" value="" type="hidden">
                <input id="lente_caracteristica" name="caracteristica" value="" type="hidden">
                <input id="prices" name="prices" value="" type="hidden">
                <input id="tipo_vision" name="tipo_vision" value="" type="hidden">
                <button type="submit" name="add-to-cart" id="procesar_lente" value="" class="single_add_to_cart_button button alt" style="display: none;"><?php _e('Añadir al carrito', 'tecno-opticas'); ?></button>
                <div id="content" class="site-content" tabindex="-1">
                    <div class="col-full">

                        <div class="title_process_shop">
                            <h1><?php _e('CONFIGURACIÓN DE GAFAS CON LENTES FORMULADOS', 'tecno-opticas'); ?></h1>
                        </div>

                        <div class="container">

                            <div class="row">

                                <div class="col col-sm-12 col-lg-8 alert tecno-optica-info">
                                    <div class="welcome-proceso">
                                        <?php echo $bienvenida; ?>
                                    </div>
                                </div>

                                <div class="col col-sm-12 col-lg-4 align-self-center">
                                    <div class="row justify-content-center">
                                        <div class="col col-sm-12 col-lg-8">
                                            <img src="<?php echo $datos['img'];?>" class="img-fluid" alt="<?php echo $datos['nombre_m'];?>">
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col col-sm-12 col-lg-8">
                                            <h2 class="h2" id="nombre_montura" data-precio="<?php echo $datos['precio_montura']; ?>" data-precio-no-html="<?php echo $datos['precio_montura_nohtml']; ?>">
                                                <?php echo $datos['nombre_m'];?>
                                                <span id="referencia">
                                                    (REF: <?php echo $datos['SKU'];?>)
                                                </span>
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion" id="procesocompra">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#paso_one" aria-expanded="true" aria-controls="paso_one">
                                            <?php echo $datos['lable_paso_one']; ?>
                                        </button>
                                    </h2>
                                    <div id="paso_one" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#procesocompra">
                                        <div class="accordion-body">
                                            <?php echo $datos['descripcion_paso_one']; ?>

                                            <?php echo $contendor_plantilla; ?>

                                            <div class="row justify-content-evenly" id="primer_btn_form">
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <a class="cont_proceso" role="button" id="confirmar_plantilla"><?php _e('Continuar', 'tecno-opticas'); ?></a>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <a class="cancel_proceso" role="button" data-key="<?php echo $datos['llave'];?>" ><?php _e('Cancelar', 'tecno-opticas'); ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="paso_two_boton">
                                        <button class="accordion-button collapsed" disabled="disabled" type="button" data-bs-toggle="collapse" data-bs-target="#paso_two" aria-expanded="false" aria-controls="paso_two">
                                            <?php echo $datos['lable_paso_two']; ?>
                                        </button>
                                    </h2>
                                    <div id="paso_two" class="accordion-collapse collapse" aria-labelledby="paso_two" data-bs-parent="#procesocompra">
                                        <div class="accordion-body">
                                            <?php echo $datos['descripcion_paso_two']; ?>

                                            <div class="tip_vision">
                                                <div class="contenedor_tip_vision">
                                                    <?php echo $datos['opciones_tipo_vision']; ?>
                                                </div>
                                            </div>

                                            <div class="mostrar_descripcion_vision" style="display: none;">
                                                <div class="descanso" style="display: none;">
                                                   <p><?php echo $datos['descripcion_descanso']; ?></p>
                                                </div>
                                                <div class="vision_sencilla" style="display: none;">
                                                    <p><?php echo $datos['descripcion_vision_sencilla']; ?></p>
                                                </div>
                                                <div class="progresivos" style="display: none;">
                                                    <p><?php echo $datos['descripcion_progresivos']; ?></p>
                                                </div>
                                                <div class="bifocales" style="display: none;">
                                                    <p><?php echo $datos['descripcion_bifocales']; ?></p>
                                                </div>
                                            </div>

                                            <div id="imprimir_form" style="display: none;"></div>

                                            <div class="row justify-content-evenly form_continuar" id="botones_formulproce" style="display: none;">
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <a class="cont_proceso" role="button" id="confirmar_formula"><?php _e('Continuar', 'tecno-opticas'); ?></a>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <a class="cancel_proceso" role="button" data-key="<?php echo $datos['llave'];?>" ><?php _e('Cancelar', 'tecno-opticas'); ?></a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="paso_three_boton">
                                        <button class="accordion-button collapsed" disabled="disabled" type="button" data-bs-toggle="collapse" data-bs-target="#paso_three" aria-expanded="false" aria-controls="paso_three">
                                            <?php echo $datos['lable_paso_three']; ?>
                                        </button>
                                    </h2>
                                    <div id="paso_three" class="accordion-collapse collapse" aria-labelledby="paso_three_boton" data-bs-parent="#procesocompra">
                                        <div class="accordion-body">
                                            <?php echo $datos['descripcion_paso_three']; ?>
                                            <div class="filtro">
                                                <?php echo $datos['filtros']; ?>
                                            </div>
                                            <div class="descripcion_filtros">
                                                <?php echo $datos['descripcion_filtros']; ?>
                                            </div>

                                            <div class="opciones_filtro">
                                                <?php echo $datos['opciones_filtro']; ?>
                                            </div>

                                            <div class="row justify-content-evenly form_continuar" id="botones_oipcion_filtro" style="display: none;">
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <a class="cont_proceso" role="button" id="confirmar_filtro"><?php _e('Continuar', 'tecno-opticas'); ?></a>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <a class="cancel_proceso" role="button" data-key="<?php echo $datos['llave'];?>" ><?php _e('Cancelar', 'tecno-opticas'); ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="paso_four_boton">
                                        <button class="accordion-button collapsed" disabled="disabled" type="button" data-bs-toggle="collapse" data-bs-target="#paso_four" aria-expanded="false" aria-controls="paso_four">
                                            <?php echo $datos['lable_paso_four']; ?>
                                        </button>
                                    </h2>
                                    <div id="paso_four" class="accordion-collapse collapse" aria-labelledby="paso_four_boton" data-bs-parent="#procesocompra">
                                        <div class="accordion-body">
                                            <?php echo $datos['descripcion_paso_four']; ?>

                                            <div id="imprimir_list_lentes"></div>

                                            <div class="row justify-content-evenly form_continuar" id="botones_lista_lentes" style="display: none;">
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <a class="cont_proceso" role="button" id="confirmar_lente"><?php _e('Continuar', 'tecno-opticas'); ?></a>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <a class="cancel_proceso" role="button" data-key="<?php echo $datos['llave'];?>" >Cancelar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="paso_five_boton">
                                        <button class="accordion-button collapsed" disabled="disabled" type="button" data-bs-toggle="collapse" data-bs-target="#paso_five" aria-expanded="false" aria-controls="paso_five">
                                            <?php echo $datos['lable_paso_five']; ?>
                                        </button>
                                    </h2>
                                    <div id="paso_five" class="accordion-collapse collapse" aria-labelledby="paso_five_boton" data-bs-parent="#procesocompra">
                                        <div class="accordion-body">
                                            <?php echo $datos['descripcion_paso_five']; ?>

                                            <div class="comentario">
                                                <textarea name="comentario_formula" id="comentario_form" cols="30" rows="10"></textarea>
                                            </div>

                                            <div class="row justify-content-evenly form_continuar" id="botones_comentarios" >
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <a class="cont_proceso" role="button" id="confirmar_comentario"><?php _e('Continuar', 'tecno-opticas'); ?></a>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <a class="cancel_proceso" role="button" data-key="<?php echo $datos['llave'];?>" ><?php _e('Cancelar', 'tecno-opticas'); ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="paso_six_boton">
                                        <button class="accordion-button collapsed" disabled="disabled" type="button" data-bs-toggle="collapse" data-bs-target="#paso_six" aria-expanded="false" aria-controls="paso_six">
                                            <?php echo $datos['lable_paso_six']; ?>
                                        </button>
                                    </h2>
                                    <div id="paso_six" class="accordion-collapse collapse" aria-labelledby="paso_six_boton" data-bs-parent="#procesocompra">
                                        <div class="accordion-body">
                                            <?php echo $datos['descripcion_paso_six']; ?>

                                            <div id="camp_formula_nombre">
                                                <input type="text" name="formu_name" class="dueno_form" id="dueno_form" value="">
                                            </div>

                                            <div class="row justify-content-evenly form_continuar" id="botones_plantilla">
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <a class="cont_proceso" role="button" id="confirmar_plantilla_nomre"><?php _e('Continuar', 'tecno-opticas'); ?></a>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <a class="cancel_proceso" role="button" data-key="<?php echo $datos['llave'];?>" ><?php _e('Cancelar', 'tecno-opticas'); ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="paso_seven_boton">
                                        <button class="accordion-button collapsed" disabled="disabled" type="button" data-bs-toggle="collapse" data-bs-target="#paso_seven" aria-expanded="false" aria-controls="paso_seven">
                                            <?php echo $datos['lable_paso_seven']; ?>
                                        </button>
                                    </h2>
                                    <div id="paso_seven" class="accordion-collapse collapse" aria-labelledby="paso_seven_boton" data-bs-parent="#procesocompra">
                                        <div class="accordion-body">
                                            <?php echo $datos['descripcion_paso_seven']; ?>

                                            <div class="pre_view">


                                            </div>

                                            <div class="row justify-content-evenly form_continuar" id="botones_procesar_compra">
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <a class="cont_proceso" role="button" id="completado"><?php _e('Continuar', 'tecno-opticas'); ?></a>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <a class="cancel_proceso" role="button" data-key="<?php echo $datos['llave'];?>" ><?php _e('Cancelar', 'tecno-opticas'); ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

        </form>
        </div>
        <?php wp_footer(); ?>
    </body>
</html>