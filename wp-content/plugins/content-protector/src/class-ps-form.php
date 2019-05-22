<?php

namespace passster;

class PS_Form
{
    /**
     * Get instance of PS_Form
     *
     * @return void
     */
    public static function get_instance()
    {
        $form = new PS_Form();
        return $form;
    }
    
    /**
     * Get password form markup and replace placeholders
     *
     * @return string
     */
    public static function get_password_form()
    {
        ob_start();
        include apply_filters( 'passster_password_form', PASSSTER_PATH . '/src/templates/password-form.php' );
        $password_form = ob_get_contents();
        ob_end_clean();
        $password_form_placeholders = array(
            '[PASSSTER_FORM_HEADLINE]'     => get_theme_mod( 'passster_form_instructions_headline', __( 'Protected Area', 'content-protector' ) ),
            '[PASSSTER_FORM_INSTRUCTIONS]' => get_theme_mod( 'passster_form_instructions_text', __( 'This content is password-protected. Please verify with a password to unlock the content.', 'content-protector' ) ),
            '[PASSSTER_BUTTON_LABEL]'      => get_theme_mod( 'passster_form_button_label', __( 'Submit', 'content-protector' ) ),
            '[PASSSTER_AUTH]'              => 'passster_password',
            '[PASSSTER_CURRENT_URL]'       => \get_the_permalink(),
        );
        foreach ( $password_form_placeholders as $placeholder => $string ) {
            $password_form = str_replace( $placeholder, $string, $password_form );
        }
        return $password_form;
    }
    
    /**
     * Get captcha form markup and replace placeholders
     *
     * @param string $catpcha_img current image url.
     * @return string
     */
    public static function get_captcha_form( $catpcha_img )
    {
        ob_start();
        include apply_filters( 'passster_captcha_form', PASSSTER_PATH . '/src/templates/captcha-form.php' );
        $captcha_form = ob_get_contents();
        ob_end_clean();
        $captcha_form_placeholders = array(
            '[PASSSTER_FORM_HEADLINE]'     => get_theme_mod( 'passster_form_instructions_headline', __( 'Protected Area', 'content-protector' ) ),
            '[PASSSTER_FORM_INSTRUCTIONS]' => get_theme_mod( 'passster_form_instructions_text', __( 'This content is password-protected. Please verify with a password to unlock the content.', 'content-protector' ) ),
            '[PASSSTER_BUTTON_LABEL]'      => get_theme_mod( 'passster_form_button_label', __( 'Submit', 'content-protector' ) ),
            '[PASSSTER_CAPTCHA_IMG]'       => $catpcha_img,
            '[PASSSTER_AUTH]'              => 'passster_captcha',
            '[PASSSTER_CURRENT_URL]'       => \get_the_permalink(),
        );
        foreach ( $captcha_form_placeholders as $placeholder => $string ) {
            $captcha_form = str_replace( $placeholder, $string, $captcha_form );
        }
        return $captcha_form;
    }
    
    /**
     * Get recaptcha form markup and replace placeholders
     *
     * @param string $recaptcha_widget current recaptcha widget string.
     * @return string
     */
    public static function get_recaptcha_form( $recaptcha_widget )
    {
    }

}