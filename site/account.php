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
                    window.location = '/teaOrdered.html';
                else if(xmlhttp.responseText.includes('fail'))
                    window.location = '/orderFailed.html';
                    
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
                <li class="rides-r-us"><a href="account.php"><b>Account</b></a></li>
            </ul>
            <hr width="100%">
        </header>
        
        <div>
            <h3>Password</h3>
            <hr width="80%">
            <input type='text' placeholder='Old Password' id='oldPass' />
            <input type='text' placeholder='New Password' id='newPass' />
            <button class='w3-button w3-blue' onclick='submitPasswordRequest()'>Set Password</button>
            <label id="passwordRequestError"></label>
        </div>
    </body>
</html>