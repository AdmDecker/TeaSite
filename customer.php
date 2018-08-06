<?php
    require "Session.php";
    PupSession::LoadSession();
    $teas = PupSession::getTeas();
?>

<!DOCTYPE html>
<html>
    <head>
        <link href="w3.css" rel="stylesheet" type="text/css">
        <link href="style.css" rel="stylesheet" type="text/css">
    </head>
    <style
    <body>
        <h2>Welcome <?php echo PupSession::getUsername() ?>,</h2>
        <p>You have <?php echo $teas ?> teas</p>
    </body>
</html>
