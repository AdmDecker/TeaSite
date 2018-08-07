<?php
	require_once('Session.php');
	PupSession::Validate();

	if(!PupSession::canOrder())
	{
		echo 'fail';
		exit();
	}

	PupSession::OrderTea();
	
	$requestMessage = filter_var(trim($_POST['requestMessage']), FILTER_SANITIZE_STRING);
	$to = 'adm.decker@gmail.com';
	$subject = 'Tea Order From $orderer';
	$orderer = PupSession::getUsername();
	$message = "<html><p>Request Message:</p><p>$requestMessage</p></html>";
	$headers = "From: orders@t.pupperino.net\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	
	mail($to, $subject, $message, $headers);

	echo 'success';
?>
