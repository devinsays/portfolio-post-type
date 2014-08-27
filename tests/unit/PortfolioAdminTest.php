<?php

class PortfolioAdminTest extends WP_UnitTestCase {

	protected $admin;

	public function setUp() {
		parent::setUp();
		$this->admin = new Portfolio_Post_Type_Admin( null );
	}

	public function testBuildTermOptions() {
		$method = new ReflectionMethod(	'Portfolio_Post_Type_Admin', 'build_term_options' );
		$method->setAccessible( true );

		// Testing the ability to build options, so mock term objects
		$foo = $this->createTerm( 'foo', 'Foo', 1 );
		$bar = $this->createTerm( 'bar', 'Bar', 2 );
		$baz = $this->createTerm( 'baz', 'Baz', 3 );

		$expected =  '<option value="foo" />Foo(1)</option><option value="bar" selected=\'selected\' />Bar(2)</option><option value="baz" />Baz(3)</option>';
		$results  = $method->invoke( $this->admin, array( $foo, $bar, $baz ), 'bar' );
		$this->assertEquals( $expected, $results );
	}

	private function createTerm( $slug, $name, $count ) {
		$term        = new stdClass;
		$term->slug  = $slug;
		$term->name  = $name;
		$term->count = $count;
		return $term;
	}

}
