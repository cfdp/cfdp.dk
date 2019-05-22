<?php

class PS_Visual_Composer extends WPBakeryShortCode
{
    /**
     * Constructor for PS_Visual_Composer
     */
    public function __construct()
    {
        add_action( 'init', array( $this, 'vc_passster_mapping' ) );
        add_shortcode( 'vc_passster', array( $this, 'vc_passster_html' ) );
        add_action( 'vc_after_init', array( $this, 'vc_passster_row' ) );
    }
    
    /**
     * Mapping VC fields with shortcode
     *
     * @return void
     */
    public function vc_passster_mapping()
    {
        if ( !defined( 'WPB_VC_VERSION' ) ) {
            return;
        }
        $args = array(
            'post_type'      => 'password_lists',
            'posts_per_page' => -1,
        );
        $lists = get_posts( $args );
        $choosable_lists = array();
        
        if ( isset( $lists ) && !empty($lists) ) {
            foreach ( $lists as $list ) {
                $choosable_lists[] = array(
                    'value' => $list->ID,
                    'label' => $list->post_title,
                );
            }
            $choosable_lists[''] = '';
        }
        
        $protection_mode = array(
            'type'        => 'dropdown',
            'heading'     => __( 'Protection type', 'content-protector' ),
            'param_name'  => 'passster_protection_type',
            'value'       => array( array(
            'value' => 'password',
            'label' => __( 'Password', 'content-protector' ),
        ), array(
            'value' => 'captcha',
            'label' => __( 'Captcha', 'content-protector' ),
        ) ),
            'description' => __( 'Choose your protection type', 'content-protector' ),
            'admin_label' => false,
            'weight'      => 0,
            'group'       => 'Protection',
        );
        $passwords = array(
            'type'        => 'textfield',
            'heading'     => __( 'Passwords', 'content-protector' ),
            'param_name'  => 'passster_passwords',
            'description' => __( 'Add multiple passwords separated by comma.', 'content-protector' ),
            'admin_label' => false,
            'weight'      => 0,
            'group'       => 'Protection',
        );
        $password_list = array(
            'type'        => 'dropdown',
            'heading'     => __( 'Password List', 'content-protector' ),
            'param_name'  => 'passster_password_list',
            'value'       => $choosable_lists,
            'description' => __( 'Choose your password list', 'content-protector' ),
            'admin_label' => false,
            'weight'      => 0,
            'group'       => 'Protection',
        );
        vc_map( array(
            'name'        => __( 'Passster', 'content-protector' ),
            'base'        => 'vc_passster',
            'description' => __( 'Build protected areas with Passster.', 'content-protector' ),
            'category'    => __( 'Protection', 'content-protector' ),
            'icon'        => PASSSTER_URL . '/assets/admin/vc-passster.png',
            'params'      => array(
            $protection_mode,
            array(
            'type'        => 'textfield',
            'heading'     => __( 'Authentication', 'content-protector' ),
            'param_name'  => 'passster_authentication',
            'description' => __( 'Use this if you have multiple Passster elements per page', 'content-protector' ),
            'admin_label' => false,
            'weight'      => 0,
            'group'       => 'Protection',
        ),
            array(
            'type'        => 'textfield',
            'heading'     => __( 'Password', 'content-protector' ),
            'param_name'  => 'passster_password',
            'admin_label' => false,
            'weight'      => 0,
            'group'       => 'Protection',
        ),
            array(
            'type'        => 'textarea_html',
            'heading'     => __( 'Protected Text', 'content-protector' ),
            'param_name'  => 'passster_protected_text',
            'value'       => __( 'This is your protected content!', 'content-protector' ),
            'admin_label' => false,
            'weight'      => 0,
            'group'       => 'Protection',
        ),
            array(
            'type'        => 'textfield',
            'heading'     => __( 'Headline', 'content-protector' ),
            'param_name'  => 'passster_headline',
            'value'       => __( 'Protected Area', 'content-protector' ),
            'admin_label' => false,
            'weight'      => 0,
            'group'       => 'Labels',
        ),
            array(
            'type'        => 'textarea',
            'heading'     => __( 'Instruction Text', 'content-protector' ),
            'param_name'  => 'passster_instruction',
            'value'       => __( 'This content is protected.', 'content-protector' ),
            'admin_label' => false,
            'weight'      => 0,
            'group'       => 'Labels',
        ),
            array(
            'type'        => 'textfield',
            'heading'     => __( 'Placeholder Text', 'content-protector' ),
            'value'       => __( 'Enter the password', 'content-protector' ),
            'param_name'  => 'passster_placeholder',
            'admin_label' => false,
            'weight'      => 0,
            'group'       => 'Labels',
        ),
            array(
            'type'        => 'textfield',
            'heading'     => __( 'Button Label', 'content-protector' ),
            'value'       => __( 'Submit', 'content-protector' ),
            'param_name'  => 'passster_button_label',
            'admin_label' => false,
            'weight'      => 0,
            'group'       => 'Labels',
        )
        ),
        ) );
    }
    
    /**
     * Render the passster shortcode with VC arguments
     *
     * @param  array $atts arguments from vc.
     * @return string
     */
    public function vc_passster_html( $atts )
    {
        extract( shortcode_atts( array(
            'passster_protection_type' => '',
            'passster_authentication'  => '',
            'passster_password'        => '',
            'passster_passwords'       => '',
            'passster_password_list'   => '',
            'passster_protected_text'  => '',
            'passster_headline'        => '',
            'passster_instruction'     => '',
            'passster_placeholder'     => '',
            'passster_button_label'    => '',
        ), $atts ) );
        switch ( $passster_protection_type ) {
            case 'password':
                $shortcode = '[passster password="' . $passster_password . '"';
                break;
            case 'captcha':
                $shortcode = '[passster captcha="captcha"';
                break;
            case 'recaptcha':
                $shortcode = '[passster captcha="recaptcha"]';
                break;
            case 'passwords':
                $shortcode = '[passster passwords="' . $passster_passwords . '"';
                break;
            case 'password_list':
                $shortcode = '[passster password_list="' . $passster_password_list . '"';
                break;
        }
        if ( !empty($passster_headline) ) {
            $shortcode .= ' headline="' . $passster_headline . '"';
        }
        if ( !empty($passster_placeholder) ) {
            $shortcode .= ' placeholder="' . $passster_placeholder . '"';
        }
        if ( !empty($passster_button_label) ) {
            $shortcode .= ' button="' . $passster_button_label . '"';
        }
        if ( !empty($passster_instruction) ) {
            $shortcode .= ' instruction="' . $passster_instruction . '"';
        }
        if ( !empty($passster_authentication) ) {
            $shortcode .= ' auth="' . $passster_authentication . '"';
        }
        $shortcode .= ']';
        $shortcode = '<div class="description">' . do_shortcode( $shortcode . $passster_protected_text . '[/passster]' ) . '</div>';
        return $shortcode;
    }
    
    /**
     * Add parameters after vc init for vc_row element.
     *
     * @return void
     */
    public function vc_passster_row()
    {
    }

}
new PS_Visual_Composer();