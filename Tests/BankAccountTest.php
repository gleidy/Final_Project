<?php

/**
 * @author Greg
 * Bank Account Class test cases
 */

require_once ('../app/BankAccount.php');
require_once ('../SimpleTest/autorun.php');

class TestCaseBankAccount extends UnitTestCase{

	private $account;

	/**
	 * Setup()
	 */
	public function setUp(){
		$this->account = new BankAccount;
	}
	/**
	 * Tear Down
	 */
	public function tearDown(){
		$this->account = NULL;
	}

	/**
	 * Test setBalance() method
	 */
	public function testsetBalance(){

		$this->account->setBalance(4);
		$this->assertEqual(4, $this->account->getBalance());

		$this->account->setBalance(-4);
		$this->assertEqual(0, $this->account->getBalance());

		$this->account->setBalance(10);
		$this->account->setBalance('a');
		$this->assertEqual(10, $this->account->getBalance());

	}

	/**
	 * Test of getBalance method
	 */
	public function testgetBalance(){
		$this->account->setBalance(4);
		$balance = $this->account->getBalance();
		$this->assertEqual(4, $balance);

	}
	/**
	 * Test of withdraw() method
	 */
	public function testwithdraw(){
		$this->account->setBalance(10);
		$balance = $this->account->withdraw(5);
		$this->assertEqual(5, $balance);

		$this->account->setBalance(10);
		$balance = $this->account->withdraw(15);
		$this->assertEqual(false, $balance);

		$this->account->setBalance(10);
		$balance = $this->account->withdraw('a');
		$this->assertEqual(false, $balance);

		$this->account->setBalance(100);
		$balance = $this->account->withdraw(50);
		$balance = $this->account->withdraw(10);
		$balance = $this->account->withdraw(20);
		$this->assertEqual(20, $balance);

	}

	/**
	 * Test of deposit() method
	 */
	public function testdeposit(){
		$this->account->setBalance(10);
		$this->account->deposit(10);
		$balance = $this->account->getBalance();
		$this->assertEqual(20, $balance);

		$this->account->setBalance(50);
		$this->account->deposit(10);
		$this->account->deposit(5);
		$this->account->deposit(15);
		$this->assertEqual(80, $this->account->getBalance());
	}
}

?>