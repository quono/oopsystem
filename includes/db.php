<?php
$dbc = array(
	'host'    => 'localhost',
	'db'      => 'system',
	'user'    => 'root',
	'pass'    => '',
	'charset' => 'utf8'
);

$dsn = 'mysql:host=' . $dbc['host'] . ';dbname=' . $dbc['db'] . ';charset=' . $dbc['charset'];
$attributes = array(
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
);

try {
	$pdo = new PDO($dsn, $dbc['user'], $dbc['pass'], $attributes);
} catch (PDOException $e) {
	exit('Database connection failed: ' . $e->getMessage());
}