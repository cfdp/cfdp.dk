<?php
/*
Plugin Name: WP to Twitter
Plugin URI: http://www.joedolson.com/articles/wp-to-twitter/
Description: Posts a Tweet when you update your WordPress blog or post to your blogroll, using your URL shortening service. Rich in features for customizing and promoting your Tweets.
Version: 2.6.5
Author: Joseph Dolson
Author URI: http://www.joedolson.com/
*/
/*  Copyright 2008-2013  Joseph C Dolson  (email : wp-to-twitter@joedolson.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ('wp-to-twitter.php' == basename($_SERVER['SCRIPT_FILENAME'])) { die ('<h2>Direct File Access Prohibited</h2>');}
global $wp_version;
$wp_content_url = content_url();
$wp_content_dir = str_replace( '/plugins/wp-to-twitter','',plugin_dir_path( __FILE__ ) );
if ( defined('WP_CONTENT_URL') ) { $wp_content_url = constant('WP_CONTENT_URL');}
if ( defined('WP_CONTENT_DIR') ) { $wp_content_dir = constant('WP_CONTENT_DIR');}

define( 'WPT_DEBUG',false );
define( 'WPT_DEBUG_ADDRESS', 'debug@joedolson.com' );
// define( 'WPT_DEBUG_ADDRESS', 'debug@joedolson.com, yourname@youraddress.com' ); // for multiple recipients.

$wp_plugin_url = plugins_url();
include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); // required in order to access is_plugin_active()

if ( version_compare( phpversion(), '5.0', '<' ) ) {
	$warning = __('WP to Twitter requires PHP version 5 or above. Please upgrade PHP to run WP to Twitter.','wp-to-twitter' );
	add_action('admin_notices', create_function( '', "echo \"<div class='error'><p>$warning</p></div>\";" ) );
} else {
	require_once( plugin_dir_path(__FILE__).'/wp-to-twitter-oauth.php' );
}
require_once( plugin_dir_path(__FILE__).'/wp-to-twitter-shorteners.php' );
require_once( plugin_dir_path(__FILE__).'/wp-to-twitter-manager.php' );
require_once( plugin_dir_path(__FILE__).'/wpt-functions.php' );

global $wpt_version,$jd_plugin_url;
$wpt_version = "2.6.5";
$plugin_dir = basename(dirname(__FILE__));
load_plugin_textdomain( 'wp-to-twitter', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );

function wpt_pro_compatibility() {
	global $wptp_version;
	$current_wptp_version = '1.4.1';
	if ( version_compare( $wptp_version, $current_wptp_version, '<' ) ) {
		echo "<div class='error notice'><p class='upgrade'>".sprintf( __('The current version of WP Tweets PRO is <strong>%s</strong>. Upgrade for best compatibility!','wp-to-twitter'),$current_wptp_version )."</p></div>";
	}
}

$jd_plugin_url = "http://www.joedolson.com/articles/wp-to-twitter/";
$jd_donate_url = "http://www.joedolson.com/articles/wp-tweets-pro/";

function wpt_marginal_function() {
global $wp_version;
$exit_msg=__('WP to Twitter requires WordPress 3.1.4 or a more recent version <a href="http://codex.wordpress.org/Upgrading_WordPress">Please update WordPress to continue using WP to Twitter with all features!</a>','wp-to-twitter');
	if ( version_compare( $wp_version,"3.1.4","<" ) ) {
		if ( is_admin() ) {
			echo "<div class='error'><p>".($exit_msg)."</p></div>";
		}
	}
}
 // check for OAuth configuration
function wpt_check_oauth( $auth=false ) {
	if ( !function_exists('wtt_oauth_test') ) {
		$oauth = false;
	} else {
		$oauth = wtt_oauth_test( $auth );
	}
	return $oauth;
}

function wpt_check_version() {
	global $wpt_version;
	$prev_version = get_option( 'wp_to_twitter_version' );
	if ( version_compare( $prev_version,$wpt_version,"<" ) ) {
		wptotwitter_activate();
	}
}

function wptotwitter_activate() {
global $wpt_version;
$prev_version = get_option( 'wp_to_twitter_version' );
// this is a switch to plan for future versions
$upgrade = version_compare( $prev_version,"2.2.9","<" );
	if ($upgrade) {
		delete_option( 'x-twitterlogin' );
		delete_option( 'twitterlogin' );
		delete_option( 'twitterpw' );
		delete_option( 'jd-use-link-title' );
		delete_option( 'jd-use-link-description' );
		delete_option( 'jd_use_both_services' );
		delete_option( 'jd-twitter-service-name' );
		delete_option( 'jd_api_post_status' );
		delete_option( 'jd-twitter-char-limit' );
		delete_option( 'x-twitterpw' );	
		delete_option( 'x_jd_api_post_status' );
		delete_option( 'cligsapi' );
		delete_option( 'cligslogin' );
		delete_option( 'wp_cligs_error' );
	}
$upgrade = version_compare( $prev_version, "2.3.1","<" );
	if ($upgrade) {
		$array = 
			array(
				'post'=> array(
						'post-published-update'=>get_option('newpost-published-update'),
						'post-published-text'=>get_option('newpost-published-text'),
						'post-edited-update'=>get_option('oldpost-edited-update'),
						'post-edited-text'=>get_option('oldpost-edited-text')
					),
				'page'=> array(
						'post-published-update'=>get_option('jd_twit_pages'),
						'post-published-text'=>get_option('newpage-published-text'),
						'post-edited-update'=>get_option('jd_twit_edited_pages'),
						'post-edited-text'=>get_option('oldpage-edited-text')				
					)
			);
		add_option( 'wpt_post_types', $array );
		add_option( 'comment-published-update', 0 );
		add_option( 'comment-published-text', 'New comment on #title# #url#' );
		delete_option('newpost-published-update');
		delete_option('newpost-published-text');
		delete_option('oldpost-edited-update');
		delete_option('oldpost-edited-text');
		delete_option('newpage-published-text');
		delete_option('oldpage-edited-text');
		delete_option( 'newpost-published-showlink' );
		delete_option( 'oldpost-edited-showlink' );
		delete_option( 'jd_twit_pages' );
		delete_option( 'jd_twit_edited_pages' );		
		delete_option( 'jd_twit_postie' );
	}
$upgrade = version_compare( $prev_version, "2.3.3","<" );
	if ( $upgrade ) {
		delete_option( 'jd_twit_quickpress' );
	}
$upgrade = version_compare( $prev_version, "2.3.4","<" );
	if ( $upgrade ) {
		add_option( 'wpt_inline_edits', '0' );
	}
$upgrade = version_compare( $prev_version, "2.3.15","<" );
	if ( $upgrade ) {
		$use = get_option( 'use_tags_as_hashtags' );
		if ( $use == 1 ) {
			$wpt_settings = get_option( 'wpt_post_types' );
			$post_types = get_post_types( '', 'names' );
			foreach ( $post_types as $type ) {
				if ( isset($wpt_settings[$type]) ) {
					$t1 = $wpt_settings[$type]['post-published-text'].' #tags#';
					$t2 = $wpt_settings[$type]['post-edited-text'].' #tags#';
					$wpt_settings[$type]['post-published-text'] = $t1;
					$wpt_settings[$type]['post-edited-text'] = $t2;
				}
			}
			update_option('wpt_post_types',$wpt_settings );
		}
		delete_option( 'use_tags_as_hashtags' );
	}
	$upgrade = version_compare( $prev_version, "2.4.0","<" );
	if ( $upgrade ) {
		$perms = get_option('wtt_user_permissions');
		switch( $perms ) {
			case 'read':$update = 'subscriber';	break;
			case 'edit_posts':$update = 'contributor';	break;
			case 'publish_posts':$update = 'author';	break;
			case 'moderate_comments':$update = 'editor';	break;
			case 'manage_options':$update = 'administrator';	break;
			default:$update = 'administrator';
		}
		update_option( 'wtt_user_permissions',$update );
	}
	$upgrade = version_compare( $prev_version, "2.4.1","<" );
	if ( $upgrade ) {
		$subscriber = get_role('subscriber');
		$contributor = get_role('contributor');
		$author = get_role('author');
		$editor = get_role('editor');
		$administrator = get_role('administrator');
		$administrator->add_cap('wpt_twitter_oauth');
		$administrator->add_cap('wpt_twitter_custom');
		$administrator->add_cap('wpt_twitter_switch'); // can toggle tweet/don't tweet
		switch ( get_option('wtt_user_permissions') ) { // users that can add twitter information
			case 'subscriber': $subscriber->add_cap('wpt_twitter_oauth'); $contributor->add_cap('wpt_twitter_oauth'); $author->add_cap('wpt_twitter_oauth'); $editor->add_cap('wpt_twitter_oauth');   break;
			case 'contributor': $contributor->add_cap('wpt_twitter_oauth'); $author->add_cap('wpt_twitter_oauth'); $editor->add_cap('wpt_twitter_oauth');  break;
			case 'author': $author->add_cap('wpt_twitter_oauth'); $editor->add_cap('wpt_twitter_oauth'); break;
			case 'editor':$editor->add_cap('wpt_twitter_oauth'); break;
			case 'administrator': break;
			default: 
				$role = get_role( get_option('wtt_user_permissions') ); 
				if ( is_object($role) ) {			
					$role->add_cap('wpt_twitter_oauth');
				}
			break;
		}
		switch ( get_option('wtt_show_custom_tweet') ) { // users that can compose a custom tweet
			case 'subscriber': $subscriber->add_cap('wpt_twitter_custom'); $contributor->add_cap('wpt_twitter_custom'); $author->add_cap('wpt_twitter_custom'); $editor->add_cap('wpt_twitter_custom');   break;
			case 'contributor': $contributor->add_cap('wpt_twitter_custom'); $author->add_cap('wpt_twitter_custom'); $editor->add_cap('wpt_twitter_custom');  break;
			case 'author': $author->add_cap('wpt_twitter_custom'); $editor->add_cap('wpt_twitter_custom'); break;
			case 'editor':$editor->add_cap('wpt_twitter_custom'); break;
			case 'administrator': break;
			default: 
				$role = get_role( get_option('wtt_show_custom_tweet') );
				if ( is_object($role) ) {
					$role->add_cap('wpt_twitter_custom');
				}
			break;
		}
	}
	$upgrade = version_compare( $prev_version, "2.4.13","<" );
	if ( $upgrade ) {
		$administrator = get_role('administrator');
			$administrator->add_cap('wpt_can_tweet');
		$editor = get_role('editor');
			if ( is_object( $editor ) ) { $editor->add_cap('wpt_can_tweet'); }
		$author = get_role('author');
			if ( is_object( $author ) ) { $author->add_cap('wpt_can_tweet'); }
		$contributor = get_role('contributor');
			if ( is_object( $contributor ) ) { $contributor->add_cap('wpt_can_tweet'); }
		update_option('wpt_can_tweet','contributor');
	}
	update_option( 'wp_to_twitter_version',$wpt_version );
}	
	
// Function checks for an alternate URL to be Tweeted. Contribution by Bill Berry.	
function wpt_link( $post_ID ) {
	$ex_link = false;
       $wtb_extlink_custom_field = get_option('jd_twit_custom_url'); 
       $permalink = get_permalink( $post_ID );
			if ( $wtb_extlink_custom_field != '' ) {
				$ex_link = get_post_meta($post_ID, $wtb_extlink_custom_field, true);
			}
       return ( $ex_link ) ? $ex_link : $permalink;
}

function wpt_saves_error( $id, $auth, $twit, $error, $http_code, $ts ) {
	$http_code = (int) $http_code;
	if ( $http_code != 200 ) {
		add_post_meta( $id, '_wpt_failed', array( 'author'=>$auth, 'sentence'=>$twit, 'error'=>$error,'code'=>$http_code, 'timestamp'=>$ts ) );
	}
}

// This function performs the API post to Twitter
function jd_doTwitterAPIPost( $twit, $auth=false, $id=false ) {
	if ( !wpt_check_oauth( $auth )	) { 
			wpt_saves_error( $id, $auth, $twit, __('This account is not authorized to post to Twitter.','wp-tweets-pro'), '401', time() );
			return true; 
	} // exit silently if not authorized
	$check = ( !$auth )?get_option('jd_last_tweet'):get_user_meta( $auth, 'wpt_last_tweet', true ); // get user's last tweet
	// prevent duplicate Tweets
	if ( $check == $twit ) {
		if ( WPT_DEBUG && function_exists( 'wpt_pro_exists' ) ) {
			wp_mail( WPT_DEBUG_ADDRESS,"Matched twit check: tweet identical: #$id","$twit, $auth, $id" ); // DEBUG
		}
		wpt_saves_error( $id, $auth, $twit, __('This tweet is identical to another Tweet recently sent to this account.','wp-tweets-pro'), '403', time() );
		return true;
	} else if ( $twit == '' || !$twit ) {
		if ( WPT_DEBUG && function_exists( 'wpt_pro_exists' ) ) {
			wp_mail( WPT_DEBUG_ADDRESS,"Tweet check: empty sentence: #$id","$twit, $auth, $id" ); // DEBUG
		}
		wpt_saves_error( $id, $auth, $twit, __('This tweet was blank and could not be sent to Twitter.','wp-tweets-pro'), '403', time() );
		return true;	
	} else {
		$protocol = ( get_option( 'wpt_http' ) == '1' )?'http:':'https:';
		$jdwp_api_post_status = "$protocol//api.twitter.com/1.1/statuses/update.json";
		if ( wtt_oauth_test( $auth ) && ( $connection = wtt_oauth_connection( $auth ) ) ) {
			$connection->post( $jdwp_api_post_status, array( 'status' => $twit, 'source' => 'wp-to-twitter', 'include_entities' => 'true', 'lang'=>'de' ) );
			$http_code = ($connection)?$connection->http_code:'failed';
		} else if ( wtt_oauth_test( false ) && ( $connection = wtt_oauth_connection( false ) ) ) {
			$connection->post( $jdwp_api_post_status, array( 'status' => $twit, 'source' => 'wp-to-twitter', 'include_entities' => 'true'	) );
			$http_code = ($connection)?$connection->http_code:'failed';	
		}
		// DEBUG JCD
		if ( $connection ) {
			if ( isset($connection->http_header['x-access-level']) && $connection->http_header['x-access-level'] == 'read' ) { $supplement = sprintf( __('Your Twitter application does not have read and write permissions. Go to <a href="%s">your Twitter apps</a> to modify these settings.','wp-to-twitter'), 'https://dev.twitter.com/apps/' ); } else { $supplement = ''; }
			$return = false;
			switch ($http_code) {
				case '200':
					$return = true;
					$error = __("200 OK: Success!",'wp-to-twitter');
					update_option('wpt_authentication_missing', false );
					break;
				case '400':
					$error = __("400 Bad Request: The request was invalid. This is the status code returned during rate limiting.",'wp-to-twitter');
					break;
				case '401':
					$error = __("401 Unauthorized: Authentication credentials were missing or incorrect.",'wp-to-twitter');
					update_option( 'wpt_authentication_missing',"$auth");
					break;
				case '403':
					$error = __("403 Forbidden: The request is understood, but it has been refused by Twitter. Reasons: Too many Tweets in a short time or the same Tweet was submitted twice, among others. Not an error from WP to Twitter.",'wp-to-twitter');
					break;
				case '404':
					$error = __("404 Not Found: The URI requested is invalid or the resource requested does not exist.",'wp-to-twitter');
					break;	
				case '406':
					$error = __("406 Not Acceptable: Invalid Format Specified.",'wp-to-twitter');
					break;
				case '429':
					$error = __("429 Too Many Requests: You have exceeded your rate limits.",'wp-to-twitter');
					break;					
				case '500':
					$error = __("500 Internal Server Error: Something is broken at Twitter.",'wp-to-twitter');
					break;
				case '502':
					$error = __("502 Bad Gateway: Twitter is down or being upgraded.",'wp-to-twitter');
					break;					
				case '503':
					$error = __("503 Service Unavailable: The Twitter servers are up, but overloaded with requests - Please try again later.",'wp-to-twitter');
					break;
				case '504':
					$error = __("504 Gateway Timeout: The Twitter servers are up, but the request couldn't be serviced due to some failure within our stack. Try again later.",'wp-to-twitter');
					break;
				default:
					$error = __("<strong>Code $http_code</strong>: Twitter did not return a recognized response code.",'wp-to-twitter');
					break;
			}
			$error .= ($supplement != '')?" $supplement":'';
			// debugging
				if ( WPT_DEBUG && function_exists( 'wpt_pro_exists' ) ) {
					wp_mail( WPT_DEBUG_ADDRESS,"Twitter Response Code: #$id","$http_code, $error" ); // DEBUG
				}			
			// end debugging
			$update = ( !$auth )?update_option( 'jd_last_tweet',$twit ):update_user_meta( $auth, 'wpt_last_tweet',$twit );
			wpt_saves_error( $id, $auth, $twit, $error, $http_code, time() );
			if ( $http_code == '200' ) {
				$jwt = get_post_meta( $id, '_jd_wp_twitter', true );
				if ( !is_array( $jwt ) ){ $jwt=array(); }
				$jwt[] = urldecode( $twit );
				if ( empty($_POST) ) { $_POST = array(); }
				$_POST['_jd_wp_twitter'] = $jwt;
				update_post_meta( $id,'_jd_wp_twitter', $jwt );
			}
			if ( !$return ) {
				update_option( 'jd_status_message',$error );
			} else {
				delete_option( 'jd_status_message' );
			}
			return $return;			
		} else {
			update_option( 'jd_status_message',__('No Twitter OAuth connection found.','wp-to-twitter') );
		}
	}
}

function fake_normalize( $string ) {
	if ( version_compare( PHP_VERSION, '5.0.0', '>=' ) && function_exists('normalizer_normalize') && 1==2 ) {
		if ( normalizer_is_normalized( $string ) ) { return $string; }
		return normalizer_normalize( $string );
	} else {
		return preg_replace( '~&([a-z]{1,2})(acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml|mp);~i', '$1', htmlentities( $string, ENT_NOQUOTES, 'UTF-8' ) );
	}
}

function wpt_is_ssl( $url ) {
	if ( stripos( $url, 'https' ) ) { return true; } else { return false; }
}

function jd_truncate_tweet( $sentence, $postinfo, $post_ID, $retweet=false, $ref=false ) {
	$sentence = trim(custom_shortcodes( $sentence, $post_ID ));
	$post = get_post( $post_ID );
	
	if ($postinfo['shortUrl'] != '') {
		$shrink = $postinfo['shortUrl'];
	} else {
		$shrink = apply_filters( 'wptt_shorten_link', $postinfo['postLink'], $postinfo['postTitle'], $post_ID, false );
	}
	// generate all template variable values
	$auth = $postinfo['authId'];
	$title = trim( apply_filters( 'wpt_status', $postinfo['postTitle'], $post_ID, 'title' ) );
	$blogname = trim($postinfo['blogTitle']);
	$excerpt = trim( apply_filters( 'wpt_status', $postinfo['postExcerpt'], $post_ID, 'post' ) );
	$thisposturl = trim($shrink);
	$category = trim($postinfo['category']);
	$cat_desc = trim($postinfo['cat_desc']);
	$user_account = get_user_meta( $auth,'wtt_twitter_username', true ) ;
	$tags = wpt_generate_hash_tags( $post_ID );
	$account = get_option('wtt_twitter_username');
	$date = trim($postinfo['postDate']);
	$modified = trim($postinfo['postModified']);
	if ( get_option( 'jd_individual_twitter_users' ) == 1 ) {
		if ( $user_account == '' ) {
			if ( get_user_meta( $auth, 'wp-to-twitter-enable-user',true ) == 'mainAtTwitter' ) {
				$account = stripcslashes(get_user_meta( $auth, 'wp-to-twitter-user-username',true ));
			} else if ( get_user_meta( $auth, 'wp-to-twitter-enable-user',true ) == 'mainAtTwitterPlus' ) {
				$account = stripcslashes(get_user_meta( $auth, 'wp-to-twitter-user-username',true ) . ' @' . get_option( 'wtt_twitter_username' ));
			}
		} else {
			$account = "$user_account";
		}
	}
	$display_name = get_the_author_meta( 'display_name',$post->post_author );	
	// value of #author#
	$author = ( $user_account != '' )?"@$user_account":$display_name;	
	// value of #account# 
	$account = ( $account != '' )?"@$account":'';
	// value of #@# 
	$uaccount = ( $user_account != '' )?"@$user_account":"$account";	
	// clean up data if extra @ included //
	$account = str_ireplace( '@@','@',$account );
	$uaccount = str_ireplace( '@@', '@', $uaccount );
	$author = str_ireplace( '@@', '@', $author );
	if ( get_user_meta( $auth, 'wpt-remove', true ) == 'on' ) { $account = ''; }
	if ( get_option( 'jd_twit_prepend' ) != "" && $sentence != '' ) {
		$sentence = stripslashes(get_option( 'jd_twit_prepend' )) . " " . $sentence;
	}
	if ( get_option( 'jd_twit_append' ) != "" && $sentence != '' ) {
		$sentence = $sentence . " " . stripslashes(get_option( 'jd_twit_append' ));
	}
	$encoding = get_option('blog_charset');
	if ( $encoding == '' ) { $encoding = 'UTF-8'; } 

	if ( strpos( $sentence, '#url#' ) === false 
		&& strpos( $sentence, '#title#' ) === false
		&& strpos( $sentence, '#blog#' ) === false
		&& strpos( $sentence, '#post#' ) === false
		&& strpos( $sentence, '#category#' ) === false
		&& strpos( $sentence, '#date#' ) === false
		&& strpos( $sentence, '#author#' ) === false
		&& strpos( $sentence, '#displayname#' ) === false
		&& strpos( $sentence, '#tags#' ) === false
		&& strpos( $sentence, '#modified#' ) === false	
		&& strpos( $sentence, '#reference#' ) === false		
		&& strpos( $sentence, '#account#' ) === false	
		&& strpos( $sentence, '#@#' ) === false
		&& strpos( $sentence, '#cat_desc' ) === false
	) {
		// there are no tags in this Tweet. Truncate and return.
		$post_sentence = mb_substr( $sentence, 0, 139, $encoding ); 
		return $post_sentence;
	}

	if ( function_exists('wpt_pro_exists') && wpt_pro_exists() == true  ) {
		$reference = ( $ref ) ? $account : '@' . get_option( 'wtt_twitter_username' );
	}
	// create full unconditional post sentence - prior to truncation
	$post_sentence = str_ireplace( '#account#', $account, $sentence );
	$post_sentence = str_ireplace( '#@#', $uaccount, $post_sentence );
	if ( function_exists('wpt_pro_exists') && wpt_pro_exists() == true  ) {
		$post_sentence = str_ireplace( '#reference#', $reference, $post_sentence );
	} else {
		$post_sentence = str_ireplace( '#reference#', '', $post_sentence );	
	}
	$post_sentence = str_ireplace( '#url#', $thisposturl, $post_sentence );
	$post_sentence = str_ireplace( '#title#', $title, $post_sentence );
	$post_sentence = str_ireplace( '#blog#',$blogname, $post_sentence );
	$post_sentence = str_ireplace( '#post#',$excerpt, $post_sentence );
	$post_sentence = str_ireplace( '#category#',$category, $post_sentence );
	$post_sentence = str_ireplace( '#cat_desc#',$cat_desc, $post_sentence );
	$post_sentence = str_ireplace( '#date#', $date, $post_sentence );
	$post_sentence = str_ireplace( '#author#', $author, $post_sentence );
	$post_sentence = str_ireplace( '#displayname#', $display_name, $post_sentence );
	$post_sentence = str_ireplace( '#tags#', $tags, $post_sentence );
	$post_sentence = str_ireplace( '#modified#', $modified, $post_sentence );
	
	$url_strlen = mb_strlen( urldecode( fake_normalize( $thisposturl ) ), $encoding );
	// check total length 
	$str_length = mb_strlen( urldecode( fake_normalize( $post_sentence ) ), $encoding );
	if ( $str_length < 140 ) {
		if ( mb_strlen( fake_normalize ( $post_sentence ) ) > 140 ) { $post_sentence = mb_substr( $post_sentence,0,139,$encoding ); }
		return $post_sentence;
	} else {
		// what is the excerpt supposed to be?
		$length = get_option( 'jd_post_excerpt' );
		// build an array of variable names and the number of characters in that variable.
		$length_array = array();
		$length_array['excerpt'] = mb_strlen(fake_normalize($excerpt),$encoding);
		$length_array['title'] = mb_strlen(fake_normalize($title),$encoding);
		$length_array['date'] = mb_strlen(fake_normalize($date),$encoding);		
		$length_array['category'] = mb_strlen(fake_normalize($category),$encoding);
		$length_array['cat_desc'] = mb_strlen(fake_normalize($cat_desc),$encoding);
		$length_array['@'] = mb_strlen(fake_normalize("$uaccount"),$encoding);
		$length_array['blogname'] = mb_strlen(fake_normalize($blogname),$encoding);
		$length_array['author'] = mb_strlen(fake_normalize($author),$encoding);
		$length_array['account'] = mb_strlen(fake_normalize($account),$encoding);
		if ( function_exists('wpt_pro_exists') && wpt_pro_exists() == true  ) {
			$length_array['reference'] = mb_strlen(fake_normalize($reference),$encoding);
		}
		$length_array['tags'] = mb_strlen(fake_normalize($tags),$encoding);
		$length_array['modified'] = mb_strlen(fake_normalize($modified),$encoding);
		// if the total length is too long, truncate items until the length is appropriate. 
		// Twitter's t.co shortener is mandatory. All URLS are max-character value set by Twitter.			
		$tco = ( wpt_is_ssl( $thisposturl ) )?23:22;
		$order = get_option( 'wpt_truncation_order' );
		if ( is_array( $order ) ) {
			asort($order);
			$preferred = array();
			foreach ( $order as $k=>$v ) {
				$preferred[$k] = $length_array[$k];
			}
		} else {
			$preferred = $length_array;
		}
		$diff = ( ($url_strlen - $tco) > 0 )?$url_strlen-$tco:0;
		if ( $str_length > ( 140 + $diff ) ) {
			foreach($preferred AS $key=>$value) {
				$str_length = mb_strlen( urldecode( fake_normalize( trim( $post_sentence ) ) ),$encoding );
				if ( $str_length > ( 140 + $diff ) ) {
					$trim = $str_length - ( 140 + $diff );
					$old_value = ${$key};
					// prevent URL from being modified
					$post_sentence = str_ireplace( $thisposturl, '#url#', $post_sentence ); 
					// modify the value and replace old with new
					if ( $key == 'account' || $key == 'author' || $key == 'category' || $key == 'date' || $key == 'modified' || $key == 'reference' || $key == '@' ) {
						// these elements make no sense if truncated, so remove them entirely.
						$new_value = '';
					} else if ( $key == 'tags' ) {
                        // remove any stray hash characters due to string truncation
                        if (mb_strlen($old_value)-$trim <= 2) {
                            $new_value = '';
                        } else {
                            $new_value = $old_value;
                            while ((mb_strlen($old_value)-$trim) < mb_strlen($new_value)) {
                                $new_value = trim(mb_substr($new_value,0,mb_strrpos($new_value,'#',$encoding)-1));
                            }
                        }
					} else {
						$new_value = mb_substr( $old_value,0,-( $trim ),$encoding );					
					}
					$post_sentence = str_ireplace( $old_value,$new_value,$post_sentence );
					// put URL back before checking length
					$post_sentence = str_ireplace( '#url#', $thisposturl, $post_sentence ); 					
				} else {
					if ( mb_strlen( fake_normalize ( $post_sentence ),$encoding ) > ( 140 + $diff ) ) { $post_sentence = mb_substr( $post_sentence,0,( 139 + $diff ),$encoding ); }
				}
			}
		}
		// this is needed in case a tweet needs to be truncated outright and the truncation values aren't in the above.
		// 1) removes URL 2) checks length of remainder 3) Replaces URL
		if ( mb_strlen( fake_normalize( $post_sentence ) ) > 140 ) {
			$temp_sentence = str_ireplace( $thisposturl, '#url#', $post_sentence );
			if ( mb_strlen( fake_normalize( $temp_sentence ) ) > (140-$tco) && $temp_sentence != $post_sentence ) { 
				$post_sentence = trim(mb_substr( $temp_sentence,0,(140-$tco),$encoding ));
				// it's possible to trim off the #url# part in this process. If that happens, put it back.
				$sub_sentence = (strpos($sentence, '#url#')===false )?$post_sentence:$post_sentence .' '. $thisposturl;
				$post_sentence = ( strpos($post_sentence,'#url#') === false )?$sub_sentence:str_ireplace( '#url#',$thisposturl,$post_sentence );
			} else {
				return $post_sentence; // only longer if URL is included, therefore fine.
			}
			return $post_sentence; // has been shortened due to too much text.
		} else {
			return $post_sentence; // was never a problem, but got this far anyway.
		}
	}
	return $post_sentence; // catch all, should never happen. But no reason not to include it.
}

function wpt_in_allowed_category( $array ) {
	$allowed_categories =  get_option( 'tweet_categories' );
	if ( is_array( $array ) && is_array( $allowed_categories ) ) {
	$common = @array_intersect( $array,$allowed_categories );
		if ( WPT_DEBUG && function_exists( 'wpt_pro_exists' ) ) {
			wp_mail(WPT_DEBUG_ADDRESS,'Category Limits Results: ---', print_r($common,1) );
		}	
		if ( count( $common ) >= 1 ) {
			return true;
		} else {
			return false;
		}
	} else {
		return true;
	}
}

function jd_post_info( $post_ID ) {
	$post = get_post( $post_ID );
	$category_ids = false;
	$values = array();
	$values['id'] = $post_ID;
	// get post author
	$values['postinfo'] = $post;
	$values['authId'] = $post->post_author;
		$postdate = $post->post_date;
		$altformat = "Y-m-d H:i:s";	
		$dateformat = (get_option('jd_date_format')=='')?get_option('date_format'):get_option('jd_date_format');
		$thisdate = mysql2date( $dateformat,$postdate );
		$altdate = mysql2date( $altformat, $postdate );
	$values['_postDate'] = $altdate;
	$values['postDate'] = $thisdate;
		$moddate = $post->post_modified;
	$values['_postModified'] = mysql2date( $altformat,$moddate );
	$values['postModified'] = mysql2date( $dateformat,$moddate );
	// get first category
		$category = $cat_desc = null;
		$categories = get_the_category( $post_ID );
		if ( is_array( $categories ) ) {
			if ( count($categories) > 0 ) {
				$category = $categories[0]->cat_name;
				$cat_desc = $categories[0]->description;
			} 
			foreach ($categories AS $cat) {
				$category_ids[] = $cat->term_id;
			}
		} else {
			$category = '';
			$cat_desc = '';
			$category_ids = array();
		}
	$values['categoryIds'] = $category_ids;
	$values['category'] = $category;
	$values['cat_desc'] = $cat_desc;
		$excerpt_length = get_option( 'jd_post_excerpt' );
	$post_excerpt = ( trim( $post->post_excerpt ) == "" )?@mb_substr( strip_tags( strip_shortcodes( $post->post_content ) ), 0, $excerpt_length ):@mb_substr( strip_tags( strip_shortcodes( $post->post_excerpt ) ), 0, $excerpt_length );
	$encoding = get_option('blog_charset'); 
	if ( $encoding == '' ) { $encoding = 'UTF-8'; }
	$values['postExcerpt'] = html_entity_decode( $post_excerpt, ENT_COMPAT, $encoding );
	$thisposttitle =  stripcslashes( strip_tags( $post->post_title ) );
		if ($thisposttitle == "") {
			$thisposttitle =  stripcslashes( strip_tags( $_POST['title'] ) );
		}
	$values['postTitle'] = html_entity_decode( $thisposttitle, ENT_COMPAT, $encoding );
	$values['postLink'] = wpt_link( $post_ID );
	$values['blogTitle'] = get_bloginfo( 'name' );
	$values['shortUrl'] = wpt_short_url( $post_ID );
	$values['postStatus'] = $post->post_status;
	$values['postType'] = $post->post_type;
	$values = apply_filters( 'wpt_post_info',$values, $post_ID );
	return $values;
}

function wpt_short_url( $post_id ) {
	$jd_short = get_post_meta( $post_id, '_wp_jd_clig', true );
	if ( $jd_short == "" ) {$jd_short = get_post_meta( $post_id, '_wp_jd_supr', true );	}
	if ( $jd_short == "" ) {$jd_short = get_post_meta( $post_id, '_wp_jd_ind', true );	}		
	if ( $jd_short == "" ) {$jd_short = get_post_meta( $post_id, '_wp_jd_bitly', true );}
	if ( $jd_short == "" ) {$jd_short = get_post_meta( $post_id, '_wp_jd_wp', true );	}	
	if ( $jd_short == "" ) {$jd_short = get_post_meta( $post_id, '_wp_jd_yourls', true );}
	if ( $jd_short == "" ) {$jd_short = get_post_meta( $post_id, '_wp_jd_url', true );}
	if ( $jd_short == "" ) {$jd_short = get_post_meta( $post_id, '_wp_jd_goo', true );}
	if ( $jd_short == "" ) {$jd_short = get_post_meta( $post_id, '_wp_jd_target', true );}
	return $jd_short;
}

function jd_get_post_meta( $post_ID, $value, $boolean ) {
	$return = get_post_meta( $post_ID, "_$value", TRUE );
	if (!$return) {
		$return = get_post_meta( $post_ID, $value, TRUE );
	}
	return $return;
}

function jd_twit( $post_ID, $type='instant' ) {
	if ( WPT_DEBUG && function_exists( 'wpt_pro_exists' ) ) {
		wp_mail( WPT_DEBUG_ADDRESS,"jd_twit 0: jd_twit running #$post_ID","Post ID: $post_ID / $type" ); // DEBUG
	}	
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE || wp_is_post_revision($post_ID) ) { return $post_ID; }
	wpt_check_version();
	$jd_tweet_this = get_post_meta( $post_ID, '_jd_tweet_this', true );
	$newpost = $oldpost = $is_inline_edit = false;
	$sentence = '';
	if ( get_option('wpt_inline_edits') != 1 ) {
		if ( isset($_POST['_inline_edit']) ) { return; }
	} else {
		if ( isset($_POST['_inline_edit']) ) { $is_inline_edit = true; }
	}
	if ( WPT_DEBUG && function_exists( 'wpt_pro_exists' ) ) {
		wp_mail( WPT_DEBUG_ADDRESS,"jd_twit 1: JD Tweet This Value: #$post_ID","Tweet this: $jd_tweet_this / $type" ); // DEBUG
	}	
	if ( get_option('jd_tweet_default') == 0 ) { 
		$test = ( $jd_tweet_this != 'no')?true:false;
	} else { 
		$test = ( $jd_tweet_this == 'yes')?true:false;
	}
	if ( $test ) { // test switch: depend on default settings.
		$post_info = jd_post_info( $post_ID );
		if ( function_exists( 'wpt_pro_exists' ) && wpt_pro_exists() == true ) {
			$auth = ( get_option( 'wpt_cotweet_lock' ) == 'false' || !get_option('wpt_cotweet_lock') )?$post_info['authId']:get_option('wpt_cotweet_lock');
		} else {
			$auth = $post_info['authId'];
		}
		/* debug data */
		if ( WPT_DEBUG && function_exists( 'wpt_pro_exists' ) ) {
			wp_mail(WPT_DEBUG_ADDRESS,"jd_twit 2: POST Debug Data #$post_ID","Post_Info: ".print_r($post_info,1)."POST: ".print_r($_POST, 1). " / $type" );
		}
		if ( function_exists( 'wpt_pro_exists' ) && wpt_pro_exists() == true && function_exists('wpt_filter_post_info') ) {
			$filter = wpt_filter_post_info( $post_info );
			if ( $filter == true ) {
				if ( WPT_DEBUG && function_exists( 'wpt_pro_exists' ) ) { 
					wp_mail( WPT_DEBUG_ADDRESS,"jd_twit 3: Post filtered: #$post_ID",print_r($post_info,1)." / $type" ); 
				}
				return false; 
			}
		}
		$post_type = $post_info['postType'];
		// if the post modified date and the post date are the same, this is new.
		if ( $type == 'future' ) {
			$new = 1; // if this is a future action, then it should be published regardless of relationship
			if ( WPT_DEBUG && function_exists( 'wpt_pro_exists' ) ) { 
				wp_mail( WPT_DEBUG_ADDRESS,"jd_twit 4: Future post: #$post_ID",print_r($post_info,1)." / $type" ); 
			}			
		} else {
			$new = wpt_date_compare( $post_info['_postModified'], $post_info['_postDate'] );
		}
		// if this post is not previously published but has been backdated: lit. if post date is edited, but save option is 'publish'
		if ( $new == 0 && ( isset( $_POST['edit_date'] ) && $_POST['edit_date'] == 1 && !isset( $_POST['save'] ) ) ) { $new = 1; }
		// post modified = updated? // postdate == published? therefore: posts which have been updated after creation (scheduled, updated in draft) may not turn up as new. // postStatus == future
		$post_type_settings = get_option('wpt_post_types');
		$post_types = array_keys($post_type_settings);		
		if ( in_array( $post_type, $post_types ) ) {
			$template = '';
			$cT = get_post_meta( $post_ID, '_jd_twitter', true );
			if ( isset( $_POST['_jd_twitter'] ) && $_POST['_jd_twitter'] != '' ) { $cT = $_POST['_jd_twitter']; }
			$customTweet = ( $cT != '' )?stripcslashes( trim( $cT ) ):'';
				// if ops is set and equals 'publish', this is being edited. Otherwise, it's a new post.
				if ( ( $new == 0 && $post_info['postStatus'] != 'future' ) || $is_inline_edit == true ) {
					// if this is an old post and editing updates are enabled
					if ( WPT_DEBUG && function_exists( 'wpt_pro_exists' ) ) {
						wp_mail( WPT_DEBUG_ADDRESS,"jd_twit 4a: Processed as an Edit #$post_ID","Tweet this post: ".$post_info['postTitle']."\n".print_r($post_info,1)." / $type" ); // DEBUG
					}
					if ( $post_type_settings[$post_type]['post-edited-update'] == '1' ) {					
						$nptext = stripcslashes( $post_type_settings[$post_type]['post-edited-text'] );
						//$nptext = apply_filters( 'wpt_user_text', $nptext, 'publish', true ); // filters for user accounts automatically.
						$oldpost = true;
					}
				} else {
					if ( WPT_DEBUG && function_exists( 'wpt_pro_exists' ) ) {
						wp_mail( WPT_DEBUG_ADDRESS,"jd_twit 4b: Processed as a New Post #$post_ID","Tweet this: ".$post_info['postTitle']."\n".print_r($post_info,1)." / $type" ); // DEBUG
					}				
					if ( $post_type_settings[$post_type]['post-published-update'] == '1' ) {
						$nptext = stripcslashes( $post_type_settings[$post_type]['post-published-text'] );			
						//$nptext = apply_filters( 'wpt_user_text', $nptext, 'false', true ); // filters for user accounts automatically.
						$newpost = true;
					}
				}
//			}
			if ($newpost || $oldpost) {
				$template = ( $customTweet != "" ) ? $customTweet : $nptext;
				$sentence = jd_truncate_tweet( $template, $post_info, $post_ID );
					if ( WPT_DEBUG && function_exists( 'wpt_pro_exists' ) ) {
						wp_mail( WPT_DEBUG_ADDRESS,"jd_twit 5: Tweet Truncated #$post_ID","Truncated Tweet: $sentence / $type" ); // DEBUG
					}					
				if ( function_exists('wpt_pro_exists') && wpt_pro_exists() == true  ) {
					$sentence2 = jd_truncate_tweet( $template, $post_info, $post_ID, false, $auth );
				}
			}
			if ( $sentence != '' ) {
					$post_type_cats = get_object_taxonomies( $post_type );
					if ( in_array( 'category', $post_type_cats ) ) { 
					// 'category' is assigned to this post type, so apply filters.
						if ( get_option('jd_twit_cats') == '1' ) {
							$continue = ( !wpt_in_allowed_category( $post_info['categoryIds'] ) )?true:false;
						} else {
							$continue = ( wpt_in_allowed_category( $post_info['categoryIds'] ) )?true:false;
						}
					} else {
						$continue = true; 
					}
				if ( WPT_DEBUG && function_exists( 'wpt_pro_exists' ) && !$continue ) {
					wp_mail(WPT_DEBUG_ADDRESS,"jd_twit 6: Category limits applied #$post_ID", print_r($post_info['categoryIds'],1)." / $type" );
				}
				if ( get_option('limit_categories') == '0' ) { $continue = true; }
				if ( $continue ) {
					// WPT PRO //
					if ( function_exists( 'wpt_pro_exists' ) && wpt_pro_exists() == true ) {
						$user = get_userdata( $auth );
						$auth_verified = wtt_oauth_test( $auth,'verify' );
						$auth = ( get_option( 'jd_individual_twitter_users' ) != 1 || !$auth_verified )?false:$auth;
						if ( $post_info['wpt_delay_tweet'] == 0 || $post_info['wpt_delay_tweet'] == '' || $post_info['wpt_no_delay'] == 'on' ) {
							$tweet = jd_doTwitterAPIPost( $sentence, $auth, $post_ID );
							if ( $post_info['wpt_cotweet'] == 1 && $auth_verified ) {
								$tweet2 = jd_doTwitterAPIPost( $sentence2, false, $post_ID );				
							}
						} else {
							$time = ( (int) $post_info['wpt_delay_tweet'] )*60;
							wp_schedule_single_event( time()+$time, 'wpt_schedule_tweet_action', array( 'id'=>$auth, 'sentence'=>$sentence, 'rt'=>0, 'post_id'=>$post_ID ) );
							if ( WPT_DEBUG && function_exists( 'wpt_pro_exists' ) ) {
								wp_mail( WPT_DEBUG_ADDRESS,"jd_twit 7: JD Main Tweet Scheduled #$post_ID",print_r( array( 'id'=>$auth, 'sentence'=>$sentence, 'rt'=>0, 'post_id'=>$post_ID, 'timestamp'=>time()+$time, 'current_time'=>time(), 'timezone'=>get_option('gmt_offset') ),1)." / $type" ); // DEBUG
							}								
						
							if ( $post_info['wpt_cotweet'] == 1 && $auth_verified ) {
								$offset = rand(60,240);	// delay co-tweet by 1-4 minutes.						
								wp_schedule_single_event( time()+$time+$offset, 'wpt_schedule_tweet_action', array( 'id'=>false, 'sentence'=>$sentence2, 'rt'=>0, 'post_id'=>$post_ID ) );
									if ( WPT_DEBUG && function_exists( 'wpt_pro_exists' ) ) {
										wp_mail( WPT_DEBUG_ADDRESS,"jd_twit 8: JD CoTweet Scheduled #$post_ID",print_r($post_info,1)." / $type" ); // DEBUG
									}
								}
							$tweet = true;
						}
						if ( $post_info['wpt_retweet_after'] != 0 && $post_info['wpt_no_repost'] != 'on' ) {
							$repeat = $post_info['wpt_retweet_repeat'];
							for ( $i=1;$i<=$repeat;$i++ ) {
								if ( $i == 1 ) { 
									$prepend = ( get_option('wpt_prepend') == 1 )?'':get_option('wpt_prepend_rt');
									$append = ( get_option('wpt_prepend') != 1 )?'':get_option('wpt_prepend_rt');
									$retweet = jd_truncate_tweet( trim( $prepend.$template.$append ), $post_info, $post_ID,true );
									$retweet2 = jd_truncate_tweet( trim( $prepend.$template.$append ), $post_info, $post_ID, true, $auth );
								}
								if ( $i == 2 ) { 
									$prepend = ( get_option('wpt_prepend') == 1 )?'':get_option('wpt_prepend_rt2');
									$append = ( get_option('wpt_prepend') != 1 )?'':get_option('wpt_prepend_rt2');								
									$retweet = jd_truncate_tweet( trim( $prepend.$template.$append ), $post_info, $post_ID,true );
									$retweet2 = jd_truncate_tweet( trim( $prepend.$template.$append ), $post_info, $post_ID, true, $auth );
								}
								if ( $i == 3 ) {
									$prepend = ( get_option('wpt_prepend') == 1 )?'':get_option('wpt_prepend_rt3');
									$append = ( get_option('wpt_prepend') != 1 )?'':get_option('wpt_prepend_rt3');								
									$retweet = jd_truncate_tweet( trim( $prepend.$template.$append ), $post_info, $post_ID,true );
									$retweet2 = jd_truncate_tweet( trim( $prepend.$template.$append ), $post_info, $post_ID, true, $auth );
								}
								if ( $i == 4 ) {
									$prepend = ( get_option('wpt_prepend') == 1 )?'':get_option('wpt_prepend_rt');
									$append = ( get_option('wpt_prepend') != 1 )?'':get_option('wpt_prepend_rt');								
									$retweet = jd_truncate_tweet( trim( $prepend.$template.$append ), $post_info, $post_ID,true ); 
									$retweet2 = jd_truncate_tweet( trim( $prepend.$template.$append ), $post_info, $post_ID, true, $auth );
								}
								// add original delay to schedule
								$delay = ( isset($post_info['wpt_delay_tweet'] ) )?( (int) $post_info['wpt_delay_tweet'] )*60:0;
								$time = ($post_info['wpt_retweet_after'])*(60*60)*$i;
								wp_schedule_single_event( time()+$time+$delay, 'wpt_schedule_tweet_action', array( 'id'=>$auth, 'sentence'=>$retweet, 'rt'=>$i, 'post_id'=>$post_ID ) );
								if ( $post_info['wpt_cotweet'] == 1 && $auth_verified ) {
									$offset = rand(60,240); // delay each co-tweet by 1-4 minutes
									wp_schedule_single_event( time()+$time+$offset+$delay, 'wpt_schedule_tweet_action', array( 'id'=>false, 'sentence'=>$retweet2, 'rt'=>$i, 'post_id'=>$post_ID ) );
								}
								$tweet = true;
								if ( $i == 4 ) { break; }
							}
						}
					} else {
						$tweet = jd_doTwitterAPIPost( $sentence, false, $post_ID );
					}
					// END WPT PRO //
					if ( $tweet == false ) {
						update_option( 'wp_twitter_failure','1' );
					}
				}
			}
		} else {
			return $post_ID;
		}
	}
	return $post_ID;
}

