<?php
    require_once('Session.php');
    require_once('dbaccess.php');

    if (PupSession::getUserType() != 'M')
        header('Location: /index.php');

    //get all the user data
    $db = new dbAccess();
    $data = $db->getAllUsersByRole('C');
?>
<!DOCTYPE html>

<html>
    <head>
        <meta name="viewport" content="width=device-width" />
        <link href="w3.css" rel="stylesheet" type="text/css" />
        <link href="style.css" rel="stylesheet" type="text/css" />
        <script src='common.js'></script>
        <script>
            function giveTea(userID)
            {
                const action = '/giveTea.php';
                const form = 'giveTea';

                let dataObject = {
                    'amount': getInputValue('input' + userID),
                    'userID': userID
                }
                
                const callBack = function (message) {
                    displayError(form, message);
                }
                
                asyncSend(
                    action,
                    form,
                    dataObject,
                    callBack,
                    callBack
                )
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
                <span><b>Name</b></span>
                <span><b>Teas</b></span>
                <span><b>Button</b></span>
            </div>
            <?php
                foreach($data as $key=>$user)
                {
                    $name = $user['username'];
                    $teas = $user['teas'];
                    $id = $user['userID'];
                    echo "
                        <div>
                            <span class='vcenter'>$name</span>
                            <span id='tea$id' class='vcenter'><input class='w3-input w3-border table-button' type='number' id='input$id' min='0' value='$teas' /></span>
                            <span height='25' class='vcenter'><button class='w3-button w3-blue table-button' onclick='giveTea($id)'>Set Teas</button></span>
                        </div>
                        ";
                }
            ?>
        </div>
        <br>
        <label id='giveTeaError' class='center center-text error' ></label>
        <div><button class="w3-button login-input center w3-red" style="margin-top: 50px;" onclick="window.location.href='/logout.php'">Logout</button></div>
    </body>
</html>
