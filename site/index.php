<?php
    // includes
    require 'Session.php';
    $userType = $PupSession::getUserType();
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