<?php
    require_once('dbaccess.php');
    require_once('Session.php');

    if (PupSession::getUserType(PupSession::getUserID()) != 'M')
    {
        exit();
    }

    $userID = $_POST['userID'];

    $db = new dbAccess();
    $db->incrementUserTeas($userID);
    echo "$userID";
?>
