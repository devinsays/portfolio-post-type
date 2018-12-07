# Portfolio Post Type

WordPress plugin that adds support for Portfolio entries.

## Description

This plugin registers a custom post type for portfolio items.  It also registers separate portfolio taxonomies for tags and categories.  If featured images are selected, they will be displayed in the column view.

This plugin doesn't change how portfolio items are displayed in your theme.  You will need to add templates for `archive-portfolio.php` and `single-portfolio.php` if you want to customize the display of portfolio items.

## Requirements

* WordPress 3.7, tested up to 5.0

## Installation

### Upload

1. Download the latest tagged archive (choose the "zip" option).
2. Go to the __Plugins -> Add New__ screen and click the __Upload__ tab.
3. Upload the zipped archive directly.
4. Go to the Plugins screen and click __Activate__.

### Manual

1. Download the latest tagged archive (choose the "zip" option).
2. Unzip the archive.
3. Copy the folder to your `/wp-content/plugins/` directory.
4. Go to the Plugins screen and click __Activate__.

Check out the Codex for more information about [installing plugins manually](http://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation).

### Git

Using git, browse to your `/wp-content/plugins/` directory and clone this repository:

`git clone git@github.com:devinsays/portfolio-post-type.git`

Then go to your Plugins screen and click __Activate__.

## Customization

Since the custom post type and two taxonomies have filterable arguments, it's possible to amend the labels or other arguments via a plugin or a theme. For example, to change the label from _Portfolio_ to _Projects_, you can do:

~~~php
add_filter( 'portfolioposttype_args', 'prefix_change_portfolio_labels' );
/**
 * Change post type labels and arguments for Portfolio Post Type plugin.
 *
 * @param array $args Existing arguments.
 *
 * @return array Amended arguments.
 */
function prefix_change_portfolio_labels( array $args ) {
	$labels = array(
		'name'               => __( 'Projects', 'portfolioposttype' ),
		'singular_name'      => __( 'Project', 'portfolioposttype' ),
		'add_new'            => __( 'Add New Item', 'portfolioposttype' ),
		'add_new_item'       => __( 'Add New Project', 'portfolioposttype' ),
		'edit_item'          => __( 'Edit Project', 'portfolioposttype' ),
		'new_item'           => __( 'Add New Project', 'portfolioposttype' ),
		'view_item'          => __( 'View Item', 'portfolioposttype' ),
		'search_items'       => __( 'Search Projects', 'portfolioposttype' ),
		'not_found'          => __( 'No projects found', 'portfolioposttype' ),
		'not_found_in_trash' => __( 'No projects found in trash', 'portfolioposttype' ),
	);
	$args['labels'] = $labels;

	// Update project single permalink format, and archive slug as well.
	$args['rewrite']     = array( 'slug' => 'project' );
	$args['has_archive'] = true;
	// Don't forget to visit Settings->Permalinks after changing these to flush the rewrite rules.

	return $args;
}
~~~

You'd likely want to do something similar with the labels for portfolio tag and portfolio category taxonomies as well.

## Frequently Asked Questions

### How can I display portfolio items differently than regular posts?

You will need to get your hands dirty with a little code and create an `archive-portfolio.php` template (for displaying multiple items) and a `single-portfolio.php` (for displaying the single item).

### Why did you make this?

To allow users of Portfolio Press to more easily migrate to a new theme.  And hopefully, to save some work for other folks trying to create a portfolio.

### Is this plugin on the WordPress repo?

Yes, you can find it here: [https://wordpress.org/plugins/portfolio-post-type/](https://wordpress.org/plugins/portfolio-post-type/)

## Credits

Built by [Devin Price](https://www.wptheming.com/) and [Gary Jones](https://gamajo.com/)
