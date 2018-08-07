<?php
    require_once('dbaccess.php');
    require_once('Session.php');

    if (PupSession::getUserType(PupSession::getUserID()) != 'M')
    {
        exit();
    }

    $userID = $_POST['userID'];
    $amount = $_POST['amount'];    

    $db = new dbAccess();
    $db->setUserTeas($userID, $amount);
    echo "$userID";
?>
