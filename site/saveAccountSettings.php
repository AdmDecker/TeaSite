<?php
    require_once('Session.php');
    require_once('dbaccess.php');

    PupSession::Validate();
    $section = $_POST['form'];
    $db = new dbAccess();
    $username = PupSession::getUsername();
    $userID = PupSession::getUserID();

    echo $section;

    if ($section == 'password')
    {
        $newPass = $_POST['newPass'];
        $oldPass = $_POST['oldPass'];

        //Check old password is match
        //Fetch password for user from DB
        $passwd_inDB = $db->getPassword($username);

        if (is_null($passwd_inDB) || !password_verify($oldPass, $passwd_inDB)) {
            echo 'password error: Old password is incorrect';
            exit();
        }

        $db->setPassword($userID, $newPass);
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
    }
    else if ($section == 'username')
    {
        $newUsername = $_POST['newUsername'];
        $password = $_POST['password'];
        
        //Check old password is match
        //Fetch password for user from DB
        $passwd_inDB = $db->getPassword($username);

        if (is_null($passwd_inDB) || !password_verify($oldPass, $passwd_inDB)) {
            echo 'username error: password is incorrect';
            exit();
        }

        PupSession::setUsername($newUsername);
    }

    echo 'success';
    exit();
?>
