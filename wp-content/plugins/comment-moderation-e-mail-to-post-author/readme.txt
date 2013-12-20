=== Send Comment Moderation E-mail only to Post Author ===
Contributors: RavanH
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=ravanhagen%40gmail%2ecom&item_name=Comment%20Moderation%20E-mail%20to%20Post%20Author&item_number=0%2e1&no_shipping=0&tax=0&bn=PP%2dDonationsBF&charset=UTF%2d8&lc=us
Tags: comments, moderation, comment, author, comment notification, comment moderation, comment moderation notification, comment moderation email, comment moderation e-mail, moderation queue, e-mail, email
Requires at least: 3.1
Tested up to: 3.4.1
Stable tag: 0.3

Sends the comment moderation notification ONLY to the post author and no longer to the main site admin e-mail address too.

== Description ==

This plugin could also have been called **Don't bother the Site Admin with every author's Moderation Messages** but that's an even longer title. However, it explains well what this plugin does:

When a comment gets posted to a particular post, the author of that post gets a notification about it. When that comment is held for moderation (which depends on your sites comment settings), the moderation notification is sent to *both* the post **Author** (if he/she has moderation rights) *and* the sites **Administrative moderator e-mail address** (as configured under **Settings > General**) at the same time.

For many blogs or sites where the owner is the only author and his/her account uses the same e-mail address as the Administrative moderator e-mail address, this will boil down to one message to one address. But when the Site Admin is not the only author, like on **colaboration sites** or sites managed by a webmaster or designer where other people like the client usually posts, this might result in overflooding the admins mailbox with moderation messages that are not his/hers concern. The site admin, with enough on his/her mind already, is bothered with each and every new comment in the moderation queue.

This plugin changes that.

Just install, activate it and it's done: All post comment moderation notifications will be sent **only** to the respective **Post Author**. If, by any chance, the post author has no moderation rights *or* there is no author e-mail set **or** the author *is* the site admin, the default site admin e-mail will still get the notification.

Works on WordPress 3.1 and above in both Normal and Multi-site mode.

== Installation ==

Hit [install now](http://coveredwebservices.com/wp-plugin-install/?plugin=comment-moderation-e-mail-to-post-author), provide your site home address and continue to log in on your own site. Easy, by Covered Web Service :) 

== Frequently Asked Questions ==

= I see no settings page =
There is no settings page. The plugin will do only *one thing* : make comment moderation notifications go to the authors e-mail address, and no longer the site moderator address. 

= Nothing looks different. Is it working at all? =
To test if it is working:

1. Check your Settings > Discussion settings and make sure that (I) at **E-mail me whenever** at least *A comment is held for moderation* and (II) at **Before a comment appears** at least *Comment author must have a previously approved comment* are checked.
2. Log out and clear your browser cookies & cache.
3. As an anonymous visitor, post a comment to a post from anyone other than the main site owner.
4. Log back in, verify that comment went into the moderation queue and then ask the author if he/she received a moderation notification about it :)

= Does this plugin work on WPMU / WP3+ Multi Site mode? =
Yep. You can install it in /plugins/ and activate it *site-by-site* or *network wide*. Or you can opload it to /mu-plugins/ for automatic (Must-use) inclusion.

== Upgrade Notice ==

= 0.3 =
WP 3.1+ compatibility: no more messages to admin.

== Changelog ==

= 0.3 =
WP 3.1+ compatibility

= 0.1 =
First concept: replace function wp_notify_moderator()
