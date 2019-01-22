<?php

namespace passster;

class PS_Admin
{
    public static function init()
    {
        add_action( 'admin_enqueue_scripts', array( __CLASS__, 'add_admin_scripts' ) );
        add_action( 'admin_footer', array( __CLASS__, 'add_pro_box' ) );
        
        if ( get_option( 'passster_admin_notice_shown' ) != 'on' ) {
            add_action( 'admin_notices', array( __CLASS__, 'passster_admin_notice' ) );
            add_action( 'admin_enqueue_scripts', array( __CLASS__, 'passster_backend_script_notices' ) );
            add_action( 'wp_ajax_passster_dismiss_notice', array( __CLASS__, 'passster_backend_script_dismiss_notices' ) );
        }
        
        $settings = new PS_Settings();
        $settings->add_section( array(
            'id'    => 'passster_shortcode',
            'title' => __( 'Shortcode', 'content-protector' ),
        ) );
        $settings->add_field( 'passster_shortcode', array(
            'id'   => 'passster_shortcode_introduction',
            'type' => 'documentation',
            'desc' => __( 'Use this little tool to <b>generate your shortcode</b>. Simply fill out the fields, save your changes and copy your shortcode. It <b>does not</b> influence your current shortcodes. ', 'content-protector' ),
            'name' => __( 'Shortcode Generator', 'content-protector' ),
        ) );
        $settings->add_field( 'passster_shortcode', array(
            'id'      => 'passster_shortcode_protection_type',
            'type'    => 'select',
            'name'    => __( 'Protection Type', 'content-protector' ),
            'options' => array(
            'password' => 'Password',
            'captcha'  => 'Captcha',
        ),
        ) );
        $settings->add_field( 'passster_shortcode', array(
            'id'          => 'passster_shortcode_password',
            'type'        => 'passwordgenerator',
            'name'        => __( 'Password', 'content-protector' ),
            'desc'        => __( 'Add your Shortcode Password', 'content-protector' ),
            'placeholder' => 'your-password',
        ) );
        $settings->add_field( 'passster_shortcode', array(
            'id'   => 'passster_shortcode_generator',
            'type' => 'shortcode',
            'name' => '<h3 style="color:#4998b3;">' . __( 'Copy shortcode', 'content-protector' ) . '</h3>',
        ) );
        $settings->add_section( array(
            'id'    => 'passster_captcha',
            'title' => __( 'Captcha', 'content-protector' ),
        ) );
        $settings->add_field( 'passster_captcha', array(
            'id'      => 'passster_captcha_code_length',
            'type'    => 'number',
            'name'    => __( 'Captcha Code Length', 'content-protector' ),
            'desc'    => __( 'Length of the generated code. For example 4 means a Code like "A2cD"', 'content-protector' ),
            'default' => '2',
        ) );
        $settings->add_field( 'passster_captcha', array(
            'id'      => 'passster_captcha_width',
            'type'    => 'number',
            'name'    => __( 'Width', 'content-protector' ),
            'desc'    => __( 'Width of the captcha image', 'content-protector' ),
            'default' => '130',
        ) );
        $settings->add_field( 'passster_captcha', array(
            'id'      => 'passster_captcha_height',
            'type'    => 'number',
            'name'    => __( 'Height', 'content-protector' ),
            'desc'    => __( 'Height of the captcha image', 'content-protector' ),
            'default' => '80',
        ) );
        $settings->add_field( 'passster_captcha', array(
            'id'      => 'passster_captcha_use_numbers_only',
            'type'    => 'toggle',
            'default' => 'off',
            'name'    => __( 'Use only numbers', 'content-protector' ),
        ) );
        $settings->add_section( array(
            'id'    => 'passster_addons',
            'title' => __( 'Addons', 'content-protector' ),
        ) );
        $settings->add_field( 'passster_addons', array(
            'id'   => 'passster_addons_information',
            'type' => 'documentation',
            'desc' => __( 'All Addons are included in the <b>pro version of Passster</b>. Activate and use the advanced features to get the maximum of out of content protection.', 'content-protector' ),
            'name' => __( 'Explanation', 'content-protector' ),
        ) );
        $settings->add_field( 'passster_addons', array(
            'id'   => 'passster_addons_multiple_passwords',
            'type' => 'title',
            'name' => '<h3>' . __( 'Multiple Passwords', 'content-protector' ) . '</h3>',
        ) );
        $settings->add_field( 'passster_addons', array(
            'id'   => 'passster_addons_multiple_passwords_documentation',
            'type' => 'documentation',
            'desc' => __( 'The Multiple Passwords Addon allows you to add multiple passwords per shortcode. You could also use the Password Generator with this addon.', 'content-protector' ),
            'name' => __( 'Description', 'content-protector' ),
        ) );
        $settings->add_field( 'passster_addons', array(
            'id'      => 'passster_addons_multiple_passwords_toggle',
            'type'    => 'toggle',
            'default' => 'off',
            'name'    => __( 'Activate Multiple Passwords', 'content-protector' ),
            'premium' => 'premium',
        ) );
        $settings->add_field( 'passster_addons', array(
            'id'   => 'passster_addons_users',
            'type' => 'title',
            'name' => '<h3>' . __( 'Users', 'content-protector' ) . '</h3>',
        ) );
        $settings->add_field( 'passster_addons', array(
            'id'   => 'passster_addons_users_documentation',
            'type' => 'documentation',
            'desc' => __( 'The User Addon add a role and and a user parameter to the passster shortcode. So specified users roles or users can bypass the content protection. Great for memberships or any kind of account based restriction.', 'content-protector' ),
            'name' => __( 'Description', 'content-protector' ),
        ) );
        $settings->add_field( 'passster_addons', array(
            'id'      => 'passster_addons_users_toggle',
            'type'    => 'toggle',
            'default' => 'off',
            'name'    => __( 'Activate Users', 'content-protector' ),
            'premium' => 'premium',
        ) );
        $settings->add_field( 'passster_addons', array(
            'id'   => 'passster_addons_recaptcha',
            'type' => 'title',
            'name' => '<h3>' . __( 'Google ReCaptcha', 'content-protector' ) . '</h3>',
        ) );
        $settings->add_field( 'passster_addons', array(
            'id'   => 'passster_addons_recaptcha_documentation',
            'type' => 'documentation',
            'desc' => __( 'Let users unlock your protected content with Google ReCaptcha. Simply add your API Key and use the Shortcode Generator to generate the shortcode.', 'content-protector' ),
            'name' => __( 'Description', 'content-protector' ),
        ) );
        $settings->add_field( 'passster_addons', array(
            'id'      => 'passster_addons_recaptcha_toggle',
            'type'    => 'toggle',
            'default' => 'off',
            'name'    => __( 'Activate Google ReCaptcha', 'content-protector' ),
            'premium' => 'premium',
        ) );
        $settings->add_field( 'passster_addons', array(
            'id'   => 'passster_addons_link',
            'type' => 'title',
            'name' => '<h3>' . __( 'Unlock via Link', 'content-protector' ) . '</h3>',
        ) );
        $settings->add_field( 'passster_addons', array(
            'id'   => 'passster_addons_link_documentation',
            'type' => 'documentation',
            'desc' => __( 'Let users unlock your protected content with a link. The passwords are always encrypted in your URL. Additionally you can use your bit.ly account to automatically shorten your link.', 'content-protector' ),
            'name' => __( 'Description', 'content-protector' ),
        ) );
        $settings->add_field( 'passster_addons', array(
            'id'      => 'passster_addons_link_toggle',
            'type'    => 'toggle',
            'default' => 'off',
            'name'    => __( 'Activate Unlock via Link', 'content-protector' ),
            'premium' => 'premium',
        ) );
        $settings->add_section( array(
            'id'    => 'passster_advanced_settings',
            'title' => __( 'Options', 'content-protector' ),
        ) );
        $settings->add_field( 'passster_advanced_settings', array(
            'id'   => 'passster_advanced_cookie_title',
            'type' => 'title',
            'name' => '<h3>' . __( 'Cookie', 'content-protector' ) . '</h3>',
        ) );
        $settings->add_field( 'passster_advanced_settings', array(
            'id'      => 'toggle_cookie',
            'type'    => 'toggle',
            'default' => 'off',
            'name'    => __( 'Use Cookie', 'content-protector' ),
        ) );
        $settings->add_field( 'passster_advanced_settings', array(
            'id'      => 'passster_cookie_duration',
            'type'    => 'text',
            'name'    => __( 'Cookie Duration', 'content-protector' ),
            'desc'    => __( 'Duration (in days) for your cookie. Once a cookie expires, the user will have to enter the password again.', 'content-protector' ),
            'default' => '2',
        ) );
        $settings->add_field( 'passster_advanced_settings', array(
            'id'   => 'passster_advanced_delete_title',
            'type' => 'title',
            'name' => '<h3>' . __( 'Uninstall', 'content-protector' ) . '</h3>',
        ) );
        $settings->add_field( 'passster_advanced_settings', array(
            'id'   => 'passster_advanced_delete_options',
            'type' => 'checkbox',
            'name' => __( 'Delete Plugin Options On Uninstall', 'content-protector' ),
            'desc' => __( 'If checked, all plugin options will be deleted if the plugin is unstalled.', 'content-protector' ),
        ) );
    }
    
