<?php
    require "Session.php";
    PupSession::LoadSession();
    $teas = PupSession::getTeas();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width" />
        <link href="w3.css" rel="stylesheet" type="text/css">
        <link href="style.css" rel="stylesheet" type="text/css">
        <script>
            function requestTea() {
                document.getElementById('requestTea').enabled = false;
                let action = '/requestTea.php';
                xmlhttp = new XMLHttpRequest();
                //Open our http request as POST with our action variable
                xmlhttp.open("POST", action, true);
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlhttp.send('requestMessage="My Message"');
            }
        </script>
    </head>
    <body>
        <div class='center'>
            <h2 class='center'>Welcome <?php echo PupSession::getUsername() ?></h2>
            <p class='center'>You have <?php echo $teas ?> teas</p>
            <button class='login-input center' id='requestTea' onclick="requestTea()">Order Tea</button>
        </div>
    </body>
</html>
