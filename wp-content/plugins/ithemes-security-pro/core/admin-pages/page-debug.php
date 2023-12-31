<?php

final class ITSEC_Debug_Page {

	/** @var string */
	private $self_url;

	public function __construct() {
		add_action( 'itsec-page-show', array( $this, 'handle_page_load' ) );
		add_action( 'itsec-page-ajax', array( $this, 'handle_ajax_request' ) );
		add_action( 'admin_print_scripts', array( $this, 'add_scripts' ) );
		add_action( 'admin_print_styles', array( $this, 'add_styles' ) );

		ITSEC_Modules::load_module_file( 'debug.php', ':active' );
	}

	public function handle_page_load( $self_url ) {
		$this->self_url = $self_url;

		$this->show_settings_page();
	}

	public function add_scripts() {

		$deps = array( 'itsec-util' );

		if ( function_exists( 'wp_enqueue_code_editor' ) ) {
			$deps[] = 'code-editor';
			wp_enqueue_code_editor( array(
				'type' => 'application/json'
			) );
		}

		ITSEC_Lib::enqueue_util( array( 'action' => 'itsec_debug_page', 'nonce' => 'itsec-debug-page' ) );
		wp_enqueue_script( 'itsec-debug', plugins_url( 'js/debug.js', __FILE__ ), $deps, ITSEC_Core::get_plugin_build() );

		do_action( 'itsec_debug_page_enqueue' );
	}

	public function add_styles() {
		wp_enqueue_style( 'itsec-debug-page-style', plugins_url( 'css/style.css', __FILE__ ), array(), ITSEC_Core::get_plugin_build() );
	}

