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
        <script type="text/javascript">
            function stateChange()
            {
                //We don't care about these states, so ignore them
                if (xmlhttp.readyState==4 || xmlhttp.status==200)
                    return;
                
                let response = xmlhttp.responseText;
                let messageTarget;

                if(response.includes('notification'))
                    messageTarget = document.getElementById('notificationError');
                else if(response.includes('password'))
                    messageTarget = document.getElementById('passwordRequestError');
                else if(response.includes('username'))
                    messageTarget = document.getElementById('usernameRequestError'); 
                else
                    console.log('Error: No messageTarget');

                if (xmlhttp.responseText.includes('success'))
                    messageTarget.innerHTML = 'Saved changes successfully!';
                else if (response.includes('failure'))
                    messageTarget.innerHTML = 'Server error - please contact Adam with this message: ' + response;
                else
                    messageTarget.innerHTML = response;
                console.log('RX: ' + response);
            }

            function submitForm(formSection) {
                let action = '/saveAccountSettings.php';
                let submitData = 'form=' + formSection;
                
                if (formSection === 'password') {
                    let oldPass = 'oldPass=' + document.getElementById('oldPass').value;
                    let newPass = 'newPass=' + document.getElementById('newPass').value;
                    submitData += '&' + oldPass + '&' + newPass;
                    document.getElementById("passwordRequestError").innerHTML = "Saving password settings...";
                }
                else if (formSection === 'notification') {
                    let email = 'email=' + document.getElementById('email');
                    submitData += '&' + email;
                    document.getElementById("notificationError").innerHTML = "Saving notification settings...";
                }
                else if (formSection === 'username') {
                    let newUsername = 'newUsername=' + document.getElementById('newUsername');
                    let password = 'password=' + document.getElementById('password');
                    submitData += '&' + newUsername + '&' + password;
                    document.getElementById('usernameRequestError').innerHTML = 'Saving username settings...';
                }
                else return;
                
                xmlhttp = new XMLHttpRequest();
                //Open our http request as POST with our action variable
                xmlhttp.open("POST", action, true);
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                xmlhttp.onreadystatechange = stateChange;
                xmlhttp.send(submitData);
            }
            
            function saveNotification() {
                submitForm('notification');
            }
            
            function savePassword() {
                submitForm('password');
            }

            function saveUsername() {
                submitForm('username');
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
        <h2 class='center'>Account Settings for <?php echo PupSession::getUsername(); ?></h2><br />
        <div>
            <h3 style='margin-bottom: 0'>Username</h3>
            <hr width="80%" style='margin-top: 0'><br />
            <input class='w3-input' type='text' placeholder='New Username' id='newUsername' /><br /><br />
            <input class='w3-input' type='password' placeholder='Password' id='password' /><br /><br />
            <button class='w3-button w3-blue' onclick='saveUsername()'>Set Username</button><br /><br />
            <div id="usernameRequestError"></div>
        </div>
        <br /><br />
        <div>
            <h3 style='margin-bottom: 0'>Password</h3>
            <hr width="80%" style='margin-top: 0'><br />
            <input class='w3-input' type='password' placeholder='Old Password' id='oldPass' /><br /><br />
            <input class='w3-input' type='password' placeholder='New Password' id='newPass' /><br /><br />
            <button class='w3-button w3-blue' onclick='savePassword()'>Set Password</button><br /><br />
            <div id="passwordRequestError"></div>
        </div>
        <br /><br />
        <div>
            <h3 style='margin-bottom: 0'>Notifications</h3>
            <hr width="80%" style='margin-top: 0'><br />
            <input class='w3-input' type='email' placeholder='Email Address' id='email' /><br />
            <input class='w3-check' type='checkbox' /><label>Enable Notifications</label><br /><br />
            <button class='w3-button w3-blue' onclick='saveNotification()'>Save Notification Settings</button><br /><br />
            <div id="notificationError"></div>
        </div>
        <br /><br />
        <button onclick="window.location = '/index.php'">Back</button>
    </body>
</html>
<?php exit() ?>
