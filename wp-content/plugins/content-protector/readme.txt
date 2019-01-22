=== Passster ===
Contributors: patrickposner
Tags: password protection, content protection, content restriction, captcha, membership, cookie restriction, members area, password protect
Requires at least: 4.6
Tested up to: 5.0
Requires PHP: 7
Stable tag: 3.1.9


Passster is the complete solution to protect parts of your content.

== Description ==

= Features =
Passster is the most complete solution to protect parts of your content. Use a simple shortcode and restrict your content with passwords and captchas.

**Free**

* restrict content with a password
* restrict content with a captcha
* completely customisable with the WordPress Customizer
* easily generate a shortcode
* use cookies for longer access
* customize the headline, instruction text, placeholder and the button label per shortcode.

**Pro**

The Pro version of Passster adding advanced features to your content protection.

The pro version of Passster includes all current and future addons which you can find under Passster->Settings->Addons.

***Multiple Passwords***
Add multiple passwords per shortcode. Use the parameter "passwords" and add the passwords them comma-separated.

***Users***
Add additional parameters "role" and "user" to specifiy which users can bypass the protection. Great for membership based restrictions.

***Advanced Captcha and Google ReCaptcha***
Customize background, customize the number of lines in front and back of your code or completely remove the effects.

Let users unlock your content with Google Recaptcha. Enter your API-Key and add the parameter "recaptcha" to use it.

***Link Access***
Use an encrypted link to give your users direct access to your protected content.

***Page Builder***
Passster Pro now supports several page builders. We currently support the following page builders:

* Elementor
* Beaver Builder
* Visual Composer (WPBakery Page Builder)

Use custom Widgets, Elements or Modules to protect your content.

Warning: Passster Pro currently not support to restrict complete rows or columns in your page builder. It's build as an element/module/widget which you can add content to via WYSIWIG-Editor.