	public function handle_ajax_request() {
		if ( WP_DEBUG ) {
			ini_set( 'display_errors', 1 );
		}

		ITSEC_Core::set_interactive( true );

		$method = ( isset( $_POST['method'] ) && is_string( $_POST['method'] ) ) ? $_POST['method'] : '';
		$module = ( isset( $_POST['module'] ) && is_string( $_POST['module'] ) ) ? $_POST['module'] : '';

		if ( empty( $GLOBALS['hook_suffix'] ) ) {
			$GLOBALS['hook_suffix'] = 'security_page_itsec-debug';
		}

		if ( false === check_ajax_referer( 'itsec-debug-page', 'nonce', false ) ) {
			ITSEC_Response::add_error( new WP_Error( 'itsec-debug-page-failed-nonce', __( 'A security check failed, preventing the request from completing as expected. Please try reloading the page and trying again.', 'it-l10n-ithemes-security-pro' ) ) );
		} elseif ( ! ITSEC_Core::current_user_can_manage() ) {
			ITSEC_Response::add_error( new WP_Error( 'itsec-debug-page-insufficient-privileges', __( 'A permissions security check failed, preventing the request from completing as expected. The currently logged in user does not have sufficient permissions to make this request. Please try reloading the page and trying again.', 'it-l10n-ithemes-security-pro' ) ) );
		} elseif ( empty( $method ) ) {
			ITSEC_Response::add_error( new WP_Error( 'itsec-debug-page-missing-method', __( 'The server did not receive a valid request. The required "method" argument is missing. Please try again.', 'it-l10n-ithemes-security-pro' ) ) );
		} elseif ( 'handle_module_request' === $method && empty( $module ) ) {
			ITSEC_Response::add_error( new WP_Error( 'itsec-debug-page-missing-module', __( 'The server did not receive a valid request. The required "module" argument is missing. Please try again.', 'it-l10n-ithemes-security-pro' ) ) );
		} elseif ( 'handle_module_request' === $method ) {
			if ( isset( $_POST['data'] ) ) {
				ITSEC_Modules::load_module_file( 'debug.php', ':active' );
				/**
				 * Fires when an ajax request is being made to a module.
				 *
				 * At some point this will probably be replaced by a more thought-out framework, but this hook will probably power it.
				 *
				 * The dynamic portion of this hook, {$module}, refers to the module name. For example, 'notification-center'.
				 *
				 * @param array $data
				 */
				do_action( "itsec_debug_module_request_{$module}", $_POST['data'] );
			} else {
				ITSEC_Response::add_error( new WP_Error( 'itsec-debug-page-module-request-missing-data', __( 'The server did not receive a valid request. The required "data" argument for the module is missing. Please try again.', 'it-l10n-ithemes-security-pro' ) ) );
			}
		} elseif ( 'reset_scheduler' === $method ) {
			ITSEC_Core::get_scheduler()->reset();
			ITSEC_Response::set_response( $this->get_events_table() );
			ITSEC_Response::set_success( true );
			ITSEC_Response::add_message( __( 'Scheduler reset.', 'it-l10n-ithemes-security-pro' ) );
		} elseif ( 'run_event' === $method ) {
			if ( empty( $_POST['data']['id'] ) ) {
				ITSEC_Response::add_error( new WP_Error( 'itsec-debug-page-run-event-missing-id', __( 'The server did not receive a valid request. The required "data.id" argument for the "run_event" method is missing.', 'it-l10n-ithemes-security-pro' ) ) );
			} elseif ( ! empty( $_POST['data']['data'] ) ) {
				$hash = $_POST['data']['data'];

				if ( ! is_string( $hash ) ) {
					ITSEC_Response::add_error( new WP_Error( 'itsec-debug-page-run-event-invalid-data', __( 'The server did not receive a valid request. The "data.data" argument for the "run_event" method is an invalid string.', 'it-l10n-ithemes-security-pro' ) ) );
				} else {
					ITSEC_Core::get_scheduler()->run_single_event_by_hash( $_POST['data']['id'], $hash );
					ITSEC_Response::set_response( $this->get_events_table() );
					ITSEC_Response::set_success( true );
					ITSEC_Response::add_message( __( 'Event successfully run.', 'it-l10n-ithemes-security-pro' ) );
				}
			} else {
				ITSEC_Core::get_scheduler()->run_recurring_event( $_POST['data']['id'] );
				ITSEC_Response::set_response( $this->get_events_table() );
				ITSEC_Response::set_success( true );
				ITSEC_Response::add_message( __( 'Event successfully run.', 'it-l10n-ithemes-security-pro' ) );
			}
		} elseif ( 'load_settings' === $method ) {
			ITSEC_Response::set_response( ITSEC_Modules::get_settings( $module ) );
		} elseif ( 'save_settings' === $method ) {
			$data = json_decode( wp_unslash( $_POST['data'] ), true );

			if ( ! is_array( $data ) ) {
				ITSEC_Response::set_success( false );
				ITSEC_Response::add_error( new WP_Error( 'itsec-debug-page-run-event-invalid-data', __( 'The server did not receive a valid request. The "data" argument for the "save_settings" method is invalid.', 'it-l10n-ithemes-security-pro' ) ) );
			} else {
				$result = ITSEC_Modules::set_settings( $module, $data );

				if ( is_wp_error( $result ) ) {
					ITSEC_Response::set_success( false );
					ITSEC_Response::add_error( $result );
				} else {
					ITSEC_Response::set_response( ITSEC_Modules::get_settings( $module ) );

					if ( $result['saved'] ) {
						ITSEC_Response::add_message( esc_html__( 'Module settings updated.', 'it-l10n-ithemes-security-pro' ) );
					}
				}
			}
		} else {
			ITSEC_Response::add_error( new WP_Error( 'itsec-debug-page-unknown-method', __( 'The server did not receive a valid request. An unknown "method" argument was supplied. Please try again.', 'it-l10n-ithemes-security-pro' ) ) );
		}

		ITSEC_Response::send_json();
	}

