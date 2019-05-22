<?php
add_action( 'vc_before_init', 'vc_before_init_actions' );


/**
 * Add new element and modify row before init.
 *
 * @return void
 */
function vc_before_init_actions() {
	require_once( PASSSTER_ABSPATH . 'src/addons/pagebuilder/visual-composer/class-ps-visual-composer.php' );

	if ( function_exists( 'vc_set_shortcodes_templates_dir' ) ) {
		vc_set_shortcodes_templates_dir( PASSSTER_ABSPATH . 'src/addons/pagebuilder/visual-composer/elements' );
	}
}
