<?php
    require_once('Session.php');
    require_once('dbaccess.php');
    require_once('PupError.php');
    require_once('Notification.php');
    require_once('TranHistoryLogger.php');

    $e = new PupError('gift');
    
    PupSession::Validate();
    $POST = json_decode(file_get_contents('php://input'), true);
    
    $recipient = $POST['giftRecipient'];
    $giftAmount = $POST['giftAmount'];
    $userID = PupSession::getUserID();
    $teas = PupSession::getTeas();
    
    $db = new dbAccess();
    $recipientID = $db->getUserID($recipient);
    
    if(!isset($recipientID))
    {
        echo $e->Error('Recipient username does not exist');
        exit();
    }
    else if($recipientID === $userID)
    {
        echo $e->Error('You cannot gift yourself teas! >:(');
        exit();
    }
    else if ($giftAmount > $teas)
    {
        echo $e->Error('You don\'t have enough teas to gift that many!');
        exit();
    }
    else if ($giftAmount < 1)
    {
        exit( $e->Error('You have to gift at least 1 tea!') );
    }
    
    //Take teas from gifter
    $newGifterTeas = $teas - $giftAmount;
    $db->setUserTeas($userID, $newGifterTeas);
    //Give teas to recipient
    $recipientTeas = $db->getUserTeas($recipientID);
    $newRecipientTeas = $recipientTeas + $giftAmount;
    $db->setUserTeas($recipientID, $newRecipientTeas);

    //Notify both parties
    Notification::sendNotification($userID, 'Teas gifted', 
        "$giftAmount teas have been gifted to $recipient from your account");

    TranHistoryLogger::logTransaction($userID, "GIFTED $giftAmount TEAS TO $recipient", $newGifterTeas);

    $sender = PupSession::getUsername();
    Notification::sendNotification($recipientID, 'Teas received', 
        "You have been gifted $giftAmount teas from $sender");

    TranHistoryLogger::logTransaction($userID, "RECEIVED $giftAmount TEAS FROM $sender; GIFT", $newRecipientTeas);
    
    //success!
    echo $e->Success("Successfully gifted $giftAmount teas to $recipient");
?>
