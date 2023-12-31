<?php
/**
 * Customizer Control: dimensions.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2020, David Vongries
 * @license     https://opensource.org/licenses/MIT
 * @since       2.1
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Dimensions control.
 * multiple fields with CSS units validation.
 */
class Kirki_Control_Dimensions extends Kirki_Control_Base {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'kirki-dimensions';

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @see WP_Customize_Control::to_json()
	 */
	public function to_json() {
		parent::to_json();

		if ( is_array( $this->choices ) ) {
			foreach ( $this->choices as $choice => $value ) {
				if ( 'labels' !== $choice && true === $value ) {
					$this->json['choices'][ $choice ] = true;
				}
			}
		}
		if ( is_array( $this->json['default'] ) ) {
			foreach ( $this->json['default'] as $key => $value ) {
				if ( isset( $this->json['choices'][ $key ] ) && ! isset( $this->json['value'][ $key ] ) ) {
					$this->json['value'][ $key ] = $value;
				}
			}
		}
	}

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {
		wp_enqueue_style( 'kirki-styles', trailingslashit( Kirki::$url ) . 'controls/css/styles.css', array(), KIRKI_VERSION );
		wp_localize_script( 'kirki-script', 'dimensionskirkiL10n', $this->l10n() );
	}

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
	 *
	 * @see WP_Customize_Control::print_template()
	 *
	 * @access protected
	 */
	protected function content_template() {
		?>
		<label>
			<# if ( data.label ) { #><span class="customize-control-title">{{{ data.label }}}</span><# } #>
			<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>
			<div class="wrapper">
				<div class="control">
					<# for ( choiceKey in data.default ) { #>
						<div class="{{ choiceKey }}">
							<h5>
								<# if ( ! _.isUndefined( data.choices.labels ) && ! _.isUndefined( data.choices.labels[ choiceKey ] ) ) { #>
									{{ data.choices.labels[ choiceKey ] }}
								<# } else if ( ! _.isUndefined( data.l10n[ choiceKey ] ) ) { #>
									{{ data.l10n[ choiceKey ] }}
								<# } else { #>
									{{ choiceKey }}
								<# } #>
							</h5>
                            <# if ( ! _.isUndefined( data.choices.descriptions ) && ! _.isUndefined( data.choices.descriptions[ choiceKey ] ) ) { #>
                                <span class="tooltip-wrapper">
                                    <span class="tooltip-trigger" data-setting="{{data.settings}}_{{ choiceKey }}">
                                        <span class="dashicons dashicons-editor-help"></span>
                                    </span>
                                    <span class="tooltip-content" data-setting="{{data.settings}}_{{ choiceKey }}">
                                        {{{ data.choices.descriptions[ choiceKey ] }}}
                                    </span>
                                </span>
                            <# } #>
							<div class="{{ choiceKey }} input-wrapper">
								<# var val = ( ! _.isUndefined( data.value ) && ! _.isUndefined( data.value[ choiceKey ] ) ) ? data.value[ choiceKey ].toString().replace( '%%', '%' ) : ''; #>
								<input {{{ data.inputAttrs }}} type="text" data-choice="{{ choiceKey }}" value="{{ val }}"/>
							</div>
						</div>
					<# } #>
				</div>
			</div>
		</label>
		<?php
	}

	/**
	 * Returns an array of translation strings.
	 *
	 * @access protected
	 * @since 3.0.0
	 * @return array
	 */
	protected function l10n() {
		return array(
			'left-top'       => esc_html__( 'Left Top', 'xstore-core' ),
			'left-center'    => esc_html__( 'Left Center', 'xstore-core' ),
			'left-bottom'    => esc_html__( 'Left Bottom', 'xstore-core' ),
			'right-top'      => esc_html__( 'Right Top', 'xstore-core' ),
			'right-center'   => esc_html__( 'Right Center', 'xstore-core' ),
			'right-bottom'   => esc_html__( 'Right Bottom', 'xstore-core' ),
			'center-top'     => esc_html__( 'Center Top', 'xstore-core' ),
			'center-center'  => esc_html__( 'Center Center', 'xstore-core' ),
			'center-bottom'  => esc_html__( 'Center Bottom', 'xstore-core' ),
			'font-size'      => esc_html__( 'Font Size', 'xstore-core' ),
			'font-weight'    => esc_html__( 'Font Weight', 'xstore-core' ),
			'line-height'    => esc_html__( 'Line Height', 'xstore-core' ),
			'font-style'     => esc_html__( 'Font Style', 'xstore-core' ),
			'letter-spacing' => esc_html__( 'Letter Spacing', 'xstore-core' ),
			'word-spacing'   => esc_html__( 'Word Spacing', 'xstore-core' ),
			'top'            => esc_html__( 'Top', 'xstore-core' ),
			'bottom'         => esc_html__( 'Bottom', 'xstore-core' ),
			'left'           => esc_html__( 'Left', 'xstore-core' ),
			'right'          => esc_html__( 'Right', 'xstore-core' ),
			'center'         => esc_html__( 'Center', 'xstore-core' ),
			'size'           => esc_html__( 'Size', 'xstore-core' ),
			'spacing'        => esc_html__( 'Spacing', 'xstore-core' ),
			'width'          => esc_html__( 'Width', 'xstore-core' ),
			'height'         => esc_html__( 'Height', 'xstore-core' ),
			'invalid-value'  => esc_html__( 'Invalid Value', 'xstore-core' ),
		);
	}
}
