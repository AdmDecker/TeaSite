<?php
    require "Session.php";
    PupSession::LoadSession();
    PupSession::Validate();
    $teas = PupSession::getTeas();
    $canOrder = PupSession::canOrder();
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
                window.location = '/teaOrdered.html';
            }
        </script>
    </head>
    <body>
        <div class='center' style="text-align: center">
            <h2 class='center'>Welcome <?php echo PupSession::getUsername(); ?></h2>
            <p class='center'>You have <?php echo $teas; ?> teas</p>
            <?php
                if (PupSession::canOrder()) {
                    echo "<button class='login-input center' id='requestTea' onclick='requestTea()'>Order Tea</button>";
                }
                else {
                    echo "<button class='w3-button w3-disabled'>Order Tea</button>";
                    echo "<p>You may only order once every 15 minutes</p>";
                }
            ?>
        </div>
    </body>
</html>
