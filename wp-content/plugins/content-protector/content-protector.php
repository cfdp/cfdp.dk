<?php

/*
Plugin Name: Passster
Text Domain: content-protector
Description: Plugin to password-protect portions of a Page or Post.
Author: patrickposner
Version: 3.1.9
@fs_premium_only /src/addons/pagebuilder, /src/templates/recaptcha-form.php
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
/* dabase upgrade for updating from 3.1.3 */
add_action(
    'upgrader_process_complete',
    'create_table_on_upgrade',
    10,
    2
);
function create_table_on_upgrade( $upgrader_object, $options )
{
    $old_db_version = get_option( 'sm_session_db_version', '0.0' );
    if ( isset( $old_db_version ) ) {
        delete_option( 'sm_session_db_version' );
    }
    $passster_plugin = plugin_basename( __FILE__ );
    if ( $options['action'] == 'update' && $options['type'] == 'plugin' && isset( $options['plugins'] ) ) {
        foreach ( $options['plugins'] as $plugin ) {
            
            if ( $plugin == $passster_plugin ) {
                $current_db_version = '0.1';
                $created_db_version = get_option( 'sm_session_db_version', '0.0' );
                
                if ( version_compare( $created_db_version, $current_db_version, '<' ) ) {
                    global  $wpdb ;
                    $collate = '';
                    if ( $wpdb->has_cap( 'collation' ) ) {
                        $collate = $wpdb->get_charset_collate();
                    }
                    $table = "CREATE TABLE {$wpdb->prefix}sm_sessions (\n\t\t\t\t  session_id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,\n\t\t\t\t  session_key char(32) NOT NULL,\n\t\t\t\t  session_value LONGTEXT NOT NULL,\n\t\t\t\t  session_expiry BIGINT(20) UNSIGNED NOT NULL,\n\t\t\t\t  PRIMARY KEY  (session_key),\n\t\t\t\t  UNIQUE KEY session_id (session_id)\n\t\t\t\t) {$collate};";
                    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
                    dbDelta( $table );
                    add_option(
                        'sm_session_db_version',
                        '0.1',
                        '',
                        'no'
                    );
                    // Nuke any legacy sessions from the options table.
                    OptionsHandler::deleteAll();
                }
            
            }
        
        }
    }
}

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
    require __DIR__ . '/vendor/autoload.php';
}
passster\PS_Admin::init();
passster\PS_Activation::init();
passster\PS_Shortcode::get_instance();
passster\PS_Form::get_instance();
passster\PS_Customizer::get_instance();
passster\PS_Session::get_instance();