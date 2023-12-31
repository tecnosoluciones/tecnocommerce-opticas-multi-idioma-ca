<?php
/**
 * The template created for displaying header promo text options
 *
 * @version 1.0.1
 * @since   1.4.0
 * last changes in 1.5.4
 */
add_filter( 'et/customizer/add/sections', function ( $sections ) {
	
	$args = array(
		'promo_text' => array(
			'name'       => 'promo_text',
			'title'      => esc_html__( 'Promo text', 'xstore-core' ),
            'description' => esc_html__('Our Promo Text feature in Header Builder is the perfect tool to add some extra flair to your website. Whether you\'re announcing a sale, a new product, or simply welcoming your visitors, make sure your message stands out with our customizable option.', 'xstore-core'),
			'panel'      => 'header-builder',
			'icon'       => 'dashicons-megaphone',
			'type'       => 'kirki-lazy',
			'dependency' => array()
		)
	);
	
	return array_merge( $sections, $args );
} );

add_filter( 'et/customizer/add/fields/promo_text', function ( $fields ) use ( $separators, $strings, $icons ) {
	$args = array();
	
	// Array of fields
	$args = array(
		// content separator
		'promo_text_content_separator'              => array(
			'name'     => 'promo_text_content_separator',
			'type'     => 'custom',
			'settings' => 'promo_text_content_separator',
			'section'  => 'promo_text',
			'default'  => $separators['content'],
			'priority' => 1,
		),
		
		// promo_text_autoplay
		'promo_text_autoplay_et-desktop'            => array(
			'name'     => 'promo_text_autoplay_et-desktop',
			'type'     => 'toggle',
			'settings' => 'promo_text_autoplay_et-desktop',
			'label'    => esc_html__( 'Autoplay', 'xstore-core' ),
            'tooltip'  => esc_html__('The animation will start automatically when the page is loaded.', 'xstore-core'),
			'section'  => 'promo_text',
			'default'  => 0,
		),
		
		// promo_text_speed
		'promo_text_speed_et-desktop'               => array(
			'name'     => 'promo_text_speed_et-desktop',
			'type'     => 'slider',
			'settings' => 'promo_text_speed_et-desktop',
			'label'    => esc_html__( 'Speed', 'xstore-core' ),
            'tooltip'  => esc_html__('The speed of element animations is measured in milliseconds and will be calculated as follows: X * 100.', 'xstore-core'),
			'section'  => 'promo_text',
			'default'  => 3,
			'choices'  => array(
				'min'  => '1',
				'max'  => '150',
				'step' => '1',
			),
		),
		
		// promo_text_delay
		'promo_text_delay_et-desktop'               => array(
			'name'            => 'promo_text_delay_et-desktop',
			'type'            => 'slider',
			'settings'        => 'promo_text_delay_et-desktop',
			'label'           => esc_html__( 'Delay (s)', 'xstore-core' ),
            'tooltip'  => esc_html__('The delay before the element animations start playing automatically.', 'xstore-core'),
			'section'         => 'promo_text',
			'default'         => 4,
			'choices'         => array(
				'min'  => '0',
				'max'  => '10',
				'step' => '1',
			),
			'active_callback' => array(
				array(
					'setting'  => 'promo_text_autoplay_et-desktop',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),
		
		// promo_text_navigation
		'promo_text_navigation_et-desktop'          => array(
			'name'      => 'promo_text_navigation_et-desktop',
			'type'      => 'toggle',
			'settings'  => 'promo_text_navigation_et-desktop',
			'label'     => esc_html__( 'Navigation', 'xstore-core' ),
            'tooltip'   => esc_html__( 'Enable this option to add arrows to this promotional text element.', 'xstore-core' ),
			'section'   => 'promo_text',
			'default'   => 0,
			'transport' => 'postMessage',
			'js_vars'   => array(
				array(
					'element'  => '.et_promo_text_carousel .swiper-custom-left, .et_promo_text_carousel .swiper-custom-right',
					'function' => 'toggleClass',
					'class'    => 'dt-hide',
					'value'    => false
				),
			),
		),
		
		// promo_text_navigation_static
		'promo_text_navigation_static_et-desktop'   => array(
			'name'            => 'promo_text_navigation_static_et-desktop',
			'type'            => 'toggle',
			'settings'        => 'promo_text_navigation_static_et-desktop',
			'label'           => esc_html__( 'Navigation static', 'xstore-core' ),
            'tooltip'   => esc_html__( 'Enable this option to display arrows permanently. By default, arrows are only displayed when the mouse is hovered over this promotional text element.', 'xstore-core' ),
			'section'         => 'promo_text',
			'default'         => 0,
			'transport'       => 'postMessage',
			'js_vars'         => array(
				array(
					'element'  => '.et_promo_text_carousel',
					'function' => 'toggleClass',
					'class'    => 'arrows-hovered-static',
					'value'    => true
				),
			),
			'active_callback' => array(
				array(
					'setting'  => 'promo_text_navigation_et-desktop',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),
		
		// promo_text_close_button
		'promo_text_close_button_et-desktop'        => array(
			'name'      => 'promo_text_close_button_et-desktop',
			'type'      => 'toggle',
			'settings'  => 'promo_text_close_button_et-desktop',
			'label'     => esc_html__( 'Close button', 'xstore-core' ),
            'tooltip'   => esc_html__( 'Enable this option to add close button to this promotional text element.', 'xstore-core' ),
			'section'   => 'promo_text',
			'default'   => 1,
			'transport' => 'postMessage',
			'js_vars'   => array(
				array(
					'element'  => '.et_promo_text_carousel .et-close',
					'function' => 'toggleClass',
					'class'    => 'dt-hide',
					'value'    => false
				),
			),
		),
		
		// promo_text_close_button
		'promo_text_close_button_action_et-desktop' => array(
			'name'            => 'promo_text_close_button_action_et-desktop',
			'type'            => 'toggle',
			'settings'        => 'promo_text_close_button_action_et-desktop',
            'label'           => esc_html__( 'Close forever', 'xstore-core' ),
            'tooltip'     => esc_html__( 'If you want to hide the promotional text element after the close button has been clicked once, enable this option. Note: the promotional text element will not be shown for one day or until the browser cookies are cleared. This will add an additional cookie to the customer\'s browser with the following parameters: name: "et_promo_text_show", purpose: "Keep closed forever value of promo text element in header", expiry: "1 day by default".', 'xstore-core' ) . '<br/>' .
                esc_html__('Note: Please remember to include this in the security policy (GDPR).', 'xstore-core'),
			'section'         => 'promo_text',
			'default'         => 0,
			'active_callback' => array(
				array(
					'setting'  => 'promo_text_close_button_et-desktop',
					'operator' => '==',
					'value'    => 1,
				),
			),
			// 'transport' => 'postMessage',
			// 'js_vars'     => array(
			// 	array(
			// 		'element'  => '.et_promo_text_carousel .et-close',
			// 		'function' => 'toggleClass',
			// 		'class' => 'close-forever',
			// 		'value' => true
			// 	),
			// ),
		),
		
		'promo_text_style_separator'              => array(
			'name'     => 'promo_text_style_separator',
			'type'     => 'custom',
			'settings' => 'promo_text_style_separator',
			'section'  => 'promo_text',
			'default'  => $separators['style'],
			'priority' => 10,
		),
		
		// promo_text_height
		'promo_text_height_et-desktop'            => array(
			'name'      => 'promo_text_height_et-desktop',
			'type'      => 'slider',
			'settings'  => 'promo_text_height_et-desktop',
			'label'     => esc_html__( 'Height (px)', 'xstore-core' ),
            'tooltip' => esc_html__( 'This controls the height of the promotional text element.', 'xstore-core' ),
			'section'   => 'promo_text',
			'default'   => 30,
			'choices'   => array(
				'min'  => '30',
				'max'  => '100',
				'step' => '1',
			),
			'transport' => 'auto',
			'output'    => array(
				array(
					'context'  => array( 'editor', 'front' ),
					'element'  => '.et_promo_text_carousel',
					'property' => '--promo-text-height',
					'units'    => 'px'
				),
			)
		),
		
		// promo_text_background_custom
		'promo_text_background_custom_et-desktop' => array(
			'name'      => 'promo_text_background_custom_et-desktop',
			'type'      => 'color',
			'settings'  => 'promo_text_background_custom_et-desktop',
			'label'     => esc_html__( 'Background color', 'xstore-core' ),
            'tooltip' => $strings['description']['bg_color'],
            'section'   => 'promo_text',
			'default'   => '#000000',
			'choices'   => array(
				'alpha' => true
			),
			'transport' => 'auto',
			'output'    => array(
				array(
					'context'  => array( 'editor', 'front' ),
					'element'  => '.et_promo_text_carousel',
					'property' => 'background-color'
				),
			),
		),
		
		// promo_text_color
		'promo_text_color_et-desktop'             => array(
			'name'        => 'promo_text_color_et-desktop',
			'settings'    => 'promo_text_color_et-desktop',
			'label'       => $strings['label']['wcag_color'],
			'tooltip' => $strings['description']['wcag_color'],
			'type'        => 'kirki-wcag-tc',
			'section'     => 'promo_text',
			'default'     => '#ffffff',
			'choices'     => array(
				'setting' => 'setting(promo_text)(promo_text_background_custom_et-desktop)',
				// 'maxHueDiff'          => 60,   // Optional.
				// 'stepHue'             => 15,   // Optional.
				// 'maxSaturation'       => 0.5,  // Optional.
				// 'stepSaturation'      => 0.1,  // Optional.
				// 'stepLightness'       => 0.05, // Optional.
				// 'precissionThreshold' => 6,    // Optional.
				// 'contrastThreshold'   => 4.5   // Optional.
				'show'    => array(
					// 'auto'        => false,
					// 'custom'      => false,
					'recommended' => false,
				),
			),
			'transport'   => 'auto',
			'output'      => array(
				array(
					'context'  => array( 'editor', 'front' ),
					'element'  => '.et_promo_text_carousel',
					'property' => 'color'
				)
			),
		),
	
	
	);
	
	return array_merge( $fields, $args );
	
} );

add_filter( 'et/customizer/add/fields', function ( $fields ) use ( $separators, $strings, $icons ) {
	$args = array();
	
	// Array of fields
	$args = array(
		
		// promo_text_package
		'promo_text_package' => array(
			'name'         => 'promo_text_package',
			'type'         => 'repeater',
			'label'        => esc_html__( 'Sections', 'xstore-core' ),
            'tooltip'      => esc_html__('With this option, you can easily add, delete, and customize each element to fit your specific needs, including the text, icon, icon position, link text, and URL.', 'xstore-core'),
			'section'      => 'promo_text',
			'dynamic'      => false,
			'priority'     => 2,
			'row_label'    => array(
				'type'  => 'field',
				'value' => esc_html__( 'Section', 'xstore-core' ),
				'field' => 'text',
			),
			'button_label' => esc_html__( 'Add new item', 'xstore-core' ),
			'settings'     => 'promo_text_package',
			'default'      => array(
				array(
					'text'          => esc_html__( 'Take 30% off when you spend $120', 'xstore-core' ),
					'icon'          => 'et_icon-delivery',
					'icon_position' => 'before',
					'link_title'    => esc_html__( 'Go shop', 'xstore-core' ),
					'link'          => '#'
				),
				array(
					'text'          => esc_html__( 'Free 2-days standard shipping on orders $255+', 'xstore-core' ),
					'icon'          => 'et_icon-coupon',
					'icon_position' => 'before',
					'link_title'    => $strings['label']['custom_link'],
					'link'          => '#'
				),
			),
			'fields'       => array(
				'text'          => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Custom text', 'xstore-core' ),
					'tooltip' => esc_html__( 'This will be the label for your link', 'xstore-core' ),
					'default'     => 'Take 30% off when you spend $120 or more with code xstore-core_Space',
				),
				'icon'          => array(
					'type'        => 'select',
					'label'       => $strings['label']['icon'],
					'tooltip' => esc_html__( 'With this option, you can select an available icon for your element or deactivate it.', 'xstore-core' ) . '<br/>' .
                        $strings['description']['icons_style'],
					'default'     => 'et_icon-coupon',
					'choices'     => $icons['simple'],
				),
				'icon_position' => array(
					'type'    => 'select',
					'label'   => esc_html__( 'Icon position', 'xstore-core' ),
                    'description' => esc_html__( 'Choose the position for element icon.', 'xstore-core' ),
					'default' => 'before',
					'choices' => array(
						'before' => esc_html__( 'Before', 'xstore-core' ),
						'after'  => esc_html__( 'After', 'xstore-core' )
					)
				),
				'link_title'    => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Link text', 'xstore-core' ),
					'description' => esc_html__( 'This will be the label for your link', 'xstore-core' ),
					'default'     => 'Read more',
				),
				'link'          => array(
					'type'    => 'link',
					'label'   => esc_html__( 'Link', 'xstore-core' ),
					'description' => $strings['description']['custom_link'],
					'default' => '#'
				),
			)
		),
	
	);
	
	return array_merge( $fields, $args );
	
} );
