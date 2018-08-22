<?php
    require_once('Session.php');
    require_once('dbaccess.php');
    require_once('PupError.php');

    PupSession::Validate();

    $POST = json_decode(file_get_contents('php://input'), true);
    $section = $POST['form'];
    $db = new dbAccess();
    $username = PupSession::getUsername();
    $userID = PupSession::getUserID();

    $e = new PupError($section);

    if ($section === 'password')
    {
        $newPass = $POST['newPass'];
        $oldPass = $POST['oldPass'];

        //Check old password is match
        //Fetch password for user from DB
        $passwd_inDB = $db->getPassword($userID);

        if (is_null($passwd_inDB) || !password_verify($oldPass, $passwd_inDB)) { 
            exit( $e->Error('password error: Old password is incorrect') );
        }

        $db->setPassword($userID, $newPass);
    }
    else if ($section == 'notification')
    {
        $email = $POST['email'];
        try {
            $db->setEmailAddress($userID);
        } 
        catch(Exception $ex) { 
            exit( $e->Error('Database Error: '.$ex->getMessage() );
        }
    }
    else if ($section == 'username')
    {
        $newUsername = $POST['newUsername'];
        $password = $POST['password'];
        
        //Check old password is match
        //Fetch password for user from DB
        $passwd_inDB = $db->getPassword($userID);

        if (is_null($passwd_inDB) || !password_verify($password, $passwd_inDB)) {
            exit( $e->Error( 'Error: Password is incorrect' ) );
        }

        PupSession::setUsername($newUsername);
    }
    else {
        exit( $e->Error('Site failure: Invalid form submission') );
    }

    exit( $e->Success( "Successfully saved $form settings" ) );
?>
