<?php
namespace PortfolioPostType\Tests\Integration;

use WP_UnitTestCase;
use Portfolio_Post_Type_Registrations;

class RegistrationsTest extends WP_UnitTestCase {

	/**
	 * @var Portfolio_Post_Type_Registrations
	 */
	private $registrations;

	public function set_up() {
		parent::set_up();
		$this->registrations = $GLOBALS['portfolio_post_type_registrations'];
	}

	public function tear_down() {
		// Restore registrations in case a test unregistered them.
		$this->registrations->register();
		parent::tear_down();
	}

	public function test_plugin_hooks_registration_into_init() {
		$this->assertSame( 10, has_action( 'init', array( $this->registrations, 'register' ) ) );
	}

	public function test_post_type_and_taxonomies_are_registered() {
		$this->assertTrue( post_type_exists( 'portfolio' ) );
		$this->assertTrue( taxonomy_exists( 'portfolio_category' ) );
		$this->assertTrue( taxonomy_exists( 'portfolio_tag' ) );
		$this->assertEqualSets( array( 'portfolio_category', 'portfolio_tag' ), get_object_taxonomies( 'portfolio' ) );
	}

	public function test_post_type_is_available_in_rest() {
		$this->assertTrue( get_post_type_object( 'portfolio' )->show_in_rest );
		$this->assertTrue( use_block_editor_for_post_type( 'portfolio' ) );
	}

	public function test_registering_twice_does_not_duplicate_taxonomies() {
		$this->registrations->register();
		$this->assertSame( array( 'portfolio_category', 'portfolio_tag' ), $this->registrations->taxonomies );
	}

	public function test_unregister_removes_post_type_and_taxonomies() {
		$this->registrations->unregister();

		$this->assertFalse( post_type_exists( 'portfolio' ) );
		$this->assertFalse( taxonomy_exists( 'portfolio_category' ) );
		$this->assertFalse( taxonomy_exists( 'portfolio_tag' ) );
		$this->assertNull( $this->registrations->post_type );
		$this->assertSame( array(), $this->registrations->taxonomies );
	}

	public function test_portfolio_item_can_be_created_with_terms() {
		$post_id = self::factory()->post->create( array( 'post_type' => 'portfolio', 'post_title' => 'Test' ) );
		wp_set_object_terms( $post_id, 'Web', 'portfolio_category' );
		wp_set_object_terms( $post_id, array( 'php', 'wordpress' ), 'portfolio_tag' );

		$this->assertSame( 'portfolio', get_post_type( $post_id ) );
		$this->assertSame( array( 'web' ), wp_get_object_terms( $post_id, 'portfolio_category', array( 'fields' => 'slugs' ) ) );
		$this->assertEqualSets( array( 'php', 'wordpress' ), wp_get_object_terms( $post_id, 'portfolio_tag', array( 'fields' => 'slugs' ) ) );
	}
}
