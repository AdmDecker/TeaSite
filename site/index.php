<?php
    // includes
    require_once('Session.php');
    require_once('dbaccess.php');

    //Check for cookie
    if (isset($_COOKIE['loginCookie']))
    {
        $db = new dbAccess();
        $userID = $db->getUserByCookie($_COOKIE['loginCookie'])
        if ($userID !== NULL)
        {
            PupSession::Login($userID);
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