<?php
/**
 * Created by PhpStorm.
 * User: DESAR01
 * Date: 11/10/2021
 * Time: 7:53 PM
 */

add_filter ( 'woocommerce_account_menu_items', 'visualizar_plantilla', 40 );
add_action( 'init', 'plantilla_add_endpoint' );
add_action( 'woocommerce_account_visualizar_plantilla_endpoint', 'plantilla_my_account_endpoint_content' );

add_action('wp_ajax_nopriv_remover_plantilla','remover_plantilla');
add_action('wp_ajax_remover_plantilla','remover_plantilla');
add_action('wp_ajax_nopriv_consultar_plantilla','consultar_plantilla');
add_action('wp_ajax_consultar_plantilla','consultar_plantilla');
add_action('wp_ajax_nopriv_consultar_tipo_vision_plantilla','consultar_tipo_vision_plantilla');
add_action('wp_ajax_consultar_tipo_vision_plantilla','consultar_tipo_vision_plantilla');
add_action('wp_ajax_nopriv_actualizar_plantilla','actualizar_plantilla');
add_action('wp_ajax_actualizar_plantilla','actualizar_plantilla');
add_action('wp_ajax_nopriv_nueva_plantilla','nueva_plantilla');
add_action('wp_ajax_nueva_plantilla','nueva_plantilla');


function visualizar_plantilla( $menu_links ){
    $menu_links = array_slice( $menu_links, 0, 5, true )
        + array( 'visualizar_plantilla' => __('Plantillas de fórmulas', 'tecno-opticas') )
        + array_slice( $menu_links, 5, NULL, true );

    return $menu_links;
}

function plantilla_add_endpoint() {
    add_rewrite_endpoint( 'visualizar_plantilla', EP_PAGES );
}

