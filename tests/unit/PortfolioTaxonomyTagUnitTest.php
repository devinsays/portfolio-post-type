<?php

class PortfolioTaxonomyTagUnitTest extends WP_UnitTestCase {

	protected $object;
	protected $label_keys;

	public function setUp() {
		parent::setUp();
		$this->object = new Portfolio_Post_Type_Taxonomy_Tag;

		$this->label_keys = array(
			'name',
			'singular_name',
			'menu_name',
			'edit_item',
			'update_item',
			'add_new_item',
			'new_item_name',
			'parent_item',
			'parent_item_colon',
			'all_items',
			'search_items',
			'popular_items',
			'separate_items_with_commas',
			'add_or_remove_items',
			'choose_from_most_used',
			'not_found',
		);
	}

	public function testPostTypeIsSet() {
		$this->assertObjectHasAttribute( 'taxonomy', $this->object );
		$this->assertNotEmpty( $this->object->get_taxonomy() );
	}

	public function testHasAllLabels() {
		$labels = $this->get_default_args()['labels'];

		foreach ( $this->label_keys as $label ) {
			$this->assertArrayHasKey( $label, $labels, "$label is not set" );
		}
	}

	private function get_default_args() {
		$method = new ReflectionMethod(	'Portfolio_Post_Type_Taxonomy_Tag', 'default_args' );
		$method->setAccessible( true );

		return $method->invoke( $this->object );
	}

}
