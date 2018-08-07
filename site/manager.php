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
        <table class='center'>
            <tbody class='center'>
                <tr class='center'>
                    <th>Name</th>
                    <th>Teas</th>
                    <th>Button</th>
                </tr>
                <?php
                    foreach($data as $key=>$user)
                    {
                        $name = $user['userName'];
                        $teas = $user['teas'];
                        $id = $user['userID'];
                        echo "
                            <tr class='center'>
                                <td>$name</td>
                                <td id='tea$id'>$teas</td>
                                <td height='25' ><button class='w3-button w3-blue' onclick='giveTea($id)'>Give Tea</button></td>
                            </tr>
                            ";
                    }
                ?>
            </tbody>
        </table>
    </body>
</html>
