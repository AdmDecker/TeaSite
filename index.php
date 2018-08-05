<!DOCTYPE html>
<?php
    // includes
    require 'Session.php';
    if (PupSession::getUserType() == 'M')
        header('Location: /manager.php');
    else if (PupSession::getUserType() == 'C')
    {
        header('Location: /customer.php');
    }
?>