Get it now on [passster.io](https://passster.io)

**Documentation**

On passster.io you can find several tutorials and the complete documentation about every feature which is included in the free and pro version of Passster.

Learn more on [passster.io/documentation](https://passster.io/documentation)

== Support ==

The free support is exclusively limited to the wordpress.org support forum.

Any kind of email priority support, customization and integration help need a valid premium license.

=== CODING STANDARDS MADE IN GERMANY ===

The plugin is coded with **modern PHP** and **WordPress standards** in mind. It’s fully OOP coded. It’s highly extendable for developers through several action and filter hooks.

Passster keeps your website performance in mind. Every script is **loaded conditionally** and all input and output data is secured.


=== MULTI-LANGUAGE ===

All major texts and information can be modified from the admin area of Passster.

The plugin is **fully translatable** in your language. At the moment there are only en_EN and de_DE, but you can easily add your preferred language as a .po/.mo.

It’s also fully compatible with WPML and Polylang.



== Screenshots ==
1. Passster Password Form
2. Passster Shortcode generator
3. Passster Customizer Options

== Installation ==

Passster is simple to install:

1. Download the .zip'
1. Unzip
1. Upload  the directory to your '/wp-content/plugins' directory
1. Go to the plugin management page and enable the Passster Plugin
1. Browse to Settings > Passster
1. Customise your settings and your good to go!

== Changelog ==

= 3.1.9 =
* PHP 5.6 compatibility
* function naming fixes
* optimize session handler class

= 3.1.8 =
* introduce conditional functions for template usage
* completely remove the autofocus
* fixes save settings for user_toggle option
* updates the session handling for captcha to PHP 7.2 compatibility
* prevents autofill for safari, chrome and webkit supported browsers

= 3.1.7 =
* includes fixes for beaver builder module support

= 3.1.6 =
* Support Release
* Fixed multiple passwords runtime
* add customizer notice on Installation
* improved german translation
* add an seprate atts function for more readable code
* add new users addon
* 

= 3.1.5 =
* Support Release
* Add auth parameter for multiple shortcodes per page
* Fixed <span> for error messages
* Fixed wp_enqueue_styles for windows servers
* Fixed php notice for captcha options

= 3.1.4 =
* Support Release
* fixed problems with WP Sessions table and Database Handler
* fixed License Activation
* Add option for autofocus
* fixed helper for addon activation

= 3.1.3 =
* Support Release
* Major improvements for captcha
* set width and height for captcha
* integrate wp-sessions-manager for session handling via database
* adding page builder support for elementor, visual composer and beaver builder (pro only)
* fix one pager bug with passster forms

= 3.1.2 =
* Support Release
* Add placeholder and button label per shortcode
* Fix option set issues for captcha
* get rid of HTTP API and all external calls and replace with object cache

= 3.1.1 =
* Support Release
* Fixing PHP notice for addons
* replace_file_get_contents() with WP HTTP API

= 3.1 =
* new admin ui
* captcha is back!
* cache-compatible cookie solution
* design modifications via customizer
* cross-browser-compatible forms
* shortcode generator
* password generation with newset bcrypt standards
* password generator
* fix several bugs like instructions text, translations, php errors

= 3.0 =
* under new development
* compatibilty with WordPress 4.9+
* clean up and restructure whole plugin
* remove deprecated solutions for ajax and captcha
* removed date based selection of cookie expires

= 2.11 =
* Setting "Password Field Placeholder" now accessible through "Settings -> Passster -> Password/CAPTCHA Field"

= 2.10 =
* Form and CAPTCHA instructions moved to outside the form.
* `content_protector_unlocked_content` filter bug in AJAX mode fixed.
* CSS for `div.content-protector-form-instructions` fixed.
* New Setting "CAPTCHA Case Insensitive" - to allow users to enter CAPTCHAs w/o case-sensitivity.
* New action `content_protector_ajax_support` - for loading any extra files needed to support your protected content in AJAX mode.

= 2.9.0.1 =
* Fixed bug crashing `content_protector_unlocked_content` filter.
* Full AJAX support for `[caption]` built-in shortcode.

= 2.9 =
* Full AJAX support for `[embed]`, `[audio]`, and `[video]` built-in shortcodes.
* Added full support for `[playlist]` and `[gallery]` built-in shortcodes.
* Fixed Encrypted Passwords Storage setting message bug.
* `content_protector_content` filter now called `content_protector_unlocked_content`.
* `content_protector_unlocked_content` filter can now be customized from the Settings -> General tab.
* `the_content` filter now applied to form and CAPTCHA instructions.

= 2.8 =
* Partial AJAX support for `[embed]`, `[audio]`, and `[video]` built-in shortcodes. (experimental)
* Fixed AJAX error from code refactoring

= 2.7 =
* Displaying Form CSS on unlocked content is now a user option (on the Form CSS tab).
* When saving settings, the Settings page will now remember which tab you were on and load it automatically,
* Fixed potential cookie expiry bug for sessions meant to last until the browser closes (expiry time set explicitly to '0').
* Improved error checking for conflicting settings.
* Some code refactoring.

= 2.6.2 =
* Fixed output buffering bug for access form introduced in 2.6.1.

= 2.6.1 =
* Fixed AJAX security nonce bugs.

= 2.6 =
* jQuery UI theme updated to 1.11.4
	
= 2.5.0.1 =
* New setting to manage encrypted passwords transient storage.
* New settings for Password/CAPTCHA Fields character lengths.
* Improved option initialization and cleanup routines.
* `content-protector-ajax.js` now loads in the footer.
* WPML/Polylang compatibility (beta).
* New partial translation into Serbian (Latin); thanks to Andrijana Nikolic from WebHostingGeeks (Novi parcijalni prevod na Srpski ( latinski ); Hvala Andrijana Nikolic iz WebHostingGeeks)

= 2.5 =
* Skipped

= 2.4 =
* Skipped

= 2.3 =
* Settings admin page now limited to users with `manage_options` permission (i.e., admin users only).
* Fixed bug where when using AJAX and CAPTCHA together, CAPTCHA image didn't reload on incorrect password.
* New settings: use either a text or password field for entering passwords/CAPTCHAs, and set placeholder text for those fields.
* Added `autocomplete="off"` to the access form.
* Streamlined i18n for date/time pickers (Use values available in Wordpress settings and `$wp_locale` when available, combined *-i18n.js files into one).

= 2.2.1 =
* Fixed AJAX bug where shortcode couldn't be found if already enclosed in another shortcode.
* Clarified error message if AJAX method cannot find shortcode.
* Changed calls from `die()` to `wp_die()`.

= 2.2 =
* Removed `content-protector-admin-tinymce.js` (No need anymore; required JS variables now hooked directly into editor). Fixes incompatibility with OptimizePress.

= 2.1.1 =
* Added custom filter `content_protector_content` to emulate `apply_filter( 'the_content', ... )` functionality for form and CAPTCHA instructions.

= 2.1 =
* Rich text editors for form and CAPTCHA instructions.
* NEW Template/Conditional Tag: `content_protector_is_logged_in()` (See Usage for details).
* Performance improvements via Transients API.

= 2.0 =
* New CAPTCHA feature! Check out the CAPTCHA tab on Settings -> Content Protector for details.
* Improved i18n.
* Various minor bug fixes.
	
= 1.4.1 =
* Dashicons support for WP 3.8 + added. Support for old-style icons in Admin/TinyMCE is deprecated.
* Unified dashicons among all of my plugins.

= 1.4 =
* Added "Display Success Message" option.

= 1.3 =
* Added "Shared Authorization" feature.
* Renamed "Password Settings" to "General Settings".

= 1.2.2 =
* Added support for Contact Form 7 when using AJAX.

= 1.2.1 =
* Fixed label repetition on "Cookie expires after" drop-down menu.

= 1.2 =
* Various CSS settings now controllable from the admin panel.
* Palettes on Settings color controls are now loaded from colors read from the active Theme's stylesheet.  This
should help in choosing colors that fit in with the active Theme.
* Spinner image now preloaded.
* Some language strings changed.

= 1.1 =
* AJAX loading message now customizable.

= 1.0.1 =
* Added required images for jQuery UI theme.
* Fixed some i18n strings.

= 1.0 =
* Initial release.

== Upgrade Notice ==
= 2.8 =
New features and bug fixes. Please upgrade.

= 2.6.1 =
New bug fixes. Please upgrade.

= 2.3 =
New features and bug fixes. Please upgrade.
	
= 2.1.1 =
Added custom filter `content_protector_content` to emulate `apply_filter( 'the_content', ... )` functionality for form and CAPTCHA instructions. Please upgrade.

= 2.1 =
New features. Please upgrade.

= 2.0 =
New features and bug fixes. Please upgrade.

= 1.2.1 =
Fixed label repetition on "Cookie expires after" drop-down menu. Please upgrade.

= 1.0.1 =
Added required images for JQuery UI theme and fixed some i18n strings.

= 1.0 =
Initial release.