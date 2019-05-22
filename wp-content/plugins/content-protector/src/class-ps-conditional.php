<?php

namespace passster;

use  Phpass\Hash ;
class PS_Conditional
{
    /**
     * Conditional function to check passwords
     *
     * @param  string $password current password.
     * @return boolean
     */
    public static function is_password_valid( $password )
    {
        $hash = new Hash();
        $admin_pass = $hash->hashPassword( $password );
        $form = PS_Form::get_password_form();
        $auth = 'passster_password';
        $wrong_password = apply_filters( 'passster_error_message', '<span class="passster-error">' . get_theme_mod( 'passster_form_error_message_text', __( 'Something went wrong. Please try again.', 'content-protector' ) ) . '</span>' );
        if ( true === PS_Helper::is_cookie_valid( $hash, $admin_pass ) ) {
            return true;
        }
        
        if ( isset( $_POST['passster_password'] ) && !empty($_POST['passster_password']) ) {
            
            if ( $hash->checkPassword( sanitize_text_field( $_POST['passster_password'] ), $admin_pass ) === true ) {
                return true;
            } else {
                $form = str_replace( '[PASSSTER_ERROR_MESSAGE]', $wrong_password, $form );
                echo  $form ;
                return false;
            }
        
        } else {
            $form = str_replace( '[PASSSTER_ERROR_MESSAGE]', '', $form );
            echo  $form ;
            return false;
        }
    
    }
    
    /**
     * Conditional to check multiple passwords
     *
     * @param string $passwords string of multiple passwords.
     * @return boolean
     */
    public static function are_passwords_valid( $passwords )
    {
    }

}