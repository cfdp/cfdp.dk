<?php

namespace passster;

use  Gregwar\Captcha\CaptchaBuilder ;
use  Gregwar\Captcha\PhraseBuilder ;
class PS_Captcha
{
    public  $captcha_settings ;
    public  $captcha ;
    public  $captcha_img ;
    public function __construct()
    {
        $this->setup_captcha();
    }
    
    public function setup_captcha()
    {
        $captcha_options = get_option( 'passster_captcha' );
        
        if ( empty($captcha_options) ) {
            $captcha_options = array(
                'passster_captcha_code_length'      => 4,
                'passster_captcha_use_numbers_only' => 'off',
                'passster_captcha_width'            => 130,
                'passster_captcha_height'           => 80,
            );
            update_option( 'passster_captcha', $captcha_options );
        }
        
        
        if ( !empty($captcha_options) ) {
            
            if ( 'on' == $captcha_options['passster_captcha_use_numbers_only'] ) {
                $this->captcha_settings = new PhraseBuilder( intval( $captcha_options['passster_captcha_code_length'] ), '0123456789' );
            } else {
                $this->captcha_settings = new PhraseBuilder( intval( $captcha_options['passster_captcha_code_length'] ) );
            }
            
            $this->captcha = new CaptchaBuilder( null, $this->captcha_settings );
            /* widht, height and font */
            $width = $captcha_options['passster_captcha_width'];
            $height = $captcha_options['passster_captcha_height'];
            $this->captcha->build( $width, $height, null );
            $this->captcha_img = '<img class="passster-captcha-img" src="' . $this->captcha->inline() . '" />';
        }
    
    }

}