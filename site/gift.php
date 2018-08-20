<?php
    require_once('Session.php');
    require_once('dbaccess.php');
    
    PupSession::Validate();
    
    $recipient = $_POST['giftRecipient'];
    $giftAmount = $_POST['giftAmount'];
    $userID = PupSession::getUserID();
    $teas = PupSession::getTeas();
    
    $db = new dbAccess();
    $recipientID = $db->getUserID($recipient);
    
    if(!isset($recipientID))
    {
        echo 'error: Recipient username does not exist';
        exit();
    }
    else if($recipientID === $userID)
    {
        echo 'error: You cannot gift yourself teas! >:(';
        exit();
    }
    else if ($giftAmount > $teas)
    {
        echo 'error: You don't have enough teas to gift that many!';
        exit();
    }
    
    //Take teas from gifter
    $db->setUserTeas($userID, $teas - $giftAmount);
    //Give teas to recipient
    $recipientTeas = $db->getUserTeas($recipientID);
    $db->setUserTeas($recipientID, $recipientTeas + $giftAmount);
    
    //success!
    echo "Successfully gifted $giftAmount teas to $recipient";
?>
