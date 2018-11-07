<?php
    require_once('dbUser.php');
    require_once('Session.php');
    require_once('PupError.php');
    require_once('Notification.php');

    $POST = json_decode(file_get_contents('php://input'), true);

    $userID = $POST['userID'];
    $amount = $POST['amount'];
    $form = $POST['form'];
    $e = new PupError($form);
    
    if (PupSession::getUserType(PupSession::getUserID()) != 'M')
    {
        exit( $e->Error('Your session has expired. Please log in again') );
    }

    $oldTeas = 0;
    $db = new dbUser();
    $username = '';
    try {
        $username = $db->getUsername($userID);
        $oldTeas = $db->getUserTeas($userID);
        $db->setUserTeas($userID, $amount);
    }
    catch(PDOException $ex) {
        exit( $e->Error('Database error: '.$ex->getMessage()) );
    }

    Notification::sendNotification($userID, 'Your teas count has changed',
        "Old amount: $oldTeas <br> New amount: $amount");
        
    echo $e->Success("Successfully set teas for $username to $amount");
?>
