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
        <script src='common.js'></script>
        <script type="text/javascript">
            function submitForm(form) {
                const action = '/saveAccountSettings.php';
                
                let dataObject = {};
                
                if (form === 'password') {
                    dataObject = {
                        'oldPass': getInputValue('oldPass'),
                        'newPass': getInputValue('newPass'),
                    }
                    displayError( form, 'Saving password settings...' );
                }
                else if (form === 'notification') {
                    dataObject = {
                        'email': getInputValue('email'),
                        'emailEnabled': getCheckboxValue('emailEnabled'),
                    }
                    displayError( form, 'Saving notification settings...' );
                }
                else if (form === 'username') {
                    dataObject = {
                        'newUsername': getInputValue('newUsername'),
                        'password': getInputValue('password'),
                    }
                    displayError( form, 'Saving username settings...' );
                }
                else return;
                
                const callBack = function (message) {
                    displayError( form, message );
                };
                
                asyncSend(
                    action,
                    form,
                    dataObject,
                    callBack,
                    callBack
                )
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
            <div id="usernameError"></div>
        </div>
        <br /><br />
        <div>
            <h3 style='margin-bottom: 0'>Password</h3>
            <hr width="80%" style='margin-top: 0'><br />
            <input class='w3-input' type='password' placeholder='Old Password' id='oldPass' /><br /><br />
            <input class='w3-input' type='password' placeholder='New Password' id='newPass' /><br /><br />
            <button class='w3-button w3-blue' onclick='savePassword()'>Set Password</button><br /><br />
            <div id="passwordError"></div>
        </div>
        <br /><br />
        <div>
            <h3 style='margin-bottom: 0'>Notifications</h3>
            <hr width="80%" style='margin-top: 0'><br />
            <input class='w3-input' type='email' placeholder='Email Address' id='email' value=
                   <?php echo '\''.PupSession::getEmail().'\''; ?>
            /><br />
            <input id='emailEnabled' class='w3-check' type='checkbox'
                   <?php
                       if (PupSession::getEmailEnabled())
                           echo 'checked';
                   ?>
            /><label>Enable Notifications</label><br /><br />
            <button class='w3-button w3-blue' onclick='saveNotification()'>Save Notification Settings</button><br /><br />
            <div id="notificationError"></div>
        </div>
        <br /><br />
        <button class='w3-button w3-red' onclick="window.location = '/index.php'">Back</button>

        <br /><br /><br /><br />
    </body>
</html>
<?php exit() ?>
