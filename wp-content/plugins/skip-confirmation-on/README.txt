=== Skip Confirmation On ===
Contributors: fliz, kona
Tags: add user, add new user, add existing user, email confirmation, email notification 
Requires at least: 4.4
Tested up to: 5.8
Stable tag: 1.0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Changes the tickbox default to NOT send an email to a new user when adding them to a WordPress or WordPress Multisite website.

== Description ==

Since WordPress 4.4, the Add New User process selectively allows an email to be sent to the new user about their account.  The default selection is to send an email when the account is created/added.

In some circumstances, an admin might wish to set up one or more accounts in advance - perhaps for testing purposes - and only notify the users later, once everything is ready.  However, it's easy to send a notification message when you didn't mean to, if you forget to change the default notification setting.

This simple plugin reverses the default behaviour so an email is NOT sent by default, as follows:

1. In standard WordPress, the tickbox "Send User Notifiction" is **ticked** by default (so a message is sent).  The plugin changes this to **unticked** by default (so a message is NOT sent).

2. In WordPress Multisite, the tickbox "Skip Confirmation Email" is **unticked** by default (so a message is sent.)  The plugin changes this to **ticked** by default (so a message is NOT sent.)

*NOTE TO MULTISITE SUPER-ADMINS:  Adding a user from the **Network Admin / Add User** screen (rather than from a particular sub-site's Add User screen) will **always** send a notification.*

== Installation ==

1. Install this plugin via the WordPress plugin control panel, 
or by manually downloading it and uploading the extracted folder 
to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. That's all! There are no configurable options for this plugin.

== Frequently Asked Questions ==

= In the Multisite Network Admin section, can the super-admin add a user to the whole network without sending that user a notification email? =

Not at present, as WordPress Multisite always sends an email in this case.

Please let us know in the plugin forum if you think this would be a useful 
new feature.

== Screenshots ==

1. This screenshot shows the reversed default settings for new user
notifications in standard WordPress.  The default is to NOT SEND
notifications once the plugin is activated.

2. This screenshot shows the reversed default settings for new user
notifications in WordPress Multisite (when adding a user to a sub-site from
that sub-site's dashboard.)  The default is to NOT SEND notifications 
once the plugin is activated.

3. This screenshot shows the "Add user" screen for WordPress Multisite Network
Administration dashboard, which is unchanged by this plugin.  (A notification
WILL be sent if a user is added from the Network Administration section.)

== Changelog ==

= 1.0.2 = 
* Update jQuery code to remove deprecated function

= 1.0.1 = 
* Tweak to plugin description

= 1.0.0 =
* Initial version

== Upgrade Notice ==

= 1.0.0 =
Initial version, released for WordPress 4.4+.
