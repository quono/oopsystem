<?php

class User extends Client {
	
	private $pdo;
	
	public function __construct(\PDO $pdo) {
		$this->pdo = $pdo;
	}
	
	public function login($nick, $pass) {
		try {
			$stmt = $this->pdo->prepare('SELECT * FROM users WHERE nick = :nick AND pass = :pass');
			$stmt->bindValue(':nick', $nick);
			$stmt->bindValue(':pass', $pass);
			$stmt->execute();
			
			if ($stmt->rowCount() > 0) {
				return true;
			} else {
				return false;
			}
			
		} catch (PDOException $e) {
			$err = 'Database connection failed while signing in - ' . $e->getMessage();
		}
	}
	
	public function getId($nick) {
		try {
			$stmt = $this->pdo->prepare('SELECT id FROM users WHERE nick = :nick');
			$stmt->bindValue(':nick', $nick);
			$stmt->execute();
			
			return (int)$stmt->fetchAll()[0]['id'];
			
		} catch (PDOException $e) {
			$err = 'Database connection failed while fetching id -' . $e->getMessage();
		}
	}	
}