<?php
/**
 * Portfolio Post Type
 *
 * @package   Portfolio_Post_Type
 * @author    Devin Price
 * @author    Gary Jones
 * @license   GPL-2.0+
 * @link      http://wptheming.com/portfolio-post-type/
 * @copyright 2011 Devin Price, Gary Jones
 */

/**
 * Portfolio tag taxonomy.
 *
 * @package Portfolio_Post_Type
 * @author  Devin Price
 * @author  Gary Jones
 */
class Portfolio_Post_Type_Taxonomy_Tag extends Gamajo_Taxonomy {
	/**
	 * Taxonomy ID.
	 *
	 * @since 1.0.0
	 *
	 * @type string
	 */
	protected $taxonomy = 'portfolio_tag';

	/**
	 * Return taxonomy default arguments.
	 *
	 * @since 1.0.0
	 *
	 * @return array Taxonomy default arguments.
	 */
	protected function default_args() {
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
			'items_list_navigation'      => __( 'Portfolio tags list navigation', 'portfolio-post-type' ),
			'items_list'                 => __( 'Portfolio tags list', 'portfolio-post-type' ),
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
			'show_in_rest'      => true,
		);

		return apply_filters( 'portfolioposttype_tag_args', $args );
	}
}