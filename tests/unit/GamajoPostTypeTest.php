<?php

class GamajoPostTypeTest extends WP_UnitTestCase {

	public function testGetSetArgsEmptyDefaults() {
		$stub = $this->getMockForAbstractClass( 'Gamajo_Post_Type' );
		$stub->expects( $this->any())
			 ->method( 'default_args' )
			 ->will( $this->returnValue( array() ) );

		$stub->set_args( array() );
		$this->assertCount( 0, $stub->get_args() );
		$this->assertEqualSets( array(), $stub->get_args() );

		$stub->set_args( array( 'foo' ) );
		$this->assertCount( 1, $stub->get_args() );
		$this->assertEqualSets( array( 'foo' ), $stub->get_args() );

		$stub->set_args( array( 'foo' => 'bar' ) );
		$this->assertCount( 1, $stub->get_args() );
		$this->assertEqualSets( array( 'foo' => 'bar' ), $stub->get_args() );
	}

	public function testGetSetArgsPopulatedDefaults() {
		$stub = $this->getMockForAbstractClass( 'Gamajo_Post_Type' );
		$stub->expects( $this->any())
			 ->method( 'default_args' )
			 ->will( $this->returnValue( array( 'baz' => 'x' ) ) );

		$stub->set_args( array() );
		$this->assertCount( 1, $stub->get_args() );
		$this->assertEqualSets( array( 'baz' => 'x' ), $stub->get_args() );

		$stub->set_args( array( 'foo' ) );
		$this->assertCount( 2, $stub->get_args() );
		$this->assertEqualSets( array( 'foo', 'baz' => 'x' ), $stub->get_args() );

		$stub->set_args( array( 'foo' => 'bar' ) );
		$this->assertCount( 2, $stub->get_args() );
		$this->assertEqualSets( array( 'foo' => 'bar', 'baz' => 'x' ), $stub->get_args() );

		$stub->set_args( array( 'baz' => 'y' ) );
		$this->assertCount( 1, $stub->get_args() );
		$this->assertEqualSets( array( 'baz' => 'y' ), $stub->get_args() );
	}

}
