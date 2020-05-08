<?php

session_start();

require 'includes/Constants.class.php';
require 'includes/InputValidator.class.php';
require 'includes/Client.class.php';
require 'includes/User.class.php';
require 'includes/db.php';

$client = new Client();
if ($client->isLogged()) $client->redirect('system.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	$nick = htmlspecialchars($_POST['nick']);
	$pass = $_POST['pass'];
	
	$inputValidator = new InputValidator($nick);
	if ($inputValidator->length(3, 20)) {
		$inputValidator = new InputValidator($pass);
		if ($inputValidator->length(8)) {
			$user = new User($pdo);
			if ($user->login($nick, $pass)) {
				$client->setAsLogged($user->getId($nick), $nick);
				$client->redirect('system.php');
			}	
		}
	}
	if (!isset($err)) $err = 'Nickname or password incorrect';
}
?>


<?php require 'layout/header.html' ?>


<h1>Sign in</h1>

<form method="post" action="<?=$_SERVER['PHP_SELF']?>">

	<p>Login: <input type="text" name="nick"></p>
	<p>Password: <input type="password" name="pass"></p>
	<input type="submit" value="Submit">

</form>


<?php if (isset($err)) echo '<p>' . $err . '</p>'; 

require 'layout/footer.html';

?>