function plantilla_my_account_endpoint_content() {

    $user_id = get_current_user_id();
    $tr = "";
    $tabla_formula = "";
    $plantilla_guardada = get_user_meta($user_id, 'plantilla', true);

    foreach ($plantilla_guardada AS $key => $value){
        $nombre_plantilla = $key;

        if($value['tipo_vision'] == "vision_sencilla"){
            if(get_option('tecnooptica-setupexclude_form_vs') == "yes"){
                $tr .= "
                     <tr>
                        <td>".$nombre_plantilla."</td>
                        <td>
                            <a class='editar' data-name='".$nombre_plantilla."' title='".__('Editar plantilla', 'tecno-opticas')."'><i class=\"fa fa-edit\"></i></a>
                            <a class='eliminar' data-name='".$nombre_plantilla."' title='".__('Eliminar plantilla', 'tecno-opticas')."'><i class=\"fa fa-times\"></i></a>
                        </td>
                    </tr>
                ";
            }
        }
        else if($value['tipo_vision'] == "descanso"){
            if(get_option('tecnooptica-setupexclude_form_descanso') == "yes"){
                $tr .= "
                     <tr>
                        <td>".$nombre_plantilla."</td>
                        <td>
                            <a class='editar' data-name='".$nombre_plantilla."' title='".__('Editar plantilla', 'tecno-opticas')."'><i class=\"fas fa-edit\"></i></a>
                            <a class='eliminar' data-name='".$nombre_plantilla."' title='".__('Eliminar plantilla', 'tecno-opticas')."'><i class=\"fas fa-times\"></i></a>
                        </td>
                    </tr>
                ";
            }
        }
        else if($value['tipo_vision'] == "bifocales"){
            if(get_option('tecnooptica-setupexclude_form_bifocales') == "yes"){
                $tr .= "
                     <tr>
                        <td>".$nombre_plantilla."</td>
                        <td>
                            <a class='editar' data-name='".$nombre_plantilla."' title='".__('Editar plantilla', 'tecno-opticas')."'><i class=\"fas fa-edit\"></i></a>
                            <a class='eliminar' data-name='".$nombre_plantilla."' title='".__('Eliminar plantilla', 'tecno-opticas')."'><i class=\"fas fa-times\"></i></a>
                        </td>
                    </tr>
                ";
            }
        }
        else if($value['tipo_vision'] == "progresivos"){
            if(get_option('tecnooptica-setupexclude_form_progresivo') == "yes"){
                $tr .= "
                     <tr>
                        <td>".$nombre_plantilla."</td>
                        <td>
                            <a class='editar' data-name='".$nombre_plantilla."' title='".__('Editar plantilla', 'tecno-opticas')."'><i class=\"fas fa-edit\"></i></a>
                            <a class='eliminar' data-name='".$nombre_plantilla."' title='".__('Eliminar plantilla', 'tecno-opticas')."'><i class=\"fas fa-times\"></i></a>
                        </td>
                    </tr>
                ";
            }
        }
        else if($value['tipo_vision'] == "ocupacionales"){
            if(get_option('tecnooptica-setupexclude_form_ocupacionales') == "yes"){
                $tr .= "
                     <tr>
                        <td>".$nombre_plantilla."</td>
                        <td>
                            <a class='editar' data-name='".$nombre_plantilla."' title='".__('Editar plantilla', 'tecno-opticas')."'><i class=\"fas fa-edit\"></i></a>
                            <a class='eliminar' data-name='".$nombre_plantilla."' title='".__('Eliminar plantilla', 'tecno-opticas')."'><i class=\"fas fa-times\"></i></a>
                        </td>
                    </tr>
                ";
            }
        }
    }

    ?>
    <div class="mensaje"></div>
    <div id="conten_nuevo_funct">
        <button id="añadir_nueva_formula">
            <?php _e('Añadir fórmula', 'tecno-opticas'); ?>
        </button>
    </div>
    <div class="wrap_plantillas">
        <table>
            <thead>
                <tr>
                    <th><?php _e('Plantilla', 'tecno-opticas'); ?></th>
                    <th><?php _e('Acciones', 'tecno-opticas'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php echo $tr;?>
            </tbody>
        </table>

        <?php echo $tabla_formula; ?>
    </div>

    <?php

}

function consultar_plantilla(){
    $user_id = get_current_user_id();
    $nombre_plantilla = $_POST['key'];
    $ancho = $_POST['ancho'];
    $plantilla_guardada = get_user_meta($user_id, 'plantilla', true);

    $tipo_plantilla = $plantilla_guardada[$nombre_plantilla]['tipo_vision'];
    $dp = $plantilla_guardada[$nombre_plantilla]['dp'];
    $datos_formula = $plantilla_guardada[$nombre_plantilla]['datos_formula'];

    switch ($tipo_plantilla) {
        case "descanso":
            $selected_ds = "selected";
            $selected_vs = "";
            $selected_bf = "";
            $selected_prog = "";
            $selected_ocup = "";
            break;
        case "vision_sencilla":
            $selected_ds = "";
            $selected_vs = "selected";
            $selected_bf = "";
            $selected_prog = "";
            $selected_ocup = "";
            break;
        case "bifocales":
            $selected_ds = "";
            $selected_bf = "selected";
            $selected_prog = "";
            $selected_ocup = "";
            break;
        case "progresivos":
            $selected_ds = "";
            $selected_bf = "";
            $selected_prog = "selected";
            $selected_ocup = "";
            break;
        case "ocupacionales":
            $selected_ds = "";
            $selected_bf = "";
            $selected_prog = "";
            $selected_ocup = "selected";
            break;
        default:
            $selected = "";
            break;
    }

    $opciones_tipo_vision = "";

    if(get_option('tecnooptica-setupexclude_form_descanso') == "yes"){
        $opciones_tipo_vision .= "
            <option ".$selected_ds." value='descanso'>".__('Descanso', 'tecno-opticas')."</option>
        ";
    }

    if(get_option('tecnooptica-setupexclude_form_vs') == "yes"){
        $opciones_tipo_vision .= "
            <option ".$selected_vs." value='vision_sencilla'>".__('Visión Sencilla', 'tecno-opticas')."</option>
        ";
    }

    if(get_option('tecnooptica-setupexclude_form_bifocales') == "yes"){
        $opciones_tipo_vision .= "
            <option ".$selected_bf." value='bifocales'>".__('Bifocales', 'tecno-opticas')."</option>
        ";
    }

    if(get_option('tecnooptica-setupexclude_form_progresivo') == "yes"){
        $opciones_tipo_vision .= "
            <option ".$selected_prog." value='progresivos'>".__('Progresivos', 'tecno-opticas')."</option>
        ";
    }

    if(get_option('tecnooptica-setupexclude_form_ocupacionales') == "yes"){
        $opciones_tipo_vision .= "
            <option ".$selected_ocup." value='ocupacionales'>".__('Ocupacionales', 'tecno-opticas')."</option>
        ";
    }

    $select = "
        <select id='select_tip_vision'>
            ".$opciones_tipo_vision."
        </select>
    ";
    $arreglo_formulas = crear_form($datos_formula, $tipo_plantilla);

    $th_add = "";
    $td_derecho = "";
    $td_izquierdo = "";
    $add_movil_derecho = "";
    $add_movil_izquierdo = "";

    if(!empty($arreglo_formulas['ojo_derecho']['ADD']) ){
        $th_add = "<th>ADD</th>";
        $td_derecho = "<td>".$arreglo_formulas['ojo_derecho']['ADD']."</td>";
        $td_izquierdo = "<td>".$arreglo_formulas['ojo_izqueirdo']['ADD']."</td>";
        if($ancho < 768){
            $add_movil_derecho = "
                <div class='add'>
                    <label for='add'>".__('ADD Ojo Derecho', 'tecno-opticas')."</label>
                    ".$arreglo_formulas['ojo_derecho']['ADD']."
                </div>
            ";
            $add_movil_izquierdo = "
                <div class='add'>
                    <label for='add'>".__('ADD Ojo Izquierdo', 'tecno-opticas')."</label>
                    ".$arreglo_formulas['ojo_izqueirdo']['ADD']."
                </div>
            ";
        }
    }

    if($ancho < 768){
        $tabla = "
            <div class='form_movil'>
                <div class='tipo_visi'>
                    <label for='nombre_plantilla'>".__('Tipo de Visión', 'tecno-opticas')."</label>
                    " . $select . "
                </div>
                <div class='dp'>
                    <label for='DP'>DP</label>
                    <input type='text' value='" . $dp . "' name='dp' class='dp' placeholder='31/31'>
                </div>
                <div class='formula'>
                    <div class='esfera'>
                        <label for='Esfera'>Esfera Ojo Derecho</label>
                        ".$arreglo_formulas['ojo_derecho']['Esfera']."
                    </div>
                    <div class='cilindro'>
                        <label for='Cilindro'>Cilindro Ojo Derecho</label>
                        ".$arreglo_formulas['ojo_derecho']['Cilindro']."
                    </div>
                    <div class='eje'>
                        <label for='Eje'>Eje Ojo Derecho</label>
                        ".$arreglo_formulas['ojo_derecho']['Eje']."
                    </div>
                    ".$add_movil_derecho."
                    <div class='esfera'>
                        <label for='Esfera'>Esfera Ojo Izquierdo</label>
                        ".$arreglo_formulas['ojo_izqueirdo']['Esfera']."
                    </div>
                    <div class='cilindro'>
                        <label for='Cilindro'>Cilindro Ojo Izquierdo</label>
                        ".$arreglo_formulas['ojo_izqueirdo']['Cilindro']."
                    </div>
                    <div class='eje'>
                        <label for='Eje'>Eje Ojo Izquierdo</label>
                        ".$arreglo_formulas['ojo_izqueirdo']['Eje']."
                    </div>
                    ".$add_movil_izquierdo."
                </div>
            </div>
            <div class='btn_movil'>
                <button class='guardar_plantilla'>".__('Guardar', 'tecno-opticas')."</button>
                <button class='cancelar_plantilla'>".__('Cancelar', 'tecno-opticas')."</button>
            </div>
        ";
    }
    else{
        $tabla = "
            <table>
                <thead>
                    <tr>
                        <th id='tipo_visi'>".__('Tipo de Visión', 'tecno-opticas')."</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>" . $select . "</td>
                    </tr>
                    <tr>
                        <th id='formula'>".__('Fórmula', 'tecno-opticas')."</th>
                    </tr>
                    <tr>
                        <td id='contenedor_formula'>
                            <table id='formulas'>
                                <thead>
                                    <th></th>
                                    <th>".__('Esfera', 'tecno-opticas')."</th>
                                    <th>".__('Cilindro', 'tecno-opticas')."</th>
                                    <th>".__('Eje', 'tecno-opticas')."</th>
                                    ".$th_add."
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>".__('Ojo Der', 'tecno-opticas')."</th>
                                        <td>" . $arreglo_formulas['ojo_derecho']['Esfera'] . "</td>
                                        <td>" . $arreglo_formulas['ojo_derecho']['Cilindro'] . "</td>
                                        <td>" . $arreglo_formulas['ojo_derecho']['Eje'] . "</td>  
                                        ".$td_derecho."  
                                    </tr>
                                    <tr>
                                        <th>".__('Ojo Izq', 'tecno-opticas')."</th>
                                        <td>" . $arreglo_formulas['ojo_izqueirdo']['Esfera'] . "</td>
                                        <td>" . $arreglo_formulas['ojo_izqueirdo']['Cilindro'] . "</td>
                                        <td>" . $arreglo_formulas['ojo_izqueirdo']['Eje'] . "</td>
                                        ".$td_izquierdo."
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th id='dp'>DP</th>
                    </tr>
                    <tr>
                        <td><input type='text' value='" . $dp . "' name='dp' class='dp' placeholder='31/31'></td>
                    </tr>
                    <tr>
                        <td colspan='3'>
                            <button class='guardar_plantilla'>".__('Guardar', 'tecno-opticas')."</button>
                            <button class='cancelar_plantilla'>".__('Cancelar', 'tecno-opticas')."</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        ";
    }


    $tabla_formula = "
        <div data-name='" . $nombre_plantilla . "' class='conten_formula_plantilla'>
            ".$tabla."
        </div>
    ";

    echo $tabla_formula;

    wp_die();
}

function consultar_tipo_vision_plantilla(){
    $tipo_vision = $_POST['tipo_vision'];
    $arreglo_formulas = consultar_form($tipo_vision);
    $ancho = $_POST['ancho'];

    $th_add = "";
    $td_derecho = "";
    $td_izquierdo = "";
    $add_movil_derecho = "";
    $add_movil_izquierdo = "";

    if(!empty($arreglo_formulas['ojo_derecho']['ADD'])){
        $th_add = "<th>ADD</th>";
        $td_derecho = "<td>".$arreglo_formulas['ojo_derecho']['ADD']."</td>";
        $td_izquierdo = "<td>".$arreglo_formulas['ojo_izqueirdo']['ADD']."</td>";
        if($ancho < 768){
            $add_movil_derecho = "
                <div class='add'>
                    <label for='add'>".__('ADD Ojo Derecho', 'tecno-opticas')."</label>
                    ".$arreglo_formulas['ojo_derecho']['ADD']."
                </div>
            ";
            $add_movil_izquierdo = "
                <div class='add'>
                    <label for='add'>".__('ADD Ojo Izquierdo', 'tecno-opticas')."</label>
                    ".$arreglo_formulas['ojo_izqueirdo']['ADD']."
                </div>
            ";
        }
    }
    if($ancho < 768){
        $tabla_formula = "
            <div class='esfera'>
                <label for='Esfera'>".__('Esfera Ojo Derecho', 'tecno-opticas')."</label>
                ".$arreglo_formulas['ojo_derecho']['Esfera']."
            </div>
            <div class='cilindro'>
                <label for='Cilindro'>".__('Cilindro Ojo Derecho', 'tecno-opticas')."</label>
                ".$arreglo_formulas['ojo_derecho']['Cilindro']."
            </div>
            <div class='eje'>
                <label for='Eje'>".__('Eje Ojo Derecho', 'tecno-opticas')."</label>
                ".$arreglo_formulas['ojo_derecho']['Eje']."
            </div>
            ".$add_movil_derecho."
            <div class='esfera'>
                <label for='Esfera'>".__('Esfera Ojo Izquierdo', 'tecno-opticas')."</label>
                ".$arreglo_formulas['ojo_izqueirdo']['Esfera']."
            </div>
            <div class='cilindro'>
                <label for='Cilindro'>".__('Cilindro Ojo Izquierdo', 'tecno-opticas')."</label>
                ".$arreglo_formulas['ojo_izqueirdo']['Cilindro']."
            </div>
            <div class='eje'>
                <label for='Eje'>".__('Eje Ojo Izquierdo', 'tecno-opticas')."</label>
                ".$arreglo_formulas['ojo_izqueirdo']['Eje']."
            </div>
            ".$add_movil_izquierdo."
        ";
    }
    else {

        $tabla_formula = "
            <table id='formulas'>
                <thead>
                    <th></th>
                    <th>".__('Esfera', 'tecno-opticas')."</th>
                    <th>".__('Cilindro', 'tecno-opticas')."</th>
                    <th>".__('Eje', 'tecno-opticas')."</th>
                    " . $th_add . "
                </thead>
                <tbody>
                    <tr>
                        <th>".__('Ojo Der', 'tecno-opticas')."</th>
                        <td>" . $arreglo_formulas['ojo_derecho']['Esfera'] . "</td>
                        <td>" . $arreglo_formulas['ojo_derecho']['Cilindro'] . "</td>
                        <td>" . $arreglo_formulas['ojo_derecho']['Eje'] . "</td>
                        " . $td_derecho . "
                    </tr>
                    <tr>
                        <th>".__('Ojo Izq', 'tecno-opticas')."</th>
                        <td>" . $arreglo_formulas['ojo_izqueirdo']['Esfera'] . "</td>
                        <td>" . $arreglo_formulas['ojo_izqueirdo']['Cilindro'] . "</td>
                        <td>" . $arreglo_formulas['ojo_izqueirdo']['Eje'] . "</td>
                        " . $td_izquierdo . "
                    </tr>
                </tbody>
            </table>
        ";
    }

    echo $tabla_formula;
    wp_die();
}

function consultar_form($tipo_vision){
    $opciones_esfera_der = "";
    $opciones_esfera_izq = "";
    $opciones_cilindro_der = "";
    $opciones_cilindro_izq = "";
    $opciones_eje_der = "";
    $opciones_eje_izq = "";
    $opciones_add_der = "";
    $opciones_add_izq = "";
    $add_der = "";
    $add_izq = "";

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
                $opciones_esfera_der .= '<option value="' . $i . '" selected="selected">' . $i . '</option>';
            }else{
                $opciones_esfera_der .= '<option value="' . $i . '">' . $i . '</option>';
            }


            if ($i == 0) {
                $opciones_esfera_izq .= '<option value="' . $i . '" selected="selected">' . $i . '</option>';
            } else {
                $opciones_esfera_izq .= '<option value="' . $i . '">' . $i . '</option>';
            }
        }

        $esfera_der = '<select name="esfera-ojo-der" id="esfera-ojo-der">' . $opciones_esfera_der . '</select>';
        $esfera_izq = '<select name="esfera-ojo-izq" id="esfera-ojo-izq">' . $opciones_esfera_izq . '</select>';

        $rang_positiv_cilindro = get_post_meta($id_tipo_lente, "rang_positiv_cilindro", true);
        $rang_negativ_cilindro = get_post_meta($id_tipo_lente, "rang_negativ_cilindro", true);
        $rang_step_cilindro = get_post_meta($id_tipo_lente, "rang_step_cilindro", true);

        for ($i = $rang_positiv_cilindro; $i >= $rang_negativ_cilindro; $i = $i - $rang_step_cilindro) {
            if ($i == 0) {
                $opciones_cilindro_der .= '<option value="' . $i . '" selected="selected">' . $i . '</option>';
            }else{
                $opciones_cilindro_der .= '<option value="' . $i . '">' . $i . '</option>';
            }


            if ($i == 0) {
                $opciones_cilindro_izq .= '<option value="' . $i . '" selected="selected">' . $i . '</option>';
            } else {
                $opciones_cilindro_izq .= '<option value="' . $i . '">' . $i . '</option>';
            }
        }

        $cilindro_der = '<select name="cilindro-ojo-der" id="cilindro-ojo-der">' . $opciones_cilindro_der . '</select>';
        $cilindro_izq = '<select name="cilindro-ojo-izq" id="cilindro-ojo-izq">' . $opciones_cilindro_izq . '</select>';

        $rang_alto_eje = get_post_meta($id_tipo_lente, "rang_alto_eje", true);
        $rang_bajo_eje = get_post_meta($id_tipo_lente, "rang_bajo_eje", true);
        $rang_step_eje = get_post_meta($id_tipo_lente, "rang_step_eje", true);
        for ($i = $rang_alto_eje; $i >= $rang_bajo_eje; $i = $i - $rang_step_eje) {
            if ($i == 0) {
                $opciones_eje_der .= '<option value="' . $i . '" selected="selected">' . $i . '</option>';
            }else{
                $opciones_eje_der .= '<option value="' . $i . '">' . $i . '</option>';
            }


            if ($i == 0) {
                $opciones_eje_izq .= '<option value="' . $i . '" selected="selected">' . $i . '</option>';
            } else {
                $opciones_eje_izq .= '<option value="' . $i . '">' . $i . '</option>';
            }
        }

        $eje_der = '<select name="eje-ojo-der" id="eje-ojo-der">' . $opciones_eje_der . '</select>';
        $eje_izq = '<select name="eje-ojo-izq" id="eje-ojo-izq">' . $opciones_eje_izq . '</select>';

        switch ($tipo_vision) {
            case "progresivos":
            case "bifocales":
            case "ocupacionales":
                $rang_positiv_add = get_post_meta($id_tipo_lente, "rang_positiv_add", true);
                $rang_negativ_add = get_post_meta($id_tipo_lente, "rang_negativ_add", true);
                $rang_step_add = get_post_meta($id_tipo_lente, "rang_step_add", true);

                for ($i = $rang_positiv_add; $i >= $rang_negativ_add; $i = $i - $rang_step_add) {
                    if ($i == 0) {
                        $opciones_add_der .= '<option value="' . $i . '" selected="selected">' . $i . '</option>';
                    }else{
                        $opciones_add_der .= '<option value="' . $i . '">' . $i . '</option>';
                    }


                    if ($i == 0) {
                        $opciones_add_izq .= '<option value="' . $i . '" selected="selected">' . $i . '</option>';
                    } else {
                        $opciones_add_izq .= '<option value="' . $i . '">' . $i . '</option>';
                    }
                }
                $add_der = '<select name="add-ojo-der" id="add-ojo-der">' . $opciones_add_der . '</select>';
                $add_izq = '<select name="add-ojo-izq" id="add-ojo-izq">' . $opciones_add_izq . '</select>';
                break;
        }

        $form_impri = [
            'ojo_derecho' => [
                "Esfera" => $esfera_der,
                "Cilindro" => $cilindro_der,
                "Eje" => $eje_der,
                "ADD" => $add_der
            ],
            'ojo_izqueirdo' => [
                "Esfera" => $esfera_izq,
                "Cilindro" => $cilindro_izq,
                "Eje" => $eje_izq,
                "ADD" => $add_izq
            ],
        ];

        return $form_impri;
    }
}

