<?php
    require 'dbAccess.php';
    require 'Session.php';

    if (PupSession::getUserType(PupSession::getUserID()) != 'M')
    {
        exit();
    }

    $userID = $_POST['userID'];

    $db = new dbAccess();
    $db->incrementUserTeas($userID);
    echo "$userID";
?>