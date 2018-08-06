<?php
    require "Session.php";
    PupSession::LoadSession();
    $teas = PupSession::getTeas();
?>

<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width" />
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
<html>
    <head>
        <link href="w3.css" rel="stylesheet" type="text/css">
        <link href="style.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <h2>Welcome <?php echo PupSession::getUsername() ?>,</h2>
        <p>You have <?php echo $teas ?> teas</p>
        <button id='requestTea' onclick="requestTea()">Order Tea</button>
    </body>
</html>
