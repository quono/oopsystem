<?php

class InputValidator {
	
	private $str;
	
	public function __construct($str) {
		$this->str = $str;
	}
	
	public function length($min, $max = 9999999) {
		if (mb_strlen($this->str) < $min || mb_strlen($this->str) > $max) return false;
		else return true;
	}
	
}