	private function show_settings_page() {

		$sysinfo = $this->get_sysinfo();

		$out = '';

		foreach ( $sysinfo as $category => $info ) {
			if ( $out ) {
				$out .= "\r\n";
			}

			$out .= "### {$category} ###\r\n";

			foreach ( $info as $label => $value ) {
				$out .= "{$label}: {$value}\r\n";
			}
		}

		$out = rtrim( $out );

		$scheduler = ITSEC_Core::get_scheduler();

		$modules = array();

		foreach ( ITSEC_Modules::get_available_modules() as $module ) {
			if ( ITSEC_Modules::get_settings_obj( $module ) ) {
				$modules[ $module ] = $module;
			}
		}

		sort( $modules );
		?>
		<div class="wrap">
			<h1>
				<?php _e( 'Solid Security', 'it-l10n-ithemes-security-pro' ); ?>
				<a href="<?php echo esc_url( ITSEC_Core::get_settings_page_url() ); ?>" class="page-title-action"><?php _e( 'Manage Settings', 'it-l10n-ithemes-security-pro' ); ?></a>
				<a href="<?php echo esc_url( apply_filters( 'itsec_support_url', 'https://go.solidwp.com/org-support' ) ); ?>" class="page-title-action">
					<?php _e( 'Support', 'it-l10n-ithemes-security-pro' ); ?>
				</a>
			</h1>

			<div id="itsec-messages"></div>

			<div>
				<h2><?php esc_html_e( 'System Info', 'it-l10n-ithemes-security-pro' ); ?></h2>
				<label for="itsec-system-info"><?php esc_html__( 'System Info Summary', 'it-l10n-ithemes-security-pro' ); ?></label>
				<textarea readonly id="itsec-system-info"><?php echo esc_textarea( $out ); ?></textarea>
			</div>

			<div>
				<h2><?php esc_html_e( 'Settings', 'it-l10n-ithemes-security-pro' ); ?></h2>
				<p>
					<label for="itsec-settings-module" class="screen-reader-text"><?php esc_html_e( 'Module', 'it-l10n-ithemes-security-pro' ); ?></label>
					<select id="itsec-settings-module">
						<?php foreach ( $modules as $module ) : ?>
							<option value="<?php echo esc_attr( $module ); ?>"><?php echo esc_html( $module ); ?></option>
						<?php endforeach; ?>
					</select>
					<button class="button" id="itsec-settings-load"><?php esc_html_e( 'Load', 'it-l10n-ithemes-security-pro' ); ?></button>
					<button class="button" id="itsec-settings-save" disabled><?php esc_html_e( 'Save', 'it-l10n-ithemes-security-pro' ) ?></button>
				</p>
				<label for="itsec-settings-editor" class="screen-reader-text"><?php esc_html_e( 'Edit Settings', 'it-l10n-ithemes-security-pro' ); ?></label>
				<textarea id="itsec-settings-editor"></textarea>
			</div>

			<div id="itsec-scheduler-events">
				<h2><?php esc_html_e( 'Scheduler', 'it-l10n-ithemes-security-pro' ); ?></h2>
				<?php echo $this->get_events_table(); ?>
				<p style="text-align: right;">
					<code><?php echo get_class( $scheduler ); ?></code>
					<button class="button" id="itsec-scheduler-reset"><?php esc_html_e( 'Reset', 'it-l10n-ithemes-security-pro' ) ?></button>
				</p>
			</div>

			<?php do_action( 'itsec_debug_page' ); ?>
		</div>
		<?php
	}

	private function get_events_table() {
		$scheduler = ITSEC_Core::get_scheduler();
		ob_start();

		?>

		<table class="widefat striped">
			<thead>
			<tr>
				<th><?php esc_html_e( 'ID', 'it-l10n-ithemes-security-pro' ) ?></th>
				<th><?php esc_html_e( 'Fire At', 'it-l10n-ithemes-security-pro' ) ?></th>
				<th><?php esc_html_e( 'Schedule', 'it-l10n-ithemes-security-pro' ) ?></th>
				<th>
					<button class="button-link" id="itsec-events-data-toggle"><?php esc_html_e( 'Data', 'it-l10n-ithemes-security-pro' ) ?></button>
				</th>
				<th></th>
			</tr>
			</thead>
			<tbody>
			<?php foreach ( array_merge( $scheduler->get_recurring_events(), $scheduler->get_single_events() ) as $event ) : ?>
				<tr>
					<td><?php echo esc_html( $event['id'] ); ?></td>
					<td><?php echo date( 'Y-m-d H:i:s', $event['fire_at'] ); ?> (<?php echo esc_html( human_time_diff( $event['fire_at'] ) ) ?>)</td>
					<td><?php echo isset( $event['schedule'] ) ? $event['schedule'] : '–'; ?></td>
					<td>
						<div class="hidden itsec-events-data"><?php $event['data'] ? ITSEC_Lib::print_r( $event['data'] ) : print( '–' ); ?></div>
					</td>
					<td>
						<button class="button" data-id="<?php echo esc_attr( $event['id'] ); ?>"
								data-data="<?php echo isset( $event['schedule'] ) ? '' : esc_attr( $event['hash'] ); ?>">
							<?php esc_html_e( 'Run', 'it-l10n-ithemes-security-pro' ) ?>
						</button>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>

		<?php

		return ob_get_clean();
	}

