<?php

/**
 * The template created for displaying single product import export
 *
 * @version 1.0.0
 * @since   4.0.4
 */
add_filter( 'et/customizer/add/sections', function ( $sections ) {
	
	$args = array(
		'single_product_import_export_section' => array(
			'name'        => 'single_product_import_export_section',
			'title'       => esc_html__( 'Import/Export', 'xstore-core' ),
			'description' => '',
			'panel'       => 'single_product_builder',
			'icon'        => 'dashicons-upload',
			'type'        => 'kirki-lazy',
			'dependency'  => array()
		)
	);
	
	return array_merge( $sections, $args );
} );


add_filter( 'et/customizer/add/fields/single_product_import_export_section', function ( $fields ) use ( $separators ) {
	$args = array();
	// Array of fields
	$args = array(
		// content separator
//		'single_product_import_export_separator'	=> array(
//			'name'		  => 'single_product_import_export_separator',
//			'type'        => 'custom',
//			'settings'    => 'single_product_import_export_separator',
//			'section'     => 'single_product_import_export_section',
//			'default'     => '<div style="display: flex;justify-content: center;align-items: center;padding: 14px 15px;margin: 0 -15px;text-align: center;font-size: 14px;line-height: 1;text-transform: uppercase;letter-spacing: 1px;background-color: var(--customizer-white-color, #fff);color: var(--customizer-dark-color, #222);border-top: 1px solid var(--customizer-border-color, #e1e1e1);border-bottom: 1px solid var(--customizer-border-color, #e1e1e1);"><span class="dashicons dashicons-schedule"></span> <span style="padding-inline-start: 5px;">' . esc_html__( 'Import\Export', 'xstore-core' ) . '</span></div>',
//			'priority'    => 10,
//		),
		// Import/Export
		'single_product_import' => array(
			'name'     => 'single_product_import',
			'type'     => 'custom',
			'settings' => 'single_product_import',
			'section'  => 'single_product_import_export_section',
			'label'    => '',
			'default'  => '
			</label>
			<div class="et_header-import-export">
                <div class="et_header-export">
                <span class="customize-control-title-ghost">' . esc_html__( 'Export', 'xstore-core' ) .
                    '<span class="tooltip-wrapper">'.
                    '<span class="tooltip-trigger" data-setting="header_import_export"><span class="dashicons dashicons-editor-help"></span></span>'.
                    '<span class="tooltip-content" data-setting="header_import_export">'.esc_html__( 'When you click the button below, a JSON file will be created for you to save to your computer. This file format will contain your single product layout and elements.', 'xstore-core' ) .
                    '<br>'.esc_html__( 'Once you have saved the downloaded file, you can use the Import function in another XStore installation to import the single product layout from this site.', 'xstore-core' ).'</span></span>'.
                    '</span>'.
                '</span>
                <span style="text-align: end;"><span class="button et_header-export-btn" data-file="single-product">' . esc_html__( 'Export File', 'xstore-core' ) . '</span></span>
                <a id="et_download-export-file" style="display:none"></a>
                </div>
			</div>
			',
			'priority' => 10,
		),

        // Import/Export
        'single_product_export' => array(
            'name'     => 'single_product_export',
            'type'     => 'custom',
            'settings' => 'single_product_export',
            'section'  => 'single_product_import_export_section',
            'label'    => '',
            'default'  => '
			</label>
			<div class="et_header-import-export">
                <div class="et_header-import">
                    <span class="customize-control-title">' . esc_html__( 'Import', 'xstore-core' ) . '</span>
                    <div class="et_file-zone" style="text-align: end;">
                    <input type="file" id="et_import-product-file" accept=".json">
                    </div>
                    <span class="et_header-import-btn hidden"><br/><span class="button et_single-product-import-btn">' . esc_html__( 'Import', 'xstore-core' ) . '</span></span>
                    <span class="et_import-error hidden" data-type="filetype">' . esc_html__( 'Wrong filetype', 'xstore-core' ) . '</span>
                    <span class="et_import-error hidden" data-type="filedata">' . esc_html__( 'Wrong filedata', 'xstore-core' ) . '</span>
                </div>
			</div>
			',
            'priority' => 10,
        ),
	);
	
	return array_merge( $fields, $args );
} );