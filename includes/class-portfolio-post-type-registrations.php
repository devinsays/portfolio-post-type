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

	public $post_type;

	public $taxonomies;

	public function init() {
		// Add the portfolio post type and taxonomies
		add_action( 'init', array( $this, 'register' ) );
	}

	/**
	 * Initiate registrations of post type and taxonomies.
	 */
	public function register() {
		global $portfolio_post_type_post_type, $portfolio_post_type_taxonomy_category, $portfolio_post_type_taxonomy_tag;

		$portfolio_post_type_post_type = new Portfolio_Post_Type_Post_Type;
		$portfolio_post_type_post_type->register();
		$this->post_type = $portfolio_post_type_post_type->get_post_type();

		$portfolio_post_type_taxonomy_category = new Portfolio_Post_Type_Taxonomy_Category;
		$portfolio_post_type_taxonomy_category->register();
		$this->taxonomies[] = $portfolio_post_type_taxonomy_category->get_taxonomy();
		register_taxonomy_for_object_type(
			$portfolio_post_type_taxonomy_category->get_taxonomy(),
			$portfolio_post_type_post_type->get_post_type()
		);

		$portfolio_post_type_taxonomy_tag = new Portfolio_Post_Type_Taxonomy_Tag;
		$portfolio_post_type_taxonomy_tag->register();
		$this->taxonomies[] = $portfolio_post_type_taxonomy_tag->get_taxonomy();
		register_taxonomy_for_object_type(
			$portfolio_post_type_taxonomy_tag->get_taxonomy(),
			$portfolio_post_type_post_type->get_post_type()
		);
	}

	/**
	 * Unregister post type and taxonomies registrations.
	 */
	public function unregister() {
		global $portfolio_post_type_post_type, $portfolio_post_type_taxonomy_category, $portfolio_post_type_taxonomy_tag;
		$portfolio_post_type_post_type->unregister();
		$this->post_type = null;

		$portfolio_post_type_taxonomy_category->unregister();
		unset( $this->taxonomies[ $portfolio_post_type_taxonomy_category->get_taxonomy() ] );

		$portfolio_post_type_taxonomy_tag->unregister();
		unset( $this->taxonomies[ $portfolio_post_type_taxonomy_tag->get_taxonomy() ] );
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

		register_taxonomy( 'portfolio_category', $this->post_type, $args );
		$this->taxonomies[] = 'portfolio_category';
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

		register_taxonomy( 'portfolio_tag', $this->post_type, $args );
		$this->taxonomies[] = 'portfolio_tag';

	}
}
