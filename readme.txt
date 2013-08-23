=== Portfolio Post Type ===
Contributors: downstairsdev, garyj
Tags: portfolio, post type
Requires at least: 3.4
Tested up to: 3.6
Stable tag: 0.6.0
License: GPLv2 or later

== Description ==

This plugin registers a custom post type for portfolio items.  It also registers separate portfolio taxonomies for tags and categories.  If featured images are selected, they will be displayed in the column view.  The portfolio image used in the dashboard was designed by Ben Dunkle, who also did the other UI icons in WordPress.

This plugin doesn't change how portfolio items are displayed in your theme.  You'll need to add templates for archive-portfolio.php and single-portfolio.php if you want to customize the display of portfolio items.

== Installation ==

Just install and activate.

== Frequently Asked Questions ==

= How can I display portfolio items differently than regular posts? =

You will need to get your hands dirty with a little code and create a archive-portfolio.php template (for displaying multiple items) and a single-portfolio.php (for displaying the single item).

= Why did you make this? =

To allow users of Portfolio Press to more easily migrate to a new theme.  And hopefully, to save some work for other folks trying to set a portfolio.

= Is this code on GitHub? =

Of course: [https://github.com/devinsays/portfolio-post-type](https://github.com/devinsays/portfolio-post-type)

== Changelog ==

= 0.6 =

* Use proper coding standards
* Updated inline documentation
* New filters for taxonomy arguments
* Adds body classes for custom taxonomy terms

= 0.5 =

* Use show_admin_column for taxonomies (http://make.wordpress.org/core/2012/12/11/wordpress-3-5-admin-columns-for-custom-taxonomies/) rather than a custom function
* Add author field custom post type
* Allows $args to be filtered (https://github.com/devinsays/portfolio-post-type/issues/8)

= 0.4 =

* Update to use classes
* Update supports to include custom fields and excerpts

= 0.3 =

* Added category to column view
* Added portfolio count to "right now" dashboard widget (props @nickhamze)
* Added contextual help on portfolio edit screen (props @nickhamze)
* Now flushes rewrite rules on plugin activation

= 0.2 =

* Fixes for portfolio tag label
* Fixes for column display of portfolio items

= 0.1 =

* Initial release