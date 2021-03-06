<?php
	require_once('Session.php');
	require_once('PupError.php');
	require_once('Notification.php');
	require_once('dbaccess.php');
	require_once('TranHistoryLogger.php');

	PupSession::Validate();

	$POST = json_decode(file_get_contents('php://input'), true);

	$e = new PupError($POST['form']);

	if(!PupSession::canOrder())
	{
		exit( $e->Error('You can\'t order right now! Please wait 15 minutes before ordering again.') );
	}
	
	$db = new dbAccess();
	$storeUserID = $db->getUserID('Amber');
	
	PupSession::OrderTea();
	
	$requestMessage = filter_var(trim($POST['requestMessage']), FILTER_SANITIZE_STRING);
	$message = "<html><p>Request Message:</p><p>$requestMessage</p></html>";
	
	$itemOrdered = 'Tea';
	$orderer = filter_var(PupSession::getUsername(), FILTER_SANITIZE_STRING);
	$subject = "$itemOrdered order From $orderer";
	
	Notification::sendNotification($storeUserID, $subject, $message);

	Notification::sendNotification(PupSession::getUserID(), 
		'Tea Ordered', 'A tea has been ordered from your account.');

	$teas = PupSession::getTeas();
	$userID = PupSession::getUserID();
	TranHistoryLogger::logTransaction($userID, "ORDERED 1 TEA", $teas);

	echo $e->Success('Successfully ordered a tea!');
?>
