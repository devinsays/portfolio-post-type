<?php
namespace PortfolioPostType\Tests\Integration;

use WP_UnitTestCase;
use ReflectionMethod;
use Portfolio_Post_Type_Admin;

class AdminTest extends WP_UnitTestCase {

	/**
	 * @var Portfolio_Post_Type_Admin
	 */
	private $admin;

	public function set_up() {
		parent::set_up();
		$this->admin = new Portfolio_Post_Type_Admin( $GLOBALS['portfolio_post_type_registrations'] );
	}

	public function tear_down() {
		unset( $_GET['portfolio_category'] );
		parent::tear_down();
	}

	private function invoke( $method, ...$args ) {
		$reflection = new ReflectionMethod( Portfolio_Post_Type_Admin::class, $method );
		$reflection->setAccessible( true );
		return $reflection->invoke( $this->admin, ...$args );
	}

	public function test_thumbnail_callback_is_scoped_to_portfolio_post_type() {
		$this->admin->init();

		$this->assertSame( 10, has_action( 'manage_portfolio_posts_custom_column', array( $this->admin, 'display_thumbnail' ) ) );
		$this->assertFalse( has_action( 'manage_posts_custom_column', array( $this->admin, 'display_thumbnail' ) ) );
	}

	public function test_thumbnail_column_is_inserted_after_title() {
		$columns = $this->admin->add_thumbnail_column(
			array(
				'cb'    => '<input type="checkbox" />',
				'title' => 'Title',
				'date'  => 'Date',
			)
		);

		$this->assertSame( array( 'cb', 'title', 'thumbnail', 'date' ), array_keys( $columns ) );
	}

	public function test_display_thumbnail_ignores_other_columns() {
		$this->expectOutputString( '' );
		$this->admin->display_thumbnail( 'title' );
	}

	public function test_build_term_options_markup() {
		$terms = array(
			(object) array( 'slug' => 'foo', 'name' => 'Foo', 'count' => 1 ),
			(object) array( 'slug' => 'bar', 'name' => 'Bar', 'count' => 2 ),
		);

		$expected = '<option value="foo">Foo (1)</option><option value="bar" selected=\'selected\'>Bar (2)</option>';
		$this->assertSame( $expected, $this->invoke( 'build_term_options', $terms, 'bar' ) );
	}

	public function test_taxonomy_filter_lists_terms_and_selects_current() {
		$post_id = self::factory()->post->create( array( 'post_type' => 'portfolio' ) );
		wp_set_object_terms( $post_id, 'Web Design', 'portfolio_category' );
		$_GET['portfolio_category'] = 'web-design';

		$html = $this->invoke( 'build_taxonomy_filter', 'portfolio_category' );

		$this->assertStringContainsString( '<select name="portfolio_category"', $html );
		$this->assertStringContainsString( '<option value="0">Portfolio Categories</option>', $html );
		$this->assertStringContainsString( '<option value="web-design" selected=\'selected\'>Web Design (1)</option>', $html );
	}

	public function test_taxonomy_filter_is_empty_without_terms() {
		$this->assertSame( '', $this->invoke( 'build_taxonomy_filter', 'portfolio_tag' ) );
	}

	/**
	 * Previously count() on a WP_Error was a fatal TypeError on PHP 8.
	 */
	public function test_taxonomy_filter_handles_unregistered_taxonomy() {
		$this->assertSame( '', $this->invoke( 'build_taxonomy_filter', 'not_a_taxonomy' ) );
	}

	public function test_taxonomy_filters_only_render_on_portfolio_screen() {
		self::factory()->term->create( array( 'taxonomy' => 'portfolio_tag', 'name' => 'Featured' ) );
		$post_id = self::factory()->post->create( array( 'post_type' => 'portfolio' ) );
		wp_set_object_terms( $post_id, 'featured', 'portfolio_tag' );

		$GLOBALS['typenow'] = 'post';
		ob_start();
		$this->admin->add_taxonomy_filters();
		$this->assertSame( '', ob_get_clean() );

		$GLOBALS['typenow'] = 'portfolio';
		ob_start();
		$this->admin->add_taxonomy_filters();
		$this->assertStringContainsString( 'name="portfolio_tag"', ob_get_clean() );
	}
}
