<!DOCTYPE html>
<?php
    // includes
    require 'Session.php';
    if (PupSession::getUserType() == 'M')
        header('/manager.php');
    else if (PupSession::getUserType() == 'C')
    {
        header('/customer.php');
    }
?>