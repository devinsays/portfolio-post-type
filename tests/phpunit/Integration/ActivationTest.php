<?php
namespace PortfolioPostType\Tests\Integration;

use WP_UnitTestCase;

class ActivationTest extends WP_UnitTestCase {

	public function test_new_sites_use_wp_initialize_site_not_deprecated_hook() {
		$plugin = $GLOBALS['portfolio_post_type'];

		$this->assertSame( 11, has_action( 'wp_initialize_site', array( $plugin, 'activate_new_site' ) ) );
		$this->assertFalse( has_action( 'wpmu_new_blog', array( $plugin, 'activate_new_site' ) ) );
	}

	public function test_activation_registers_post_type_and_flushes_rewrite_rules() {
		$GLOBALS['portfolio_post_type_registrations']->unregister();
		$this->set_permalink_structure( '/%postname%/' );
		$this->assertFalse( post_type_exists( 'portfolio' ) );
		$this->assertArrayNotHasKey( 'portfolio/?$', get_option( 'rewrite_rules' ) );

		$GLOBALS['portfolio_post_type']->activate( false );

		$this->assertTrue( post_type_exists( 'portfolio' ) );
		$this->assertArrayHasKey( 'portfolio/?$', get_option( 'rewrite_rules' ) );
	}

	public function tear_down() {
		$GLOBALS['portfolio_post_type_registrations']->register();
		$this->set_permalink_structure( '' );
		parent::tear_down();
	}

	public function test_activate_new_site_accepts_wp_site_object() {
		if ( ! is_multisite() ) {
			$this->markTestSkipped( 'Multisite only. Run with WP_MULTISITE=1.' );
		}
		$this->set_permalink_structure( '/%postname%/' );
		$site = get_site( get_current_blog_id() );

		$GLOBALS['portfolio_post_type']->activate_new_site( $site );

		$this->assertTrue( post_type_exists( 'portfolio' ) );
		$this->assertSame( get_current_blog_id(), (int) $site->blog_id );
	}
}