// Add Tweets on links in Blogroll
function jd_twit_link( $link_ID )  {
	wpt_check_version();
	global $wpt_version;
	$thislinkprivate = $_POST['link_visible'];
	if ($thislinkprivate != 'N') {
		$thislinkname = stripcslashes( $_POST['link_name'] );
		$thispostlink =  $_POST['link_url'] ;
		$thislinkdescription =  stripcslashes( $_POST['link_description'] );
		$sentence = stripcslashes( get_option( 'newlink-published-text' ) );
		$sentence = str_ireplace("#title#",$thislinkname,$sentence);
		$sentence = str_ireplace("#description#",$thislinkdescription,$sentence);		 

		if (mb_strlen( $sentence ) > 118) {
			$sentence = mb_substr($sentence,0,114) . '...';
		}
		$shrink = apply_filters( 'wptt_shorten_link', $thispostlink, $thislinkname, false, 'link' );
			if ( stripos($sentence,"#url#") === FALSE ) {
				$sentence = $sentence . " " . $shrink;
			} else {
				$sentence = str_ireplace("#url#",$shrink,$sentence);
			}						
			if ( $sentence != '' ) {
				$tweet = jd_doTwitterAPIPost( $sentence, false, $link_ID );
				if ( $tweet == false ) { update_option('wp_twitter_failure','2'); }
			}
		return $link_ID;
	} else {
		return;
	}
}

