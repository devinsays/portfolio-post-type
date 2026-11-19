<?php
namespace PortfolioPostType\Tests\Integration;

use WP_UnitTestCase;
use Gamajo_Single_Entry_Term_Body_Classes;

class BodyClassesTest extends WP_UnitTestCase {

	/**
	 * @var Gamajo_Single_Entry_Term_Body_Classes
	 */
	private $body_classes;

	public function set_up() {
		parent::set_up();
		$this->body_classes = new Gamajo_Single_Entry_Term_Body_Classes();
		$this->body_classes->init( 'portfolio' );
	}

	public function test_single_portfolio_item_gets_term_classes() {
		$post_id = self::factory()->post->create( array( 'post_type' => 'portfolio' ) );
		wp_set_object_terms( $post_id, 'Web Design', 'portfolio_category' );
		wp_set_object_terms( $post_id, 'featured', 'portfolio_tag' );

		$this->go_to( get_permalink( $post_id ) );
		$classes = $this->body_classes->body_class( array( 'existing' ) );

		$this->assertEqualSets( array( 'existing', 'portfolio-category-web-design', 'portfolio-tag-featured' ), $classes );
	}

	public function test_single_portfolio_item_without_terms_is_unchanged() {
		$post_id = self::factory()->post->create( array( 'post_type' => 'portfolio' ) );

		$this->go_to( get_permalink( $post_id ) );

		$this->assertSame( array( 'existing' ), $this->body_classes->body_class( array( 'existing' ) ) );
	}

	public function test_other_post_types_are_unchanged() {
		$post_id = self::factory()->post->create();

		$this->go_to( get_permalink( $post_id ) );

		$this->assertSame( array( 'existing' ), $this->body_classes->body_class( array( 'existing' ) ) );
	}
}
