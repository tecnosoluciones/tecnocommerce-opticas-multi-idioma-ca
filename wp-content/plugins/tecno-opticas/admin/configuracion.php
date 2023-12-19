<?php
/**
 * Created by PhpStorm.
 * User: DESAR01
 * Date: 13/09/2021
 * Time: 3:20 PM
 */

if (! current_user_can ('manage_options')) wp_die (__('No tienes suficientes permisos para acceder a esta página.', 'tecno-opticas'));
?>
    <div class="wrap">
    <p><img src="<?php echo get_site_url(); ?>/wp-content/plugins/tecnoseguridad/images/ts_logo.png" alt="Tecno-Soluciones" title="Tecno-Soluciones"></p>
    <h2><?php _e( 'Tecno Opticas', 'tecno-opticas' ) ?></h2>
    <p><?php _e( 'Bienvenido a la Documentación de Tecno-Seguridad', 'tecno-opticas' ) ?></p>
    <p><?php _e( 'El plugin de forma automatica integra en la <strong>Página de mi cuenta</strong> de Woocommerce un tab llamado <strong>Autenticación en dos factores</strong>', 'tecno-opticas' ) ?></p>
    <p><?php _e( 'Usted, haciendo uso del hook <strong>[two_factor_ts]</strong> podrá integrar en cualquier otra página el proceso de configuración y activación de la autenticación en dos factores.', 'tecno-opticas' ) ?></p>
</div>
<?php

?>