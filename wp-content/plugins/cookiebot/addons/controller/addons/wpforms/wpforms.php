<?php

namespace cookiebot_addons\controller\addons\wpforms;

use cookiebot_addons\controller\addons\Cookiebot_Addons_Interface;
use cookiebot_addons\lib\Cookie_Consent_Interface;
use cookiebot_addons\lib\Settings_Service_Interface;
use cookiebot_addons\lib\script_loader_tag\Script_Loader_Tag_Interface;
use cookiebot_addons\lib\buffer\Buffer_Output_Interface;

class Wpforms implements Cookiebot_Addons_Interface {

	/**
	 * @var Settings_Service_Interface
	 *
	 * @since 1.3.0
	 */
	protected $settings;

	/**
	 * @var Script_Loader_Tag_Interface
	 *
	 * @since 1.3.0
	 */
	protected $script_loader_tag;

	/**
	 * @var Cookie_Consent_Interface
	 *
	 * @since 1.3.0
	 */
	public $cookie_consent;

	/**
	 * @var Buffer_Output_Interface
	 *
	 * @since 1.3.0
	 */
	protected $buffer_output;

	/**
	 * Jetpack constructor.
	 *
	 * @param $settings          Settings_Service_Interface
	 * @param $script_loader_tag Script_Loader_Tag_Interface
	 * @param $cookie_consent    Cookie_Consent_Interface
	 * @param $buffer_output     Buffer_Output_Interface
	 *
	 * @since 1.3.0
	 */
	public function __construct( Settings_Service_Interface $settings, Script_Loader_Tag_Interface $script_loader_tag, Cookie_Consent_Interface $cookie_consent, Buffer_Output_Interface $buffer_output ) {
		$this->settings          = $settings;
		$this->script_loader_tag = $script_loader_tag;
		$this->cookie_consent    = $cookie_consent;
		$this->buffer_output     = $buffer_output;
	}

	/**
	 * Loads addon configuration
	 *
	 * @since 1.3.0
	 */
	public function load_configuration() {
		add_action( 'wp_loaded', array( $this, 'cookiebot_addon_wpforms' ), 5 );
	}

	/**
	 * Disable scripts if state not accepted
	 *
	 * @since 1.3.0
	 */
	public function cookiebot_addon_wpforms() {
		add_filter( 'wpforms_disable_entry_user_ip', array( $this, 'gdpr_consent_is_given' ) );
		add_action( 'wp_footer', array( $this, 'enqueue_script_for_adding_the_cookie_after_the_consent' ), 18 );
	}

	/**
	 * Create cookie when the visitor gives consent
	 */
	public function enqueue_script_for_adding_the_cookie_after_the_consent() {
		wp_enqueue_script( 'wpforms-gdpr-cookiebot',
			COOKIEBOT_URL . 'addons/controller/addons/wpforms/cookie-after-consent.js',
			array( 'jquery' ),
			'',
			true );
		wp_localize_script( 'wpforms-gdpr-cookiebot', 'cookiebot_wpforms_settings', array( 'cookie_types' => $this->get_cookie_types() ) );
	}

