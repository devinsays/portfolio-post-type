<?php
/**
 * PHPUnit Bootstrap file.
 */

/**
 * You'll need to set `WP_TESTS_DIR` to the base directory of WordPress.
 *
 * Examples
 * `svn export http://develop.svn.wordpress.org/trunk/ /tmp/wordpress-tests`
 *
 * Then add this to your bash environment:
 *   `export WP_TESTS_DIR=/tmp/wordpress-tests`
 *
 *   (For Windows: powershell)
 *   `$env:WP_TESTS_DIR = "C:\tmp\wordpress-tests"`
 *
 *   (For Windows: cygwin)
 *   `setx WP_TESTS_DIR "C:\tmp\wordpress-tests"`
 */
if ( ! $wp_test_dir = getenv( 'WP_TESTS_DIR' ) ) {

	$wp_test_dir = '/tmp/wordpress-tests';

	if ( ! file_exists( $wp_test_dir ) || ! file_exists( $wp_test_dir . '/tests' ) ) {
		die( "Fatal Error: Could not find the WordPress tests directory.\n" );
	}
}

/** Bootstraps the WordPress stack. */
require_once $wp_test_dir . 'includes/bootstrap.php';

require plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-portfolio-post-type.php';
require plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-portfolio-post-type-registrations.php';
require plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-gamajo-dashboard-glancer.php';
require plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-gamajo-dashboard-rightnow.php';
require plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-portfolio-post-type-admin.php';
require plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-gamajo-single-entry-term-body-classes.php';
require plugin_dir_path( dirname( __FILE__ ) ) . 'includes/interface-gamajo-registerable.php';
require plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-gamajo-post-type.php';
require plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-gamajo-taxonomy.php';
require plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-portfolio-post-type-post-type.php';
require plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-portfolio-post-type-taxonomy-category.php';
require plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-portfolio-post-type-taxonomy-tag.php';
