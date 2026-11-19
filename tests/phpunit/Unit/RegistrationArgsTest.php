<?php
namespace PortfolioPostType\Tests\Unit;

use WP_UnitTestCase;
use ReflectionMethod;
use Portfolio_Post_Type_Post_Type;
use Portfolio_Post_Type_Taxonomy_Category;
use Portfolio_Post_Type_Taxonomy_Tag;

class RegistrationArgsTest extends WP_UnitTestCase {

	private function default_args( $object ) {
		$method = new ReflectionMethod( $object, 'default_args' );
		$method->setAccessible( true );
		return $method->invoke( $object );
	}

	public function test_post_type_id() {
		$this->assertSame( 'portfolio', ( new Portfolio_Post_Type_Post_Type() )->get_post_type() );
	}

	public function test_post_type_has_all_labels() {
		$labels = $this->default_args( new Portfolio_Post_Type_Post_Type() )['labels'];

		$keys = array( 'name', 'singular_name', 'menu_name', 'name_admin_bar', 'add_new', 'add_new_item', 'new_item', 'edit_item', 'view_item', 'all_items', 'search_items', 'parent_item_colon', 'not_found', 'not_found_in_trash' );
		foreach ( $keys as $key ) {
			$this->assertArrayHasKey( $key, $labels, "$key is not set" );
		}
	}

	public function test_post_type_supports_block_editor_and_graphql() {
		$args = $this->default_args( new Portfolio_Post_Type_Post_Type() );

		$this->assertTrue( $args['show_in_rest'] );
		$this->assertTrue( $args['public'] );
		$this->assertTrue( $args['has_archive'] );
		$this->assertTrue( $args['show_in_graphql'] );
		$this->assertContains( 'thumbnail', $args['supports'] );
		$this->assertContains( 'editor', $args['supports'] );
	}

	public function test_post_type_args_are_filterable() {
		$filter = function ( $args ) {
			$args['rewrite'] = array( 'slug' => 'project' );
			return $args;
		};
		add_filter( 'portfolioposttype_args', $filter );

		$args = $this->default_args( new Portfolio_Post_Type_Post_Type() );
		$this->assertSame( array( 'slug' => 'project' ), $args['rewrite'] );

		remove_filter( 'portfolioposttype_args', $filter );
	}

	/**
	 * @dataProvider taxonomy_provider
	 */
	public function test_taxonomy_args( $class, $id, $hierarchical, $filter ) {
		$taxonomy = new $class();
		$this->assertSame( $id, $taxonomy->get_taxonomy() );

		$args = $this->default_args( $taxonomy );
		$this->assertSame( $hierarchical, $args['hierarchical'] );
		$this->assertTrue( $args['show_in_rest'] );
		$this->assertTrue( $args['show_admin_column'] );

		$keys = array( 'name', 'singular_name', 'menu_name', 'edit_item', 'update_item', 'add_new_item', 'new_item_name', 'parent_item', 'parent_item_colon', 'all_items', 'search_items', 'popular_items', 'separate_items_with_commas', 'add_or_remove_items', 'choose_from_most_used', 'not_found' );
		foreach ( $keys as $key ) {
			$this->assertArrayHasKey( $key, $args['labels'], "$key is not set" );
		}

		$callback = function ( $args ) {
			$args['public'] = false;
			return $args;
		};
		add_filter( $filter, $callback );
		$this->assertFalse( $this->default_args( $taxonomy )['public'] );
		remove_filter( $filter, $callback );
	}

	public function taxonomy_provider() {
		return array(
			'category' => array( Portfolio_Post_Type_Taxonomy_Category::class, 'portfolio_category', true, 'portfolioposttype_category_args' ),
			'tag'      => array( Portfolio_Post_Type_Taxonomy_Tag::class, 'portfolio_tag', false, 'portfolioposttype_tag_args' ),
		);
	}
}
