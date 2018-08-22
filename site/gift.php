<?php
    require_once('Session.php');
    require_once('dbaccess.php');
    require_once('PupError.php');

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
    $db->setUserTeas($userID, $teas - $giftAmount);
    //Give teas to recipient
    $recipientTeas = $db->getUserTeas($recipientID);
    $db->setUserTeas($recipientID, $recipientTeas + $giftAmount);
    
    //success!
    echo $e->Success("Successfully gifted $giftAmount teas to $recipient");
?>