	private function get_sysinfo() {

		/** @var $wpdb wpdb */
		global $wpdb;

		$info = array();

		$info['Site Info'] = array(
			'Site URL'  => site_url(),
			'Home URL'  => home_url(),
			'Multisite' => is_multisite() ? 'Yes' : 'No'
		);

		$wp_config = array(
			'Version'       => get_bloginfo( 'version' ),
			'Language'      => defined( 'WPLANG' ) && WPLANG ? WPLANG : 'en_US',
			'Permalink'     => get_option( 'permalink_structure' ) ?: 'Default',
			'Theme'         => wp_get_theme()->Name . ' ' . wp_get_theme()->Version,
			'Show on Front' => get_option( 'show_on_front' )
		);

		if ( get_option( 'show_on_front' ) === 'page' ) {
			$front_page_id = get_option( 'page_on_front' );
			$blog_page_id  = get_option( 'page_for_posts' );

			$wp_config['Page On Front']  = $front_page_id ? get_the_title( $front_page_id ) . " (#$front_page_id)" : 'Unset';
			$wp_config['Page For Posts'] = $blog_page_id ? get_the_title( $blog_page_id ) . " (#$blog_page_id)" : 'Unset';
		}

		$wp_config['ABSPATH']            = ABSPATH;
		$wp_config['Table Prefix']       = 'Length: ' . strlen( $wpdb->prefix ) . ' Status: ' . ( strlen( $wpdb->prefix ) > 16 ? 'Too long' : 'Acceptable' );
		$wp_config['WP_DEBUG']           = defined( 'WP_DEBUG' ) ? ( WP_DEBUG ? 'Enabled' : 'Disabled' ) : 'Not set';
		$wp_config['WP_DEBUG_LOG']       = defined( 'WP_DEBUG_LOG' ) ? ( WP_DEBUG_LOG ? 'Enabled' : 'Disabled' ) : 'Not set';
		$wp_config['SCRIPT_DEBUG']       = defined( 'SCRIPT_DEBUG' ) ? ( SCRIPT_DEBUG ? 'Enabled' : 'Disabled' ) : 'Not set';
		$wp_config['Object Cache']       = wp_using_ext_object_cache() ? 'Yes' : 'No';
		$wp_config['Memory Limit']       = WP_MEMORY_LIMIT;
		$info['WordPress Configuration'] = $wp_config;

		$defines = array(
			'ITSEC_USE_CRON',
			'ITSEC_DISABLE_PASSWORD_REQUIREMENTS',
			'ITSEC_DEVELOPMENT',
			'ITSEC_DISABLE_MODULES',
			'ITSEC_DISABLE_TWO_FACTOR',
			'ITSEC_DISABLE_CRON_TEST',
			'ITSEC_SERVER_OVERRIDE',
			'ITSEC_DOING_FILE_CHECK',
			'ITSEC_TEST_MALWARE_SCAN_SKIP_CACHE',
			'ITSEC_TEST_MALWARE_SCAN_SITE_URL',
			'ITSEC_TEST_MALWARE_SCAN_DISABLE_SSL_VERIFY',
			'ITSEC_SUCURI_KEY',
			'ITSEC_NOTIFY_USE_CRON',
			'ITSEC_DISABLE_SECURITY_CHECK_PRO',
			'ITSEC_DISABLE_AUTOMATIC_REMOTE_IP_DETECTION',
			'ITSEC_DISABLE_PASSWORD_STRENGTH',
			'ITSEC_DISABLE_INACTIVE_USER_CHECK',
			'ITSEC_SHOW_FEATURE_FLAGS',
			'ITSEC_ENABLE_BACKUPS',
			'ITSEC_FORCE_UNINSTALL',
			'ITSEC_IGNORE_MODULE_REQUIREMENTS',
			'ITSEC_FORCE_INSTALL_TYPE',
		);

		ITSEC_Lib::load( 'feature-flags' );

		$info['Solid Security'] = array(
			'Build'       => ITSEC_Core::get_plugin_build(),
			'Pro'         => ITSEC_Core::is_pro(),
			'Modules'     => wp_sprintf( '%l', ITSEC_Modules::get_active_modules() ),
			'Cron'        => ITSEC_Lib::use_cron(),
			'Cron Status' => ITSEC_Lib::is_cron_working(),
			'Scheduler'   => get_class( ITSEC_Core::get_scheduler() ),
			'Features'    => wp_sprintf( '%l', ITSEC_Lib_Feature_Flags::get_enabled() ),
		);

		foreach ( $defines as $define ) {
			if ( defined( $define ) ) {
				$value = constant( $define );

				if ( true === $value ) {
					$value = 'Enabled';
				} elseif ( false === $value ) {
					$value = 'Disabled';
				}

				$info['Solid Security'][ $define ] = $value;
			}
		}

		$plugins        = get_plugins();
		$active_plugins = get_option( 'active_plugins', array() );

		foreach ( $plugins as $plugin_path => $plugin ) {

			if ( ! in_array( $plugin_path, $active_plugins, true ) ) {
				continue;
			}

			$info['Active Plugins'][ $plugin['Name'] ] = $plugin['Version'];
		}

		foreach ( get_mu_plugins() as $plugin ) {
			$info['MU Plugins'][ $plugin['Name'] ] = $plugin['Version'];
		}

		if ( is_multisite() ) {
			$plugins        = wp_get_active_network_plugins();
			$active_plugins = get_site_option( 'active_sitewide_plugins', array() );

			foreach ( $plugins as $plugin_path ) {

				$plugin_base = plugin_basename( $plugin_path );

				if ( ! array_key_exists( $plugin_base, $active_plugins ) ) {
					continue;
				}

				$plugin = get_plugin_data( $plugin_path );

				$info['Network Active Plugins'][ $plugin['Name'] ] = $plugin['Version'];
			}
		}

		$info['Webserver Configuration'] = array(
			'PHP Version'    => PHP_VERSION,
			'MySQL Version'  => $wpdb->db_version(),
			'Use MySQLi'     => $wpdb->use_mysqli ? 'Yes' : 'No',
			'Webserver Info' => ITSEC_Lib::get_server(),
			'Host'           => $this->get_host(),
		);

		$info['PHP Configuration'] = array(
			'Safe Mode'           => ini_get( 'safe_mode' ) ? 'Enabled' : 'Disabled',
			'Memory Limit'        => ini_get( 'memory_limit' ),
			'Upload Max Size'     => ini_get( 'upload_max_filesize' ),
			'Post Max Size'       => ini_get( 'post_max_size' ),
			'Upload Max Filesize' => ini_get( 'upload_max_filesize' ),
			'Time Limit'          => ini_get( 'max_execution_time' ),
			'Max Input Vars'      => ini_get( 'max_input_vars' ),
			'Display Errors'      => ini_get( 'display_errors' ) ? 'On (' . ini_get( 'display_errors' ) . ')' : 'N/A'
		);

		$info['PHP Extensions'] = array(
			'cURL'        => function_exists( 'curl_init' ) ? 'Supported' : 'Not Supported',
			'fsockopen'   => function_exists( 'fsockopen' ) ? 'Supported' : 'Not Supported',
			'SOAP Client' => class_exists( 'SoapClient' ) ? 'Installed' : 'Not Installed',
			'Suhosin'     => extension_loaded( 'suhosin' ) ? 'Installed' : 'Not Installed'
		);

		return $info;
	}

