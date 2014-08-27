<?php
/**
 * Gamajo Post Type
 *
 * @package   Gamajo_Registerable
 * @author    Gary Jones
 * @link      http://gamajo.com/registerable
 * @copyright 2013 Gary Jones
 * @license   GPL-2.0+
 * @version   1.0.1
 */

/**
 * Custom post type registration.
 *
 * @package Gamajo_Registerable
 * @author  Gary Jones
 */
abstract class Gamajo_Post_Type implements Gamajo_Registerable {
	/**
	 * Post type ID.
	 *
	 * @since 1.0.0
	 *
	 * @type string
	 */
	protected $post_type;

	/**
	 * Post type arguments.
	 *
	 * @since 1.0.0
	 *
	 * @type array
	 */
	protected $args;

	/**
	 * Register the post type.
	 *
	 * @since 1.0.0
	 */
	public function register() {
		if ( ! $this->args ) {
			$this->set_args();
		}
		register_post_type( $this->post_type, $this->args );
	}

	/**
	 * Unregister the post type.
	 *
	 * Since there is no unregister_post_type() function, the value is unset from the global instead.
	 *
	 * @since 1.0.0
	 *
	 * @global array $wp_post_types
	 */
	public function unregister() {
		global $wp_post_types;
		if ( isset( $wp_post_types[ $this->post_type ] ) ) {
			unset( $wp_post_types[ $this->post_type ] );
		}
	}

	/**
	 * Merge any provided arguments with the default ones for a post type.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args Post type arguments.
	 */
	public function set_args( $args = null ) {
		$this->args = wp_parse_args( $args, $this->default_args() );
	}

	/**
	 * Return post type arguments.
	 *
	 * @since 1.0.0
	 *
	 * @return array Post type arguments.
	 */
	public function get_args() {
		return $this->args;
	}

	/**
	 * Return post type ID.
	 *
	 * @since 1.0.0
	 *
	 * @return string Post type ID.
	 */
	public function get_post_type() {
		return $this->post_type;
	}

	/**
	 * Return post type updated messages.
	 *
	 * @since 1.0.0
	 *
	 * @return array Post type updated messages.
	 */
	abstract public function messages();

	/**
	 * Return post type default arguments.
	 *
	 * @since 1.0.0
	 *
	 * @return array Post type default arguments.
	 */
	abstract protected function default_args();
}
