<?php
    require_once('dbaccess.php');
    require_once('Session.php');
    require_once('PupError.php');

    $POST = json_decode(file_get_contents('php://input'), true);

    $userID = $POST['userID'];
    $amount = $POST['amount'];
    $form = $POST['form'];
    $e = new PupError($form);
    
    if (PupSession::getUserType(PupSession::getUserID()) != 'M')
    {
        exit( $e->Error('Your session has expired. Please log in again') );
    }

    $db = new dbAccess();
    $username = '';
    try {
        $username = $db->getUsername($userID);
        $db->setUserTeas($userID, $amount);
    }
    catch(PDOException $ex) {
        exit( $e->Error('Database error: '.$ex->getMessage()) );
    }
        
    echo $e->Success("Successfully set teas for $username to $amount");
?>
