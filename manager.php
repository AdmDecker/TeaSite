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
    <body>
        <table>
            <th>
                <td>Name</td>
                <td>Teas</td>
            </th>
            <?php
                foreach($data as $key=>$user)
                {
                    $name = $user['userName'];
                    $teas = $user['teas'];
                    $id = $user['userID'];
                    echo "
                        <tr>
                            <td>$name</td>
                            <td id='tea$id'>$teas</td>
                            <td><button onclick='giveTea($id)'>Give Tea</button</td>
                        </tr>
                        ";
                }
            ?>
        </table>
    </body>
</html>
<script>
    function stateChange()
    {
        //Save the server's response in a variable
        let response = xmlhttp.responseText;
        //We don't care about these states, so ignore them
        if (!(xmlhttp.readyState==4) && !(xmlhttp.status==200))
            return;
        document.getElementById('tea' + response).value += 1;
        console.log('teathing: ' + 'tea' + response);
        console.log('type: ' + typeof response);
    }

    function giveTea(userID)
    {
        let action = '/givetea.php';
        xmlhttp = new XMLHttpRequest();

        //Open our http request as POST with our action variable
        xmlhttp.open("POST", action, true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        //Set stateChange() as the onreadystatechange event handler
        //onreadystatechange is triggered any time the xmlhttp object changes state,
        //like when it receives a response from the server
        xmlhttp.onreadystatechange = stateChange;

        xmlhttp.send('userID=' + userID);
    }
</script>
