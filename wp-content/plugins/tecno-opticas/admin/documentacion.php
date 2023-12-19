<?php
/**
 * Created by PhpStorm.
 * User: DESAR01
 * Date: 13/09/2021
 * Time: 3:21 PM
 */
if (! current_user_can ('manage_options')) wp_die (__('No tienes suficientes permisos para acceder a esta página.', 'tecno-opticas'));
?>
    <div class="wrap">
        <p><img src="<?php echo get_site_url(); ?>/wp-content/plugins/tecnoseguridad/images/ts_logo.png" alt="Tecno-Soluciones" title="Tecno-Soluciones"></p>
        <h2><?php _e( 'Tecno Ópticas', 'tecno-opticas' ) ?></h2>
        <p><?php _e( 'Bienvenido a la Documentación del Módulo de Tecno Ópticas', 'tecno-opticas' ) ?></p>
        <p>
        <?php _e( 'Este módulo permite configurar dentro de su comercio electrónico productos tipo monturas formuladas, lentes y lentes de contacto cada uno con su rango de fórmula.', 'tecno-opticas' ) ?>
        <?php _e( 'Adicional a eso le permite establecer rangos de fórmulas para definir precios en los productos tipo lentes. Usted podrá configurar las características de los lentes y agregar tinturas o
            colores para los cristales.', 'tecno-opticas' ) ?>
        </p>
    </div>
<?php

?>