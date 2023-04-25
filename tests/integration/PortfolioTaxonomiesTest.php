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
	
	public function tearDown() {
		$this->reg->unregister();
	}

}
