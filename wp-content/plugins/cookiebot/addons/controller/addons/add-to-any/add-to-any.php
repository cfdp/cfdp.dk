<?php

namespace cookiebot_addons\controller\addons\add_to_any;

use cookiebot_addons\controller\addons\Cookiebot_Addons_Interface;
use cookiebot_addons\lib\Cookie_Consent_Interface;
use cookiebot_addons\lib\Settings_Service_Interface;
use cookiebot_addons\lib\script_loader_tag\Script_Loader_Tag_Interface;
use cookiebot_addons\lib\buffer\Buffer_Output_Interface;

class Add_To_Any implements Cookiebot_Addons_Interface {
	
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
	protected $cookie_consent;
	
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
		add_action( 'wp_loaded', array( $this, 'cookiebot_addon_add_to_any' ), 5 );
	}
	
	/**
	 * Disable scripts if state not accepted
	 *
	 * @since 1.3.0
	 */
	public function cookiebot_addon_add_to_any() {
		// Check if Add To Any is loaded.
		if ( ! function_exists( 'A2A_SHARE_SAVE_init' ) ) {
			return;
		}
		
		// Check if Cookiebot is activated and active.
		if ( ! function_exists( 'cookiebot_active' ) || ! cookiebot_active() ) {
			return;
		}
		
		// consent is given
		if ( $this->cookie_consent->are_cookie_states_accepted( $this->get_cookie_types() ) ) {
			return;
		}
		
		if( $this->is_remove_tag_enabled() ) {
			add_filter( 'addtoany_script_disabled', '__return_true' );
			
			/**
			 * Block head script
			 */
			if ( has_action( 'wp_head', 'A2A_SHARE_SAVE_head_script' ) ) {
				remove_action( 'wp_head', 'A2A_SHARE_SAVE_head_script' );
			}
			
			/**
			 * Block footer script
			 */
			if ( has_action( 'wp_footer', 'A2A_SHARE_SAVE_footer_script' ) ) {
				remove_action( 'wp_footer', 'A2A_SHARE_SAVE_footer_script' );
			}
			
			/**
			 * Block content addition
			 */
			if ( has_action( 'pre_get_posts', 'A2A_SHARE_SAVE_pre_get_posts' ) ) {
				remove_action( 'pre_get_posts', 'A2A_SHARE_SAVE_pre_get_posts' );
			}
		} else {
			$this->buffer_output->add_tag( 'wp_head', 10, array(
				'data-cfasync' => $this->get_cookie_types(),
				'addtoany' => $this->get_cookie_types()
			), false );

			$this->buffer_output->add_tag( 'wp_footer', 10, array(
				'data-cfasync' => $this->get_cookie_types(),
				'addtoany' => $this->get_cookie_types()
			), false );

			$this->buffer_output->add_tag( 'pre_get_posts', 10, array(
				'GoogleAnalyticsObject' => $this->get_cookie_types(),
			), false );
		}
		
		// External js, so manipulate attributes
		if ( has_action( 'wp_enqueue_scripts', 'A2A_SHARE_SAVE_enqueue_script' ) ) {
			$this->script_loader_tag->add_tag( 'addtoany', $this->get_cookie_types() );
		}
	}
	
	/**
	 * Return addon/plugin name
	 *
	 * @return string
	 *
	 * @since 1.3.0
	 */
	public function get_addon_name() {
		return 'addToAny Share Buttons';
	}
	
	/**
	 * Default placeholder content
	 *
	 * @return string
	 *
	 * @since 1.8.0
	 */
	public function get_default_placeholder() {
		return 'Please accept [renew_consent]%cookie_types[/renew_consent] cookies to enable Social Share buttons.';
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
		return 'add_to_any';
	}
	
	/**
	 * Plugin file name
	 *
	 * @return string
	 *
	 * @since 1.3.0
	 */
	public function get_plugin_file() {
		return 'add-to-any/add-to-any.php';
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
		return array( 'marketing', 'statistics' );
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
		return $this->settings->is_addon_installed( $this->get_plugin_file() );
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
		return '<p>' . __( 'Blocks embedded videos from Youtube, Twitter, Vimeo and Facebook.', 'cookiebot-addons' ) . '</p>';
	}
	
	/**
	 * Returns the url of WordPress SVN repository or another link where we can verify the plugin file.
	 *
	 * @return string
	 *
	 * @since 1.8.0
	 */
	public function get_svn_url() {
		return 'http://plugins.svn.wordpress.org/add-to-any/trunk/add-to-any.php';
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
	 * Returns true if addon has an option to remove tag instead of adding attributes
	 *
	 * @return boolean
	 *
	 * @since 2.1.0
	 */
	public function has_remove_tag_option() {
		return true;
	}
	
	/**
	 * Return true if the remove tag option is enabled
	 *
	 * @return mixed
	 *
	 * @since 2.1.0
	 */
	public function is_remove_tag_enabled() {
		return $this->settings->is_remove_tag_enabled( $this->get_option_name() );
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
}
