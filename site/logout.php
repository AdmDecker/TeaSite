<?php
    require_once('Session.php');

    PupSession::Destroy();
    header('Location: /index.php');
?>
