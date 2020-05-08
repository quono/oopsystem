<?php

session_start();

require 'includes/InputValidator.class.php';
require 'includes/Files.class.php';
require 'includes/Client.class.php';
require 'includes/User.class.php';

$client = new Client();
if (!$client->isLogged()) $client->redirect('index.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	$name = htmlspecialchars($_POST['name']);
	$content = htmlspecialchars($_POST['content']);

	$inputValidator = new InputValidator($name);
	if ($inputValidator->length(1, 50)) {
		$inputValidator = new InputValidator($content);
		if ($inputValidator->length(0, 10000)) {
			require 'includes/db.php';
			$files = new Files($pdo, $_SESSION['userid']);
			$files->add($name, $content);
			
			if (!isset($err)) {
				$_SESSION['message'] = 'File has been added successfully';
				$_SESSION['filesData'] = null;
				$client->redirect('system.php');
			}
			
		} else {
			$err = 'Your file size is too big';
		}
		
	} else {
		$err = 'File name length is not correct';
	}
}

?>

<?php require 'layout/header.html'; ?>

<h1>Add new file</h1>
<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
	<p>Name:<br><input type="text" name="name" maxlength="50"></p>
	<p>Content:<br><textarea cols="60" rows="15" name="content"></textarea></p>
	<p><input type="submit" value="Save"></p>
	<a href="system.php">Cancel</a>
</form>

<?php if (isset($err)) echo '<p>' . $err . '</p>'; ?>

<?php require 'layout/footer.html'; ?>
