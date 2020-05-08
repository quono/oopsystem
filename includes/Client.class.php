<?php

class Client {
	
	public function isLogged() {
		if (isset($_SESSION['userid']) && isset($_SESSION['nick'])) return true;
		else return false;
	}
	
	public function setAsLogged($id, $nick) {
		$_SESSION['nick'] = $nick;
		$_SESSION['userid'] = $id;
	}
	
	public function logout() {
		$_SESSION['nick'] = null;
		$_SESSION['userid'] = null;
	}
	
	public function redirect($target) {
		header('Location: ' . $target);
		exit;
	}
	
}