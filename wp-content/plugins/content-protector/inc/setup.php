<?php

// Create a helper function for easy SDK access.
function ps_fs()
{
    global  $ps_fs ;
    
    if ( !isset( $ps_fs ) ) {
        // Include Freemius SDK.
        require_once dirname( __FILE__ ) . '/freemius/start.php';
        $ps_fs = fs_dynamic_init( array(
            'id'             => '1938',
            'slug'           => 'content-protector',
            'type'           => 'plugin',
            'public_key'     => 'pk_9d9d6d17bd34372b199f36e37dd4b',
            'is_premium'     => false,
            'has_addons'     => false,
            'has_paid_plans' => true,
            'menu'           => array(
            'slug'           => 'passster_settings',
            'override_exact' => true,
            'contact'        => false,
            'support'        => false,
            'parent'         => array(
            'slug' => 'options-general.php',
        ),
        ),
            'is_live'        => true,
        ) );
    }
    
    return $ps_fs;
}

// Init Freemius.
ps_fs();
// Signal that SDK was initiated.
do_action( 'ps_fs_loaded' );
function ps_fs_settings_url()
{
    return admin_url( 'options-general.php?page=passster_settings' );
}

ps_fs()->add_filter( 'connect_url', 'ps_fs_settings_url' );
ps_fs()->add_filter( 'after_skip_url', 'ps_fs_settings_url' );
ps_fs()->add_filter( 'after_connect_url', 'ps_fs_settings_url' );
ps_fs()->add_filter( 'after_pending_connect_url', 'ps_fs_settings_url' );
function passster_cleanup()
{
    $advanced_options = get_option( 'passster_advanced_settings' );
    if ( isset( $advanced_options ) ) {
        
        if ( 'on' === $advanced_options['passster_advanced_delete_options'] ) {
            $options = array(
                'passster_shortcode',
                'passster_captcha',
                'passster_link',
                'passster_advanced_settings',
                'passster_addons',
                'sm_session_db_version'
            );
            
            if ( is_multisite() ) {
                foreach ( $options as $option ) {
                    delete_site_option( $option );
                }
            } else {
                foreach ( $options as $option ) {
                    delete_option( $option );
                }
            }
        
        }
    
    }
}

ps_fs()->add_action( 'after_uninstall', 'passster_cleanup' );