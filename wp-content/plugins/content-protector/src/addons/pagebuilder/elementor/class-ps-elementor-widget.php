<?php

class PS_Elementor_Widget extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'passster';
    }
    
    public function get_title()
    {
        return __( 'Passster', 'content-protector' );
    }
    
    public function get_icon()
    {
        return 'fa fa-code';
    }
    
    public function get_categories()
    {
        return [ 'general' ];
    }
    
    protected function _register_controls()
    {
        $args = array(
            'post_type'      => 'password_lists',
            'posts_per_page' => -1,
        );
        $lists = get_posts( $args );
        $choosable_lists = array();
        
        if ( isset( $lists ) && !empty($lists) ) {
            foreach ( $lists as $list ) {
                $choosable_lists[$list->ID] = $list->post_title;
            }
            $choosable_lists[''] = '';
        }
        
        $this->start_controls_section( 'passster_section', [
            'label' => __( 'Passster', 'content-protector' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'passster_protect_options', [
            'label'     => __( 'Protection', 'content-protector' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ] );
        $this->add_control( 'passster_type', [
            'label'   => __( 'Protection Type', 'content-protector' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'password',
            'options' => [
            'password' => __( 'Password', 'content-protector' ),
            'captcha'  => __( 'Captcha', 'content-protector' ),
        ],
        ] );
        $this->add_control( 'passster_password', [
            'label'       => __( 'Password', 'content-protector' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'placeholder' => __( 'Enter your password', 'content-protector' ),
        ] );
        $this->add_control( 'passster_style_options', [
            'label'     => __( 'Texts', 'content-protector' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ] );
        $this->add_control( 'passster_headline', [
            'label'   => __( 'Headline', 'content-protector' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __( 'Protected Area', 'content-protector' ),
        ] );
        $this->add_control( 'passster_placeholder', [
            'label'       => __( 'Input Placeholder', 'content-protector' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'placeholder' => __( 'Enter Password', 'content-protector' ),
        ] );
        $this->add_control( 'passster_button_label', [
            'label'       => __( 'Button Label', 'content-protector' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'placeholder' => __( 'Submit', 'content-protector' ),
        ] );
        $this->add_control( 'passster_instructions', [
            'label'   => __( 'Instructions Text', 'content-protector' ),
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'rows'    => 10,
            'default' => __( 'This content is protected. Please enter your password to unlock.', 'content-protector' ),
        ] );
        $this->add_control( 'passster_protected_content_headline', [
            'label'     => __( 'Protected Content', 'content-protector' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ] );
        $this->add_control( 'passster_protected_content', [
            'label'   => __( 'Protected Content', 'content-protector' ),
            'type'    => \Elementor\Controls_Manager::WYSIWYG,
            'default' => __( 'This content is your protected content', 'content-protector' ),
        ] );
        $this->end_controls_section();
    }
    
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $shortcode = '';
        switch ( $settings['passster_type'] ) {
            case 'password':
                $shortcode .= '[passster password="' . $settings['passster_password'] . '"';
                break;
            case 'captcha':
                $shortcode .= '[passster captcha="captcha"';
                break;
            case 'recaptcha':
                $shortcode .= '[passster captcha="recaptcha"]';
                break;
            case 'passwords':
                $shortcode .= '[passster passwords="' . $settings['passster_passwords'] . '"';
                break;
            case 'password_list':
                $shortcode .= '[passster password_list="' . $settings['passster_password_list'] . '"';
                break;
        }
        if ( !empty($settings['passster_headline']) ) {
            $shortcode .= ' headline="' . $settings['passster_headline'] . '"';
        }
        if ( !empty($settings['passster_placeholder']) ) {
            $shortcode .= ' placeholder="' . $settings['passster_placeholder'] . '"';
        }
        if ( !empty($settings['passster_button_label']) ) {
            $shortcode .= ' button="' . $settings['passster_button_label'] . '"';
        }
        if ( !empty($settings['passster_instructions']) ) {
            $shortcode .= ' instruction="' . $settings['passster_instructions'] . '"';
        }
        $shortcode .= ']';
        echo  '<div class="description">' . do_shortcode( $shortcode . $settings['passster_protected_content'] . '[/passster]' ) . '</div>' ;
    }
    
    protected function _content_template()
    {
        ?>
		<div class="passster-form">  
			<form id="password-form" action="" method="post" autocomplete="off" _lpchecked="1">
				<h4>{{{ settings.passster_headline }}}</h4>
				<p>{{{ settings.passster_instructions }}}</p>
				<fieldset>
					<input placeholder="{{{ settings.passster_placeholder }}}" tabindex="1" name="passster_password" id="passster_password" background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%;" autocomplete="off" type="password">
					<button name="submit" type="submit" id="passster_submit" data-submit="...Checking Password">{{{ settings.passster_button_label }}}</button>
					<div class="error"></div>
				</fieldset>
			</form>
		</div>
		<?php 
    }

}