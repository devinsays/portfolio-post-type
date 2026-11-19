<?php
namespace PortfolioPostType\Tests\Integration;

use WP_UnitTestCase;
use Portfolio_Post_Type_Admin;

class DashboardGlanceTest extends WP_UnitTestCase {

	public function set_up() {
		parent::set_up();
		wp_set_current_user( self::factory()->user->create( array( 'role' => 'editor' ) ) );

		$admin = new Portfolio_Post_Type_Admin( $GLOBALS['portfolio_post_type_registrations'] );
		add_filter( 'dashboard_glance_items', array( $admin, 'add_glance_counts' ), 10, 1 );
	}

	public function test_glance_shows_published_and_pending_counts() {
		self::factory()->post->create_many( 2, array( 'post_type' => 'portfolio' ) );
		self::factory()->post->create( array( 'post_type' => 'portfolio', 'post_status' => 'pending' ) );

		$items = apply_filters( 'dashboard_glance_items', array() );

		$this->assertContains( '<a class="portfolio-count" href="edit.php?post_status=publish&#038;post_type=portfolio">2 Portfolio</a>', $items );
		$this->assertContains( '<a class="portfolio-count" href="edit.php?post_status=pending&#038;post_type=portfolio">1 Portfolio Item (pending)</a>', $items );
	}

	public function test_glance_omits_zero_counts() {
		$this->assertSame( array(), apply_filters( 'dashboard_glance_items', array() ) );
	}

	/**
	 * Previously the second run read an unset property and triggered a PHP warning.
	 */
	public function test_glance_filter_can_run_more_than_once() {
		self::factory()->post->create( array( 'post_type' => 'portfolio' ) );

		apply_filters( 'dashboard_glance_items', array() );
		$items = apply_filters( 'dashboard_glance_items', array() );

		$this->assertCount( 1, $items );
	}

	public function test_glance_is_plain_text_for_users_who_cannot_edit() {
		self::factory()->post->create( array( 'post_type' => 'portfolio' ) );
		wp_set_current_user( self::factory()->user->create( array( 'role' => 'subscriber' ) ) );

		$items = apply_filters( 'dashboard_glance_items', array() );

		$this->assertSame( array( '<span class="portfolio-count">1 Portfolio Item</span>' ), $items );
	}
}