// Add comment Tweet function from Luis Nobrega
function jd_twit_comment( $comment_id, $approved ) {	
	$_t = get_comment( $comment_id );
	$post_ID = $_t->comment_post_ID;
	$commenter = $_t->comment_author;
	$jd_tweet_this = get_post_meta( $post_ID, '_jd_tweet_this', TRUE );
	if ( $jd_tweet_this != 'no' && $_t->comment_approved == 1 ) { // comments only tweeted on posts which are tweeted
		$post_info = jd_post_info( $post_ID );
		$sentence = '';
		$sentence = stripcslashes( get_option( 'comment-published-text' ) );
		$sentence = jd_truncate_tweet( $sentence, $post_info, $post_ID );
		$sentence = str_replace("#commenter#",$commenter,$sentence);
		if ( $sentence != '' ) {
			$tweet = jd_doTwitterAPIPost( $sentence, false, $post_ID );
		}
	}
	return $post_ID;
}

function wpt_generate_hash_tags( $post_ID ) {
	$hashtags = '';
	$max_tags = get_option( 'jd_max_tags' );
	$max_characters = get_option( 'jd_max_characters' );
	$max_characters = ( $max_characters == 0 || $max_characters == "" )?100:$max_characters + 1;
	if ($max_tags == 0 || $max_tags == "") { $max_tags = 100; }
		$tags = get_the_tags( $post_ID );
		if ( $tags > 0 ) {
		$i = 1;
			foreach ( $tags as $value ) {
			if ( get_option('wpt_tag_source') == 'slug' ) {
				$tag = $value->slug;
			} else {
				$tag = $value->name;
			}
			$replace = get_option( 'jd_replace_character' );
			$strip = get_option( 'jd_strip_nonan' );
			$search = "/[^\p{L}\p{N}\s]/u";
			if ( $replace == "[ ]" || $replace == "" ) { $replace = ""; }
			$tag = str_ireplace( " ",$replace,trim( $tag ) );
			if ($strip == '1') { $tag = preg_replace( $search, $replace, $tag ); }
				$newtag = "#$tag";
					if ( mb_strlen( $newtag ) > 2 && (mb_strlen( $newtag ) <= $max_characters) && ($i <= $max_tags) ) {
					$hashtags .= "$newtag ";
					$i++;
					}
			}
		}
	$hashtags = trim( $hashtags );
	if ( mb_strlen( $hashtags ) <= 1 ) { $hashtags = ""; }		
	return $hashtags;	
}