function crear_form($formula, $tipo_vision){
    $opciones_esfera_der = "";
    $opciones_esfera_izq = "";
    $opciones_cilindro_der = "";
    $opciones_cilindro_izq = "";
    $opciones_eje_der = "";
    $opciones_eje_izq = "";
    $opciones_add_der = "";
    $opciones_add_izq = "";
    $add_der = "";
    $add_izq = "";

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

            if ($i == $formula['esfera-ojo-der']) {
                $opciones_esfera_der .= '<option value="' . $i . '" selected="selected">' . $i . '</option>';
            }else{
                $opciones_esfera_der .= '<option value="' . $i . '">' . $i . '</option>';
            }


            if ($i == $formula['esfera-ojo-izq']) {
                $opciones_esfera_izq .= '<option value="' . $i . '" selected="selected">' . $i . '</option>';
            } else {
                $opciones_esfera_izq .= '<option value="' . $i . '">' . $i . '</option>';
            }
        }

        $esfera_der = '<select name="esfera-ojo-der" id="esfera-ojo-der">' . $opciones_esfera_der . '</select>';
        $esfera_izq = '<select name="esfera-ojo-izq" id="esfera-ojo-izq">' . $opciones_esfera_izq . '</select>';

        $rang_positiv_cilindro = get_post_meta($id_tipo_lente, "rang_positiv_cilindro", true);
        $rang_negativ_cilindro = get_post_meta($id_tipo_lente, "rang_negativ_cilindro", true);
        $rang_step_cilindro = get_post_meta($id_tipo_lente, "rang_step_cilindro", true);

        for ($i = $rang_positiv_cilindro; $i >= $rang_negativ_cilindro; $i = $i - $rang_step_cilindro) {
            if ($i == $formula['cilindro-ojo-der']) {
                $opciones_cilindro_der .= '<option value="' . $i . '" selected="selected">' . $i . '</option>';
            }else{
                $opciones_cilindro_der .= '<option value="' . $i . '">' . $i . '</option>';
            }


            if ($i == $formula['cilindro-ojo-izq']) {
                $opciones_cilindro_izq .= '<option value="' . $i . '" selected="selected">' . $i . '</option>';
            } else {
                $opciones_cilindro_izq .= '<option value="' . $i . '">' . $i . '</option>';
            }
        }

        $cilindro_der = '<select name="cilindro-ojo-der" id="cilindro-ojo-der">' . $opciones_cilindro_der . '</select>';
        $cilindro_izq = '<select name="cilindro-ojo-izq" id="cilindro-ojo-izq">' . $opciones_cilindro_izq . '</select>';

        $rang_alto_eje = get_post_meta($id_tipo_lente, "rang_alto_eje", true);
        $rang_bajo_eje = get_post_meta($id_tipo_lente, "rang_bajo_eje", true);
        $rang_step_eje = get_post_meta($id_tipo_lente, "rang_step_eje", true);
        for ($i = $rang_alto_eje; $i >= $rang_bajo_eje; $i = $i - $rang_step_eje) {
            if ($i == $formula['eje-ojo-der']) {
                $opciones_eje_der .= '<option value="' . $i . '" selected="selected">' . $i . '</option>';
            }else{
                $opciones_eje_der .= '<option value="' . $i . '">' . $i . '</option>';
            }


            if ($i == $formula['eje-ojo-izq']) {
                $opciones_eje_izq .= '<option value="' . $i . '" selected="selected">' . $i . '</option>';
            } else {
                $opciones_eje_izq .= '<option value="' . $i . '">' . $i . '</option>';
            }
        }

        $eje_der = '<select name="eje-ojo-der" id="eje-ojo-der">' . $opciones_eje_der . '</select>';
        $eje_izq = '<select name="eje-ojo-izq" id="eje-ojo-izq">' . $opciones_eje_izq . '</select>';

        switch ($tipo_vision) {
            case "progresivos":
            case "bifocales":
                $rang_positiv_add = get_post_meta($id_tipo_lente, "rang_positiv_add", true);
                $rang_negativ_add = get_post_meta($id_tipo_lente, "rang_negativ_add", true);
                $rang_step_add = get_post_meta($id_tipo_lente, "rang_step_add", true);

                for ($i = $rang_positiv_add; $i >= $rang_negativ_add; $i = $i - $rang_step_add) {
                    if ($i == $formula['add-ojo-der']) {
                        $opciones_add_der .= '<option value="' . $i . '" selected="selected">' . $i . '</option>';
                    }else{
                        $opciones_add_der .= '<option value="' . $i . '">' . $i . '</option>';
                    }


                    if ($i == $formula['add-ojo-izq']) {
                        $opciones_add_izq .= '<option value="' . $i . '" selected="selected">' . $i . '</option>';
                    } else {
                        $opciones_add_izq .= '<option value="' . $i . '">' . $i . '</option>';
                    }
                }
                $add_der = '<select name="add-ojo-der" id="add-ojo-der">' . $opciones_add_der . '</select>';
                $add_izq = '<select name="add-ojo-izq" id="add-ojo-izq">' . $opciones_add_izq . '</select>';
                break;
        }

        $form_impri = [
            'ojo_derecho' => [
                "Esfera" => $esfera_der,
                "Cilindro" => $cilindro_der,
                "Eje" => $eje_der,
                "ADD" => $add_der
            ],
            'ojo_izqueirdo' => [
                "Esfera" => $esfera_izq,
                "Cilindro" => $cilindro_izq,
                "Eje" => $eje_izq,
                "ADD" => $add_izq
            ],
        ];

        return $form_impri;
    }
}

