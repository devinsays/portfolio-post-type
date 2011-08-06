<?php
/*
Plugin Name: Portfolio Post Type
Plugin URI: http://www.wptheming.com
Description: Enables a portfolio post type and taxonomies.
Version: 0.1
Author: Devin Price
Author URI: http://www.wptheming.com
License: GPLv2
*/

function portfolioposttype() {

	/**
	 * Enable the Portfolio custom post type
	 * http://codex.wordpress.org/Function_Reference/register_post_type
	 */

	$labels = array(
		'name' => __( 'Portfolio', 'portfolioposttype' ),
		'singular_name' => __( 'Portfolio Item', 'portfolioposttype' ),
		'add_new' => __( 'Add New Item', 'portfolioposttype' ),
		'add_new_item' => __( 'Add New Portfolio Item', 'portfolioposttype' ),
		'edit_item' => __( 'Edit Portfolio Item', 'portfolioposttype' ),
		'new_item' => __( 'Add New Portfolio Item', 'portfolioposttype' ),
		'view_item' => __( 'View Item', 'portfolioposttype' ),
		'search_items' => __( 'Search Portfolio', 'portfolioposttype' ),
		'not_found' => __( 'No portfolio items found', 'portfolioposttype' ),
		'not_found_in_trash' => __( 'No portfolio items found in trash', 'portfolioposttype' )
	);

	$args = array(
    	'labels' => $labels,
    	'public' => true,
		'supports' => array( 'title', 'editor', 'thumbnail', 'comments' ),
		'capability_type' => 'post',
		'rewrite' => array("slug" => "portfolio"), // Permalinks format
		'menu_position' => 5,
		'has_archive' => true
	); 

	register_post_type( 'portfolio', $args);
	
	/**
	 * Register a taxonomy for Portfolio Tags
	 * http://codex.wordpress.org/Function_Reference/register_taxonomy
	 */
	 
	
	$taxonomy_portfolio_tag_labels = array(
		'name' => _x( 'Portfolio Tags', 'portfolioposttype' ),
		'singular_name' => _x( 'Portfolio Tag', 'portfolioposttype' ),
		'search_items' => _x( 'Search Portfolio Tags', 'portfolioposttype' ),
		'popular_items' => _x( 'Popular Portfolio Tags', 'portfolioposttype' ),
		'all_items' => _x( 'All Portfolio Tags', 'portfolioposttype' ),
		'parent_item' => _x( 'Parent Portfolio Tag', 'portfolioposttype' ),
		'parent_item_colon' => _x( 'Parent Portfolio Tag:', 'portfolioposttype' ),
		'edit_item' => _x( 'Edit Portfolio Tag', 'portfolioposttype' ),
		'update_item' => _x( 'Update Portfolio Tag', 'portfolioposttype' ),
		'add_new_item' => _x( 'Add New Portfolio Tag', 'portfolioposttype' ),
		'new_item_name' => _x( 'New Portfolio Tag Name', 'portfolioposttype' ),
		'separate_items_with_commas' => _x( 'Separate portfolio tags with commas', 'portfolioposttype' ),
		'add_or_remove_items' => _x( 'Add or remove portfolio tags', 'portfolioposttype' ),
		'choose_from_most_used' => _x( 'Choose from the most used portfolio tags', 'portfolioposttype' ),
		'menu_name' => _x( 'Portfolio Tags', 'portfolioposttype' ),
	);
	
	$taxonomy_portfolio_tag_args = array(
		'labels' => $labels,
		'public' => true,
		'show_in_nav_menus' => true,
		'show_ui' => true,
		'show_tagcloud' => true,
		'hierarchical' => false,
		'rewrite' => true,
		'query_var' => true
	);
	
	register_taxonomy( 'portfolio_tag', array('portfolio'), $args );
	
	/**
	 * Register a taxonomy for Portfolio Categories
	 * http://codex.wordpress.org/Function_Reference/register_taxonomy
	 */

    $taxonomy_portfolio_category_labels = array(
		'name' => _x( 'Portfolio Categories', 'portfolioposttype' ),
		'singular_name' => _x( 'Portfolio Category', 'portfolioposttype' ),
		'search_items' => _x( 'Search Portfolio Categories', 'portfolioposttype' ),
		'popular_items' => _x( 'Popular Portfolio Categories', 'portfolioposttype' ),
		'all_items' => _x( 'All Portfolio Categories', 'portfolioposttype' ),
		'parent_item' => _x( 'Parent Portfolio Category', 'portfolioposttype' ),
		'parent_item_colon' => _x( 'Parent Portfolio Category:', 'portfolioposttype' ),
		'edit_item' => _x( 'Edit Portfolio Category', 'portfolioposttype' ),
		'update_item' => _x( 'Update Portfolio Category', 'portfolioposttype' ),
		'add_new_item' => _x( 'Add New Portfolio Category', 'portfolioposttype' ),
		'new_item_name' => _x( 'New Portfolio Category Name', 'portfolioposttype' ),
		'separate_items_with_commas' => _x( 'Separate portfolio categories with commas', 'portfolioposttype' ),
		'add_or_remove_items' => _x( 'Add or remove portfolio categories', 'portfolioposttype' ),
		'choose_from_most_used' => _x( 'Choose from the most used portfolio categories', 'portfolioposttype' ),
		'menu_name' => _x( 'Portfolio Categories', 'portfolioposttype' ),
    );
	
    $taxonomy_portfolio_category_args = array(
		'labels' => $taxonomy_portfolio_category_labels,
		'public' => true,
		'show_in_nav_menus' => true,
		'show_ui' => true,
		'show_tagcloud' => true,
		'hierarchical' => true,
		'rewrite' => true,
		'query_var' => true
    );
	
    register_taxonomy( 'portfolio_category', array('portfolio'), $taxonomy_portfolio_category_args );
	
}

