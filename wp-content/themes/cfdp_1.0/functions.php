<?php

// Load jQuery
if( !is_admin()){
  function mytheme_enqueue_scripts() {
    wp_deregister_script('jquery');
    wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"), false, '1.7.1');
    wp_enqueue_script('jquery');
  }
  add_action('wp_enqueue_scripts', 'mytheme_enqueue_scripts');
}

	// Add RSS links to <head> section
add_theme_support( 'automatic-feed-links' );

// Add support for featured images
add_theme_support( 'post-thumbnails' );

//Remove ... from excerpt()
function new_excerpt_more($more) {
	return '';
}
add_filter('excerpt_more', 'new_excerpt_more');

//change excerpt length
function new_excerpt_length($length) {
	return 2000;
}
add_filter('excerpt_length', 'new_excerpt_length');

//Add Unlink category
function the_category_unlinked($separator = ' ') {
  $categories = (array) get_the_category();

  $thelist = '';
  foreach($categories as $category) {    // concate
      $thelist .= $separator . $category->category_nicename;
  }
  echo $thelist;
}

//Truncate text
function truncate($str, $len){
  if (strlen($str) > $len) {
     $truncated = substr($str,0,strpos($str,' ',$len));
      echo $truncated . "...";
  } else {
     echo $str;
  }
}

//Get the authors permalink hack
function authorPermalink($userDisplayName){
	$displayNameLower = strtolower($userDisplayName);
	$displayNameLowerScore = str_replace(" ","-",$displayNameLower);
	echo $displayNameLowerScore;
}

// Remove & add elements in user profile
function my_new_contactmethods( $contactmethods ) {
  unset($contactmethods['aim']);
  unset($contactmethods['jabber']);
  unset($contactmethods['yim']);
  $contactmethods['twitter'] = 'Twitter <br /> (fx twitter.com/#username#)';
  $contactmethods['facebook'] = 'Facebook <br /> (fx facebook.com/#username#)';
  $contactmethods['linkedin'] = 'Linkedin <br /> (fx linkedin.com/#username#)';
  return $contactmethods;
}
add_filter('user_contactmethods','my_new_contactmethods',10,1);

// Get all custom fields attached to a page

// Tutorial at http://www.kevinleary.net/advanced-content-management-wordpress-custom-field-templates/
if( !function_exists('base_get_all_custom_fields') ) {
	function base_get_all_custom_fields(){
		global $post;
		global $wpdb;
		$sql = "SELECT * FROM $wpdb->postmeta	WHERE post_id = $post->ID ORDER BY meta_id ASC";
		$custom_fields = $wpdb->get_results($sql);
		$custom_field_array = array();
		foreach($custom_fields as $field) {
			$custom_field_array["$field->meta_key"] = $field->meta_value;
		}
		return $custom_field_array;
	}
}

// Check if post is in parent cat
function post_is_in_descendant_category( $cats, $_post = null ) {
  foreach ( (array) $cats as $cat ) {
    // get_term_children() accepts integer ID only
    $descendants = get_term_children( (int) $cat, 'category');
    if ( $descendants && in_category( $descendants, $_post ) )
      return true;
  }
  return false;
}

// Custom fields tweak
function get_custom_field_value($szKey, $bPrint = false) {
  global $post;
  $szValue = get_post_meta($post->ID, $szKey, true);
  if ( $bPrint == false ) return $szValue; else echo $szValue;
}

// Clean up the <head>
function removeHeadLinks() {
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
}
add_action('init', 'removeHeadLinks');
remove_action('wp_head', 'wp_generator');

if (function_exists('register_sidebar')) {
	register_sidebar(array(
		'name' => 'Sidebar Widgets',
		'id'   => 'sidebar-widgets',
		'description'   => 'These are widgets for the sidebar.',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>'
	));
}

// Remove category "Not in feed", "International news" & Testbruger
function myFeedExcluder($query) {
 if ($query->is_feed) {
   $query->set('cat','-144,-35');
   $query->set( 'author', '-14' );
 }
return $query;
}

add_filter('pre_get_posts','myFeedExcluder');


?>