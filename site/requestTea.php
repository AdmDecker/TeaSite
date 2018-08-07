<?php
	require_once('Session.php');
	PupSession::Validate();

	if(!PupSession::canOrder())
	{
		echo 'fail';
		exit();
	}

	PupSession::OrderTea();
	
	$requestMessage = $_POST['requestMessage'];
	$to = 'adm.decker@gmail.com';
	$subject = 'Tea Order';
	$orderer = PupSession::getUsername();
	$message = "<html><p>$orderer has requested a tea.</p><p>Request:</p><p>$requestMessage</p></html>";
	$headers = "From: orders@t.pupperino.net";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	
	mail($to, $subject, $message, $headers);

	echo 'success';
?>
