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
                if (!(xmlhttp.readyState==4) && !(xmlhttp.status==200))
                    return;
                
                if (xmlhttp.responseText.includes('success'))
                    document.getElementById('passwordRequestError').innerHTML = 'Password change successful';
                else if(xmlhttp.responseText.includes('notification'))
                    document.getElementById('notificationError').innerHTML = xmlhttp.responseText;
                else if(xmlhttp.responseText.includes('password'))
                    document.getElementById('passwordRequestError').innerHTML = xmlhttp.responseText;
                    
            }

            function submitForm(formSection) {
                let action = '/saveAccountSettings.php';
                let submitData = 'form=' + formSection;
                
                if (formSection === 'password') {
                    let oldPass = 'oldPass=' + document.getElementById('oldPass').value;
                    let newPass = 'newPass=' + document.getElementById('newPass').value;
                    submitData += '&' + oldPass + '&' + newPass;
                    document.getElementById("passwordRequestError").innerHTML = "Sending password request...";
                }
                else if (formSection === 'notification') {
                    let email = 'email=' + document.getElementById('email');
                    submitData += '&' + email;
                    document.getElementById("notificationError").innerHTML = "Submitting notification settings...";
                }
                
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
            <button class='w3-button w3-blue' onclick='savePassword()'>Set Password</button><br /><br />
            <div id="passwordRequestError"></div>
        </div>
        <br /><br />
        <div>
            <h3 style='margin-bottom: 0'>Notifications</h3>
            <hr width="80%" style='margin-top: 0'><br />
            <input class='w3-input' type='email' placeholder='Email Address' id='email' /><br /><br />
            <input class='w3-check' type='checkbox' /><label>Enable Notifications</label><br /><br />
            <button class='w3-button w3-blue' onclick='saveNotification()'>Save Notification Settings</button><br /><br />
            <div id="notificationError"></div>
        </div>
    </body>
</html>
<?php exit() ?>
