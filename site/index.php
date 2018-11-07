<?php
    // includes
    require_once('Session.php');
    require_once('dbUser.php');

    trigger_error('cooking login');
    //Check for cookie
    if (isset($_COOKIE['loginCookie']) && PupSession::getUserType() === 'U')
    {
        trigger_error($_COOKIE['loginCookie']);
        $db = new dbUser();
        $userID = $db->getUserByCookie($_COOKIE['loginCookie']);
        trigger_error('userID: '.$userID);
        if ($userID != NULL)
        {
            trigger_error('logging in user by cookie');
            PupSession::Login($userID, FALSE);
        }
    }

    $userType = PupSession::getUserType();
    
    if ($userType === 'M')
        header('Location: /manager.php');
    else if ($userType === 'C')
    {
        header('Location: /customer.php');
    }
    else
    {
        header('Location: /login.html');
    }
?>