	private function get_host() {

		if ( defined( 'WPE_APIKEY' ) ) {
			$host = 'WP Engine';
		} elseif ( defined( 'PAGELYBIN' ) ) {
			$host = 'Pagely';
		} elseif ( DB_HOST === 'localhost:/tmp/mysql5.sock' ) {
			$host = 'ICDSoft';
		} elseif ( DB_HOST === 'mysqlv5' ) {
			$host = 'NetworkSolutions';
		} elseif ( strpos( DB_HOST, 'ipagemysql.com' ) !== false ) {
			$host = 'iPage';
		} elseif ( strpos( DB_HOST, 'ipowermysql.com' ) !== false ) {
			$host = 'IPower';
		} elseif ( strpos( DB_HOST, '.gridserver.com' ) !== false ) {
			$host = 'MediaTemple Grid';
		} elseif ( strpos( DB_HOST, '.pair.com' ) !== false ) {
			$host = 'pair Networks';
		} elseif ( strpos( DB_HOST, '.stabletransit.com' ) !== false ) {
			$host = 'Rackspace Cloud';
		} elseif ( strpos( DB_HOST, '.sysfix.eu' ) !== false ) {
			$host = 'SysFix.eu Power Hosting';
		} elseif ( isset( $_SERVER['SERVER_NAME'] ) && strpos( $_SERVER['SERVER_NAME'], 'Flywheel' ) !== false ) {
			$host = 'Flywheel';
		} else {
			// Adding a general fallback for data gathering
			$host = 'DBH/' . DB_HOST . ', SRV/' . ( isset( $_SERVER['SERVER_NAME'] ) ? $_SERVER['SERVER_NAME'] : '' );
		}

		return $host;
	}
}

new ITSEC_Debug_Page();
