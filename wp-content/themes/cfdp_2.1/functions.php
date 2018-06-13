<?php

// Load jQuery
if( !is_admin()){
  function mytheme_enqueue_scripts() {
    wp_deregister_script('jquery');
    wp_register_script('jquery', ("https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"), false, '1.7.1');
    wp_enqueue_script('jquery');
  }
  add_action('wp_enqueue_scripts', 'mytheme_enqueue_scripts');
}



/* @Recreate the default filters on the_content so we can pull formated content with get_post_meta
-------------------------------------------------------------- */
add_filter( 'meta_content', 'wptexturize'        );
add_filter( 'meta_content', 'convert_smilies'    );
add_filter( 'meta_content', 'convert_chars'      );
add_filter( 'meta_content', 'wpautop'            );
add_filter( 'meta_content', 'shortcode_unautop'  );
add_filter( 'meta_content', 'prepend_attachment' );



function register_my_menu() {
  register_nav_menus(
    array(
      'header-menu' => __( 'Header Menu' ),
      'sub-header-menu' => __( 'Sub Header Menu' ),
      'mobile-menu' => __( 'Mobile Menu' )
    )
  );
}
add_action( 'init', 'register_my_menu' );

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


// Remove & add elements in user profile
function my_new_contactmethods( $contactmethods ) {
  unset($contactmethods['aim']);
  unset($contactmethods['jabber']);
  unset($contactmethods['yim']);
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

if ( function_exists('register_sidebar') )
  register_sidebar(array(
    'name' => 'Front page section',
    'before_widget' => '<div class = "frontpage-section">',
    'after_widget' => '</div>',
    'before_title' => '<h2>',
    'after_title' => '</h2>',
  )
);

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

if ( function_exists('register_sidebar') )
  register_sidebar(array(
    'name' => 'Newsletter signup',
    'before_widget' => '<div class = "newsletter">',
    'after_widget' => '</div>',
    'before_title' => '<h2>',
    'after_title' => '</h2>',
  )
);

if ( function_exists('register_sidebar') )
  register_sidebar(array(
    'name' => 'Footer',
    'before_widget' => '<div class = "footer">',
    'after_widget' => '</div>',
    'before_title' => '<h2>',
    'after_title' => '</h2>',
  )
);

// Remove category "Not in feed", "International news" & Testbruger
function myFeedExcluder($query) {
 if ($query->is_feed) {
   $query->set('cat','-144,-35');
   $query->set( 'author', '-14' );
 }
return $query;
}

add_filter('pre_get_posts','myFeedExcluder');























class CSS_Menu_Maker_Walker extends Walker {

  var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );

  function start_lvl( &$output, $depth = 0, $args = array() ) {
    $indent = str_repeat("\t", $depth);
    $output .= "\n$indent<ul>\n";
  }

  function end_lvl( &$output, $depth = 0, $args = array() ) {
    $indent = str_repeat("\t", $depth);
    $output .= "$indent</ul>\n";
  }

  function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

    global $wp_query;
    $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
    $class_names = $value = '';
    $classes = empty( $item->classes ) ? array() : (array) $item->classes;

    /* Add active class */
    if(in_array('current-menu-item', $classes)) {
      $classes[] = 'active';
      unset($classes['current-menu-item']);
    }

    /* Check for children */
    $children = get_posts(array('post_type' => 'nav_menu_item', 'nopaging' => true, 'numberposts' => 1, 'meta_key' => '_menu_item_menu_item_parent', 'meta_value' => $item->ID));
    if (!empty($children)) {
      $classes[] = 'has-sub';
    }

    $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
    $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

    $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
    $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

    $output .= $indent . '<li' . $id . $value . $class_names .'>';

    $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
    $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
    $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
    $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

    $item_output = $args->before;
    $item_output .= '<a'. $attributes .'><span>';
    $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
    $item_output .= '</span></a>';
    $item_output .= $args->after;

    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
  }

  function end_el( &$output, $item, $depth = 0, $args = array() ) {
    $output .= "</li>\n";
  }
}






class CSS_Menu_Walker extends Walker {

	var $db_fields = array('parent' => 'menu_item_parent', 'id' => 'db_id');
	
	function start_lvl(&$output, $depth = 0, $args = array()) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul>\n";
	}
	
	function end_lvl(&$output, $depth = 0, $args = array()) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
	}
	
	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
	
		global $wp_query;
		$indent = ($depth) ? str_repeat("\t", $depth) : '';
		$class_names = $value = '';
		$classes = empty($item->classes) ? array() : (array) $item->classes;
		
		/* Add active class */
		if (in_array('current-menu-item', $classes)) {
			$classes[] = 'active';
			unset($classes['current-menu-item']);
		}
		
		/* Check for children */
		$children = get_posts(array('post_type' => 'nav_menu_item', 'nopaging' => true, 'numberposts' => 1, 'meta_key' => '_menu_item_menu_item_parent', 'meta_value' => $item->ID));
		if (!empty($children)) {
			$classes[] = 'has-sub';
		}
		
		$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
		$class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
		
		$id = apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args);
		$id = $id ? ' id="' . esc_attr($id) . '"' : '';
		
		$output .= $indent . '<li' . $id . $value . $class_names .'>';
		
		$attributes  = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
		$attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target    ) .'"' : '';
		$attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn       ) .'"' : '';
		$attributes .= ! empty($item->url)        ? ' href="'   . esc_attr($item->url       ) .'"' : '';
		
		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'><span>';
		$item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
		$item_output .= '</span></a>';
		$item_output .= $args->after;
		
		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
	}
	
	function end_el(&$output, $item, $depth = 0, $args = array()) {
		$output .= "</li>\n";
	}
}












?>
