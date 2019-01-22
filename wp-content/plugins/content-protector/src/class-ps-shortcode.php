<?php

namespace passster;

use  Phpass\Hash ;
class PS_Shortcode
{
    public function __construct()
    {
        add_shortcode( 'content_protector', array( $this, 'render_shortcode' ) );
        add_shortcode( 'passster', array( $this, 'render_shortcode' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'add_scripts' ) );
    }
    
    public static function get_instance()
    {
        new PS_Shortcode();
    }
    
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
        
        }
        
        /* captcha */
        
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
        
        if ( strpos( $output, 'passster-form' ) === false ) {
            $output = apply_filters( 'the_content', $output );
        }
        return $output;
    }
    
    /**
     * check attributes and modify placeholders based on arguments
     *
     * @param array  $atts
     * @param string $output
     * @param string $form
     * @return void
     */
    public function check_atts( $atts, $output, $form )
    {
        
        if ( isset( $atts['placeholder'] ) ) {
            $output = str_replace( '[PASSSTER_PLACEHOLDER]', $atts['placeholder'], $form );
        } else {
            $output = str_replace( '[PASSSTER_PLACEHOLDER]', __( 'Password', 'content-protector' ), $form );
        }
        
        
        if ( isset( $atts['id'] ) ) {
            $id = 'id="' . $atts['id'] . '"';
            $output = str_replace( '[PASSSTER_ID]', $id, $output );
        } else {
            $output = str_replace( '[PASSSTER_ID]', '', $output );
        }
        
        if ( isset( $atts['button'] ) ) {
            $output = str_replace( get_theme_mod( 'passster_form_button_label', __( 'Submit', 'content-protector' ) ), $atts['button'], $output );
        }
        if ( isset( $atts['headline'] ) ) {
            $output = str_replace( get_theme_mod( 'passster_form_instructions_headline', __( 'Protected Area', 'content-protector' ) ), $atts['headline'], $output );
        }
        if ( isset( $atts['instruction'] ) ) {
            $output = str_replace( get_theme_mod( 'passster_form_instructions_text', __( 'This content is password-protected. Please verify with a password to unlock the content.', 'content-protector' ) ), $atts['instruction'], $output );
        }
        return $output;
    }
    
    /**
     * enqueue scripts for shortcode
     *
     * @return void
     */
    public function add_scripts()
    {
        $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min' );
        if ( !is_admin() ) {
            wp_enqueue_style( 'passster-css', PASSSTER_URL . '/assets/public/passster' . $suffix . '.css' );
        }
        $cookie_options = get_option( 'passster_advanced_settings' );
        
        if ( !empty($cookie_options) && 'on' == $cookie_options['toggle_cookie'] ) {
            wp_enqueue_script( 'cookie', PASSSTER_URL . '/assets/public/cookie' . $suffix . '.js', array( 'jquery' ) );
            wp_enqueue_script( 'passster-cookie', PASSSTER_URL . '/assets/public/passster-cookie' . $suffix . '.js', array( 'jquery', 'cookie' ) );
            wp_localize_script( 'passster-cookie', 'passster_cookie', array(
                'url'        => admin_url() . 'admin-ajax.php',
                'days'       => intval( $cookie_options['passster_cookie_duration'] ),
                'use_cookie' => $cookie_options['toggle_cookie'],
            ) );
        }
    
    }

}