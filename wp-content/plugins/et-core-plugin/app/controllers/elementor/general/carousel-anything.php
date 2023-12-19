<?php
namespace ETC\App\Controllers\Elementor\General;

use ETC\App\Classes\Elementor;
/**
 * Horizontal Scroll widget.
 *
 * @since      5.1.7
 * @package    ETC
 * @subpackage ETC/Controllers/Elementor/General
 */
class Carousel_Anything extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @since 5.1.7
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'etheme_carousel_anything';
	}
	
	/**
	 * Get widget title.
	 *
	 * @since 5.1.7
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Carousel Anything', 'xstore-core' );
	}
	
	/**
	 * Get widget icon.
	 *
	 * @since 5.1.7
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eight_theme-elementor-icon et-elementor-carousel-anything';
	}
	
	/**
	 * Get widget keywords.
	 *
	 * @since 5.1.7
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'scroll', 'slider', 'sections', 'mouse', 'wheel', 'carousel' ];
	}
	
	/**
	 * Get widget categories.
	 *
	 * @since 5.1.7
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return ['eight_theme_general'];
	}
	
	/**
	 * Get widget dependency.
	 *
	 * @since 5.1.7
	 * @access public
	 *
	 * @return array Widget dependency.
	 */
	public function get_script_depends() {
	    return ['etheme_elementor_slider'];
	}
	
	/**
	 * Help link.
	 *
	 * @since 5.1.7
	 *
	 * @return string
	 */
	public function get_custom_help_url() {
		return etheme_documentation_url('122-elementor-live-copy-option', false);
	}
	
	/**
	 * Register controls.
	 *
	 * @since 5.1.7
	 * @access protected
	 */
	protected function register_controls() {

        $this->start_controls_section(
            'section_items',
            [
                'label' => esc_html__( 'Items', 'xstore-core' ),
            ]
        );

        $repeater = new \Elementor\Repeater();

//        $repeater->start_controls_tabs( 'slide_tabs' );
//
//        $repeater->start_controls_tab(
//            'slide_general_tab',
//            [
//                'label' => __( 'General', 'xstore-core' ),
//            ]
//        );

        $repeater->add_control(
            'content_type',
            [
                'label' 		=>	__( 'Content Type', 'xstore-core' ),
                'type' 			=>	\Elementor\Controls_Manager::SELECT,
                'options' => $this->get_saved_content_list(),
                'default'	=> 'custom'
            ]
        );

        $repeater->add_control(
            'save_template_info',
            [
                'type'            => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => sprintf( __( 'Create template in Templates -> <a href="%s" target="_blank">Saved Templates</a> -> Choose ready to use template or go to Saved Templates and create new one.', 'xstore-core' ), admin_url('edit.php?post_type=elementor_library&tabs_group=library') ),
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                'condition' => [
                    'content_type' => 'saved_template'
                ]
            ]
        );

        $repeater->add_control(
            'content',
            [
                'type'        => \Elementor\Controls_Manager::WYSIWYG,
                'label'       => __( 'Content', 'xstore-core' ),
                'condition'   => [
                    'content_type' => 'custom',
                ],
                'default' => '<p>'.esc_html__('You can add any HTML here', 'xstore-core').'<br/>'.
                    __('We suggest you to create a Saved Template in Dashboard -> Templates -> Saved Templates and use it by switching content type above to Saved template.', 'xstore-core').'</p>'
            ]
        );

        $repeater->add_control(
            'global_widget',
            [
                'label' => __( 'Global Widget', 'xstore-core' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $this->get_saved_content( 'widget' ),
                'default' => 'select',
                'condition' => [
                    'content_type' => 'global_widget'
                ],
            ]
        );

        $repeater->add_control(
            'saved_template',
            [
                'label' => __( 'Saved Template', 'xstore-core' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $this->get_saved_content(),
                'default' => 'select',
                'condition' => [
                    'content_type' => 'saved_template'
                ],
            ]
        );

//        $repeater->end_controls_tab();
//
//        $repeater->start_controls_tab(
//            'slide_style_tab',
//            [
//                'label' => __( 'Style', 'xstore-core' ),
//            ]
//        );
//
//        $repeater->add_control(
//            'slide_background_info',
//            [
//                'type'            => \Elementor\Controls_Manager::RAW_HTML,
//                'raw' => esc_html__('Set the background here and choose the target for applying changes in Scroll settings below', 'xstore-core'),
//                'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
//            ]
//        );
//
//        $repeater->add_group_control(
//            \Elementor\Group_Control_Background::get_type(),
//            [
//                'name' => 'animated_background',
//                'types' => [ 'classic' ],
//                'exclude' => [ 'image' ],
//                'selector' => '',
//                'render_type' => 'template',
//                'fields_options' => [
//                    'background' => [
//                        'label' => esc_html__('Animated background type', 'xstore-core')
//                    ],
//                ],
//            ]
//        );

//        $repeater->end_controls_tab();
//
//        $repeater->end_controls_tabs();

        $this->add_control(
            'slides',
            [
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'content_type'  => 'custom',
                    ],
                    [
                        'content_type'  => 'custom',
                    ],
                ],
            ]
        );

		$this->end_controls_section();

        // slider global settings
        Elementor::get_slider_general_settings($this);

        $this->update_control( 'section_slider', [
            'label' => esc_html__('Carousel', 'xstore-core'),
        ] );

        $this->update_control( 'navigation', [
            'default' => 'both',
        ] );

        $this->remove_control('slider_vertical_align');

        $this->update_control( 'slides_per_view', [
            'default' => 1,
            'tablet_default' => 1,
            'mobile_default' => 1,
            'separator' => 'before',
        ] );

        $this->start_injection( [
            'type' => 'section',
            'at' => 'start',
            'of' => 'section_slider',
        ] );

        $this->add_control(
            'content_animation',
            [
                'label' => esc_html__( 'Content Animation', 'xstore-core' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => esc_html__( 'None', 'xstore-core' ),
                    'fadeIn' => esc_html__('Fade', 'xstore-core'),
                    'fadeInDown' => esc_html__( 'Down', 'xstore-core' ),
                    'fadeInUp' => esc_html__( 'Up', 'xstore-core' ),
                    'fadeInRight' => esc_html__( 'Right', 'xstore-core' ),
                    'fadeInLeft' => esc_html__( 'Left', 'xstore-core' ),
                    'zoomIn' => esc_html__( 'Zoom', 'xstore-core' ),
                ],
            ]
        );

//        $this->add_control(
//            'slides_bg_animation',
//            [
//                'label' => esc_html__('Slides background animation', 'xstore-core'),
//                'type'  => \Elementor\Controls_Manager::SWITCHER,
//                'frontend_available' => true,
//            ]
//        );
//
//        $this->add_control(
//            'animated_background_for',
//            [
//                'label' 		=> esc_html__( 'Background animation target', 'xstore-core' ),
//                'description' => esc_html__('The background colors you set in each item above will be animated on scroll for the element you choose in this setting.', 'xstore-core'),
//                'type'			=> \Elementor\Controls_Manager::SELECT,
//                'options'		=> [
//                    'section' 	=>	esc_html__( 'Section', 'xstore-core' ),
//                    'container' 	=>	esc_html__( 'Section container', 'xstore-core' ),
//                    'widget' 	=>	esc_html__( 'Widget', 'xstore-core' ),
//                    'slider' 	=>	esc_html__( 'Slider', 'xstore-core' ),
//                ],
//                'condition' => [
//                    'slides_bg_animation' => 'yes'
//                ],
//                'render_type' => 'ui',
//                'frontend_available' => true,
//                'default' => 'section'
//            ]
//        );

        $this->end_injection();

        $this->start_injection( [
            'type' => 'control',
            'at'   => 'after',
            'of'   => 'space_between',
        ] );

        $this->add_control(
            'free_mode',
            [
                'label' => esc_html__('Free mode', 'xstore-core'),
                'type'  => \Elementor\Controls_Manager::SWITCHER,
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'overflow',
            [
                'label' 		=>	__( 'Overflow visible', 'xstore-core' ),
                'type' 			=>	\Elementor\Controls_Manager::SWITCHER,
                'render_type' => 'template',
                'frontend_available' => true,
                'selectors' => [
                    '{{WRAPPER}} .swiper-container' => 'overflow: visible;',
                ],
            ]
        );

        $this->end_injection();

        $this->start_injection( [
            'type' => 'control',
            'at'   => 'after',
            'of'   => 'arrows_position_style',
        ] );

        $this->add_control(
            'dots_header',
            [
                'label' => esc_html__( 'Dots', 'xstore-core' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'navigation' => ['both', 'dots']
                ],
            ]
        );

        $this->add_control(
            'dots_type',
            [
                'label' 		=> esc_html__( 'Type', 'xstore-core' ),
                'type'			=> \Elementor\Controls_Manager::SELECT,
                'options'		=> [
                    'bullets' 	=>	esc_html__( 'Bullets', 'xstore-core' ),
                    'fraction' 	=>	esc_html__( 'Fraction', 'xstore-core' ),
                    'numbers' 	=>	esc_html__( 'Numbers', 'xstore-core' ),
                ],
                'frontend_available' => true,
                'default'	=> 'bullets',
                'condition' => [ 'navigation' => ['both', 'dots'] ]
            ]
        );

        $this->add_control(
            'dots_position',
            [
                'label' 		=> esc_html__( 'Position', 'xstore-core' ),
                'type'			=> \Elementor\Controls_Manager::SELECT,
                'options'		=> [
                    'inside' 			=>	esc_html__( 'Inside', 'xstore-core' ),
                    'outside' 			=>	esc_html__( 'Outside', 'xstore-core' ),
                ],
                'default'	=> 'outside',
                'condition' => [ 'navigation' => ['both', 'dots'] ]
            ]
        );

        $this->add_control(
            'dots_color_schema',
            [
                'label' 		=> esc_html__( 'Color Schema', 'xstore-core' ),
                'type'			=> \Elementor\Controls_Manager::SELECT,
                'options'		=> [
                    'dark' 	=>	esc_html__( 'Dark', 'xstore-core' ),
                    'white' 	=>	esc_html__( 'White', 'xstore-core' ),
                ],
                'default'	=> 'dark',
                'condition' => [ 'navigation' => ['both', 'dots'] ],
                'selectors_dictionary'  => [
                    'dark'          => '',
                    'white'         => '#fff',
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination .swiper-pagination-fraction, {{WRAPPER}} .swiper-pagination .swiper-pagination-number' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_injection();

        // slider style settings
        Elementor::get_slider_style_settings($this);

        $this->update_control( 'section_style_slider', [
            'label' => esc_html__('Carousel', 'xstore-core'),
        ] );

	}

	/**
	 * Render widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 5.1.7
	 * @access protected
	 */
	public function render()
    {
        $settings = $this->get_settings_for_display();

        $edit_mode = \Elementor\Plugin::$instance->editor->is_edit_mode();
        $swiper_latest = \Elementor\Plugin::$instance->experiments->is_feature_active('e_swiper_latest');
        if ($swiper_latest && in_array($settings['arrows_position'], array('middle', 'middle-inside')))
            $settings['arrows_position'] = 'middle-inbox';

        $this->add_render_attribute('wrapper', [
            'class' => [
                'etheme-elementor-swiper-entry',
                'swiper-entry',
                $settings['arrows_position'],
                $settings['arrows_position_style']
            ]
        ]);


        $this->add_render_attribute('wrapper-inner',
            [
                'class' =>
                    [
                        $swiper_latest ? 'swiper' : 'swiper-container',
                        'etheme-elementor-slider',
                    ],
                'dir' => is_rtl() ? 'rtl' : 'ltr'
            ]
        );

        $this->add_render_attribute('slide-content', 'class', 'swiper-slide-contents');

        if ($settings['content_animation'] != 'none') {
            $this->add_render_attribute('wrapper-inner', 'data-animation', $settings['content_animation']);
            if ($edit_mode) {
                $this->add_render_attribute('slide-content', 'class', [
                    'animated',
                    $settings['content_animation']
                ]);
            }
        }

        $this->add_render_attribute('slides-wrapper', 'class', 'swiper-wrapper');

//        $last_set_bg = false;
//        if ($settings['slides_bg_animation']) {
//            $last_set_bg = current(array_filter($settings['slides'], function ($slide) {
//                return isset($slide['background_color']) && !empty($slide['background_color']);
//            }));
//        }
//        $last_set_bg = $last_set_bg ? $last_set_bg['background_color'] : 'transparent';
//        if ( $settings['animated_background_for'] == 'slider' ) {
//            $this->add_render_attribute('wrapper', [
//                'style' => implode(';', [
//                    'background: ' . $last_set_bg,
//                    'transition: background .3s linear'
//                ])
//            ]);
//        }

		?>
        
        <div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
            <div <?php $this->print_render_attribute_string( 'wrapper-inner' ); ?>>
                <div <?php $this->print_render_attribute_string( 'slides-wrapper' ); ?>>
                    <?php
                        foreach ($settings['slides'] as $slide_index => $slide) {
                            $this->add_render_attribute( 'slide-'.$slide['_id'], [
                                    'class' => [
                                        'elementor-repeater-item-' . $slide['_id'],
                                        'swiper-slide'
                                    ],
                            ]);
//                            if ( $settings['slides_bg_animation'] ) {
//                                if (isset($slide['animated_background_color']) && !empty($slide['animated_background_color'])) {
//                                    $active_bg = $slide['animated_background_color'];
//                                    $last_set_bg = $active_bg;
//                                } else {
//                                    $active_bg = $last_set_bg;
//                                }
//                                $this->add_render_attribute( 'slide-'.$slide['_id'], [
//                                    'data-bg' => $active_bg
//                                ]);
//                            }
                            echo '<div '. $this->get_render_attribute_string( 'slide-'.$slide['_id'] ) . '>';
                                echo '<div '. $this->get_render_attribute_string( 'slide-content' ) . '>';
                                    switch ($slide['content_type']) {
                                        case 'custom':
                                            $this->print_unescaped_setting('content', 'slides', $slide_index);
                                            break;
                                        case 'global_widget':
                                        case 'saved_template':
                                            if (!empty($slide[$slide['content_type']])):
                                                //								echo \Elementor\Plugin::$instance->frontend->get_builder_content( $slide[$slide['content_type']], true );
                                                $posts = get_posts(
                                                    [
                                                        'name' => $slide[$slide['content_type']],
                                                        'post_type'      => 'elementor_library',
                                                        'posts_per_page' => '1',
                                                        'tax_query'      => [
                                                            [
                                                                'taxonomy' => 'elementor_library_type',
                                                                'field'    => 'slug',
                                                                'terms'    => str_replace(array('global_widget', 'saved_template'), array('widget', 'section'), $slide['content_type']),
                                                            ],
                                                        ],
                                                        'fields' => 'ids'
                                                    ]
                                                );
                                                if (!isset($posts[0]) || !$content = \Elementor\Plugin::$instance->frontend->get_builder_content_for_display($posts[0])) {
                                                    echo esc_html__('We have imported popup template successfully. To setup it in the correct way please, save this page, refresh and select it in dropdown.', 'xstore-core');
                                                } else {
                                                    echo $content;
                                                }
                                            endif;
                                            break;
                                    }
                                echo '</div>';
                            echo '</div>';
                        }
                    ?>
                </div>

                <?php
                    if ( $swiper_latest ) {
                        if (in_array($settings['navigation'], array('both', 'arrows')))
                            Elementor::get_slider_navigation($settings, $edit_mode);
                    }
                    //                                    if ( 1 < count($products) ) {
                    if ( in_array($settings['navigation'], array('both', 'dots')) ) {
                        Elementor::get_slider_pagination($this, $settings, $edit_mode);
                    }

                    //                                    }
                    ?>

            </div>

            <?php
                if ( !$swiper_latest ) {
                    if (in_array($settings['navigation'], array('both', 'arrows')))
                        Elementor::get_slider_navigation($settings, $edit_mode);
                }
            ?>
        </div>
		<?php

	}

    /**
     * Get all elementor page templates
     *
     * @return array
     */
    protected function get_saved_content_list() {
        $content_list = [
            'custom'   => __( 'Custom', 'xstore-core' ),
            'saved_template' => __( 'Saved Template', 'xstore-core' ),
        ];

        if ( defined( 'ELEMENTOR_PRO_VERSION' ) ) {
            $content_list['global_widget'] = __( 'Global Widget', 'xstore-core' );
        }
        return $content_list;
    }

    protected function get_post_template( $term = 'page' ) {
        $posts = get_posts(
            [
                'post_type'      => 'elementor_library',
                'orderby'        => 'title',
                'order'          => 'ASC',
                'posts_per_page' => '-1',
                'tax_query'      => [
                    [
                        'taxonomy' => 'elementor_library_type',
                        'field'    => 'slug',
                        'terms'    => $term,
                    ],
                ],
            ]
        );

        $templates = [];
        foreach ( $posts as $post ) {
            $templates[] = [
                'id'   => $post->ID,
                'name' => $post->post_title,
                'slug' => $post->post_name
            ];
        }
        return $templates;
    }

    protected function get_saved_content( $term = 'section' ) {
        $saved_contents = $this->get_post_template( $term );

        if ( count( $saved_contents ) > 0 ) {
            foreach ( $saved_contents as $saved_content ) {
//                $content_id             = $saved_content['id'];
//                $options[ $content_id ] = $saved_content['name'];
                $content_slug             = $saved_content['slug'];
                $options[ $content_slug ] = $saved_content['name'];
            }
        } else {
            $options['no_template'] = __( 'Nothing Found', 'xstore-core' );
        }
        return $options;
    }
}
