<?php
/*
Plugin Name: Display Name Author Permalink
Plugin URI: http://sivel.net/wordpress/display-name-author-permalink/
Description: Replaces the username for author permalinks with the users display name.  Returns a 404 if the author permalink using the actual username is used.
Author: hallsofmontezuma, Matt Martz
Author URI: http://sivel.net
Version: 1.1

        Copyright (c) 2009 Matt Martz (http://sivel.net)
        Display Name Author Permalink is released under the GNU General Public License (GPL)
        http://www.gnu.org/licenses/gpl-2.0.txt
*/

class DisplayNameAuthorPermaLink {

	var $users = array();

	// Build an array of usernames and display names and increment duplicates for uniqueness
	function __construct() {
		$i = 1;
		foreach ( get_users() as $user ) { 
			$display_name = $display_name = sanitize_title($user->display_name);
			if ( in_array(sanitize_title($user->display_name), $this->users) ) {
				$i++;
				$display_name .= "-$i";	
			}
	        	$this->users[sanitize_title($user->user_login)] = $display_name;
		}
		add_action('pre_get_posts', array(&$this, 'switch_author'));
		add_filter('author_link', array(&$this, 'filter_author'), 10, 3);
	}


	// Switch the display name with the username so that we can populate the posts properly
	// If the username was used in the call do a 404 template redirection
	function switch_author() {
		if ( ! is_author() ) 
			return;
		$author_name = get_query_var('author_name');
		$key = array_search($author_name, $this->users);
        	if ( $key ) {
        	        set_query_var('author_name', $key);
	                $author = get_user_by('login', $key);
	                set_query_var('author', $author->ID);
	        } else {
			set_query_var('author_name', false);
			set_query_var('author', false);
			add_action('template_redirect', array(&$this, 'redirect_404'));
		}
	}

	// Replace the username in author links generated in the theme with the users display name
	function filter_author($link,$author_id,$author_nicename) {
        	if ( array_key_exists($author_nicename, $this->users) )
	                $link = str_replace($author_nicename,$this->users[$author_nicename], $link);
	        return $link;
	}

	// redirect template to use 404 template
	function redirect_404() {
		include(get_404_template());
		die();
	}

}

// Instantiate the DisplayNameAuthorPermaLink class
$DisplayNameAuthorPermaLink = new DisplayNameAuthorPermaLink();