    public static function add_admin_scripts()
    {
        $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min' );
        wp_enqueue_style( 'passster-admin', PASSSTER_URL . '/assets/admin/passster-admin.css' );
        wp_enqueue_script( 'passster-admin', PASSSTER_URL . '/assets/admin/passster-admin' . $suffix . '.js', array( 'jquery' ) );
    }
    
    public static function add_pro_box()
    {
        $current_screen = get_current_screen();
        ?>

		<?php 
        
        if ( 'settings_page_passster_settings' === $current_screen->base ) {
            ?>
			<div class="passster-pro-box">
				<h3><?php 
            _e( 'Want to be a Pro?', 'content-protector' );
            ?></h3>
				<ul>
					<li><?php 
            _e( 'Multiple Passwords', 'content-protector' );
            ?></li>
					<li><?php 
            _e( 'Google Recaptcha', 'content-protector' );
            ?></li>
					<li><?php 
            _e( 'Unlock via Link', 'content-protector' );
            ?></li>
					<li><?php 
            _e( 'bit.ly URL Shortener', 'content-protector' );
            ?></li>
					<li><?php 
            _e( 'All future addons', 'content-protector' );
            ?></li>
					<li><?php 
            _e( 'Awesome Support', 'content-protector' );
            ?></li>
				</ul>
				<a href="https://passster.io" target="_blank"><?php 
            _e( 'Get it now', 'content-protector' );
            ?></a>
			</div>
			<div class="passster-pro-box-2">
				<h3><?php 
            _e( 'Need help?', 'content-protector' );
            ?></h3>
				<p><?php 
            _e( 'We have added an extensive documention for every detail on the configuration of passster.', 'content-protector' );
            ?></p>
				<a href="https://passster.io/documentation/" target="_blank"><?php 
            _e( 'Read the Docs', 'content-protector' );
            ?></a>
			</div>
		<?php 
        }
        
        ?>

		<?php 
    }
    
