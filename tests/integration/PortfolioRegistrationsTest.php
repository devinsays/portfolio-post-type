<?php

class PortfolioRegistrationsTest extends WP_UnitTestCase {

	protected $object;

	public function setUp() {
		parent::setUp();
		$this->object = new Portfolio_Post_Type_Registrations;
	}

	public function testPostTypeIsRegistered() {
		$this->assertEmpty( $this->object->post_type );

		$this->object->register();

		$this->assertArrayHasKey( $this->object->post_type, get_post_types() );
	}

	public function testGetPortfolioItem() {
		$this->object->register();

		$item_args = array(
			'post_type' => $this->object->post_type,
			'post_title' => 'Test',
		);

		$item = $this->factory->post->create_and_get( $item_args );

		$this->assertEquals( $this->object->post_type, $item->post_type );
		$this->assertEquals( 'Test', $item->post_title );
	}

	public function tearDown() {
		$this->object->unregister();
	}

}
