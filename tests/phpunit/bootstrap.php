<?php
/**
 * PHPUnit bootstrap file.
 *
 * Install the WordPress test suite first: bash tests/bin/install-wp-tests.sh <db> <user> <pass>
 */

define( 'PROJECT_DIR', dirname( dirname( __DIR__ ) ) );
define( 'TESTS_DIR', getenv( 'WP_TESTS_DIR' ) ?: PROJECT_DIR . '/tests/tmp/wordpress-tests-lib' );

if ( ! file_exists( TESTS_DIR . '/includes/functions.php' ) ) {
	throw new RuntimeException( 'WordPress tests directory not found: ' . TESTS_DIR . '. Run tests/bin/install-wp-tests.sh first.' );
}

// Load PHPUnit Polyfills.
require_once PROJECT_DIR . '/vendor/yoast/phpunit-polyfills/phpunitpolyfills-autoload.php';

// Load WordPress test functions.
require_once TESTS_DIR . '/includes/functions.php';

// Load the plugin the same way WordPress would.
tests_add_filter(
	'muplugins_loaded',
	function () {
		require_once PROJECT_DIR . '/portfolio-post-type.php';
	}
);

// Bootstrap WordPress.
require_once TESTS_DIR . '/includes/bootstrap.php';

// Admin classes are only loaded on admin requests, so load them for tests.
require_once PROJECT_DIR . '/includes/class-gamajo-dashboard-glancer.php';
require_once PROJECT_DIR . '/includes/class-portfolio-post-type-admin.php';
require_once PROJECT_DIR . '/includes/class-gamajo-single-entry-term-body-classes.php';
