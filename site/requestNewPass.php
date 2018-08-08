<?php
    require_once('Session.php');
    require_once('dbaccess.php');

    PupSession::Validate();
    $newPass = $_POST['newPass'];
    $oldPass = $_POST['oldPass'];
    $username = PupSession::getUsername();
    $userID = PupSession::getUserID();
    $db = new dbAccess();

    //Check old password is match
    //Fetch password for user from DB
    $passwd_inDB = $db->getPassword($userID);

    if (is_null($passwd_inDB) || !password_verify($oldPass, $passwd_inDB))
    {
        echo 'Old password is incorrect';
        exit();
    }

    $db->setPassword($userID, $newPass);

    echo 'success';
    exit();
?>