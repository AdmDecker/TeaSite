<?php
    require_once('Session.php');
    require_once('dbaccess.php');

    PupSession::Validate();
    $section = $_POST['form'];
    $db = new dbAccess();
    $username = PupSession::getUsername();
    $userID = PupSession::getUserID();

    if ($section == 'password')
    {
        $newPass = $_POST['newPass'];
        $oldPass = $_POST['oldPass'];

        //Check old password is match
        //Fetch password for user from DB
        $passwd_inDB = $db->getPassword($username);

        if (is_null($passwd_inDB) || !password_verify($oldPass, $passwd_inDB)) {
            echo 'Old password is incorrect';
            exit();
        }

        $db->setPassword($userID, $newPass);
        echo 'password';
    }
    else if ($section == 'notification')
    {
        $email = $_POST['email'];
        try {
            $db->setEmailAddress($userID);
        } 
        catch(Exception $e) { 
            echo 'notification error: '.$e->getMessage();
            exit();
        }
        echo 'notification';
    }

    echo 'success';
    exit();
?>
