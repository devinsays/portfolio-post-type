<?php
namespace PortfolioPostType\Tests\Unit;

use WP_UnitTestCase;
use Gamajo_Post_Type;

class GamajoPostTypeTest extends WP_UnitTestCase {

	private function stub_with_defaults( array $defaults ) {
		$stub = $this->getMockForAbstractClass( Gamajo_Post_Type::class );
		$stub->method( 'default_args' )->willReturn( $defaults );
		return $stub;
	}

	public function test_set_args_with_empty_defaults() {
		$stub = $this->stub_with_defaults( array() );

		$stub->set_args( array() );
		$this->assertSame( array(), $stub->get_args() );

		$stub->set_args( array( 'foo' => 'bar' ) );
		$this->assertSame( array( 'foo' => 'bar' ), $stub->get_args() );
	}

	public function test_set_args_merges_over_defaults() {
		$stub = $this->stub_with_defaults( array( 'baz' => 'x' ) );

		$stub->set_args( array() );
		$this->assertSame( array( 'baz' => 'x' ), $stub->get_args() );

		$stub->set_args( array( 'foo' => 'bar' ) );
		$this->assertEqualSets( array( 'foo' => 'bar', 'baz' => 'x' ), $stub->get_args() );

		$stub->set_args( array( 'baz' => 'y' ) );
		$this->assertSame( array( 'baz' => 'y' ), $stub->get_args() );
	}
}
