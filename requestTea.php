<?php
	require_once('Session.php');
	if (PupSession::getUserType() != 'C')
	{
		echo 'fail';
		exit();
	}
	
	$requestMessage = $_POST['requestMessage'];
	$to = 'adm.decker@gmail.com';
	$subject = 'Tea Order';
	$orderer = PupSession::getUsername();
	$message = "<p>$orderer has requested a tea.</p><p>Request:</p><p>$requestMessage</p>";
	$headers = "From: orders@t.pupperino.net";
	
	mail($to, $subject, $message, $headers);


?>
