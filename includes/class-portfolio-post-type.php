<?php
/**
 * Portfolio Post Type
 *
 * @package   Portfolio_Post_Type
 * @author    Devin Price
 * @license   GPL-2.0+
 * @link      http://wptheming.com/portfolio-post-type/
 * @copyright 2011-2013 Devin Price
 */

/**
 * Registration of CPT and related taxonomies.
 *
 * @since Unknown
 */
class Portfolio_Post_Type {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   0.7.0
	 *
	 * @var    string VERSION Plugin version.
	 */
	const VERSION = '0.7.0';

	/**
	 * Unique identifier for your plugin.
	 *
	 * Use this value (not the variable name) as the text domain when internationalizing strings of text. It should
	 * match the Text Domain file header in the main plugin file.
	 *
	 * @since    0.7.0
	 *
	 * @var      string
	 */
	const PLUGIN_SLUG = 'portfolio-post-type';

	protected $registration_handler;

	/**
	 * Initialize the plugin by setting localization and new site activation hooks.
	 *
	 * @since     0.7.0
	 */
	public function __construct( $registration_handler ) {

		$this->registration_handler = $registration_handler;

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Activate plugin when new blog is added
		add_action( 'wpmu_new_blog', array( $this, 'activate_new_site' ) );

	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since    0.7.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Activate" action, false if WPMU is
	 *                                       disabled or plugin is activated on an individual blog.
	 */
	public function activate( $network_wide ) {
		if ( function_exists( 'is_multisite' ) && is_multisite() ) {
			if ( $network_wide  ) {
				// Get all blog ids
				$blog_ids = $this->get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {
					switch_to_blog( $blog_id );
					$this->single_activate();
				}
				restore_current_blog();
			} else {
				$this->single_activate();
			}
		} else {
			$this->single_activate();
		}
	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    0.7.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Deactivate" action, false if WPMU is
	 *                                       disabled or plugin is deactivated on an individual blog.
	 */
	public function deactivate( $network_wide ) {
		if ( function_exists( 'is_multisite' ) && is_multisite() ) {
			if ( $network_wide ) {
				// Get all blog ids
				$blog_ids = $this->get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {
					switch_to_blog( $blog_id );
					$this->single_deactivate();
				}
				restore_current_blog();
			} else {
				$this->single_deactivate();
			}
		} else {
			$this->single_deactivate();
		}
	}

	/**
	 * Fired when a new site is activated with a WPMU environment.
	 *
	 * @since    0.7.0
	 *
	 * @param	int	$blog_id ID of the new blog.
	 */
	public function activate_new_site( $blog_id ) {
		if ( 1 !== did_action( 'wpmu_new_blog' ) )
			return;

		switch_to_blog( $blog_id );
		$this->single_activate();
		restore_current_blog();
	}

	/**
	 * Get all blog ids of blogs in the current network that are:
	 * - not archived
	 * - not spam
	 * - not deleted
	 *
	 * @since    0.7.0
	 *
	 * @return	array|false	The blog ids, false if no matches.
	 */
	private function get_blog_ids() {
		global $wpdb;

		// get an array of blog ids
		$sql = "SELECT blog_id FROM $wpdb->blogs
			WHERE archived = '0' AND spam = '0'
			AND deleted = '0'";
		return $wpdb->get_col( $sql );
	}

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 * @since    0.7.0
	 */
	private function single_activate() {
		$this->registration_handler->register();
		flush_rewrite_rules();
	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @since    0.7.0
	 */
	private function single_deactivate() {
		flush_rewrite_rules();
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    0.7.0
	 */
	public function load_plugin_textdomain() {
		$domain = self::PLUGIN_SLUG;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, basename( dirname( __FILE__ ) ) . '/languages' );
	}

}
