<?php

class Files {
	
	private $pdo;
	private $user;
	private $sql;
	
	public function __construct(\PDO $pdo, $id) {
		$this->pdo = $pdo;
		$this->id = $id;
	}
	
	public function fetch(string $file = '') {
		
		if ($file === '') $this->sql = 'SELECT * FROM files WHERE userid = :userid';
		else $this->sql = 'SELECT * FROM files WHERE userid = :userid AND id = :id';
		
		try {
			$stmt = $this->pdo->prepare($this->sql);
			$stmt->bindValue('userid', $this->id);
			if ($file !== '') $stmt->bindValue(':id', $file);
			$stmt->execute();
			
			return $stmt->fetchAll();
			
		} catch (PDOException $e) {
			$err = 'Database connection failed while fetching files - ' . $e->getMessage();
		}
		
	}
	
	public function add($title, $text) {
		
		$this->sql = 'INSERT INTO files VALUES (:id, :userid, :title, :text)';
		
		try {
			$stmt = $this->pdo->prepare($this->sql);
			$stmt->bindValue(':id', rand(10000001,99999999) . rand(10000001,99999999));
			$stmt->bindValue(':userid', $this->id);
			$stmt->bindValue(':title', $title);
			$stmt->bindValue(':text', $text);
			$stmt->execute();
			
		} catch (PDOException $e) {
			$err = 'Database connection failed while fetching files - ' . $e->getMessage();
		}
	}
		
	public function remove($id) {
		$this->sql = 'DELETE FROM files WHERE id = :id';
		
		try {
			$stmt = $this->pdo->prepare($this->sql);
			$stmt->bindValue(':id', $id);
			$stmt->execute();
		} catch (PDOException $e) {
			$err = 'Database connection failed while removing a file - ' . $e->getMessage();
		}
	}
}
