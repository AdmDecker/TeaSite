<?php
    require "Session.php";
    PupSession::LoadSession();
    $teas = PupSession::getTeas();
?>

<!DOCTYPE html>
<html>
    <body>
        <p>You have <?php echo $teas ?> teas</p>
    </body>
</html>
