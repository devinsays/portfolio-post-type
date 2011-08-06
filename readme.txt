=== Options Framework ===
Contributors: Devin Price
Tags: portfolio, post type
Requires at least: 3.1
Tested up to: 3.2
Stable tag: 0.1
License: GPLv2

== Description ==

This plugin registers a custom post type for portfolio items.  It also registers separate portfolio taxonomies for tags and categories.  If featured images are selected, they will be displayed in the column view.  The portfolio image used in the dashboard was designed by Ben Dunkle, who also did the other UI icons in WordPress.

It doesn't change how portfolio items are displayed in your theme however.  You'll need to add templates for archive-portfolio.php and single.php if you want to customize the display of portfolio items.

== Installation ==

Just install and activate.

== Frequently Asked Questions ==

= How can I display portfolio items differently than regular posts? =

You will need to get your hands dirty with a little code and create a archive-portfolio.php template (for displaying multiple items) and a single-portfolio.php (for displaying the single item).

= Why did you make this? =

To allow users of Portfolio Press to more easily migrate to a new theme.  And hopefully, to save some work for other folks trying to set a portfolio.

== Changelog ==

= 0.1 =

* Initial release