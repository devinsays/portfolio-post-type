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
}
