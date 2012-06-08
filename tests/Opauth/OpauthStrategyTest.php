<?php
/**
 * OpauthStrategyTest
 *
 * @copyright    Copyright © 2012 U-Zyn Chua (http://uzyn.com)
 * @link         http://opauth.org
 * @package      Opauth.OpauthStrategyTest
 * @license      MIT License
 */

require './lib/Opauth/OpauthStrategy.php';
//require './tests/Opauth/OpauthTest.php';

/**
 * OpauthTest class
 */
class OpauthStrategyTest extends PHPUnit_Framework_TestCase{
	
	public function testHash(){
		$input = 'random string';
		$timestamp = date('c');
		$iteration = 250;
		$salt = 'sodium chrloride';
		$control = OpauthStrategy::hash($input, $timestamp, $iteration, $salt);
		$this->assertFalse(empty($control));
		
		// Ensure iteration is taken into account and producing different hash
		$diffIteration = OpauthStrategy::hash($input, $timestamp, 888, $salt);
		$this->assertFalse(empty($diffIteration));
		$this->assertFalse($diffIteration == $control);
		
		$diffIteration2 = OpauthStrategy::hash($input, $timestamp, 99999, $salt);
		$this->assertFalse(empty($diffIteration2));
		$this->assertFalse($diffIteration2 == $control);
		$this->assertFalse($diffIteration2 == $diffIteration);
		
		$diffIteration3 = OpauthStrategy::hash($input, $timestamp, 0, $salt);
		$this->assertFalse($diffIteration3);
		
		// Ensure salt is taken into account and producing different hash
		$diffSalt = OpauthStrategy::hash($input, $timestamp, $iteration, 'a98woj34 89789&SFDIU(@&*#(*@$');
		$this->assertFalse(empty($diffSalt));
		$this->assertFalse($diffSalt == $control);
		
		$diffSalt2 = OpauthStrategy::hash($input, $timestamp, $iteration, null);
		$this->assertFalse(empty($diffSalt2));
		$this->assertFalse($diffSalt2 == $control);
		$this->assertFalse($diffSalt2 == $diffSalt);
	}
	
}