    /**
     * Add admin notice
     *
     * @return void
     */
    public static function passster_admin_notice()
    {
        $query['autofocus[panel]'] = 'passster';
        $panel_link = add_query_arg( $query, admin_url( 'customize.php' ) );
        $text = sprintf( __( 'Thanks for using <b>Passster</b>! After adding a shortcode to your content you can begin to modify text and design settings of Passster in your <a href="%s">customizer</a>.', 'content-protector' ), $panel_link );
        
        if ( !empty($text) ) {
            ?>
			<div class="notice notice-warning is-dismissible passster-notice">
				<p><?php 
            echo  $text ;
            ?></p>
			</div>
			<?php 
        }
    
    }
    
    /**
     * Add admin notice script
     *
     * @return void
     */
    public static function passster_backend_script_notices()
    {
        $min = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : 'min.' );
        wp_enqueue_script(
            'passster-admin-notices',
            PASSSTER_URL . '/assets/admin/passster-admin-notice.' . $min . 'js',
            array( 'jquery' ),
            wp_get_theme()->get( 'Version' )
        );
        wp_localize_script( 'passster-admin-notices', 'admin_notice_ajax_object', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
        ) );
    }
    
    /**
     * Remove admin notice and save option for deactivation
     *
     * @return void
     */
    public static function passster_backend_script_dismiss_notices()
    {
        update_option( 'passster_admin_notice_shown', 'on' );
        exit;
    }

}