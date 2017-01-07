<?php
/*
Plugin Name: Code Embed
Plugin URI: https://wordpress.org/plugins/simple-code-embed/
Description: Allows you to embed code into your posts & pages
Version: 2.2.1
Author: David Artiss
Author URI: http://www.artiss.co.uk
Text Domain: simple-embed-code
Domain Path: /languages
*/

/**
* Code Embed
*
* Embed code into a post
*
* @package	Code-Embed
* @since	1.6
*/

define( 'code_embed_version', '2.2.1' );

// Include all the various functions

$functions_dir = plugin_dir_path( __FILE__ ) . 'includes/';

include_once( $functions_dir . 'initialise.php' );		    			// Initialisation scripts

if ( is_admin() ) {

	include_once( $functions_dir . 'admin-config.php' );				// Various administration config. options

} else {

	include_once( $functions_dir . 'add-scripts.php' );		       		// Add scripts to the main theme

	include_once( $functions_dir . 'add-embeds.php' );		        	// Filter to apply code embeds

}
?>