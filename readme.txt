=== Portfolio Post Type ===
Contributors: downstairsdev, GaryJ
Tags: portfolio, post type
Requires at least: 3.8
Tested up to: 5.5
Stable tag: 1.0.1
License: GPLv2 or later

== Description ==

This plugin registers a custom post type for portfolio items.  It also registers separate portfolio taxonomies for tags and categories.  If featured images are selected, they will be displayed in the column view.

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

= 1.0.1 =

* Update: Show portfolio icon in dashboard glance. Removed by mistake in v1.0.0, props @chesio for bug report.
* Update: Fix for PHP 7.4.9 notices

= 1.0.0 =

* Update: WordPress 5.0 Editor Support (props @simube)
* Update: Use filter rather than action for dashboard glance (props @chesio)

= 0.9.3 =

* Fix notice in dashboard when used with PHP7
* Fix notice on specific screens when $screen variable not available

= 0.9.2 =

* Update post type messages for WordPress 4.4

= 0.9.1 =

* Updated translation file
* Fixes issue with thumbnail support in some themes

= 0.9.0 =

* Remove legacy support for icons
* Gamajo_Registerable interface and classes

= 0.8.2 =

* Updated .pot file for translations
* Portuguese translation by Pedro Mendonça

= 0.8.1 =

* Fix for developer notices on admin pages

= 0.8.0 =

* Fix for taxonomy body classes on portfolio posts

= 0.7.0 =

* Code refactor by @garyj
* Update icons for WordPress 3.8

= 0.6.2 =

* Fix for portfolio post type search in the dashboard.  Props @pdme.
* Minor code improvement for taxonomy body class filter.  Props @garyj.

= 0.6.1 =

* Taxonomy body classes when is_single(), fixes debug notices

= 0.6 =

* Added @garyj as a contributor (Welcome!)
* Updated to proper coding standards
* Updated inline documentation
* New filters for taxonomy arguments
* Added body classes for custom taxonomy terms
* Refactored code to be more DRY
* Added not_found label to portfolio tag taxonomy
* Updated translations.pot

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