add_action('admin_menu','jd_add_twitter_outer_box');

function jd_add_twitter_outer_box() {
	wpt_check_version();
	// add Twitter panel to post types where it's enabled.
	$wpt_post_types = get_option('wpt_post_types');
	if ( function_exists( 'add_meta_box' )) {
		if ( is_array( $wpt_post_types ) ) {
			foreach ($wpt_post_types as $key=>$value) {
				if ( $value['post-published-update'] == 1 || $value['post-edited-update'] == 1 ) {
					add_meta_box( 'wptotwitter_div','WP to Twitter', 'jd_add_twitter_inner_box', $key, 'advanced' );
				}
			}
		}
	}
}

function jd_add_twitter_inner_box( $post ) {
	if ( current_user_can('wpt_can_tweet') ) {
	global $jd_plugin_url, $jd_donate_url;
		$post_length = 140;
		$wpt_settings = get_option('wpt_post_types');
		if ( is_object( $post ) ) {
			$type = $post->post_type;
			$status = $post->post_status;
			$post_id = $post->ID;
		} 
		$jd_twitter = esc_attr( stripcslashes( get_post_meta($post_id, '_jd_twitter', true ) ) );
		$jd_twitter = apply_filters( 'wpt_user_text', $jd_twitter, $status );
		$jd_template = ( $status == 'publish' )?$wpt_settings[$type]['post-edited-text']:$wpt_settings[$type]['post-published-text'];
		$jd_tweet_this = get_post_meta( $post_id, '_jd_tweet_this', true );
		if ( $jd_tweet_this == '' ) { 
			$jd_tweet_this = (get_option( 'jd_tweet_default' ) == '1' )?'no':'yes'; 
		}
		if ( isset( $_GET['action'] ) && $_GET['action'] == 'edit' && get_option( 'jd_tweet_default_edit' ) == '1' ) { $jd_tweet_this = 'no'; }
		$previous_tweets = get_post_meta ( $post_id, '_jd_wp_twitter', true );
		$failed_tweets = get_post_meta( $post_id, '_wpt_failed' );
		?>
	<?php if ( current_user_can('update_core') && function_exists( 'wpt_pro_exists' ) ) { wpt_pro_compatibility(); } ?>
	<?php if ( current_user_can('update_core') && !function_exists( 'wpt_pro_exists' ) ) { ?> <strong><a target="__blank" href="<?php echo $jd_donate_url; ?>"><?php _e('Upgrade to WP Tweets Pro!', 'wp-to-twitter', 'wp-to-twitter') ?></a></strong> <?php } ?>
	<?php if ( current_user_can( 'wpt_twitter_custom' ) || current_user_can('update_core') ) { ?>
	<p class='jtw'>
	<label for="jtw"><?php _e("Custom Twitter Post", 'wp-to-twitter', 'wp-to-twitter') ?></label><br /><textarea class="attachmentlinks" name="_jd_twitter" id="jtw" rows="2" cols="60"><?php echo esc_attr( $jd_twitter ); ?></textarea>
	</p>
	<?php
		$jd_expanded = $jd_template;
			if ( get_option( 'jd_twit_prepend' ) != "" ) {
				$jd_expanded = "<span title='".__('Your prepended Tweet text; not part of your template.','wp-to-twitter')."'>".stripslashes( get_option( 'jd_twit_prepend' )) . "</span> " . $jd_expanded;
			}
			if ( get_option( 'jd_twit_append' ) != "" ) {
				$jd_expanded = $jd_expanded . " <span title='".__('Your appended Tweet text; not part of your template.','wp-to-twitter')."'>" . stripslashes(get_option( 'jd_twit_append' ))."</span>";
			}
			/* $turl = ( $status = "publish" )?wpt_short_url( $post_id ):'http://t.co/example1';
			$search = array( '#url#','#title#','#reference#','#post#','#category#','#date#','#modified#','#author#','#account#','#tags#','#blog#' );
			$replace = array( 
				'<span class="tw_url">'.$turl.'</span>',
				'<span class="tw_title">#title#</span>',
				'<span class="tw_post">#post#</span>',
				'<span class="tw_reference">#reference#</span>',
				'<span class="tw_category">#category#</span>',
				'<span class="tw_date">#date#</span>',
				'<span class="tw_modified">#modified#</span>',
				'<span class="tw_author">#author#</span>',
				'<span class="tw_tags">#tags#</span>',
				get_bloginfo('blogname') );
			$jd_expanded = str_replace( $search, $replace, $jd_expanded ); */ ?>
	<p class='template'><?php _e('Your template:','wp-to-twitter'); ?> <code><?php echo stripcslashes( $jd_expanded ); ?></code></p>

	<?php 
		if ( get_option('jd_keyword_format') == 2 ) {
			$custom_keyword = get_post_meta( $post_id, '_yourls_keyword', true );
			echo "<label for='yourls_keyword'>".__('YOURLS Custom Keyword','wp-to-twitter')."</label> <input type='text' name='_yourls_keyword' id='yourls_keyword' value='$custom_keyword' />";
		}
	?>
	<?php } else { ?>
	<input type="hidden" name='_jd_twitter' value='<?php echo esc_attr($jd_twitter); ?>' />
	<?php } ?>
	<?php if ( current_user_can( 'wpt_twitter_switch' ) || current_user_can('update_core') ) { ?>
	<?php
		// "no" means 'Don't Tweet' (is checked)
		$nochecked = ( $jd_tweet_this == 'no' )?' checked="checked"':'';
		$yeschecked = ( $jd_tweet_this == 'yes' )?' checked="checked"':'';
	?>
	<p><input type="radio" name="_jd_tweet_this" value="no" id="jtn"<?php echo $nochecked; ?> /> <label for="jtn"><?php _e("Don't Tweet this post.", 'wp-to-twitter'); ?></label> <input type="radio" name="_jd_tweet_this" value="yes" id="jty"<?php echo $yeschecked; ?> /> <label for="jty"><?php _e("Tweet this post.", 'wp-to-twitter'); ?></label></p>
	<?php } else { ?>
		<input type='hidden' name='_jd_tweet_this' value='<?php echo $jd_tweet_this; ?>' />
	<?php } ?>
	<?php /* WPT PRO */ ?>
	<?php 
	if ( function_exists('wpt_pro_exists') && wpt_pro_exists() == true  && ( current_user_can( 'wpt_twitter_custom' ) || current_user_can( 'update_core' ) ) ) { 
		wpt_schedule_values( $post_id ); 
	} ?>
	<?php /* WPT PRO */ ?>
	<?php if ( !current_user_can( 'wpt_twitter_custom' ) && !current_user_can( 'update_core' ) ) { ?>
	<div>
	<p><?php _e('Access to customizing WP to Twitter values is not allowed for your user role.','wp-to-twitter'); ?></p>
	<?php 
	if ( function_exists('wpt_pro_exists') && wpt_pro_exists() == true ) { 
		wpt_schedule_values( $post_id, 'hidden' ); 
	} ?>
	</div>
	<?php } ?>
	<?php if ( current_user_can( 'wpt_twitter_custom' ) || current_user_can( 'update_core' ) ) { ?>
	<p>
	<?php _e("Tweets are no more than 140 characters; Twitter counts URLs as 20 or 21 characters. Template tags: <code>#url#</code>, <code>#title#</code>, <code>#post#</code>, <code>#category#</code>, <code>#date#</code>, <code>#modified#</code>, <code>#author#</code>, <code>#account#</code>, <code>#tags#</code>, or <code>#blog#</code>.", 'wp-to-twitter') ?> 
	</p>
	<?php } ?>
	<?php if ( !is_array( $previous_tweets ) && $previous_tweets != '' ) { $previous_tweets = array( 0=>$previous_tweets ); } ?>
	<?php if ( ! empty( $previous_tweets ) || ! empty( $failed_tweets ) ) { ?>
	<hr>
	<p class='error'><strong><?php _e('Previous Tweets','wp-to-twitter'); ?>:</strong></p>
	<ul>
	<?php
	$hidden_fields = '';
		if ( is_array( $previous_tweets ) ) {
			foreach ( $previous_tweets as $previous_tweet ) {
				if ( $previous_tweet != '' ) {
					$hidden_fields .= "<input type='hidden' name='_jd_wp_twitter[]' value='".esc_attr($previous_tweet)."' />";
					echo "<li>$previous_tweet <a href='http://twitter.com/intent/tweet?text=".urlencode($previous_tweet)."'>Retweet this</a></li>";
				}
			}
		}
	?>
	</ul>
	<p class='error'><strong><?php _e('Failed Tweets','wp-to-twitter'); ?>:</strong></p>
	<ul>
	<?php
		$list = false;
		if ( is_array( $failed_tweets ) ) {
			foreach ( $failed_tweets as $failed_tweet ) {
				if ( !empty($failed_tweet) ) {
					$ft = $failed_tweet['sentence'];
					$reason = $failed_tweet['code'];
					$error = $failed_tweet['error'];
					$list = true;
					echo "<li> <code>Error: $reason</code> $ft <a href='http://twitter.com/intent/tweet?text=".urlencode($ft)."'>Tweet this</a><br /><em>$error</em></li>";
				}
			}
		}
		if ( !$list ) { echo "<li>".__('No failed tweets on this post.','wp-to-twitter')."</li>"; }
	?>
	</ul>
	<?php echo "<div>".$hidden_fields."</div>"; } ?>	
	<p>
	<?php if ( !function_exists( 'wpt_pro_exists' ) ) { ?>
	<a target="_blank" href="<?php echo admin_url('options-general.php?page=wp-to-twitter/wp-to-twitter.php'); ?>#get-support"><?php _e('Get Support', 'wp-to-twitter', 'wp-to-twitter') ?></a> &bull; <strong><a target="__blank" href="<?php echo $jd_donate_url; ?>"><?php _e('Upgrade to WP Tweets Pro', 'wp-to-twitter', 'wp-to-twitter') ?></a></strong> &raquo;
	<?php } else { ?>
	<a target="_blank" href="<?php echo admin_url('admin.php?page=wp-tweets-pro'); ?>#get-support"><?php _e('Get Support', 'wp-to-twitter', 'wp-to-twitter') ?></a> &raquo;
	<?php } ?>
	</p>
	<?php 
	} else { // permissions: this user isn't allowed to Tweet;
		_e('Your role does not have the ability to Post Tweets from this site.','wp-to-twitter'); ?> <input type='hidden' name='_jd_tweet_this' value='no' /> <?php
	}
} 

