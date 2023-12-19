<?php
/**
 * Created by PhpStorm.
 * User: DESAR01
 * Date: 13/09/2021
 * Time: 3:19 PM
 */

function menu_tecno_opticas() {
    global $menu, $submenu;

    if(TECNO_OPTICAS_LICENSE['licencia'] == "no_active"){
        add_menu_page(TECNO_OPTICAS_NOMBRE,TECNO_OPTICAS_NOMBRE,'manage_options',TECNO_OPTICAS_RUTA . '/admin/licencia.php');
    }
    else{
        add_menu_page(TECNO_OPTICAS_NOMBRE,TECNO_OPTICAS_NOMBRE,'manage_options',TECNO_OPTICAS_RUTA . '/admin/ajustes_modulo.php');
        add_submenu_page(TECNO_OPTICAS_RUTA . '/admin/ajustes_modulo.php', __('Documentación', 'tecno-opticas'), __('Documentación', 'tecno-opticas'), 'manage_options', TECNO_OPTICAS_RUTA . '/admin/documentacion.php',"","1");
        add_submenu_page(TECNO_OPTICAS_RUTA . '/admin/ajustes_modulo.php', __('Fórmulas', 'tecno-opticas'), __('Fórmulas', 'tecno-opticas'), 'manage_options', TECNO_OPTICAS_RUTA . '/admin/formulas.php',"","2");
        add_submenu_page(TECNO_OPTICAS_RUTA . '/admin/ajustes_modulo.php', __('Fórmulas para lentes de contacto', 'tecno-opticas'), __('Lentes de contacto', 'tecno-opticas'), 'manage_options', TECNO_OPTICAS_RUTA . '/admin/formulas_lentes_contacto.php',"","3");
        add_submenu_page(TECNO_OPTICAS_RUTA . '/admin/ajustes_modulo.php', __('Filtros', 'tecno-opticas'), __('Filtros', 'tecno-opticas'), 'manage_options','edit.php?post_type=filtros',"","4");
        add_submenu_page(TECNO_OPTICAS_RUTA . '/admin/ajustes_modulo.php', __('Añadir Filtros', 'tecno-opticas'), __('Añadir Filtros', 'tecno-opticas' ), 'manage_options', 'post-new.php?post_type=filtros',"","5");
        add_submenu_page(TECNO_OPTICAS_RUTA . '/admin/ajustes_modulo.php', __('Opciones de Filtros', 'tecno-opticas'), __('Opciones de Filtros', 'tecno-opticas'), 'manage_options','/edit-tags.php?taxonomy=opciones_filtro&post_type=filtros',"","6");
        add_submenu_page(TECNO_OPTICAS_RUTA . '/admin/ajustes_modulo.php', __('Ajustes', 'tecno-opticas'), __('Ajustes', 'tecno-opticas'), 'manage_options', TECNO_OPTICAS_RUTA . '/admin/ajustes_modulo.php',"","7");
        add_submenu_page(TECNO_OPTICAS_RUTA . '/admin/ajustes_modulo.php', __('Descripción Tipos de Visión', 'tecno-opticas'), __('Descripción Tipos de Visión', 'tecno-opticas'), 'manage_options', TECNO_OPTICAS_RUTA . '/admin/descripcion_tipos.php',"","8");
        add_submenu_page(TECNO_OPTICAS_RUTA . '/admin/ajustes_modulo.php', __('Mensajes', 'tecno-opticas'), __('Mensajes', 'tecno-opticas'), 'manage_options', TECNO_OPTICAS_RUTA . '/admin/ajustes.php',"","9");
        add_submenu_page(TECNO_OPTICAS_RUTA . '/admin/ajustes_modulo.php', __('Configuración de WhatsApp', 'tecno-opticas'), __('Configuración de WhatsApp', 'tecno-opticas'),'manage_options', TECNO_OPTICAS_RUTA . '/admin/ajustes_whatsapp.php',"","10");
    }
}

if($control != 0){
    add_action( 'admin_menu', 'menu_tecno_opticas' );
}