	/**
	 * Retrieve if the cookie consent is given
	 *
	 * @return bool
	 *
	 * @since 2.1.4
	 */
	public function gdpr_consent_is_given() {
		if ( $this->cookie_consent->are_cookie_states_accepted( $this->get_cookie_types() ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Return addon/plugin name
	 *
	 * @return string
	 *
	 * @since 1.3.0
	 */
	public function get_addon_name() {
		return 'WPForms';
	}

	/**
	 * Default placeholder content
	 *
	 * @return string
	 *
	 * @since 1.8.0
	 */
	public function get_default_placeholder() {
		return 'Please accept [renew_consent]%cookie_types[/renew_consent] cookies to enable saving user information.';
	}

	/**
	 * Get placeholder content
	 *
	 * This function will check following features:
	 * - Current language
	 *
	 * @param $src
	 *
	 * @return bool|mixed
	 *
	 * @since 1.8.0
	 */
	public function get_placeholder( $src = '' ) {
		return $this->settings->get_placeholder( $this->get_option_name(), $this->get_default_placeholder(), cookiebot_addons_output_cookie_types( $this->get_cookie_types() ), $src );
	}

	/**
	 * Option name in the database
	 *
	 * @return string
	 *
	 * @since 1.3.0
	 */
	public function get_option_name() {
		return 'wpforms';
	}

	/**
	 * Plugin file name
	 *
	 * @return string
	 *
	 * @since 1.3.0
	 */
	public function get_plugin_file() {
		return 'wpforms/wpforms.php';
	}

	/**
	 * Returns checked cookie types
	 * @return mixed
	 *
	 * @since 1.3.0
	 */
	public function get_cookie_types() {
		return $this->settings->get_cookie_types( $this->get_option_name(), $this->get_default_cookie_types() );
	}

	/**
	 * Returns default cookie types
	 * @return array
	 *
	 * @since 1.5.0
	 */
	public function get_default_cookie_types() {
		return array( 'preferences' );
	}

	/**
	 * Check if plugin is activated and checked in the backend
	 *
	 * @since 1.3.0
	 */
	public function is_addon_enabled() {
		return $this->settings->is_addon_enabled( $this->get_option_name() );
	}

	/**
	 * Checks if addon is installed
	 *
	 * @since 1.3.0
	 */
	public function is_addon_installed() {
		$installed = $this->settings->is_addon_installed( $this->get_plugin_file() );

		if ( $installed && version_compare( $this->get_addon_version(), '1.5.1', '<' ) ) {
			$installed = false;
		}

		return $installed;
	}

	/**
	 * Checks if addon is activated
	 *
	 * @since 1.3.0
	 */
	public function is_addon_activated() {
		return $this->settings->is_addon_activated( $this->get_plugin_file() );
	}

	/**
	 * Retrieves current installed version of the addon
	 *
	 * @return bool
	 *
	 * @since 2.2.1
	 */
	public function get_addon_version() {
		return $this->settings->get_addon_version( $this->get_plugin_file() );
	}

	/**
	 * Checks if it does have custom placeholder content
	 *
	 * @return mixed
	 *
	 * @since 1.8.0
	 */
	public function has_placeholder() {
		return $this->settings->has_placeholder( $this->get_option_name() );
	}

	/**
	 * returns all placeholder contents
	 *
	 * @return mixed
	 *
	 * @since 1.8.0
	 */
	public function get_placeholders() {
		return $this->settings->get_placeholders( $this->get_option_name() );
	}

	/**
	 * Return true if the placeholder is enabled
	 *
	 * @return mixed
	 *
	 * @since 1.8.0
	 */
	public function is_placeholder_enabled() {
		return $this->settings->is_placeholder_enabled( $this->get_option_name() );
	}

	/**
	 * Adds extra information under the label
	 *
	 * @return string
	 *
	 * @since 1.8.0
	 */
	public function get_extra_information() {
		return 	'<p>' . 
				__( 'If the user gives correct consent, IP and Unique User ID will be saved on form submissions, otherwise not.', 'cookiebot-addons' ) .
				'<br />' .
				__( 'Increases opt-in rate compared to WPForms "GDPR mode".', 'cookiebot-addons' ) .
				'</p>';
	}

	/**
	 * Returns the url of WordPress SVN repository or another link where we can verify the plugin file.
	 *
	 * @return string
	 *
	 * @since 1.8.0
	 */
	public function get_svn_url() {
		return false;
	}

	/**
	 * Placeholder helper overlay in the settings page.
	 *
	 * @return string
	 *
	 * @since 1.8.0
	 */
	public function get_placeholder_helper() {
		return '<p>Merge tags you can use in the placeholder text:</p><ul><li>%cookie_types - Lists required cookie types</li><li>[renew_consent]text[/renew_consent] - link to display cookie settings in frontend</li></ul>';
	}

	/**
	 * Returns parent class or false
	 *
	 * @return string|bool
	 *
	 * @since 2.1.3
	 */
	public function get_parent_class() {
		return get_parent_class( $this );
	}

	/**
	 * Action after enabling the addon on the settings page
	 *
	 * Clear gdpr settings in the wpforms
	 *
	 * @since 2.2.0
	 */
	public function post_hook_after_enabling() {
		$wpforms_settings = get_option( 'wpforms_settings' );

		$wpforms_settings['gdpr']                 = false;
		$wpforms_settings['gdpr-disable-uuid']    = false;
		$wpforms_settings['gdpr-disable-details'] = false;

		update_option( 'wpforms_settings', $wpforms_settings );
	}

	/**
	 * Cookiebot plugin is deactivated
	 *
	 * @since 2.2.0
	 */
	public function plugin_deactivated() {
		// if the checkbox was checked and the cookiebot plugin is deactivated
		// remove the setting so the default gdpr checkboxes are still visible
		$this->wpforms_set_setting( 'gdpr-cookiebot', false );
	}

	/**
	 * Set the value of a specific WPForms setting.
	 *
	 * @since 1.5.0.4
	 *
	 * @param string $key
	 * @param mixed $new_value
	 * @param string $option
	 *
	 * @return mixed
	 */
	public function wpforms_set_setting( $key, $new_value, $option = 'wpforms_settings' ) {

		$key          = wpforms_sanitize_key( $key );
		$options      = get_option( $option, false );
		$option_value = is_array( $options ) && ! empty( $options[ $key ] ) ? $options[ $key ] : false;

		if ( $new_value !== $option_value ) {
			$options[ $key ] = $new_value;
		}

		update_option( $option, $options );
	}
}