function wpt_admin_scripts( $hook ) {
global $current_screen;
	if ( $current_screen->base == 'post' || $current_screen->id == 'wp-tweets-pro_page_wp-to-twitter-schedule' ) {
		wp_enqueue_script(  'charCount', plugins_url( 'wp-to-twitter/js/jquery.charcount.js'), array('jquery') );
	}
}
add_action( 'admin_enqueue_scripts', 'wpt_admin_scripts', 10, 1 );

function wpt_admin_script( $hook ) {
global $current_screen;
if ( $current_screen->base == 'post' || $current_screen->id == 'wp-tweets-pro_page_wp-to-twitter-schedule' ) {
if ( $current_screen->base == 'post' ) {
	$allowed = 140 - mb_strlen( get_option('jd_twit_prepend').get_option('jd_twit_append') );
} else {
	$change = wpt_date_compare( date('Y-m-d'), '2012-02-20' );
	// temporary fix incase I don't hit the release date of 2/20.
	if ( $change === 1 ) {
		// if the home URL is SSL, I'm assuming sent URLs will be. Best I can do.
		$allowed = ( wpt_is_ssl( home_url() ) )?139:140;
	} else {
		// after February 20th, t.co links will be two characters longer.
		$allowed = ( wpt_is_ssl( home_url() ) )?137:138;		
	}
}
echo "
<script type='text/javascript'>
	jQuery(document).ready(function(\$){	
		//default usage
		\$('#jtw').charCount( { allowed: $allowed, counterText: '".__('Characters left: ','wp-to-twitter')."' } );
	});
</script>
<style type='text/css'>
#wptotwitter_div .jtw{ position: relative; padding-bottom: 1.4em;}
#wptotwitter_div .jtw textarea {font-size: 1.2em;}
#wptotwitter_div .counter{
	position:absolute;right:4%;bottom:0;
	font-size:1.3em;font-weight:700;color:#666;
}
#wptotwitter_div .warning{color:#700;}	
#wptotwitter_div .exceeded{color:#e00;}	
#wptotwitter_div code span { border-bottom: 1px dashed!important; cursor: pointer; }
#wptotwitter_div strong:first-child { border: 1px dashed; display: block; width: 25%; float: right; padding: 10px; background: #fff; font-size: 1.2em; line-height: 1.4; text-align:center; }
#wptotwitter_div strong:first-child a { display: block; padding-top: 80px; background: url(".plugins_url('wp-to-twitter/logo.png').") 50% 10px no-repeat; }
#wptotwitter_div .jtw { margin-right: 26%; width: 70%; }
#side-sortables #wptotwitter_div .jtw {margin: 0;width: 100%; }
#side-sortables #wptotwitter_div .jtw textarea { height: 120px; }
#side-sortables #wptotwitter_div strong:first-child { width: 90%; float: none; margin: 0 auto 10px;  }
</style>";
	}
}
add_action( 'admin_head', 'wpt_admin_script' );