function remover_plantilla(){
    $plantilla = $_POST['key'];
    $user_id = get_current_user_id();
    $plantilla_guardada = get_user_meta($user_id, 'plantilla', true);
    unset($plantilla_guardada[$plantilla]);
    echo update_user_meta( $user_id, 'plantilla', $plantilla_guardada );
    wp_die();
}

function actualizar_plantilla(){
    $tipo_vision = $_POST['tipo_vision'];
    $dp = $_POST['dp'];
    $plantilla = $_POST['plantilla'];
    $datos_formula = $_POST['datos_formula'];

    $plantilla_nueva[$plantilla] = [
        "tipo_vision" => $tipo_vision,
        "dp" => $dp,
        "datos_formula" => $datos_formula
    ];



    $user_id = get_current_user_id();
    $plantilla_guardada = get_user_meta($user_id, 'plantilla', true);
    $plantilla_final = $plantilla_nueva;
    if(!empty($plantilla_guardada)){
        $plantilla_final = array_merge($plantilla_guardada,$plantilla_nueva);
    }

    if(empty($plantilla_guardada)){
        $respuesta = add_user_meta($user_id, 'plantilla', $plantilla_final );
    }
    else{
        $respuesta = update_user_meta( $user_id, 'plantilla', $plantilla_final );
    }

    echo $respuesta;
    wp_die();
}

