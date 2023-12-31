<?php

/**
 * Class ITSEC_Fingerprinting_Privacy
 */
final class ITSEC_Fingerprinting_Privacy {

	/**
	 * ITSEC_Fingerprinting_Privacy constructor.
	 */
	public function __construct() {
		add_filter( 'itsec_get_privacy_policy_sections', array( $this, 'get_privacy_policy_sections' ) );
		add_filter( 'itsec_get_privacy_policy_for_fingerprints', array( $this, 'get_privacy_policy_for_fingerprints' ) );
		add_filter( 'itsec_get_privacy_policy_for_sharing', array( $this, 'get_privacy_policy_for_sharing' ) );
	}

	public function get_privacy_policy_sections( $sections ) {

		$sections['collection']['subheadings']['fingerprints'] = __( 'Login Device Protection', 'it-l10n-ithemes-security-pro' );

		return $sections;
	}

	public function get_privacy_policy_for_fingerprints( $policy ) {
		$suggested_text = '<strong class="privacy-policy-tutorial">' . __( 'Suggested text:', 'it-l10n-ithemes-security-pro' ) . '</strong>';

		$policy .= "<p>{$suggested_text} ";
		$policy .= esc_html__( 'Session data, such as IP addresses and user agents, are stored to verify that users are logging in from trusted devices.', 'it-l10n-ithemes-security-pro' );
		$policy .= '<p>';

		return $policy;
	}

	public function get_privacy_policy_for_sharing( $policy ) {

		$role = ITSEC_Modules::get_setting( 'fingerprinting', 'role' );

		require_once( ITSEC_Core::get_core_dir() . 'lib/class-itsec-lib-geolocation.php' );
		$geolocators = apply_filters( 'itsec_geolocator_apis', array() );

		$has_mm_api = $has_mm_db = false;

		foreach ( $geolocators as $geolocator ) {
			if ( $geolocator instanceof ITSEC_Geolocator_MaxMind_API ) {
				$has_mm_api = true;
			}

			if ( $geolocator instanceof ITSEC_Geolocator_MaxMind_DB ) {
				$has_mm_db = true;
			}
		}

		$suggested_text = '<strong class="privacy-policy-tutorial">' . __( 'Suggested text:', 'it-l10n-ithemes-security-pro' ) . '</strong>';

		if ( $has_mm_api ) {
			$policy .= "<p>{$suggested_text} ";
			$policy .= sprintf(
				esc_html__( 'When logging into this website, users with the %1$s role or higher may have their IP address transmitted to MaxMind to provide a rough estimate of their location to help prevent unauthorized access to their account. Read the %2$sMaxMind EULA%3$s for more details about their service.', 'it-l10n-ithemes-security-pro' ),
				translate_user_role( $role ),
				'<a href="https://go.solidwp.com/maxmind-end-user-license-agreements">',
				'</a>'
			);
			$policy .= '</p>';
		} elseif ( ! $has_mm_db ) {
			$policy .= "<p>{$suggested_text} ";
			$policy .= wp_sprintf(
				esc_html__( 'When logging into this website, users with the %1$s role or higher may have their IP address transmitted to one of the following 3rd-parties, depending on availability, to provide a rough estimate of their location to help prevent unauthorized access to their account: %2$l', 'it-l10n-ithemes-security-pro' ),
				translate_user_role( $role ),
				array(
					'<a href="https://go.solidwp.com/ip-address-info-lookup">IP Info</a>',
					'<a href="https://go.solidwp.com/geolocation-services-from-geobytes">Geobytes</a>',
					'<a href="https://go.solidwp.com/geolocation">GeoPlugin</a>',
					'<a href="https://go.solidwp.com/ip-geolocation-api">IP API</a>',
				)
			);
			$policy .= '</p>';
		}

		return $policy;
	}
}

new ITSEC_Fingerprinting_Privacy();
