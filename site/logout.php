<?php
    require_once('Session.php');

    PupSession::Logout();
    header('Location: /index.php');
?>
