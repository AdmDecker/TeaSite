<?php 
    require_once('Session.php');
    PupSession::Validate();
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
                    document.getElementById('passwordRequestError').innerText = 'Password change successful'
                else
                    document.getElementById('passwordRequestError').innerText = htmlhttp.responseText;
                    
            }

            function submitPasswordRequest() {
                let action = '/requestNewPass.php';
                let oldPass = 'oldPass=' + document.getElementById('oldPass').value;
                let newPass = 'newPass=' + document.getElementById('newPass').value;
                xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = stateChange;
                //Open our http request as POST with our action variable
                xmlhttp.open("POST", action, true);
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlhttp.send(oldPass + '&' + newPass);
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
        
        <div>
            <h3 style='margin-bottom: 0'>Password</h3>
            <hr width="80%" style='margin-top: 0'><br />
            <input class='w3-input' type='password' placeholder='Old Password' id='oldPass' /><br /><br />
            <input class='w3-input' type='password' placeholder='New Password' id='newPass' /><br /><br />
            <button class='w3-button w3-blue' onclick='submitPasswordRequest()'>Set Password</button><br /><br />
            <label id="passwordRequestError"></label>
        </div>
    </body>
</html>