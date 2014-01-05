<?php
/**
 * Portfolio Post Type
 *
 * @package   Portfolio_Post_Type
 * @author    Devin Price
 * @author    Gary Jones
 * @license   GPL-2.0+
 * @link      http://wptheming.com/portfolio-post-type/
 * @copyright 2011-2013 Devin Price
 */

/**
 * Register post types and taxonomies.
 *
 * @package Portfolio_Post_Type
 * @author  Devin Price
 * @author  Gary Jones
 */
class Portfolio_Post_Type_Registrations {

	public $post_type = 'portfolio';

	public $taxonomies = array( 'portfolio_category', 'portfolio_tag' );

	public function init() {
		// Add the portfolio post type and taxonomies
		add_action( 'init', array( $this, 'register' ) );
	}

	/**
	 * Initiate registrations of post type and taxonomies.
	 *
	 * @uses Portfolio_Post_Type_Registrations::register_post_type()
	 * @uses Portfolio_Post_Type_Registrations::register_taxonomy_tag()
	 * @uses Portfolio_Post_Type_Registrations::register_taxonomy_category()
	 */
	public function register() {
		$this->register_post_type();
		$this->register_taxonomy_category();
		$this->register_taxonomy_tag();
	}

	/**
	 * Register the custom post type.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_post_type
	 */
	protected function register_post_type() {
		$labels = array(
			'name'               => __( 'Portfolio', 'portfolio-post-type' ),
			'singular_name'      => __( 'Portfolio Item', 'portfolio-post-type' ),
			'add_new'            => __( 'Add New Item', 'portfolio-post-type' ),
			'add_new_item'       => __( 'Add New Portfolio Item', 'portfolio-post-type' ),
			'edit_item'          => __( 'Edit Portfolio Item', 'portfolio-post-type' ),
			'new_item'           => __( 'Add New Portfolio Item', 'portfolio-post-type' ),
			'view_item'          => __( 'View Item', 'portfolio-post-type' ),
			'search_items'       => __( 'Search Portfolio', 'portfolio-post-type' ),
			'not_found'          => __( 'No portfolio items found', 'portfolio-post-type' ),
			'not_found_in_trash' => __( 'No portfolio items found in trash', 'portfolio-post-type' ),
		);

		$supports = array(
			'title',
			'editor',
			'excerpt',
			'thumbnail',
			'comments',
			'author',
			'custom-fields',
			'revisions',
		);

		$args = array(
			'labels'          => $labels,
			'supports'        => $supports,
			'public'          => true,
			'capability_type' => 'post',
			'rewrite'         => array( 'slug' => 'portfolio', ), // Permalinks format
			'menu_position'   => 5,
			'menu_icon'       => ( version_compare( $GLOBALS['wp_version'], '3.8', '>=' ) ) ? 'dashicons-portfolio' : '',
			'has_archive'     => true,
		);

		$args = apply_filters( 'portfolioposttype_args', $args );

		register_post_type( $this->post_type, $args );
	}

	/**
	 * Register a taxonomy for Portfolio Categories.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
	 */
	protected function register_taxonomy_category() {
		$labels = array(
			'name'                       => __( 'Portfolio Categories', 'portfolio-post-type' ),
			'singular_name'              => __( 'Portfolio Category', 'portfolio-post-type' ),
			'menu_name'                  => __( 'Portfolio Categories', 'portfolio-post-type' ),
			'edit_item'                  => __( 'Edit Portfolio Category', 'portfolio-post-type' ),
			'update_item'                => __( 'Update Portfolio Category', 'portfolio-post-type' ),
			'add_new_item'               => __( 'Add New Portfolio Category', 'portfolio-post-type' ),
			'new_item_name'              => __( 'New Portfolio Category Name', 'portfolio-post-type' ),
			'parent_item'                => __( 'Parent Portfolio Category', 'portfolio-post-type' ),
			'parent_item_colon'          => __( 'Parent Portfolio Category:', 'portfolio-post-type' ),
			'all_items'                  => __( 'All Portfolio Categories', 'portfolio-post-type' ),
			'search_items'               => __( 'Search Portfolio Categories', 'portfolio-post-type' ),
			'popular_items'              => __( 'Popular Portfolio Categories', 'portfolio-post-type' ),
			'separate_items_with_commas' => __( 'Separate portfolio categories with commas', 'portfolio-post-type' ),
			'add_or_remove_items'        => __( 'Add or remove portfolio categories', 'portfolio-post-type' ),
			'choose_from_most_used'      => __( 'Choose from the most used portfolio categories', 'portfolio-post-type' ),
			'not_found'                  => __( 'No portfolio categories found.', 'portfolio-post-type' ),
		);

		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_ui'           => true,
			'show_tagcloud'     => true,
			'hierarchical'      => true,
			'rewrite'           => array( 'slug' => 'portfolio_category' ),
			'show_admin_column' => true,
			'query_var'         => true,
		);

		$args = apply_filters( 'portfolioposttype_category_args', $args );

		register_taxonomy( $this->taxonomies[0], $this->post_type, $args );
	}

	/**
	 * Register a taxonomy for Portfolio Tags.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
	 */
	protected function register_taxonomy_tag() {
		$labels = array(
			'name'                       => __( 'Portfolio Tags', 'portfolio-post-type' ),
			'singular_name'              => __( 'Portfolio Tag', 'portfolio-post-type' ),
			'menu_name'                  => __( 'Portfolio Tags', 'portfolio-post-type' ),
			'edit_item'                  => __( 'Edit Portfolio Tag', 'portfolio-post-type' ),
			'update_item'                => __( 'Update Portfolio Tag', 'portfolio-post-type' ),
			'add_new_item'               => __( 'Add New Portfolio Tag', 'portfolio-post-type' ),
			'new_item_name'              => __( 'New Portfolio Tag Name', 'portfolio-post-type' ),
			'parent_item'                => __( 'Parent Portfolio Tag', 'portfolio-post-type' ),
			'parent_item_colon'          => __( 'Parent Portfolio Tag:', 'portfolio-post-type' ),
			'all_items'                  => __( 'All Portfolio Tags', 'portfolio-post-type' ),
			'search_items'               => __( 'Search Portfolio Tags', 'portfolio-post-type' ),
			'popular_items'              => __( 'Popular Portfolio Tags', 'portfolio-post-type' ),
			'separate_items_with_commas' => __( 'Separate portfolio tags with commas', 'portfolio-post-type' ),
			'add_or_remove_items'        => __( 'Add or remove portfolio tags', 'portfolio-post-type' ),
			'choose_from_most_used'      => __( 'Choose from the most used portfolio tags', 'portfolio-post-type' ),
			'not_found'                  => __( 'No portfolio tags found.', 'portfolio-post-type' ),
		);

		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_ui'           => true,
			'show_tagcloud'     => true,
			'hierarchical'      => false,
			'rewrite'           => array( 'slug' => 'portfolio_tag' ),
			'show_admin_column' => true,
			'query_var'         => true,
		);

		$args = apply_filters( 'portfolioposttype_tag_args', $args );

		register_taxonomy( $this->taxonomies[1], $this->post_type, $args );

	}
}
