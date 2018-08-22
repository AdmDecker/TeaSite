<?php
	require_once('Session.php');
	require_once('PupError.php');

	PupSession::Validate();

	$POST = json_decode(file_get_contents('php://input'), true);

	$e = new PupError($POST['form']);

	if(!PupSession::canOrder())
	{
		echo $e->Error('You can\'t order right now! Please wait 15 minutes before ordering again.');
		exit();
	}
	
	
	$storeEmail = 'Pupperteas@gmail.com';
	$itemOrdered = 'Tea';

	PupSession::OrderTea();
	
	$requestMessage = filter_var(trim($POST['requestMessage']), FILTER_SANITIZE_STRING);
	
	$orderer = filter_var(PupSession::getUsername(), FILTER_SANITIZE_STRING);
	$subject = "$itemordered Order From $orderer";
	
	$message = "<html><p>Request Message:</p><p>$requestMessage</p></html>";
	$headers = "From: orders@t.pupperino.net\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	
	mail($storeEmail, $subject, $message, $headers);

	echo $e->Success('Successfully ordered a tea!');
?>
