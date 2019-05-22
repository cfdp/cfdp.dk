<?php

class PS_Module extends FLBuilderModule
{
    public function __construct()
    {
        parent::__construct( array(
            'name'        => __( 'Passster', 'content-protector' ),
            'description' => __( 'The Passster Beaver Builder Module', 'content-protector' ),
            'category'    => __( 'Content Protection', 'content-protector' ),
            'dir'         => PASSSTER_PATH . '/src/addons/pagebuilder/beaverbuilder/modules/passster/',
            'url'         => PASSSTER_URL . '/src/addons/pagebuilder/beaverbuilder/modules/passster/',
        ) );
    }

}
$protection_types = array(
    'type'    => 'select',
    'label'   => __( 'Select Type', 'content-protector' ),
    'default' => 'password',
    'options' => array(
    'password' => __( 'Password', 'content-protector' ),
    'captcha'  => __( 'Captcha', 'content-protector' ),
),
);
$fields = array(
    'passster_protection_type' => $protection_types,
    'passster_password'        => array(
    'type'        => 'text',
    'label'       => __( 'Password', 'content-protector' ),
    'placeholder' => __( 'Password', 'content-protector' ),
),
    'passster_headline'        => array(
    'type'    => 'text',
    'label'   => __( 'Headline', 'content-protector' ),
    'default' => __( 'Protected Area', 'content-protector' ),
),
    'passster_placeholder'     => array(
    'type'    => 'text',
    'label'   => __( 'Placeholder Input', 'content-protector' ),
    'default' => __( 'Enter your Password', 'content-protector' ),
),
    'passster_button_label'    => array(
    'type'    => 'text',
    'label'   => __( 'Button Label', 'content-protector' ),
    'default' => __( 'Submit', 'content-protector' ),
),
    'passster_instruction'     => array(
    'type'    => 'textarea',
    'label'   => __( 'Instruction Text', 'content-protector' ),
    'default' => __( 'This content is protected!', 'content-protector' ),
    'rows'    => '6',
),
    'passster_protected_text'  => array(
    'type'    => 'editor',
    'label'   => __( 'Protected Text', 'content-protector' ),
    'default' => __( 'This is your protected content.', 'content-protector' ),
    'rows'    => '6',
),
);
FLBuilder::register_module( 'PS_Module', array(
    'general' => array(
    'title'    => __( 'Shortcode', 'content-protector' ),
    'sections' => array(
    'general' => array(
    'title'  => __( 'Protection', 'content-protector' ),
    'fields' => $fields,
),
),
),
) );