// Post the Custom Tweet into the post meta table
function post_jd_twitter( $id ) {
	if ( empty($_POST) || ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) || wp_is_post_revision($id) || isset($_POST['_inline_edit']) ) { return $id; }
	if ( isset( $_POST['_yourls_keyword'] ) ) {
		$yourls = $_POST[ '_yourls_keyword' ];
		update_post_meta( $id, '_yourls_keyword', $yourls );
	}
	if ( isset( $_POST[ '_jd_twitter' ] ) && $_POST['_jd_twitter'] != '' ) {
		$jd_twitter = $_POST[ '_jd_twitter' ];
		update_post_meta( $id, '_jd_twitter', $jd_twitter );
	} 
	if ( isset( $_POST[ '_jd_wp_twitter' ] ) && $_POST['_jd_wp_twitter'] != '' ) {
		$jd_wp_twitter = $_POST[ '_jd_wp_twitter' ];
		update_post_meta( $id, '_jd_wp_twitter', $jd_wp_twitter );
	}
	if ( isset( $_POST[ '_jd_tweet_this' ] ) ) {
		$jd_tweet_this = ( $_POST[ '_jd_tweet_this' ] == 'no')?'no':'yes';
		update_post_meta( $id, '_jd_tweet_this', $jd_tweet_this );
	} else {
		if ( isset($_POST['_wpnonce'] ) ) {
			$jd_tweet_default = ( get_option( 'jd_tweet_default' ) == 1 )?'no':'yes';
			update_post_meta( $id, '_jd_tweet_this', $jd_tweet_default );
		}
	}
	// WPT PRO //
	apply_filters( 'wpt_insert_post', $_POST, $id );
	// WPT PRO //	

	if ( WPT_DEBUG && function_exists( 'wpt_pro_exists' ) ) {
		wp_mail( WPT_DEBUG_ADDRESS,"Post Meta Inserted: #$id",print_r($_POST,1) ); // DEBUG
	}		
}

