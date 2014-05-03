<?php

class PortfolioPostTypeTest extends WP_UnitTestCase {

	public $reg;

	public function setUp() {
		parent::setUp();
		$this->reg = new Portfolio_Post_Type_Registrations;
	}

	public function testPostTypeIsRegistered() {
		$this->reg->register();
		$this->assertArrayHasKey( $this->reg->post_type, get_post_types() );
	}

	public function testGetPortfolioItem() {
		$this->reg->register();

		$item_args = array(
			'post_type' => $this->reg->post_type,
			'post_title' => 'Test',
		);

		$item = $this->factory->post->create_and_get( $item_args );

		$this->assertEquals( $this->reg->post_type, $item->post_type );
		$this->assertEquals( 'Test', $item->post_title );
	}

}
