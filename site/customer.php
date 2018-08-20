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
            function stateChange()
            {
                //We don't care about these states, so ignore them
                if (!(xmlhttp.readyState==4) && !(xmlhttp.status==200))
                    return;
                
                if (xmlhttp.responseText.includes('success'))
                    window.location = '/teaOrdered.html';
                else if(xmlhttp.responseText.includes('fail'))
                    window.location = '/orderFailed.html';
                    
            }

            function requestTea() {
                let action = '/requestTea.php';
                let message = document.getElementById('orderMessage').value;
                xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = stateChange;
                //Open our http request as POST with our action variable
                xmlhttp.open("POST", action, true);
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlhttp.send('requestMessage=' + message);
            }
        </script>
    </head>
    <body>
        <header class="main-header">
            <ul class="nav-list">
                <li class="rides-r-us"><a href="index.php"><b>Tea</b></a></li>
                <li><a href="account.php"><b>Account</b></a></li>
            </ul>
            <hr width="100%">
        </header>
        <div class='center' style="text-align: center">
            <h2 class='center'>Welcome <?php echo PupSession::getUsername(); ?></h2>
            <p class='center'>You have <?php echo $teas; ?> teas</p>
            <?php
                if (PupSession::canOrder()) {
                    echo "<input type='text' id='orderMessage' class='w3-input center login-input' placeholder='Order Message' /><br/><br/>";
                    echo "<button class='w3-button login-input center w3-blue' id='requestTea' onclick='requestTea()'>Order Tea</button>";
                }
                else {
                    echo "<button class='w3-button w3-blue w3-disabled login-input'>Order Tea</button>";
                    echo "<p>You may only order once every 15 minutes</p>";
                }
            ?>
            <br /><br />
            <h3 class='center'>Gift Teas</h3>
            <span class='login-input center'>
                <input type='text' id='giftRecipient' class='w3-input' style='width: 80%' placeholder='Gift Recipient' /><br />
                <input type='number' id='giftAmount' class='w3-input' value='0' min='0' style='width: 20%'/><br />
            </span>
            <button class='w3-button login-input center w3-blue' onclick='giftTeas()'>Gift Teas</button><br />
            <label id='giftError'></label>
            
            <div><button class="w3-button login-input center w3-blue" style="margin-top: 50px;" onclick="window.location='/logout.php'">Logout</button></div>
        </div>
    </body>
</html>
