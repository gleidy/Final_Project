<?php

require_once ('../app/Validation.php');
require_once ('../SimpleTest/autorun.php');

class TestValidationClass extends UnitTestCase{

	private $validation;

	public function setUp(){
		$this->validation = new Validation;
	}

	/*
	 * Test validity of email in validation class
	 */
	public function TestisEmailValid(){
		$this->assertEqual(true,$this->validation->isEmailValid('bob@hotmail.com'));
		$this->assertEqual(false,$this->validation->isEmailValid('bob'));
		$this->assertEqual(false,$this->validation->isEmailValid(11000));
	}

	/*
	 * Tests validity of nnumbers ensureing in a certain range and not alpha chars
	 */
	public function TestisNumberInRangeValid(){
		$this->assertEqual(true,$this->validation->isNumberInRangeValid(5,2,7));
		$this->assertEqual(false,$this->validation->isNumberInRangeValid(1,2,7));
		$this->assertEqual(false,$this->validation->isNumberInRangeValid('a',2,'c'));
	}

	/*
	 * Tests that a string is not over a certain length
	 */
	public function TestisLengthStringValid(){
		$this->assertEqual(true, $this->validation->isLengthStringValid('test',10));
		$this->assertEqual(false, $this->validation->isLengthStringValid('testtesttest',10));
	}


	public function tearDown(){
		$this->validation = NULL;
	}

}

?>