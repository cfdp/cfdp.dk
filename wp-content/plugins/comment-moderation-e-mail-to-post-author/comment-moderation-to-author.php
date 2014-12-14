<?php
/*
Plugin Name: Comment Moderation E-mail only to Author
Plugin URI: http://status301.net/wordpress-plugins/comment-moderation-e-mail-to-post-author/
Description: Send comment moderation notifications **only** to the posts Author, not to the site Administration address (as configured on Settings > General) any more, unless the author in question has no moderation rights. There are no options, just activate and the site admin will no longer be bothered with notifications about posts from other authors. <strong>Happy with it? <em><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=ravanhagen%40gmail%2ecom&item_name=Comment%20Moderation%20E-mail%20to%20Post%20Author&item_number=0%2e4&no_shipping=0&tax=0&bn=PP%2dDonationsBF&charset=UTF%2d8&lc=us">Buy me a coffee...</a></em> Thanks! :)</strong>
Version: 0.4
Author: RavanH
Author URI: http://status301.net/
*/

/**
 * Filters wp_notify_moderator() recipients: $emails includes only author e-mail,
 * unless the authors e-mail is missing or the author has no moderator rights. 
 *
 * @since 0.4
 *
 * @param array $emails     List of email addresses to notify for comment moderation.
 * @param int   $comment_id Comment ID.
 * @return array
 */
function comment_moderation_post_author_only($emails, $comment_id)
{
	$comment = get_comment($comment_id);
	$post = get_post($comment->comment_post_ID);
	$user = get_userdata($post->post_author);

	// Return only the post author if the author can modify.
	if ( user_can($user->ID, 'edit_comment', $comment_id) && !empty($user->user_email) )
		return array( $user->user_email );

	return $emails;
}

add_filter('comment_moderation_recipients', 'comment_moderation_post_author_only', 11, 2);
