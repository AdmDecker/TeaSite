<?php
    require 'dbaccess.php';
    $password = $_POST['password'];
    $username = $_POST['username'];

	try 
    {   
        $db = new dbaccess();
        
        //Verify username exists
        $userID = $db->getUserID($username);
        if (is_null($userID))
        {
            echo "Login Failed: User does not exist.";
            exit();
        }
		
        //Fetch password for user from DB
        $passwd_inDB = $db->getPassword($username);

		if (!is_null($passwd_inDB) && password_verify($password, $passwd_inDB))
        {
            //Start the session
            session_start();
            $_SESSION['timeout'] = time() + 60 * 60 * 15;
            $_SESSION['username'] = $username;
            $_SESSION['userID'] = $userID;
            $_SESSION['userType'] = $db->getUserType($userID);
            echo "success";
        }	
		else
			echo "Login Failed: Username and password do not match.";				
	}
	catch(PDOException $e)
	{
		echo "Database error: " . $e->getMessage();
	}
    exit();
?>

