<?php
    require_once('Session.php');
    require_once('dbaccess.php');

    if (PupSession::getUserType() != 'M')
        header('Location: /accessDenied.html');

    //get all the user data
    $db = new dbAccess();
    $data = $db->getAllUsersByRole('C');
?>
<!DOCTYPE html>

<html>
    <head>
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

            //Open our http request as POST with our action variable
            xmlhttp.open("POST", action, true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xmlhttp.onreadystatechange = stateChange;
            xmlhttp.send('userID=' + userID);
            let nm = parseInt(document.getElementById('tea' + userID).innerText);
            document.getElementById('tea' + userID).innerText = nm + 1;
        }
    </script>
    </head>
    <body>
        <div class='center' style='text-align: center'>
            <div class='center'>
                <span class='center'><b>Name</b></span>
                <span class='center'><b>Teas</b></span>
                <span class='center'><b>Button</b></span>
            </div>
            <?php
                foreach($data as $key=>$user)
                {
                    $name = $user['userName'];
                    $teas = $user['teas'];
                    $id = $user['userID'];
                    echo "
                        <div class='center'>
                            <span class='center'>$name</span>
                            <span class='center' id='tea$id'>$teas</span>
                            <span class='center' height='25' ><button class='w3-button w3-blue' onclick='giveTea($id)'>Give Tea</button></span>
                        </div>
                        ";
                }
            ?>
        </div>
    </body>
</html>
