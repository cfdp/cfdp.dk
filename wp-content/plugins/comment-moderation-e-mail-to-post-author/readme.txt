=== Comment Moderation E-mail only to Author ===
Contributors: RavanH
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=ravanhagen%40gmail%2ecom&item_name=Comment%20Moderation%20E-mail%20to%20Post%20Author&item_number=0%2e1&no_shipping=0&tax=0&bn=PP%2dDonationsBF&charset=UTF%2d8&lc=us
Tags: comments, moderation, comment, author, comment notification, comment moderation, comment moderation notification, comment moderation recipients, comment_moderation_recipients, comment moderation email, comment moderation e-mail, moderation queue, e-mail, email
Requires at least: 3.7
Tested up to: 4.0
Stable tag: 0.4

Send comment moderation notifications ONLY to the Author, not to the site Administration address any more.

== Description ==

This plugin could also have been called **Don't bother the Site Administrator with every other author's Comment Moderation Notifications, unless the author has no moderation rights** but since that's a slightly longer title, I chose to keep it as simple as I could. However, it explains well what this plugin does:

Normaly, when a comment gets submitted to a particular post, the author of that post gets a notification about it. But when that comment is held for moderation (which depends on your sites comment settings) then the moderation notification is sent to *both* the post **Author** (if he/she has moderation rights) *and* the sites **Administrative moderator e-mail address** as configured under **Settings > General** at the same time.

For many blogs or sites where the owner is the only author and his/her account uses the same e-mail address as the Administrative moderator e-mail address, this will boil down to one message to one address. But when the Site Admin is not the only author, like on **colaboration sites** or sites managed by a webmaster or designer where other people like the client usually posts, this might result in flooding the admins mailbox with moderation messages that are not really his/her concern. The site admin, with enough on his/her mind already, is bothered with each and every new comment in the moderation queue.

This plugin changes that.

Just install and activate it: All post comment moderation notifications will be sent **only** to each respective **Post Author**. If, by any chance, the post author has no moderation rights (Contributor level) *or* there is no author e-mail set then the default site e-mail address will still get the notification.

Works on WordPress 3.7 and above in both Normal and Multi-site mode.

== Installation ==

Hit [install now](http://coveredwebservices.com/wp-plugin-install/?plugin=comment-moderation-e-mail-to-post-author), provide your site home address and continue to log in on your own site. Easy, by Covered Web Service :) 

== Frequently Asked Questions ==

= I see no settings page =
There is no settings page. The plugin will do only *one thing* : make comment moderation notifications go to the authors e-mail address, and no longer the site moderator address. 

= Nothing looks different. Is it working at all? =
To test if it is working:

1. Check your Settings > Discussion settings and make sure that (I) at **E-mail me whenever** at least *A comment is held for moderation* and (II) at **Before a comment appears** at least *Comment author must have a previously approved comment* are checked.
2. Open an incognito browser window, go to your site as an anonymous visitor and post a comment to a post from anyone with at least author level (contributor has no moderation rights!) other than the main site administrator.
3. Switch back to your normal browser window, verify that comment went into the moderation queue, verify that you as site administrator did not receive any moderation e-mail and then ask the post author if he/she did receive the moderation notification correctly :)

= I get no messages =
This plugin does not send any messages. It only changes the addressee of the comment moderation queue notifications that are sent by WordPress. 

If nobody get any of these notifications, disable the plugin and test again. You will probably still not get any notifications and the problem lies with WordPress not being able to send emails via PHP. There are other plugins or tutorials about server configuration that can help you with that... 

= Does this plugin work on WPMU / WP3+ Multi Site mode? =
Yep, it was made for Multisite :)

You can install it in /plugins/ and activate it *site-by-site* or *network wide*. Or you can upload it to /mu-plugins/ for automatic (Must-use) inclusion.

== Upgrade Notice ==

= 0.4 =
WP 3.7+ compatibility

== Changelog ==

= 0.4 =
New concept: filter comment_moderation_recipients available since WP 3.7

= 0.3 =
WP 3.1+ compatibility

= 0.1 =
First concept: replace function wp_notify_moderator()