add_action( 'init', 'portfolioposttype' );

// Allow thumbnails to be used on portfolio post type

add_theme_support( 'post-thumbnails', array( 'portfolio' ) );
 
/**
 * Add Columns to Portfolio Edit Screen
 * http://wptheming.com/2010/07/column-edit-pages/
 */
 
function portfolioposttype_edit_columns($portfolio_columns){
	$portfolio_columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => _x('Title', 'column name'),
		"thumbnail" => __('Thumbnail', 'portfolioposttype'),
		"portfolio-tags" => __('Tags', 'portfolioposttype'),
		"author" => __('Author', 'portfolioposttype'),
		"comments" => __('Comments', 'portfolioposttype'),
		"date" => __('Date', 'portfolioposttype'),
	);
	$portfolio_columns['comments'] = '<div class="vers"><img alt="Comments" src="' . esc_url( admin_url( 'images/comment-grey-bubble.png' ) ) . '" /></div>';
	return $portfolio_columns;
}
 
function portfolioposttype_columns_display($portfolio_columns, $post_id){

	switch ($portfolio_columns)
	
	{
		// Code from: http://wpengineer.com/display-post-thumbnail-post-page-overview
		
		case "thumbnail":
			$width = (int) 35;
			$height = (int) 35;
			$thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );
			
			// Display the featured image in the column view if possible
			if ($thumbnail_id) {
				$thumb = wp_get_attachment_image( $thumbnail_id, array($width, $height), true );
			}
			if ( isset($thumb) ) {
				echo $thumb;
			} else {
				echo __('None', 'portfolioposttype');
			}
			break;	
			
			// Display the portfolio tags in the column view
			case "portfolio-tags":
			
			if ( $tag_list = get_the_term_list( $post_id, 'portfolio-tags', '', ', ', '' ) ) {
				echo $tag_list;
			} else {
				echo __('None', 'portfolioposttype');
			}
			break;			
	}
}

add_filter('manage_edit-portfolio_columns', 'portfolioposttype_edit_columns');

add_action('manage_posts_custom_column',  'portfolioposttype_columns_display', 10, 2);

/**
 * Displays the custom post type icon in the dashboard
 */

function portfolioposttype_portfolio_icons() {
    ?>
    <style type="text/css" media="screen">
        #menu-posts-portfolio .wp-menu-image {
            background: url(<?php echo plugin_dir_url( __FILE__ ); ?>images/portfolio-icon.png) no-repeat 6px 6px !important;
        }
		#menu-posts-portfolio:hover .wp-menu-image, #menu-posts-portfolio.wp-has-current-submenu .wp-menu-image {
            background-position:6px -16px !important;
        }
		#icon-edit.icon32-posts-portfolio {background: url(<?php echo plugin_dir_url( __FILE__ ); ?>images/portfolio-32x32.png) no-repeat;}
    </style>
<?php }

add_action( 'admin_head', 'portfolioposttype_portfolio_icons' );

?>