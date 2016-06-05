<?php
$candidate = false;
require_once('dbconfig.php');
try {
	$dbh = new PDO($driver, $user, $pass, $attr);
	try {
		$stmt = $dbh->prepare('SELECT * FROM `live_support`');
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			switch ($row['schedule']) {
				case 'Sunday':
				case 'Monday':
				case 'Tuesday':
				case 'Wednesday':
				case 'Thursday':
				case 'Friday':
				case 'Saturday':
					$time = date('l', time());
					if ($time != $row['schedule']) continue 2;
			}
			$time = date('Gi', time() - 18000); //adjust for time zone
			if ($time >= $row['time_lower'] && $time <= $row['time_upper']) {
				$candidate = $row;
				break;
			}
		}
		unset($stmt);
		unset($dbh);
	} catch (Exception $f) {
		echo "Exception: " . $f->getMessage() . "<br />";
	}
	if ($candidate === false) echo 0;
	else echo $candidate['name'] . "\n" . $candidate['phone'];
} catch (Exception $e) {
	$recipient = "dwheelerw@gmail.com";
	$subject = "ERROR - SQL Connection";
	$mail_body = "An exception occurred on the helpdesk live page: " . $e->getMessage();
	mail($recipient, $subject, $mail_body);
	echo 0;
}
?>