function jd_twitter_profile() {
	global $user_ID;
	get_currentuserinfo();
	if ( current_user_can( 'wpt_twitter_oauth' ) || current_user_can('update_core') ) {
		$user_edit = ( isset($_GET['user_id']) )?(int) $_GET['user_id']:$user_ID; 

		$is_enabled = get_user_meta( $user_edit, 'wp-to-twitter-enable-user',true );
		$twitter_username = get_user_meta( $user_edit, 'wp-to-twitter-user-username',true );
		$wpt_remove = get_user_meta( $user_edit, 'wpt-remove', true );
		?>
		<h3><?php _e('WP Tweets User Settings', 'wp-to-twitter'); ?></h3>
		<?php if ( function_exists('wpt_connect_oauth_message') ) { wpt_connect_oauth_message( $user_edit ); } ?>
		<table class="form-table">
		<tr>
			<th scope="row"><?php _e("Use My Twitter Username", 'wp-to-twitter'); ?></th>
			<td><input type="radio" name="wp-to-twitter-enable-user" id="wp-to-twitter-enable-user-3" value="mainAtTwitter"<?php if ($is_enabled == "mainAtTwitter") { echo " checked='checked'"; } ?> /> <label for="wp-to-twitter-enable-user-3"><?php _e("Tweet my posts with an @ reference to my username.", 'wp-to-twitter'); ?></label><br />
			<input type="radio" name="wp-to-twitter-enable-user" id="wp-to-twitter-enable-user-4" value="mainAtTwitterPlus"<?php if ($is_enabled == "mainAtTwitterPlus") { echo " checked='checked'"; } ?> /> <label for="wp-to-twitter-enable-user-3"><?php _e("Tweet my posts with an @ reference to both my username and to the main site username.", 'wp-to-twitter'); ?></label>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="wp-to-twitter-user-username"><?php _e("Your Twitter Username", 'wp-to-twitter'); ?></label></th>
			<td><input type="text" name="wp-to-twitter-user-username" id="wp-to-twitter-user-username" value="<?php echo esc_attr( $twitter_username ); ?>" /> <?php _e('Enter your own Twitter username.', 'wp-to-twitter'); ?></td>
		</tr>
		<tr>
			<th scope="row"><label for="wpt-remove"><?php _e("Hide account name in Tweets", 'wp-to-twitter'); ?></label></th>
			<td><input type="checkbox" name="wpt-remove" id="wpt-remove" value="on"<?php if ( $wpt_remove == 'on' ) { echo ' checked="checked"'; } ?> /> <?php _e('Do not display my account in the #account# template tag.', 'wp-to-twitter'); ?></td>
		</tr>
		<?php if ( !function_exists('wpt_pro_exists') ) { add_filter( 'wpt_twitter_user_fields',create_function('','return;') ); } ?>
		<?php echo apply_filters('wpt_twitter_user_fields',$user_edit ); ?>
		</table>
		<?php 
		if ( function_exists('wpt_schedule_tweet') ) {
			if ( function_exists('wtt_connect_oauth') ) { wtt_connect_oauth( $user_edit ); }
		}
	}
}

function custom_shortcodes( $sentence, $post_ID ) {
	$pattern = '/([([\[\]?)([A-Za-z0-9-_])*(\]\]]?)+/';
	$params = array(0=>"[[",1=>"]]");
	preg_match_all($pattern,$sentence, $matches);
	if ($matches && is_array($matches[0])) {
		foreach ($matches[0] as $value) {
			$shortcode = "$value";
			$field = str_replace($params, "", $shortcode);
			$custom = strip_tags(get_post_meta( $post_ID, $field, TRUE ));
			$sentence = str_replace( $shortcode, $custom, $sentence );
		}
		return $sentence;
	} else {
		return $sentence;
	}
}
	
