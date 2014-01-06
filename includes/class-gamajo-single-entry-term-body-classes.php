<?php
/**
 * Gamajo Single Entry Term Body Classes
 *
 * @package   Gamajo_Single_Entry_Term_Body_Classes
 * @author    Gary Jones
 * @license   GPL-2.0+
 * @copyright 2014 Gary Jones, Gamajo Tech
 * @link      http://gamajo.com/single-entry-term-body-classes
 */

/**
 * Modifications to the front-end.
 *
 * @package Gamajo_Single_Entry_Term_Body_Classes
 * @author  Gary Jones
 */
class Gamajo_Single_Entry_Term_Body_Classes {

	/**
	 * Post type to add single entry body classes.
	 *
	 * @since 1.0.0
	 *
	 * @type string
	 */
	protected $post_type;

	/**
	 * Hook in methods.
	 *
	 * @since 1.0.0
	 *
	 * @param string $post_type Post type to add single entry body classes.
	 */
	public function init( $post_type ) {
		$this->post_type = $post_type;

		// Add taxonomy terms as body classes
		add_filter( 'body_class', array( $this, 'body_class' ) );
	}

	/**
	 * Add taxonomy terms as body classes.
	 *
	 * If the taxonomy doesn't exist (has been unregistered), then get_the_terms() returns WP_Error, which is checked
	 * for before adding classes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $classes Existing body classes.
	 *
	 * @return array Amended body classes.
	 */
	public function body_class( $classes ) {
		// Only single entries of a certain post type should have the taxonomy body classes
		if ( ! is_singular( $this->post_type ) ) {
			return $classes;
		}

		global $portfolio_post_type_registrations;
		return array_merge( $classes, $this->get_taxonomy_term_classes( $portfolio_post_type_registrations->taxonomies ) );
	}

	/**
	 * Get classes for taxonomy terms.
	 *
	 * @since 1.0.0
	 *
	 * @param array|string $taxonomies Taxonomy slugs. Single slug only if string.
	 *
	 * @return array Classes in form of {taxonomy-slug}-{term-slug}.
	 */
	protected function get_taxonomy_term_classes( $taxonomies ) {
		$classes = array();
		foreach ( (array) $taxonomies as $taxonomy ) {
			$terms = $this->get_terms( $taxonomy );
			if ( is_array( $terms ) ) {
				foreach (  $terms as $term ) {
					$classes[] = $this->get_taxonomy_term_class( $taxonomy, $term->slug );
				}
			}
		}

		return $classes;
	}

	/**
	 * Get all the terms for a taxonomy applied to a post.
	 *
	 * If taxonomy is not registered, return an empty array.
	 *
	 * @since 1.0.0
	 *
	 * @param array|string $taxonomy Taxonomy slugs.
	 * @param int          $post_id  Optional. Post ID. Defaults to current global post ID.
	 *
	 * @return array Terms, or empty array if taxonomy not found.
	 */
	protected function get_terms( $taxonomy, $post_id = null ) {
		if ( is_null( $post_id ) ) {
			$post_id = get_the_ID();
		}

		$terms = get_the_terms( $post_id, $taxonomy );

		if ( is_wp_error( $terms ) ) {
			$terms = array();
		}

		return $terms;
	}

	/**
	 * Get string made up of taxonomy and term slugs, sanitized to be a HTML class.
	 *
	 * @since 1.0.0
	 *
	 * @param  string $taxonomy_slug Taxonomy slug.
	 * @param  string $term_slug     Term slug.
	 *
	 * @return string Sanitized class in the form of {$taxonomy_slug}-{$term_slug}.
	 */
	protected function get_taxonomy_term_class( $taxonomy_slug, $term_slug ) {
		return sanitize_html_class( str_replace( '_', '-', $taxonomy_slug ) . '-' . $term_slug );
	}

}