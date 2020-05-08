<?php
session_start();

require 'includes/Client.class.php';
require 'includes/User.class.php';
require 'includes/Files.class.php';

$client = new Client();
if (!$client->isLogged()) if ($client->isLogged()) $client->redirect('index.php');

if (isset($_GET['logout'])) {
	$client->logout();
	$client->redirect('index.php');
}

require 'includes/db.php';
$files = new Files($pdo, $_SESSION['userid']);

if (!isset($_SESSION['filesData'])) $_SESSION['filesData'] = $files->fetch();

$htmlFileContent = '';

if (isset($_GET['open'])) {
	
	if (in_array($_GET['open'], array_column($_SESSION['filesData'], 'id'))) {	
		$file = $_SESSION['filesData'][array_search($_GET['open'], array_column($_SESSION['filesData'], 'id'))];
		$htmlFileContent .= '<hr>';
		$htmlFileContent .= '<p><b>' . $file['name'] . '.txt</b></p>';
		$htmlFileContent .= nl2br($file['text']);
	} else {
		$htmlFileContent = 'File doesn\'t exist on your system';
	}
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delId'])) {
	if (in_array($_POST['delId'], array_column($_SESSION['filesData'], 'id'))) {
		$files->remove($_POST['delId']);
		$_SESSION['filesData'] = null;
		$_SESSION['message'] = 'File has been removed successfully';
		$client->redirect($_SERVER['PHP_SELF']);
	}
}


$htmlFiles = '';

foreach($_SESSION['filesData'] as $file) {
	$htmlFiles .= '<form action method="post">';
	$htmlFiles .= '<p><span style="margin-right:15px;"><input type="submit" name="delete" value="Remove"></span>';
	$htmlFiles .= '<a href="?' . 'open=' . $file['id'] . '">' . $file['name'] . '.txt</a></p>';
	$htmlFiles .= '<input type="hidden" name="delId" value="' . $file['id'] . '">';
	$htmlFiles .= '</form>';
}

if (empty($htmlFiles)) $htmlFiles = '<i>You don\'t have any files yet</i>';


?>

<?php require 'layout/header.html' ?>

<h1>System - manage your files</h1>

<?php 

echo 'Logged as: ' . $_SESSION['nick'];
if (isset($_SESSION['message'])) {
	echo '<p>' . $_SESSION['message'] . '</p>';
	$_SESSION['message'] = null;
}

?>

<p>
	<a href="add.php">Add new file</a>
</p>
My files:
<br>
<?=$htmlFiles?>

<p>
	<a href="?logout">Log out</a>
</p>

<?=$htmlFileContent?>

<?php require 'layout/footer.html'; ?>