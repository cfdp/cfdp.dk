<?php

/*
Plugin Name: Passster
Text Domain: content-protector
Description: Plugin to password-protect portions of a Page or Post.
Author: patrickposner
Version: 3.2.2
*/
define( 'PASSSTER_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'PASSSTER_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( 'PASSSTER_ABSPATH', dirname( __FILE__ ) . DIRECTORY_SEPARATOR );
define( 'PASSSTER_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );
/* load setup */
require_once PASSSTER_ABSPATH . 'inc' . DIRECTORY_SEPARATOR . 'setup.php';
/* localize */
$textdomain_dir = plugin_basename( dirname( __FILE__ ) ) . '/languages';
load_plugin_textdomain( 'content-protector', false, $textdomain_dir );
/* boot autoloader */
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
    require __DIR__ . '/vendor/autoload.php';
}
/* setup main classes */
passster\PS_Admin::init();
passster\PS_Activation::init();
passster\PS_Shortcode::get_instance();
passster\PS_Form::get_instance();
passster\PS_Customizer::get_instance();

if ( true === passster\PS_Helper::is_addon_active( 'captcha' ) ) {
    passster\PS_Session::get_instance();
    passster\DatabaseHandler::createTable();
}

/* setup pagebuilder modules */
if ( is_plugin_active( 'beaver-builder-lite-version/fl-builder.php' ) || is_plugin_active( 'bb-plugin/fl-builder.php' ) ) {
    require_once PASSSTER_PATH . '/src/addons/pagebuilder/beaverbuilder/class-ps-beaver-loader.php';
}
if ( is_plugin_active( 'elementor/elementor.php' ) ) {
    require_once PASSSTER_ABSPATH . 'src/addons/pagebuilder/elementor/class-ps-elementor.php';
}
if ( is_plugin_active( 'js_composer/js_composer.php' ) ) {
    require_once PASSSTER_ABSPATH . 'src/addons/pagebuilder/visual-composer/visual-composer-setup.php';
}