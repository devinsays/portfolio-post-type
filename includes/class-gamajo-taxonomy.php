<?php
/**
 * Gamajo Taxonomy
 *
 * @package   Gamajo_Registerable
 * @author    Gary Jones
 * @link      http://gamajo.com/registerable
 * @copyright 2013 Gary Jones
 * @license   GPL-2.0+
 * @version   1.0.1
 */

/**
 * Custom taxonomy registration
 *
 * @package Gamajo_Registerable
 * @author  Gary Jones
 */
abstract class Gamajo_Taxonomy implements Gamajo_Registerable {
	/**
	 * Taxonomy ID.
	 *
	 * @since 1.0.0
	 *
	 * @type string
	 */
	protected $taxonomy;

	/**
	 * Taxonomy arguments.
	 *
	 * @since 1.0.0
	 *
	 * @type array
	 */
	protected $args;

	/**
	 * Register a taxonomy.
	 *
	 * Setting the object type explicitly to null registers the taxonomy but doesn't associate it with any objects, so
	 * it won't be directly available within the Admin UI. You will need to manually register it using the 'taxonomy'
	 * parameter (passed through $args) when registering a custom post_type (see register_post_type()), or using
	 * register_taxonomy_for_object_type().
	 *
	 * @since 1.0.0
	 *
	 * @param  array|string $object_type Optional. Name of the object type. Default is null.
	 */
	public function register( $object_type = null ) {
		if ( ! $this->args ) {
			$this->set_args();
		}
		register_taxonomy( $this->taxonomy, $object_type, $this->args );
	}

	/**
	 * Unregister the post type.
	 *
	 * Since there is no unregister_taxonomy() function, the value is unset from the global instead.
	 *
	 * @since 1.0.0
	 *
	 * @global array $wp_taxonomies
	 */
	public function unregister() {
		global $wp_taxonomies;
		if ( taxonomy_exists( $this->taxonomy ) ) {
			unset( $wp_taxonomies[ $this->taxonomy ] );
		}
		// Alternatively, to leave it not registered to any post type:
		// register_taxonomy( $this->taxonomy, null );
	}

	/**
	 * Merge any provided arguments with the default ones for the taxonomy.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args Taxonomy arguments.
	 */
	public function set_args( $args = null ) {
		$this->args = wp_parse_args( $args, $this->default_args() );
	}

	/**
	 * Return taxonomy arguments.
	 *
	 * @since 1.0.0
	 *
	 * @return array Post type arguments.
	 */
	public function get_args() {
		return $this->args;
	}

	/**
	 * Return taxonomy ID.
	 *
	 * @since 1.0.0
	 *
	 * @return string Taxonomy ID.
	 */
	public function get_taxonomy() {
		return $this->taxonomy;
	}

	/**
	 * Return taxonomy default arguments.
	 *
	 * @since 1.0.0
	 *
	 * @return array Taxonomy default arguments.
	 */
	abstract protected function default_args();
}
