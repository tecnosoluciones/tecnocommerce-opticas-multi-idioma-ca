<?php
/**
 * Preload section template.
 *
 * @since 3.0
 *
 * @param array {
 *     Section arguments.
 *
 *     @type string $id    Page section identifier.
 *     @type string $title Page section title.
 * }
 */

defined( 'ABSPATH' ) || exit;

?>

<div id="<?php echo esc_attr( $data['id'] ); ?>" class="wpr-Page">
	<div class="wpr-sectionHeader">
		<h2 class="wpr-title1 wpr-icon-refresh"><?php echo esc_html( $data['title'] ); ?></h2>
	</div>
	<?php $this->render_settings_sections( $data['id'] ); ?>
</div>
