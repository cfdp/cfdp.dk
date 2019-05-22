<?php

namespace cookiebot_addons\controller;

use cookiebot_addons\controller\addons\Cookiebot_Addons_Interface;
use cookiebot_addons\lib\buffer\Buffer_Output_Interface;
use cookiebot_addons\lib\Settings_Service_Interface;

class Plugin_Controller {

	/**
	 * IoC container - Dependency Injection
	 *
	 * @var Settings_Service_Interface
	 *
	 * @since 1.1.0
	 */
	private $settings_service;

	/**
	 * Plugin_Controller constructor.
	 *
	 * @param $settings_service  Settings_Service_Interface IoC Container
	 *
	 * @since 1.2.0
	 */
	public function __construct( Settings_Service_Interface $settings_service ) {
		$this->settings_service = $settings_service;

		$this->load_init_files();
	}

	/**
	 * Load init files to use 'validate_plugin' and 'is_plugin_active'
	 *
	 * @since 1.3.0
	 */
	protected function load_init_files() {
		if ( ! function_exists( 'is_plugin_active' ) ) {
			require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
			require_once( ABSPATH . '/wp-includes/l10n.php' );
			require_once( ABSPATH . '/wp-admin/includes/translation-install.php' );
		}
	}

	/**
	 *  Load addon configuration if the plugin is activated
	 *
	 * @throws \DI\DependencyException
	 * @throws \DI\NotFoundException
	 *
	 * @version 1.3.0
	 * @since 1.2.0
	 */
	public function load_active_addons() {
		/**
		 * Check if Cookiebot is activated and active. Return if cookiebot is inactive
		 */
		if ( ! function_exists( 'cookiebot_active' ) || ! cookiebot_active() ) {
			return;
		}
		
		/**
		 * Check plugins one by one and load configuration if it is active
		 *
		 * @var $plugin Cookiebot_Addons_Interface
		 */
		foreach ( $this->settings_service->get_active_addons() as $plugin ) {
			if ( ! $plugin->cookie_consent->are_cookie_states_accepted( $plugin->get_cookie_types() )
				|| cookiebot_addons_enabled_cache_plugin() ) {
				$plugin->load_configuration();
			}
		}

		/**
		 * After WordPress is fully loaded
		 *
		 * Run buffer output actions - this runs after scanning of every addons
		 */
		add_action( 'parse_request', array( $this, 'run_buffer_output_manipulations' ) );
	}

	/**
	 * Runs every added action hooks to manipulate script tag
	 *
	 * @since 1.3.0
	 */
	public function run_buffer_output_manipulations() {
		/**
		 * @var $buffer_output Buffer_Output_Interface
		 */
		$buffer_output = $this->settings_service->container->get( 'Buffer_Output_Interface' );

		if ( $buffer_output->has_action() ) {
			$buffer_output->run_actions();
		}
	}
}
