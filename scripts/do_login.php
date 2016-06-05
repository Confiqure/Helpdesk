<?php
session_start();
$success = false;
require_once('../dbconfig.php');
try {
	$dbh = new PDO($driver, $user, $pass, $attr);
	$stmt = $dbh->prepare('SELECT * FROM `users` WHERE `username` = :username AND `password` = :password');
	$stmt->bindParam(':username', $_POST['username'], PDO::PARAM_STR);
	$stmt->bindParam(':password', $_POST['password'], PDO::PARAM_STR);
	$stmt->execute();
	while ($row = $stmt->fetch()) {
		$success = true;
		break;
	}
	if ($success) {
		$charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		$count = strlen($charset) - 1;
		$length = 10;
		while ($length--) $token .= $charset[mt_rand(0, $count)];
		$stmt = $dbh->prepare('UPDATE `users` SET `token` = "' .  $token . '" WHERE `username` = :username');
		$stmt->bindParam(':username', $_POST['username'], PDO::PARAM_STR);
		$stmt->execute();
		$_SESSION['token'] = $token;
		header('Location: http://www.bownhs.org/helpdesk/');
	} else {
		header('Location: http://www.bownhs.org/helpdesk/login.php?username=' . $_POST['username']);
	}
	unset($stmt);
	unset($dbh);
} catch (Exception $e) {
	$recipient = "dwheelerw@gmail.com";
	$subject = "ERROR - SQL Connection";
	$mail_body = "An exception occurred on the helpdesk log-in page: " . $e->getMessage();
	mail($recipient, $subject, $mail_body);
	die('Feature currently unavailable.');
}
?>