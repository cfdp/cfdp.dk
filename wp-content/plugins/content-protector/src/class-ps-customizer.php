<?php

namespace passster;

class PS_Customizer {

	public function __construct() {
		add_action( 'customize_register', array( $this, 'customize_register' ) );
		add_action( 'wp_head', array( $this, 'dynamic_styles' ) );
	}

	public static function get_instance() {
		new PS_Customizer();
	}

	public function customize_register( $wp_customize ) {

		$wp_customize->add_panel( 'passster', array(
			'priority'       => 999,
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'title'          => __( 'Passster', 'content-protector' ),
		) );

		/* general section */
		$wp_customize->add_section( 'passster_form_general', array(
			'title' => __( 'General', 'content-protector' ),
			'panel' => 'passster',
		) );

		/* background color - form container */
		$wp_customize->add_setting( 'passster_form_general_background_color', array(
			'default' => '#F9F9F9',
		) );

		$wp_customize->add_control( 'passster_form_general_background_color_control', array(
			'label'       => __( 'Background Color', 'content-protector' ),
			'description' => __( 'Change the background color of the form', 'content-protector' ),
			'section'     => 'passster_form_general',
			'settings'    => 'passster_form_general_background_color',
			'type'        => 'color',
		) );

		// padding - form container
		$wp_customize->add_setting( 'passster_form_general_padding', array(
			'default' => '10',
		) );

		$wp_customize->add_control( 'passster_form_general_padding_control', array(
			'label'       => __( 'Padding', 'content-protector' ),
			'description' => __( 'Padding in PX', 'content-protector' ),
			'section'     => 'passster_form_general',
			'settings'    => 'passster_form_general_padding',
			'type'        => 'text',
		) );

		// margin - form container
		$wp_customize->add_setting( 'passster_form_general_margin', array(
			'default' => '0',
		) );

		$wp_customize->add_control( 'passster_form_general_margin_control', array(
			'label'       => __( 'Margin', 'content-protector' ),
			'description' => __( 'Margin in PX', 'content-protector' ),
			'section'     => 'passster_form_general',
			'settings'    => 'passster_form_general_margin',
			'type'        => 'text',
		) );

		/* form instructions section */
		$wp_customize->add_section( 'passster_form_instructions', array(
			'title' => __( 'Form Instructions', 'content-protector' ),
			'panel' => 'passster',
		) );

		/* instructions headline */
		$wp_customize->add_setting( 'passster_form_instructions_headline', array(
			'default' => __( 'Protected Area', 'content-protector' ),
		) );
		$wp_customize->add_control( 'passster_form_instructions_headline_control', array(
			'label'    => __( 'Headline', 'content-protector' ),
			'section'  => 'passster_form_instructions',
			'settings' => 'passster_form_instructions_headline',
			'type'     => 'text',
		) );

		/* headline font size */
		$wp_customize->add_setting( 'passster_form_instructions_headline_font_size', array(
			'default' => '20',
		) );
		$wp_customize->add_control( 'passster_form_instructions_headline_font_size_control', array(
			'label'       => __( 'Headline Font Size', 'content-protector' ),
			'description' => __( 'Font size in PX', 'content-protector' ),
			'section'     => 'passster_form_instructions',
			'settings'    => 'passster_form_instructions_headline_font_size',
			'type'        => 'number',
		) );

		/* headline font weight */
		$wp_customize->add_setting( 'passster_form_instructions_headline_font_weight', array(
			'default' => '700',
		) );
		$wp_customize->add_control( 'passster_form_instructions_headline_font_weight_control', array(
			'label'    => __( 'Headline Font Weight', 'content-protector' ),
			'section'  => 'passster_form_instructions',
			'settings' => 'passster_form_instructions_headline_font_weight',
			'type'     => 'number',
		) );

		/* headline color */
		$wp_customize->add_setting( 'passster_form_instructions_headline_color', array(
			'default' => '#4998b3',
		) );

		$wp_customize->add_control( 'passster_form_instructions_headline_color_control', array(
			'label'    => __( 'Headline Color', 'content-protector' ),
			'section'  => 'passster_form_instructions',
			'settings' => 'passster_form_instructions_headline_color',
			'type'     => 'color',
		) );

		/* instructions text */
		$wp_customize->add_setting( 'passster_form_instructions_text', array(
			'default' => __( 'This content is password-protected. Please verify with a password to unlock the content.', 'content-protector' ),
		) );
		$wp_customize->add_control( 'passster_form_instructions_text_control', array(
			'label'    => __( 'Instructions Text', 'content-protector' ),
			'section'  => 'passster_form_instructions',
			'settings' => 'passster_form_instructions_text',
			'type'     => 'textarea',
		) );

		/* instructions font size */
		$wp_customize->add_setting( 'passster_form_instructions_text_font_size', array(
			'default' => '14',
		) );
		$wp_customize->add_control( 'passster_form_instructions_text_font_size_control', array(
			'label'       => __( 'Font Size', 'content-protector' ),
			'description' => __( 'Font size in PX', 'content-protector' ),
			'section'     => 'passster_form_instructions',
			'settings'    => 'passster_form_instructions_text_font_size',
			'type'        => 'number',
		) );

		/* instructions font weight */
		$wp_customize->add_setting( 'passster_form_instructions_text_font_weight', array(
			'default' => '400',
		) );
		$wp_customize->add_control( 'passster_form_instructions_text_font_weight_control', array(
			'label'    => __( 'Font Weight', 'content-protector' ),
			'section'  => 'passster_form_instructions',
			'settings' => 'passster_form_instructions_text_font_weight',
			'type'     => 'number',
		) );

		/* text color - form instructions */
		$wp_customize->add_setting( 'passster_form_instructions_text_color', array(
			'default' => '#000000',
		) );

		$wp_customize->add_control( 'passster_form_instructions_text_color_control', array(
			'label'    => __( 'Text Color', 'content-protector' ),
			'section'  => 'passster_form_instructions',
			'settings' => 'passster_form_instructions_text_color',
			'type'     => 'color',
		) );

		/* form error message section */
		$wp_customize->add_section( 'passster_form_error_message', array(
			'title' => __( 'Error Message', 'content-protector' ),
			'panel' => 'passster',
		) );

		/* error message text */
		$wp_customize->add_setting( 'passster_form_error_message_text', array(
			'default' => __( 'Something went wrong. Please try again.', 'content-protector' ),
		) );
		$wp_customize->add_control( 'passster_form_error_message_text_control', array(
			'label'    => __( 'Error Message', 'content-protector' ),
			'section'  => 'passster_form_error_message',
			'settings' => 'passster_form_error_message_text',
			'type'     => 'textarea',
		) );

		/* error message font size */
		$wp_customize->add_setting( 'passster_form_error_message_text_font_size', array(
			'default' => '14',
		) );
		$wp_customize->add_control( 'passster_form_error_message_text_font_size_control', array(
			'label'       => __( 'Font Size', 'content-protector' ),
			'description' => __( 'Font size in PX', 'content-protector' ),
			'section'     => 'passster_form_error_message',
			'settings'    => 'passster_form_error_message_text_font_size',
			'type'        => 'number',
		) );

		/* error message font weight */
		$wp_customize->add_setting( 'passster_form_error_message_text_font_weight', array(
			'default' => '400',
		) );
		$wp_customize->add_control( 'passster_form_error_message_text_font_weight_control', array(
			'label'    => __( 'Font Weight', 'content-protector' ),
			'section'  => 'passster_form_error_message',
			'settings' => 'passster_form_error_message_text_font_weight',
			'type'     => 'number',
		) );

		/* error message text color */
		$wp_customize->add_setting( 'passster_form_error_message_text_color', array(
			'default' => '#FFFFFF',
		) );

		$wp_customize->add_control( 'passster_form_error_message_text_color_control', array(
			'label'    => __( 'Text Color', 'content-protector' ),
			'section'  => 'passster_form_error_message',
			'settings' => 'passster_form_error_message_text_color',
			'type'     => 'color',
		) );

		/* error message background color */
		$wp_customize->add_setting( 'passster_form_error_message_background_color', array(
			'default' => '#CC4C43',
		) );

		$wp_customize->add_control( 'passster_form_error_message_background_color_control', array(
			'label'    => __( 'Background Color', 'content-protector' ),
			'section'  => 'passster_form_error_message',
			'settings' => 'passster_form_error_message_background_color',
			'type'     => 'color',
		) );

		/* form button */
		$wp_customize->add_section( 'passster_form_button', array(
			'title' => __( 'Button', 'content-protector' ),
			'panel' => 'passster',
		) );

		/* button label */
		$wp_customize->add_setting( 'passster_form_button_label', array(
			'default' => __( 'Submit', 'content-protector' ),
		) );
		$wp_customize->add_control( 'passster_form_button_label_control', array(
			'label'    => __( 'Button Label', 'content-protector' ),
			'section'  => 'passster_form_button',
			'settings' => 'passster_form_button_label',
			'type'     => 'text',
		) );

		/* button text color */
		$wp_customize->add_setting( 'passster_form_button_text_color', array(
			'default' => '#FFFFFF',
		) );

		$wp_customize->add_control( 'passster_form_button_text_color_control', array(
			'label'    => __( 'Text Color', 'content-protector' ),
			'section'  => 'passster_form_button',
			'settings' => 'passster_form_button_text_color',
			'type'     => 'color',
		) );

		/* button text hover color */
		$wp_customize->add_setting( 'passster_form_button_text_hover_color', array(
			'default' => '#FFFFFF',
		) );

		$wp_customize->add_control( 'passster_form_button_text_hover_color_control', array(
			'label'    => __( 'Text Color (Hover)', 'content-protector' ),
			'section'  => 'passster_form_button',
			'settings' => 'passster_form_button_text_hover_color',
			'type'     => 'color',
		) );

		/* button background color */
		$wp_customize->add_setting( 'passster_form_button_background_color', array(
			'default' => '#4998b3',
		) );

		$wp_customize->add_control( 'passster_form_button_background_color_control', array(
			'label'    => __( 'Background Color', 'content-protector' ),
			'section'  => 'passster_form_button',
			'settings' => 'passster_form_button_background_color',
			'type'     => 'color',
		) );

		/* button background hover color */
		$wp_customize->add_setting( 'passster_form_button_background_hover_color', array(
			'default' => '#aa1100',
		) );

		$wp_customize->add_control( 'passster_form_button_background_hover_color_control', array(
			'label'    => __( 'Background Color (Hover)', 'content-protector' ),
			'section'  => 'passster_form_button',
			'settings' => 'passster_form_button_background_hover_color',
			'type'     => 'color',
		) );

	}
	public function dynamic_styles() {
		?>
		<style>
		.passster-form {
			background: <?php echo get_theme_mod( 'passster_form_general_background_color', '#F9F9F9' ); ?>;
			padding: <?php echo get_theme_mod( 'passster_form_general_padding', '10' ); ?>px;
			margin: <?php echo get_theme_mod( 'passster_form_general_margin', '0' ); ?>px;
		}
		.passster-form h4 {
			font-size: <?php echo get_theme_mod( 'passster_form_instructions_headline_font_size', '20' ); ?>px;
			font-weight: <?php echo get_theme_mod( 'passster_form_instructions_headline_font_weight', '700' ); ?>;
			color: <?php echo get_theme_mod( 'passster_form_instructions_headline_color', '#4998b3' ); ?>;
		}
		.passster-form p {
			font-size: <?php echo get_theme_mod( 'passster_form_instructions_text_font_size', '14' ); ?>px;
			font-weight: <?php echo get_theme_mod( 'passster_form_instructions_text_font_weight', '400' ); ?>;
			color: <?php echo get_theme_mod( 'passster_form_instructions_text_color', '#000000' ); ?>;
		}
		.passster-form .error {
			font-size: <?php echo get_theme_mod( 'passster_form_error_message_text_font_size', '14' ); ?>px;
			font-weight: <?php echo get_theme_mod( 'passster_form_error_message_text_font_weight', '400' ); ?>;
			color: <?php echo get_theme_mod( 'passster_form_error_message_text_color', '#FFFFFF' ); ?>;
			background: <?php echo get_theme_mod( 'passster_form_error_message_background_color', '#CC4C43' ); ?>;
		}
		.passster-form #passster_submit {
			color: <?php echo get_theme_mod( 'passster_form_button_text_color', '#FFFFFF' ); ?>;
			background: <?php echo get_theme_mod( 'passster_form_button_background_color', '#4998b3' ); ?>;
		}
		.passster-form #passster_submit:hover {
			color: <?php echo get_theme_mod( 'passster_form_button_text_hover_color', '#FFFFFF' ); ?>;
			background: <?php echo get_theme_mod( 'passster_form_button_background_hover_color', '#aa1100' ); ?>;
		}                
		</style>
		<?php
	}

}