function nueva_plantilla(){

    $ancho = $_POST['ancho'];

    $opciones_tipo_vision = "<option value='' selected>".__('Seleccionar', 'tecno-opticas')."</option>";

    if(get_option('tecnooptica-setupexclude_form_descanso') == "yes"){
        $opciones_tipo_vision .= "
            <option value='descanso'>".__('Descanso', 'tecno-opticas')."</option>
        ";
    }

    if(get_option('tecnooptica-setupexclude_form_vs') == "yes"){
        $opciones_tipo_vision .= "
            <option value='vision_sencilla'>".__('Visión Sencilla', 'tecno-opticas')."</option>
        ";
    }

    if(get_option('tecnooptica-setupexclude_form_bifocales') == "yes"){
        $opciones_tipo_vision .= "
            <option value='bifocales'>".__('Bifocales', 'tecno-opticas')."</option>
        ";
    }

    if(get_option('tecnooptica-setupexclude_form_progresivo') == "yes"){
        $opciones_tipo_vision .= "
            <option value='progresivos'>".__('Progresivos', 'tecno-opticas')."</option>
        ";
    }

    if(get_option('tecnooptica-setupexclude_form_ocupacionales') == "yes"){
        $opciones_tipo_vision .= "
            <option value='ocupacionales'>".__('Ocupacionales', 'tecno-opticas')."</option>
        ";
    }

    $select = "
        <select id='select_tip_vision'>
        ".$opciones_tipo_vision."
        </select>
    ";

    $arreglo_formulas = consultar_form("vision_sencilla");

    if($ancho < 768){
        $tabla_formula_contenedor = "
            <div class='conten_formula_plantilla'>
                <div class='form_movil'>
                    <div class='nombre_plantilla'>
                        <label for='nombre_plantilla'>".__('Nombre de la plantilla', 'tecno-opticas')."</label>
                        <input type='text' value='' name='nombre_plantilla' class='nombre_plantilla' placeholder='Jose'>
                    </div>
                    <div class='tipo_visi'>
                        <label for='tipo_visi'>".__('Tipo de Visión', 'tecno-opticas')."</label>
                        " . $select . "
                    </div>
                    <div class='dp'>
                        <label for='DP'>DP</label>
                        <input type='text' value='' name='dp' class='dp' placeholder='31/31'>
                    </div>
                    <div class='formula'>
                        <div class='esfera'>
                            <label for='Esfera'>".__('Esfera Ojo Derecho', 'tecno-opticas')."</label>
                            ".$arreglo_formulas['ojo_derecho']['Esfera']."
                        </div>
                        <div class='cilindro'>
                            <label for='Cilindro'>".__('Cilindro Ojo Derecho', 'tecno-opticas')."</label>
                            ".$arreglo_formulas['ojo_derecho']['Cilindro']."
                        </div>
                        <div class='eje'>
                            <label for='Eje'>".__('Eje Ojo Derecho', 'tecno-opticas')."</label>
                            ".$arreglo_formulas['ojo_derecho']['Eje']."
                        </div>
                        <div class='esfera'>
                            <label for='Esfera'>".__('Esfera Ojo Izquierdo', 'tecno-opticas')."</label>
                            ".$arreglo_formulas['ojo_izqueirdo']['Esfera']."
                        </div>
                        <div class='cilindro'>
                            <label for='Cilindro'>".__('Cilindro Ojo Izquierdo', 'tecno-opticas')."</label>
                            ".$arreglo_formulas['ojo_izqueirdo']['Cilindro']."
                        </div>
                        <div class='eje'>
                            <label for='Eje'>".__('Eje Ojo Izquierdo', 'tecno-opticas')."</label>
                            ".$arreglo_formulas['ojo_izqueirdo']['Eje']."
                        </div>
                    </div>
                </div>
                <div class='btn_movil'>
                    <button class='agregar_plantilla'>".__('Guardar', 'tecno-opticas')."</button>
                    <button class='cancelar_plantilla'>".__('Cancelar', 'tecno-opticas')."</button>
                </div>
            </div>
        ";
    }
    else {
        $tabla_formula = "
            <table id='formulas'>
                <thead>
                    <th></th>
                    <th>".__('Esfera', 'tecno-opticas')."</th>
                    <th>".__('Cilindro', 'tecno-opticas')."</th>
                    <th>".__('Eje', 'tecno-opticas')."</th>
                </thead>
                <tbody>
                    <tr>
                        <th>".__('Ojo Der', 'tecno-opticas')."</th>
                        <td>" . $arreglo_formulas['ojo_derecho']['Esfera'] . "</td>
                        <td>" . $arreglo_formulas['ojo_derecho']['Cilindro'] . "</td>
                        <td>" . $arreglo_formulas['ojo_derecho']['Eje'] . "</td>
                    </tr>
                    <tr>
                        <th>".__('Ojo Izq', 'tecno-opticas')."</th>
                        <td>" . $arreglo_formulas['ojo_izqueirdo']['Esfera'] . "</td>
                        <td>" . $arreglo_formulas['ojo_izqueirdo']['Cilindro'] . "</td>
                        <td>" . $arreglo_formulas['ojo_izqueirdo']['Eje'] . "</td>
                    </tr>
                </tbody>
            </table>
        ";

        $tabla_formula_contenedor = "
            <div data-name='' class='conten_formula_plantilla'>
                <table>
                    <thead>
                        <tr>
                            <th id='nombre_plantilla'>".__('Nombre de la plantilla', 'tecno-opticas')."</th>
                            <th id='tipo_visi'>".__('Tipo de Visión', 'tecno-opticas')."</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type='text' value='' name='nombre_plantilla' class='nombre_plantilla' placeholder='Jose'></td>
                            <td>" . $select . "</td>
                        </tr>
                        <tr>
                            <th id='formula' colspan='2' align='center'>".__('Fórmula', 'tecno-opticas')."</th>
                        </tr>
                        <tr>
                            <td id='contenedor_formula' colspan='2'>
                                " . $tabla_formula . "
                            </td>
                        </tr>
                        <tr>
                            <th id='dp' colspan='2'>DP</th>
                        </tr>
                        <tr>
                            <td colspan='2'><input type='text' value='' name='dp' class='dp' placeholder='31/31'></td>
                        </tr>
                        <tr>
                            <td colspan='5'>
                                <button class='agregar_plantilla'>".__('Guardar', 'tecno-opticas')."</button>
                                <button class='cancelar_plantilla'>".__('Cancelar', 'tecno-opticas')."</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        ";
    }

    echo $tabla_formula_contenedor;
    wp_die();
}