function jd_twitter_save_profile(){
	global $user_ID;
	get_currentuserinfo();
	if ( isset($_POST['user_id']) ) {
		$edit_id = (int) $_POST['user_id']; 
	} else {
		$edit_id = $user_ID;
	}
	$enable = ( isset($_POST['wp-to-twitter-enable-user']) )?$_POST['wp-to-twitter-enable-user']:'';
	$username = ( isset($_POST['wp-to-twitter-user-username']) )?$_POST['wp-to-twitter-user-username']:'';
	$wpt_remove = ( isset($_POST['wpt-remove']) )?'on':'';
	update_user_meta($edit_id ,'wp-to-twitter-enable-user' , $enable );
	update_user_meta($edit_id ,'wp-to-twitter-user-username' , $username );
	update_user_meta($edit_id ,'wpt-remove' , $wpt_remove );
	//WPT PRO
	apply_filters( 'wpt_save_user', $edit_id, $_POST );
}
function jd_list_categories() {
	$selected = "";
	$categories = get_categories('hide_empty=0');
	$nonce = wp_nonce_field('wp-to-twitter-nonce', '_wpnonce', true, false).wp_referer_field(false);
	$input = "<form action=\"\" method=\"post\">
	<div>$nonce</div>
	<fieldset><legend>".__('Check off categories to tweet','wp-to-twitter')."</legend>";
	$input .= '
	<p>
	<input type="checkbox" name="jd_twit_cats" id="jd_twit_cats" value="1"'.jd_checkCheckbox('jd_twit_cats').' />
	<label for="jd_twit_cats">'.__("Do not tweet posts in checked categories (Reverses default behavior)", 'wp-to-twitter').'</label>
	</p>';
	$input .= "
	<ul>\n";
	$tweet_categories =  get_option( 'tweet_categories' );
		foreach ($categories AS $cat) {
			if (is_array($tweet_categories)) {
				if (in_array($cat->term_id,$tweet_categories)) {
					$selected = " checked=\"checked\"";
				} else {
					$selected = "";
				}
			}
			$input .= '		<li><input'.$selected.' type="checkbox" name="categories[]" value="'.$cat->term_id.'" id="'.$cat->category_nicename.'" /> <label for="'.$cat->category_nicename.'">'.$cat->name."</label></li>\n";
		}
	$input .= "	</ul>
	</fieldset>
	<p>".__('Limits are exclusive. If a post is in one category which should be posted and one category that should not, it will not be posted.','wp-to-twitter')."</p>
	<div>
	<input type=\"hidden\" name=\"submit-type\" value=\"setcategories\" />
	<input type=\"submit\" name=\"submit\" class=\"button-primary\" value=\"".__('Set Categories','wp-to-twitter')."\" />
	</div>
	</form>";
	echo $input;
}

// Add the administrative settings to the "Settings" menu.
function jd_addTwitterAdminPages() {
    if ( function_exists( 'add_options_page' ) && !function_exists( 'wpt_pro_functions') ) {
		 $plugin_page = add_options_page( 'WP to Twitter', 'WP to Twitter', 'manage_options', __FILE__, 'wpt_update_settings' );
    }
}
add_action( 'admin_head', 'jd_addTwitterAdminStyles' );
function jd_addTwitterAdminStyles() {
	if ( isset($_GET['page']) && ( 1==1 || $_GET['page'] == "wp-to-twitter" || $_GET['page'] == "wp-to-twitter/wp-to-twitter.php" || $_GET['page'] == "wp-tweets-pro" || $_GET['page'] == "wp-to-twitter-schedule" || $_GET['page'] == "wp-to-twitter-tweets" || $_GET['page'] == "wp-to-twitter-errors" ) ) {
		echo '<link type="text/css" rel="stylesheet" href="'.plugins_url('/wp-to-twitter/styles.css').'" />';
	}
}

function jd_plugin_action($links, $file) {
	if ( $file == plugin_basename(dirname(__FILE__).'/wp-to-twitter.php') ) {
		$admin_url = ( is_plugin_active('wp-tweets-pro/wpt-pro-functions.php') )?admin_url('admin.php?page=wp-tweets-pro'):admin_url('options-general.php?page=wp-to-twitter/wp-to-twitter.php');
		global $jd_donate_url;
		$links[] = "<a href='$admin_url'>" . __('Settings', 'wp-to-twitter', 'wp-to-twitter') . "</a>";
		if ( ! function_exists( 'wpt_pro_exists' ) ) { $links[] = "<a href='$jd_donate_url'>" . __('Upgrade', 'wp-to-twitter', 'wp-to-twitter') . "</a>"; }	
	}
	return $links;
}
//Add Plugin Actions to WordPress
add_filter('plugin_action_links', 'jd_plugin_action', -10, 2);

if ( get_option( 'jd_individual_twitter_users')=='1') {
	add_action( 'show_user_profile', 'jd_twitter_profile' );
	add_action( 'edit_user_profile', 'jd_twitter_profile' );
	add_action( 'profile_update', 'jd_twitter_save_profile');
}

$admin_url = ( is_plugin_active('wp-tweets-pro/wpt-pro-functions.php') )?admin_url('admin.php?page=wp-tweets-pro'):admin_url('options-general.php?page=wp-to-twitter/wp-to-twitter.php');

if ( get_option( 'disable_url_failure' ) != '1' ) {
	if ( get_option( 'wp_url_failure' ) == '1' && !( isset($_POST['submit-type']) && $_POST['submit-type'] == 'clear-error' ) ) {
		add_action('admin_notices', create_function( '', "if ( ! current_user_can( 'manage_options' ) ) { return; } echo '<div class=\"error\"><p>';_e('There\'s been an error shortening your URL! <a href=\"".$admin_url."\">Visit your WP to Twitter settings page</a> to get more information and to clear this error message.','wp-to-twitter'); echo '</p></div>';" ) );
	}
}
if ( get_option( 'disable_twitter_failure' ) != '1' ) {
	if ( get_option( 'wp_twitter_failure' ) == '1' && !( isset($_POST['submit-type']) && $_POST['submit-type'] == 'clear-error' ) ) {
		add_action('admin_notices', create_function( '', "if ( ! current_user_can( 'manage_options' ) ) { return; } echo '<div class=\"error\"><p>';_e('There\'s been an error posting your Twitter status! <a href=\"".$admin_url."\">Visit your WP to Twitter settings page</a> to get more information and to clear this error message.','wp-to-twitter'); echo '</p></div>';" ) );
	}
}

add_action( 'in_plugin_update_message-wp-to-twitter/wp-to-twitter.php', 'wpt_plugin_update_message' );
function wpt_plugin_update_message() {
	global $wpt_version;
	$note = '';
	define('WPT_PLUGIN_README_URL',  'http://svn.wp-plugins.org/wp-to-twitter/trunk/readme.txt');
	$response = wp_remote_get( WPT_PLUGIN_README_URL, array ('user-agent' => 'WordPress/WP to Twitter' . $wpt_version . '; ' . get_bloginfo( 'url' ) ) );
	if ( ! is_wp_error( $response ) || is_array( $response ) ) {
		$data = $response['body'];
		$bits=explode('== Upgrade Notice ==',$data);
		$note = '<div id="wpt-upgrade"><p><strong style="color:#c22;">Upgrade Notes:</strong> '.nl2br(trim($bits[1])).'</p></div>';
	} else {
		printf(__('<br /><strong>Note:</strong> Please review the <a class="thickbox" href="%1$s">changelog</a> before upgrading.','wp-to-twitter'),'plugin-install.php?tab=plugin-information&amp;plugin=wp-to-twitter&amp;TB_iframe=true&amp;width=640&amp;height=594');
	}
	echo $note;
}

if ( get_option( 'jd_twit_blogroll' ) == '1' ) {
	add_action( 'add_link', 'jd_twit_link' );
}

$post_type_settings = get_option('wpt_post_types');
if ( is_array( $post_type_settings ) ) {
	$post_types = array_keys($post_type_settings);
	foreach ($post_types as $value ) {
		// in theory, publish_future_ only runs on scheduled, publish_ runs on all. 
		if ( version_compare( $wp_version,"3.3.3","<" ) ) { // I've only tested through 3.3.3, but those versions work without this action.
			add_action( 'publish_future_'.$value, 'wpt_twit_future', 16 ); 
		}
		add_action( 'publish_'.$value, 'post_jd_twitter', 10 );
		add_action( 'publish_'.$value, 'wpt_twit_instant', 16 );	
	}
}

function wpt_twit_future( $id ) {
	set_transient( '_wpt_twit_future', $id, 10 );
	// instant action has already run for this post. // prevent running actions twice (need both functions for older WP)
	if ( get_transient ( '_wpt_twit_instant' ) && get_transient( '_wpt_twit_instant' ) == $id ) {
		delete_transient( '_wpt_twit_instant' );
		return;
	}	
	jd_twit( $id, 'future' );
}
function wpt_twit_instant( $id ) {
	set_transient( '_wpt_twit_instant', $id, 10 );
	// future action has already run for this post.
	if ( get_transient ( '_wpt_twit_future' ) && get_transient( '_wpt_twit_future' ) == $id ) {
		delete_transient( '_wpt_twit_future' );
		return;
	}
	jd_twit( $id, 'instant' );
}
function wpt_twit_xmlrpc( $id ) {
	jd_twit( $id, 'xmlrpc' );
}

add_action( 'save_post', 'post_jd_twitter', 10 ); // Now things will happen twice. Hmmm...guess that's OK. 

if ( get_option( 'jd_twit_remote' ) == '1' || ( function_exists( 'wpt_pro_exists') && wpt_pro_exists() == true && get_option( 'wpt_delay_tweets' ) > 0 ) ) {
	add_action( 'xmlrpc_publish_post', 'wpt_twit_xmlrpc' ); 
	add_action( 'publish_phone', 'wpt_twit_xmlrpc' ); // to add later	
}
if ( get_option('comment-published-update') == 1 ) {
	add_action( 'comment_post', 'jd_twit_comment', 10, 2 );
}
add_action( 'admin_menu', 'jd_addTwitterAdminPages' );