<?php
/**
* Administration Menu Options
*
* Add various adminstration menu options
*
* @package	simple-embed-code
*/

/**
* Add Settings link to plugin list
*
* Add a Settings link to the options listed against this plugin
*
* @since	1.6
*
* @param	string  $links	Current links
* @param	string  $file	File in use
* @return   string			Links, now with settings added
*/

function ce_add_settings_link( $links, $file ) {

	static $this_plugin;

	if ( !$this_plugin ) { $this_plugin = plugin_basename( __FILE__ ); }

	if ( strpos( $file, 'code-embed.php' ) !== false ) {
		$settings_link = '<a href="admin.php?page=ce-options">' . __( 'Settings', 'simple-embed-code' ) . '</a>';
		array_unshift( $links, $settings_link );
	}

	return $links;
}

add_filter( 'plugin_action_links', 'ce_add_settings_link', 10, 2 );

/**
* Add meta to plugin details
*
* Add options to plugin meta line
*
* @since	1.6
*
* @param	string  $links	Current links
* @param	string  $file	File in use
* @return   string			Links, now with settings added
*/

function ce_set_plugin_meta( $links, $file ) {

	if ( strpos( $file, 'code-embed.php' ) !== false ) { $links = array_merge( $links, array( '<a href="https://wordpress.org/plugins/simple-embed-code/">' . __( 'Support', 'simple-embed-code' ) . '</a>' ) ); }

	return $links;
}

add_filter( 'plugin_row_meta', 'ce_set_plugin_meta', 10, 2 );

/**
* Code Embed Menu
*
* Add a new option to the Admin menu and context menu
*
* @since	1.4
*
* @uses ce_help			Return help text
*/

function ce_menu() {

    // Add search sub-menu

    global $ce_search_hook;

	$ce_search_hook = add_submenu_page( 'tools.php', __( 'Code Embed Search', 'simple-embed-code' ), __( 'Code Search', 'simple-embed-code' ), 'edit_posts', 'ce-search', 'ce_search' );

    add_action('load-'.$ce_search_hook, 'ce_add_search_help');

    // Add options sub-menu

    global $ce_options_hook;

    $ce_options_hook = add_submenu_page( 'options-general.php', __( 'Code Embed Settings', 'simple-embed-code' ), __( 'Code Embed', 'simple-embed-code' ), 'manage_options', 'ce-options', 'ce_options' );

    add_action('load-'.$ce_options_hook, 'ce_add_options_help');

}

add_action( 'admin_menu','ce_menu' );

/**
* Add Options Help
*
* Add help tab to options screen
*
* @since	2.0
*
* @uses     ce_options_help    Return help text
*/

function ce_add_options_help() {

    global $ce_options_hook;
    $screen = get_current_screen();

    if ( $screen->id != $ce_options_hook ) { return; }

    $screen -> add_help_tab( array( 'id' => 'ce-options-help-tab', 'title'	=> __( 'Help', 'simple-embed-code' ), 'content' => ce_options_help() ) );
}

/**
* Add Search Help
*
* Add help tab to search screen
*
* @since	2.0
*
* @uses     ce_search_help    Return help text
*/

function ce_add_search_help() {

    global $ce_search_hook;
    $screen = get_current_screen();

    if ( $screen->id != $ce_search_hook ) { return; }

    $screen -> add_help_tab( array( 'id' => 'ce-search-help-tab', 'title' => __( 'Help', 'simple-embed-code' ), 'content' => ce_search_help() ) );
}

/**
* Code Embed Options
*
* Define an option screen
*
* @since	1.4
*/

function ce_options() {

	include_once( WP_PLUGIN_DIR . '/' . str_replace( basename( __FILE__ ), '', plugin_basename( __FILE__ ) ) . 'options-screen.php' );

}

/**
* Code Embed Search
*
* Define a the search screen
*
* @since	1.6
*/

function ce_search() {

	include_once( WP_PLUGIN_DIR . '/' . str_replace( basename( __FILE__ ), '', plugin_basename( __FILE__ ) ) . 'search-screen.php' );

}

/**
* Code Embed Options Help
*
* Return help text for options screen
*
* @since	1.5
*
* @return	string	Help Text
*/

function ce_options_help() {

	$help_text = '<p>' . __( 'Use this screen to modify the various settings, including the identifiers and keyword used to specify your embedded code.', 'simple-embed-code' ) . '</p>';
	$help_text .= '<p>' . __( 'The first option allows to suppress debug output. Normally this is an HTML comment in your page source - if you wish to hide this then simply tick this option.', 'simple-embed-code' ) . '</p>';
	$help_text .= '<p>' . __( 'The second option allows to specify whether code embed requests should work in excerpts.', 'simple-embed-code' ) . '</p>';
	$help_text .= '<p>' . __( 'The keyword is the name used for your custom field. The custom field\'s value is the code that you wish to embed.', 'simple-embed-code' ) . '</p>';
	$help_text .= '<p>' . __( 'The keyword, sandwiched with the identifier before and after, is what you then need to add to your post or page to activate the embed code.', 'simple-embed-code' ) . '</p>';

	return $help_text;
}

/**
* Code Embed Search Help
*
* Return help text for search screen
*
* @since	1.6
*
* @return	string	Help Text
*/

function ce_search_help() {

	$help_text = '<p>' . __( 'This screen allows you to search for the post and pages that a particular code embed has been used in.', 'simple-embed-code' ) . '</p>';
	$help_text .= '<p>' . __( 'Simply enter the code suffix that you wish to search for and press the \'Search\' key to display a list of all the posts using it. In addition the code will be shown alongside it. Click on the post name to edit the post.', 'simple-embed-code' ) . '</p>';
	$help_text .= '<p>' . __( 'The search results are grouped together in matching code groups, so posts with the same code will be shown together with the same color background.', 'simple-embed-code' ) . '</p>';

	return $help_text;
}
?>