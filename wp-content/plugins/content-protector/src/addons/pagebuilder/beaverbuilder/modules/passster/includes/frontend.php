<?php

switch ( $settings->passster_protection_type ) {
	case 'password':
		$shortcode = '[passster password="' . $settings->passster_password . '"';
		break;
	case 'captcha':
		$shortcode = '[passster captcha="captcha"';
		break;
	case 'recaptcha':
		$shortcode = '[passster captcha="recaptcha"]';
		break;
	case 'passwords':
		$shortcode = '[passster passwords="' . $settings->passster_passwords . '"';
		break;
	case 'password_list':
		$shortcode = '[passster password_list="' . $settings->passster_lists . '"';
		break;
}

if ( ! empty( $settings->passster_headline ) ) {
				$shortcode .= ' headline="' . $settings->passsster_headline . '"';
}

if ( ! empty( $settings->passster_placeholder ) ) {
			$shortcode .= ' placeholder="' . $settings->passster_placeholder . '"';
}

if ( ! empty( $settings->passster_button_label ) ) {
			$shortcode .= ' button="' . $settings->passster_button_label . '"';
}

if ( ! empty( $settings->passster_instruction ) ) {
			$shortcode .= ' instruction="' . $settings->passster_instruction . '"';
}

$shortcode .= ']';

echo '<div class="description">' . do_shortcode( $shortcode . $settings->passster_protected_text . '[/passster]' ) . '</div>';

