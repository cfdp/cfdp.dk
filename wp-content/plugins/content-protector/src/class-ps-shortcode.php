<?php

namespace passster;

use  Phpass\Hash ;
class PS_Shortcode
{
    /**
     * Constructor for PS_Shortcode
     */
    public function __construct()
    {
        add_shortcode( 'content_protector', array( $this, 'render_shortcode' ) );
        add_shortcode( 'passster', array( $this, 'render_shortcode' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'add_scripts' ) );
    }
    
    /**
     * Get instance of PS_Shortcode
     *
     * @return object
     */
    public static function get_instance()
    {
        $shortcode = new PS_Shortcode();
        return $shortcode;
    }
    
    /**
     * Render the passster shortcode
     *
     * @param array  $atts array of attributes.
     * @param string $content current page content.
     * @return string
     */
    public function render_shortcode( $atts, $content = null )
    {
        /* user input */
        $output = $content;
        $wrong_password = apply_filters( 'passster_error_message', '<span class="passster-error">' . get_theme_mod( 'passster_form_error_message_text', __( 'Something went wrong. Please try again.', 'content-protector' ) ) . '</span>' );
        /* single password */
        
        if ( isset( $atts['password'] ) ) {
            $hash = new Hash();
            $admin_pass = $hash->hashPassword( $atts['password'] );
            $form = PS_Form::get_password_form();
            $output = $this->check_atts( $atts, $output, $form );
            
            if ( isset( $atts['auth'] ) ) {
                $output = str_replace( 'passster_password', $atts['auth'], $output );
                $auth = $atts['auth'];
            } else {
                $auth = 'passster_password';
            }
            
            
            if ( true === PS_Helper::is_user_valid( $atts ) ) {
                $output = $content;
            } elseif ( true === PS_Helper::is_cookie_valid( $hash, $admin_pass ) ) {
                $output = $content;
            } elseif ( isset( $_POST[$auth] ) && !empty($_POST[$auth]) ) {
                $output = str_replace( '[PASSSTER_ERROR_MESSAGE]', $wrong_password, $output );
                if ( $hash->checkPassword( sanitize_text_field( $_POST[$auth] ), $admin_pass ) === true ) {
                    $output = apply_filters( 'passster_content', $content );
                }
            } else {
                $output = str_replace( '[PASSSTER_ERROR_MESSAGE]', '', $output );
            }
            
            
            if ( isset( $atts['auth'] ) ) {
                PS_Helper::set_amp_headers( $atts['auth'], $atts['password'] );
            } else {
                PS_Helper::set_amp_headers( 'passster_password', $atts['password'] );
            }
        
        }
        
        /* captcha */
        if ( true === PS_Helper::is_addon_active( 'captcha' ) ) {
            
            if ( isset( $atts['captcha'] ) && 'captcha' == $atts['captcha'] ) {
                
                if ( isset( $atts['auth'] ) ) {
                    $output = str_replace( 'passster_captcha', $atts['auth'], $output );
                    $auth = $atts['auth'];
                } else {
                    $auth = 'passster_captcha';
                }
                
                $captcha = new PS_Captcha();
                $output = $content;
                if ( false === PS_Helper::is_user_valid( $atts ) ) {
                    
                    if ( !isset( $_POST[$auth] ) || sanitize_text_field( $_POST[$auth] ) !== $_SESSION['phrase'] ) {
                        $_SESSION['phrase'] = $captcha->captcha->getPhrase();
                        $form = PS_Form::get_captcha_form( $captcha->captcha_img );
                        $output = $this->check_atts( $atts, $output, $form );
                    }
                
                }
            }
        
        }
        if ( strpos( $output, 'passster-form' ) === false ) {
            $output = apply_filters( 'the_content', $output );
        }
        return $output;
    }
    
