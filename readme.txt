=== Delicious Wishlist for WordPress ===
Contributors: aldolat
Donate link: http://dev.aldolat.it/projects/delicious-wishlist-for-wordpress/
Tags: delicious, del.icio.us, wishlist, bookmarks
Requires at least: 3.0
Tested up to: 4.1
Stable tag: 2.6

Adds a Wishlist page to your WordPress blog using your Delicious Bookmarks.

== Description ==

This plugin allows you to publish in your blog a wishlist using your Delicious bookmarks.

In order to make this, when you visit a web page with something you like, tag that page with two different bookmarks: `wishlist` and, if it is very important, `***` (three stars). 
Then, when you visit a page with something less important, you could use `wishlist` and `**` (two stars), and finally for a page with something even less important, you could use `wishlist` and `*` (one star). 

It's not mandatory to use these exact tags: you can choose your own tags, but consider that you have to bookmark a page with at least two different tags: 
one general to collect all your bookmarks relative to your wishlist, and another to mark that page depending on the importance of the stuff for you. 

When you are done with an item (you have bought it or someone gave it to you as a gift), you can edit that bookmark on Delicious and remove the star(s).
Leave only the main tag (e.g., `wishlist`), so you can maintain in Delicious an archive of all desired items.

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload  the `delicious-wishlist-for-wordpress` directory to the `/wp-content/plugins/` directory
1. Activate the plugin through the Plugins menu in WordPress
1. Fill in all the fields in the options page of the plugin
1. Create a new page
1. Place `[my-delicious-wishlist]` in that page as content. You can add a custom text before the shortcode and/or after.

== Frequently Asked Questions ==

= May I tag a page using other tags besides those who I chose to tag my wishlists? =

Yes. Keep in mind that you have to choose a general tag to collect all your wishlisted bookmars on Delicious 
and three different tags to mark them depending on their importance for you. Also, besides them, you can add all the tags you desire.

= May I change the style of the page? =
Yes. The plugin comes with a css file that is used to stylize the page. 
The plugin, however, looks first in your theme directory: if it finds a file named `wdw.css`, 
it will use it **instead of** that one provided with the plugin. 
In this way, you can change the look of your wishlist page and you'll preserve it even if an update of the plugin will be released.

== Screenshots ==

1. The settings panel of the plugin
2. The settings for the widget
3. The rendered wishlist page

== Changelog ==

= 2.6 =

* Localized date format
* Removed check and conversion for old settings
* Small code fixings

= 2.5 =

* Added compatibility to last WordPress version.
* Moved screenshots to /assets/ directory
* Updated call to new contextual help WordPress API
* Added uninstall for widget options too
* Various bugs fixed

= 2.4 =

* Now the minimum required WordPress version is 3.0
* Moved the User Guide to a contextual help on top of the options page
* Added a link to the settings page in the plugins page
* Improved the class name for ul elements

= 2.3 =

* The code has been totally reviewed
* NEW: Now the user can select the HTML element for titles
* NEW: Now the user can sort tags in alphabetical order
* NEW: Now the user can set a symbol before each tag and a separator between two tags
* Some minor change in the options page

= 2.2 =

* NEW: Added the count for total items in every title of the widget
* Other minor changes

= 2.1.1 =

* FIX: Changed ids into classes, to avoid duplicated ids when viewing the main wishlist page while the wishlist widget is active
* Changed "Check out my complete wishlist" into "Check out my complete list": the plugin may be used not only for 'wishlist' purposes

= 2.1 =
* NEW: Now the user can display or not the date, the tags or the "section" (i.e. the two main Delicious tags)
* NEW: Now in the widget the user can put a link to the Wishlist page
* NEW: Added the Section for main Delicious tags which links to the original Delicious tags
* Better formatting for some messages

= 2.0 =
* NEW: Added the widget
* NEW: Added control if the core options have been setup by the user, otherwise print the admin notice in the backend
* NEW: Added possibility to define the maximum lenght of tags descriptions
* NEW: Added link to the original bookmark on Delicious
* Other minor improvements

= 1.0 =
* NEW: Now you can avoid the plugin's CSS and use your own styles from your theme CSS
* Compatibility with WordPress 3.0

= 0.6 =
* NEW: the plugin can display the tags of a bookmark
* Other minor changes

= 0.5 =
* FIX: Setting a cache expiry time now works correctly
* NEW: Now you can specify an alternative feed source to retrieve bookmarks (such as FeedBurner or Yahoo! Pipes or any other source)
* NEW: Uninstall function. If the plugin is uninstalled, it deletes any option it created in the database, with no necessary action by user
* Cache time increased to 1 hour
* Now the plugin displays the error in case the feed is unreachable
* Removed duplicated ids in the options panel

= 0.4 =
* Now the admin page style reflects the WordPress style
* NEW: Added cache expiry time option
* Plugin options are now into a single options item in the database and the conversion is automatic if the plugin detects the old set of options
* FIX: accented letters in dates

= 0.3.5 =
* Removed unused variable
* Removed redundant conditions
* Better formatting of warning
* Added CSS style for warning
* i18n: added name of day of week
* l10n: updated Italian translation
* Cleaning up of code
* Added GPL License text

= 0.3.4 =
* Fix: call to a wrong variable

= 0.3.3 =
* Added Safe Mode in case the feed is unreachable

= 0.3.2 =
* Transition to GPLv3

= 0.3.1 =
* Compatibility with WordPress 2.9
* Added style for abbr

= 0.3 =
* Equalized the plugin name

= 0.2 =
* Changed the plugin directory name to match the SVN name.

= 0.1 =
* First release of the plugin.

== Upgrade Notice ==

= 0.6 =
Upgrade is suggested to display the tags of bookmarks.

= 0.5 =
Upgrade is recommended. This version correctly handles the cache and also you can specify alternative sources for your feed.


== Credits ==

My thanks go to all people who contributed in revisioning and helping me in any form, 
and in particular to [Nicola D'Agostino](http://www.nicoladagostino.net/ "Nicola's website") 
and to [Barbara Arianna Ripepi](http://suzupearl.com/ "Barbara's website") for their great idea behind this work.
