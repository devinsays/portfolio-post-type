<?php

class PortfolioTaxonomiesTest extends WP_UnitTestCase {

	protected $reg;

	public function setUp() {
		$this->reg = new Portfolio_Post_Type_Registrations;
	}

	public function testTaxonomyIsRegistered() {
		$this->assertArrayNotHasKey( 'portfolio_category', get_taxonomies(), 'portfolio_category is registered.' );
		$this->assertArrayNotHasKey( 'portfolio_tag', get_taxonomies(), 'portfolio_tag is registered.' );
		$this->reg->register();
		$this->assertArrayHasKey( $this->reg->taxonomies[0], get_taxonomies(), 'portfolio_category not registered.' );
		$this->assertArrayHasKey( $this->reg->taxonomies[1], get_taxonomies(), 'portfolio_tag not registered.' );
	}

	// public function testGetPortfolioItem() {
	// 	$this->reg->register();

	// 	$item_args = array(
	// 		'post_type' => $this->reg->post_type,
	// 		'post_title' => 'Test',
	// 	);

	// 	$item = $this->factory->post->create_and_get( $item_args );

	// 	$this->assertEquals( $this->reg->post_type, $item->post_type );
	// 	$this->assertEquals( 'Test', $item->post_title );
	// }
	
	public function tearDown() {
		$this->reg->unregister();
	}

}