    /**
     * Check attributes and modify placeholders based on arguments
     *
     * @param array  $atts array of attributes.
     * @param string $output output content.
     * @param string $form current form.
     * @return string
     */
    public function check_atts( $atts, $output, $form )
    {
        
        if ( isset( $atts['placeholder'] ) ) {
            $form = str_replace( '[PASSSTER_PLACEHOLDER]', $atts['placeholder'], $form );
        } else {
            
            if ( isset( $atts['captcha'] ) ) {
                $form = str_replace( '[PASSSTER_PLACEHOLDER]', __( 'Captcha Code', 'content-protector' ), $form );
            } else {
                $form = str_replace( '[PASSSTER_PLACEHOLDER]', __( 'Password', 'content-protector' ), $form );
            }
        
        }
        
        
        if ( isset( $atts['id'] ) ) {
            $id = 'id="' . $atts['id'] . '"';
            $form = str_replace( '[PASSSTER_ID]', $id, $form );
        } else {
            $form = str_replace( '[PASSSTER_ID]', '', $form );
        }
        
        if ( isset( $atts['button'] ) ) {
            $form = str_replace( get_theme_mod( 'passster_form_button_label', __( 'Submit', 'content-protector' ) ), $atts['button'], $form );
        }
        if ( isset( $atts['headline'] ) ) {
            $form = str_replace( get_theme_mod( 'passster_form_instructions_headline', __( 'Protected Area', 'content-protector' ) ), $atts['headline'], $form );
        }
        if ( isset( $atts['instruction'] ) ) {
            $form = str_replace( get_theme_mod( 'passster_form_instructions_text', __( 'This content is password-protected. Please verify with a password to unlock the content.', 'content-protector' ) ), $atts['instruction'], $form );
        }
        
        if ( isset( $atts['hide'] ) && true == $atts['hide'] ) {
            $form = str_replace( '[PASSSTER_HIDE]', ' passster-hide', $form );
        } else {
            $form = str_replace( '[PASSSTER_HIDE]', '', $form );
        }
        
        return $form;
    }
    
    /**
     * Enqueue scripts for shortcode
     *
     * @return void
     */
    public function add_scripts()
    {
        $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min' );
        if ( !is_admin() ) {
            wp_enqueue_style(
                'passster-css',
                PASSSTER_URL . '/assets/public/passster' . $suffix . '.css',
                '3.2',
                'all'
            );
        }
        $cookie_options = get_option( 'passster_advanced_settings' );
        
        if ( !empty($cookie_options) && 'on' == $cookie_options['toggle_cookie'] ) {
            wp_enqueue_script(
                'cookie',
                PASSSTER_URL . '/assets/public/cookie' . $suffix . '.js',
                array( 'jquery' ),
                '3.2',
                false
            );
            wp_enqueue_script(
                'passster-cookie',
                PASSSTER_URL . '/assets/public/passster-cookie' . $suffix . '.js',
                array( 'jquery', 'cookie' ),
                '3.2',
                false
            );
            wp_localize_script( 'passster-cookie', 'passster_cookie', array(
                'url'        => admin_url() . 'admin-ajax.php',
                'days'       => intval( $cookie_options['passster_cookie_duration'] ),
                'use_cookie' => $cookie_options['toggle_cookie'],
            ) );
        }
        
        if ( isset( $cookie_options['toggle_amp'] ) && 'on' == $cookie_options['toggle_amp'] ) {
            wp_enqueue_script(
                'passster-amp',
                'https://cdn.ampproject.org/v0/amp-form-0.1.js',
                array( 'jquery' ),
                '3.2',
                false
            );
        }
        $password_typing = get_theme_mod( 'passster_form_instructions_password_typing' );
        if ( isset( $password_typing ) && true === $password_typing ) {
            wp_enqueue_script(
                'password-typing',
                PASSSTER_URL . '/assets/public/password-typing' . $suffix . '.js',
                array( 'jquery' ),
                '3.2',
                false
            );
        }
    }

}