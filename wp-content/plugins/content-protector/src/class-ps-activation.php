<?php
namespace passster;
class PS_Activation {
	/**
	 * Initialize activation
	 */
	public static function init() {
		register_activation_hook( __FILE__, array( __CLASS__, 'activate' ) );
		add_filter( 'plugin_action_links_' . PASSSTER_PLUGIN_BASENAME, array( __CLASS__, 'plugin_action_links' ) );
	}
	/**
	 * Add plugin actions links for settings page
	 *
	 * @param array $links admin links.
	 *
	 * @return array
	 */
	public static function plugin_action_links( $links ) {
		$action_links = array(
			'settings' => '<a href="' . admin_url( 'options-general.php?page=passster_settings' ) . '" aria-label="' . esc_attr__( 'View Passster settings', 'content-protector' ) . '">' . esc_html__( 'Settings', 'content-protector' ) . '</a>',
		);
		return array_merge( $action_links, $links );
	}
	/**
	 * Check conditions before activate
	 */
	public function activate() {
		global $wp_version;
		$php = '5.6';
		$wp  = '4.1';
		if ( version_compare( PHP_VERSION, $php, '<' ) ) {
			deactivate_plugins( basename( __FILE__ ) );
			wp_die(
				'<p>' .
				sprintf(
					__( 'This plugin can not be activated because it requires a PHP version greater than %1$s. Your PHP version can be updated by your hosting company.', 'content-protector' ),
					$php
				)
				. '</p> <a href="' . admin_url( 'plugins.php' ) . '">' . __( 'go back', 'content-protector' ) . '</a>'
			);
		}
		if ( version_compare( $wp_version, $wp, '<' ) ) {
			deactivate_plugins( basename( __FILE__ ) );
			wp_die(
				'<p>' .
				sprintf(
					__( 'This plugin can not be activated because it requires a WordPress version greater than %1$s. Please go to Dashboard &#9656; Updates to gran the latest version of WordPress .', 'content-protector' ),
					$php
				)
				. '</p> <a href="' . admin_url( 'plugins.php' ) . '">' . __( 'go back', 'content-protector' ) . '</a>'
			);
		}
	}
}
