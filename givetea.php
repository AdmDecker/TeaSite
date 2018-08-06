<?php
    require_once('dbaccess.php');
    require_once('Session.php');

    if (PupSession::getUserType(PupSession::getUserID()) != 'M')
    {
        exit();
    }

    $userID = PupSession::getUserID();

    $db = new dbAccess();
    $db->incrementUserTeas($userID);
    echo "$userID";
?>
