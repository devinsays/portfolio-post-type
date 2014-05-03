<?php

class PortfolioTaxonomiesTest extends WP_UnitTestCase {

	public $reg;

	public function setUp() {
		$this->reg = new Portfolio_Post_Type_Registrations;
	}

	public function testTaxonomyIsRegistered() {
		$this->reg->register();
		$this->assertArrayHasKey( $this->reg->taxonomies[0], get_taxonomies(), 'portfolio_category not registered.' );
		$this->assertArrayHasKey( $this->reg->taxonomies[1], get_taxonomies(), 'portfolio_tag not registered.' );
	}

}
