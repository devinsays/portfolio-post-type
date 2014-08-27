<?php

class PortfolioPostTypeUnitTest extends WP_UnitTestCase {

	protected $object;
	protected $label_keys;

	public function setUp() {
		parent::setUp();
		$this->object = new Portfolio_Post_Type_Post_Type;

		$this->label_keys = array(
			'name',
			'singular_name',
			'menu_name',
			'name_admin_bar',
			'add_new',
			'add_new_item',
			'new_item',
			'edit_item',
			'view_item',
			'all_items',
			'search_items',
			'parent_item_colon',
			'not_found',
			'not_found_in_trash',
		);
	}

	public function testPostTypeIsSet() {
		$this->assertObjectHasAttribute( 'post_type', $this->object );
		$this->assertNotEmpty( $this->object->get_post_type() );
	}

	public function testHasAllLabels() {
		$labels = $this->get_default_args()['labels'];

		foreach ( $this->label_keys as $label ) {
			$this->assertArrayHasKey( $label, $labels, "$label is not set" );
		}
	}

	private function get_default_args() {
		$method = new ReflectionMethod(	'Portfolio_Post_Type_Post_Type', 'default_args' );
		$method->setAccessible( true );

		return $method->invoke( $this->object );
	}

}
