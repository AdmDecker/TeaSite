<?php
    require_once('dbaccess.php');
    require_once('Session.php');
    require_once('PupError.php');

    $e = new PupError('giveTea');

    if (PupSession::getUserType(PupSession::getUserID()) != 'M')
    {
        exit();
    }
    
    $POST = json_decode(file_get_contents('php://input'), true);

    $userID = $POST['userID'];
    $amount = $POST['amount'];    

    $db = new dbAccess();
    $db->setUserTeas($userID, $amount);
    echo $e->Success('$userID');
?>
