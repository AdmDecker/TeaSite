<?php
  PupSession::Validate():
  if (PupSession::getUserType() != 'A') {
    exit();
  }
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
            //Save the server's response in a variable
            let response = xmlhttp.responseText;
            //We don't care about these states, so ignore them
            if (!(xmlhttp.readyState==4) && !(xmlhttp.status==200))
                return;
        }
        function giveTea(userID)
        {
            let action = '/givetea.php';
            xmlhttp = new XMLHttpRequest();
            let amount = document.getElementById('input' + userID).value;
            //Open our http request as POST with our action variable
            xmlhttp.open("POST", action, true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.onreadystatechange = stateChange;
            xmlhttp.send('userID=' + userID + '&' + 'amount=' + amount);
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
        <div class='table' style='text-align: center'>
            <div>
                <span><b>userID</b></span>
                <span><b>Name</b></span>
                <span><b>ResetPassword</b></span>
                <span><b>Role</b></span>
                <span><b>Email</b></span>
                <span><b>Button</b></span>
            </div>
            <?php
                foreach($data as $key=>$user)
                {
                    $userID = $user['userID']
                    $name = $user['username'];
                    $email = $user['email'];
                    echo "
                        <div>
                            <span>$userID</span>
                            <span><input class='w3-input w3-border table-button' type='text' id='username$userID' value='$name' /></span>
                            <span height='25' ><button class='w3-button w3-blue table-button' onclick='resetPassword($userID)'>Reset Password</button></span>
                            <span height='25' ><button class='w3-button w3-blue table-button' onclick='giveTea($userID)'>Set Teas</button></span>
                        </div>
                        ";
                }
            ?>
        </div>
        <div><button class="w3-button login-input center w3-blue" style="margin-top: 50px;" onclick="window.location.href='/login.html'">Logout</button></div>
    </body>
</html>
